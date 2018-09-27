<?php
session_start();

if(!isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']!=true)
{
	header('Location: index.php');
	exit();
}

if($_SESSION['level']!='admin')
{
	header('Location: panel_sterowania.php');
	exit();	
}
$zmiana = false;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="pl-PL">
	<head>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<title>Praca na zaliczenie -> zmienic tytuł</title>
	</head>

	<body>
	
		<div id="container">
			<div id="logo">
				<div id="logo_tytul">Puchar Polski Maratonów na Orientację <span style="color:#EDC40E; font-size: 22px"> <br/>Panel Administracyjny</span></div>
				
			</div>
			<div id="menu">
			<?php	
			echo "Witaj <span style='color: #802000; font-weight: 700'>".$_SESSION['login'].' '."[".$_SESSION['level']."]"."</span>!".' <a class="logout" href="logout.php">Wyloguj się</a><br/><br/>';
			require_once "connect.php"; ?>
			
			
				<div id="opcje_admin">Opcje kont użytkowników: <br/>
					<a id="link"  href="admin_panel.php"><input class="przycisk" name="lista" type="submit" value="Powrót"/></a>
				</div>
			
				<div id="up_admin">
				<?php
				try
				{
					$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
					if($polaczenie->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
					else
						//-------------------UPDATE-------------------
						if($_SESSION['update']=true)
						{
							
							$rezultat = $polaczenie->query("SELECT * FROM uczestnicy WHERE id='$_SESSION[id]'");
							$up = $rezultat->fetch_assoc();
							?>
							<?php
							// Zmiana loginu
							if(isset($_POST['login']))
							{	
								if( $_POST['login']!=$up['login'])
								{
									$zmiana = true;
									$polaczenie->query("UPDATE uczestnicy SET login='$_POST[login]' WHERE id='$_SESSION[id]'");								
								}
							}
							
							// Zmiana emaila
							if(isset($_POST['email']))
							{	
								if( $_POST['email']!=$up['email'])
								{
									$zmiana = true;
									$polaczenie->query("UPDATE uczestnicy SET email='$_POST[email]' WHERE id='$_SESSION[id]'");								
								}
							}
							
							// Zmiana imienia
							if(isset($_POST['imie']))
							{	
								if( $_POST['imie']!=$up['imie'])
								{
									$zmiana = true;
									$polaczenie->query("UPDATE uczestnicy SET imie='$_POST[imie]' WHERE id='$_SESSION[id]'");								
								}
							}
							
							// Zmiana nazwiska
							if(isset($_POST['nazwisko']))
							{	
								if( $_POST['nazwisko']!=$up['nazwisko'])
								{
									$zmiana = true;
									$polaczenie->query("UPDATE uczestnicy SET nazwisko='$_POST[nazwisko]' WHERE id='$_SESSION[id]'");								
								}
							}	
							
							// Zmiana miasta
							if(isset($_POST['miasto']))
							{	
								if( $_POST['miasto']!=$up['miasto'])
								{
									$zmiana = true;
									$polaczenie->query("UPDATE uczestnicy SET miasto='$_POST[miasto]' WHERE id='$_SESSION[id]'");								
								}
							}
							// Zmiana drużyny
							if(isset($_POST['druzyna']))
							{	
								if( $_POST['druzyna']!=$up['druzyna'])
								{
									$zmiana = true;
									$polaczenie->query("UPDATE uczestnicy SET druzyna='$_POST[druzyna]' WHERE id='$_SESSION[id]'");								
								}
							}
							
							// Zmiana opłaty
							if(isset($_POST['oplata']))
							{	
								if( $_POST['oplata']!=$up['oplata'])
								{
									$zmiana = true;
									$polaczenie->query("UPDATE uczestnicy SET oplata='$_POST[oplata]' WHERE id='$_SESSION[id]'");								
								}
							}

							// Zmiana poziomu użytkownika
							if(isset($_POST['level']))
							{	
								if( $_POST['level']!=$up['level'])
								{
									$zmiana = true;	
									$polaczenie->query("UPDATE uczestnicy SET level='$_POST[level]' WHERE id='$_SESSION[id]'");								
								}
							}
							
							?>
							<form method="post">
							<!-- --------------------Odświeżenie danych------------------------- -->
							<?php $rezultat = $polaczenie->query("SELECT * FROM uczestnicy WHERE id='$_SESSION[id]'");
							$up = $rezultat->fetch_assoc(); ?>
							
							<div class="form_rej2">Aktualizacja danych użytkownika: <span style="color: red"><?php echo $up['login']; ?> </span></div><br/>
							Login: <br/>
							<input class="ps_input" type="text" name="login" value="<?php echo $up['login']; ?>"/><br/><br/>
							
							Email: <br/>
							<input class="ps_input" type="text" name="email" value="<?php echo $up['email']; ?>"/><br/><br/>
							
							Imię: <br/>
							<input class="ps_input" type="text" name="imie" value="<?php echo $up['imie']; ?>"/><br/><br/>
							
							Nazwisko: <br/>
							<input class="ps_input" type="text" name="nazwisko" value="<?php echo $up['nazwisko']; ?>"/><br/><br/>
							
							Miasto: <br/>
							<input class="ps_input" type="text" name="miasto" value="<?php echo $up['miasto']; ?>"/><br/><br/>
							
							Drużyna: <br/>
							<input class="ps_input" type="text" name="druzyna" value="<?php echo $up['druzyna']; ?>"/><br/><br/>
							
							Opłata: <br/>
							<select class="ps_input" name="oplata" >
							  <option value="">NIE</option>
							  <option value="TAK" <?php if($up['oplata']=='TAK') echo "selected";?>>TAK</option>
							 </select><br/><br/>
							
							
							Poziom użytkownika: <br/>
							<select class="ps_input" name="level" >
							  <option value="member">Member</option>
							  <option value="admin" <?php if($up['level']=='admin') echo "selected";?>>Admin</option>
							 </select><br/><br/>
							
							
							<input type="submit" value="Wprowadź zmiany"/>
							</form>
							<?php
							
							
						}
						$_SESSION['update'] = false;			
						if($zmiana==true)
						{	?> <script> alert('Dane zostały zaktualizowane'); </script><?php }
						
						$polaczenie->close();				
						
				}
				catch(Exception $error)
				{
					echo '<span style="color: red">Błąd serwera</span>';
				}
		
				?>
				</div>
				
			</div>
			
			</div>
		</div>
	</body>

</html> 