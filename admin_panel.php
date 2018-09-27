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
if(isset($_POST['id']))
	$_SESSION['id'] = $_POST['id'];
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
				<div id="logo_tytul">Rajd na orientację<div id="logo_tytul2"> Bałtycka Tułaczka</div><span style="color:#EDC40E; font-size: 22px">Panel Administracyjny</span></div>
				
			</div>
			<div id="menu">
			<table width="800" border="1" align="center"cellpadding="3" cellspacing="0">
			<?php	
			echo "Witaj <span style='color: #802000; font-weight: 700'>".$_SESSION['login'].' '."[".$_SESSION['level']."]"."</span>!".' <a class="logout" href="logout.php">Wyloguj się</a><br/><br/>';
			require_once "connect.php"; ?>
			
			<form method="post">
				<div id="opcje_admin">Opcje kont użytkowników: <br/>
					<div id="opcje_admin2"><input name="id" type="text" placeholder="id"> <br/>
					(*Wpisz id użytkownika, dla którego chcesz wprowadzać zmiany)<br/>
					</div>
					<input class="przycisk" name="lista" type="submit" value="Lista"/> 
					<input class="przycisk" name="update" type="submit" value="Update"/> 
					<input class="przycisk" name="delete" type="submit" value="Delete"/><br/>
				
				</div>
			</form>
			
			<?php
			try
			{
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
				if($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$rezultat = $polaczenie->query("SELECT * FROM uczestnicy");
					$liczba_rekordow = $rezultat->num_rows;
										
					if(isset($_POST['lista']))
					{
						echo<<<END
						<tr>
						<th>ID</th>
						<th>Login</th>
						<th>Email</th>
						<th>Imię</th>
						<th>Nazwisko</th>
						<th>Miasto</th>
						<th>Drużyna</th>
						<th>Opłata</th>
						<th>Level konta</th>
						</tr>				
END;
						
						while($lista = $rezultat->fetch_assoc())
						{	
						
												
						$id = $lista['id'];
						$login = $lista['login'];
						$email = $lista['email'];
						$imie = $lista['imie'];
						$nazwisko = $lista['nazwisko'];
						$miasto = $lista['miasto'];
						$druzyna =  $lista['druzyna'];
						$oplata = $lista['oplata'];
						$level = $lista['level'];
					
						echo<<<END
						<td>$id</td>
						<td>$login</td>
						<td>$email</td>
						<td>$imie</td>
						<td>$nazwisko</td>
						<td>$miasto</td>
						<td>$druzyna</td>
						<td>$oplata</td>
						<td>$level</td>
						<tr>
END;
						
						}
						unset($_POST['lista']);		
					}
					//-------------------UPDATE-------------------
					else if(isset($_POST['update']))
					{
						if(!empty($_POST['id']))
						{
							$czy_jest = $polaczenie->query("SELECT * FROM uczestnicy WHERE id='$_POST[id]'");
							if(($czy_jest->num_rows)>=1)
							{
								$_SESSION['update']=true;
								header('Location: update.php');
							}
							else
							{
								?><script> alert('Nie ma takiego rekordu w bazie!'); </script><?php
							}
						}
						else
						{
							?><script> alert('Wpisz ID użytkownika do zaktualizowania!'); </script><?php
						}
						
					}//-------------------DELETE-------------------
					else if(isset($_POST['delete']))
					{
						if(!empty($_POST['id']))
						{
							$czy_jest = $polaczenie->query("SELECT * FROM uczestnicy WHERE id='$_POST[id]'");
							if(($czy_jest->num_rows)>=1)
							{	
								$rezultat = $polaczenie->query("DELETE FROM uczestnicy WHERE id='$_POST[id]'");
								?><script> alert('Użytkownik usunięty!'); </script><?php
							}
							else
							{
								?><script> alert('Nie ma takiego rekordu w bazie!'); </script><?php
							}
						}
						else
						{
							?><script> alert('Wpisz ID użytkownika do usunięcia!'); </script><?php
						}
					}
				}		
							
				$polaczenie->close();		
			}
			catch(Exception $error)
			{
				echo '<span style="color: red">Błąd serwera</span>';
			}
			
			
			
			?>
			</table>	
			
			</div>
			
			</div>
		</div>
	</body>

</html> 