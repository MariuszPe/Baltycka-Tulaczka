<?php
session_start();
require_once "connect.php";


if(!isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']!=true)
{
	header('Location: index.php');
	exit();
}


mysqli_report(MYSQLI_REPORT_STRICT);
	
	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$id = $_SESSION['id'];
			$sql = $polaczenie->query("SELECT * FROM uczestnicy WHERE id='$id'");
			$wydruk = $sql->fetch_assoc();
			$update = false;
			
			//-------Update emaila-------
			if(isset($_POST['u_email']))
			{
				if($_POST['u_email']!=$wydruk['email'])
					{
						$u_email = $_POST['u_email'];
						$email_san = filter_var($u_email, FILTER_SANITIZE_EMAIL);
						if(filter_var($email_san, FILTER_VALIDATE_EMAIL)==false || $u_email!=$email_san)
						{
							$_SESSION['e_email'] = "Błędny adres email!";
						}
						else
						{	
								$update = true;
								$polaczenie->query("UPDATE uczestnicy SET email='$email_san' WHERE id='$id'");
								if(!$polaczenie)
									throw new Exception($polaczenie->error);
						}
					}
			}
			
			//-------Update miasta-------
			if(isset($_POST['u_miasto']))
			{
				if($_POST['u_miasto']!=$wydruk['miasto'])
					{
						$u_miasto = $_POST['u_miasto'];
						if(strlen($u_miasto)>1)
						{	
								$update = true;
								$polaczenie->query("UPDATE uczestnicy SET miasto='$u_miasto' WHERE id='$id'");
								if(!$polaczenie)
									throw new Exception($polaczenie->error);
						}
					}
			}
			
			//-------Update drużyny-------
			if(isset($_POST['u_druzyna']))
			{
				if($_POST['u_druzyna']!=$wydruk['druzyna'])
					{
						$u_druzyna = $_POST['u_druzyna'];
						if(strlen($u_druzyna)>1)
						{	
								$update = true;
								$polaczenie->query("UPDATE uczestnicy SET druzyna='$u_druzyna' WHERE id='$id'");
								if(!$polaczenie)
									throw new Exception($polaczenie->error);
						}
					}
			}
		
			if($update == true)
			{
				?> <script>alert('Dane zostały zmienione') </script> <?php
				$update = false;
			}		
		}
				
				$polaczenie->close();
	}
	catch(Exception $error)
	{
				echo '<span style="color: red">Błąd serwera, spróbuj zalogować się później</span>';
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="pl-PL">
	<head>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<title>Panel Sterowania</title>
	</head>

	<body>
	
		<div id="container">
			<div id="logo">
				<div id="logo_tytul">Rajd na orientację<div id="logo_tytul2"> Bałtycka Tułaczka</div> <span style="color:#EDC40E; font-size: 22px">Panel Uczestnika</span></div>
				<div id="logo_img"><img src="img/slajd1.png"/></div>
			</div>
			<div id="menu">
			<form id="edycja_danych" method="post">
			<?php
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			$sql = $polaczenie->query("SELECT * FROM uczestnicy WHERE id='$id'");

			$wydruk = $sql->fetch_assoc();
			
			echo "Witaj <span style='color: #802000; font-weight: 700'>".$wydruk['login']."</span>!".' <a class="logout" href="logout.php">Wyloguj się</a><br/><br/>';

			if($wydruk['level']=='member')
			{
			?>
			
			
			<u><b>Twoje dane:</b></u><br/><br/>
			
			<b>Imię: </b><?php echo $wydruk['imie'];?><br/>
			<b>Nazwisko: </b><?php echo $wydruk['nazwisko'];?><br/>		
			
			<?php //-----------------------Email-----------------------
			if(isset($_SESSION['e_email']))
				{
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			?>
			<b>Email: </b><input class="ps_input" type="text" name="u_email" value="<?php echo $wydruk['email']; ?>"><br/>
			<b>Miasto: </b><input class="ps_input" type="text" name="u_miasto" value="<?php echo $wydruk['miasto'];?>"><br/>
			<b>Drużyna: </b><input class="ps_input" type="text" name="u_druzyna" value="<?php echo $wydruk['druzyna']?>"><br/>
			<input type="submit" value="Wprowadź zmiany">
			<?php
			
			}
			else if($wydruk['level']=='admin')
			{
				header('Location: admin_panel.php');	
			}
			$polaczenie->close();
			?>
			
			</form>

			
			</div>
			<div id="stopka">Wszystkie prawa zastrzeżone &copy</div>
			</div>
		</div>
	</body>

</html> 

