<?php
session_start();
require_once "connect.php";


if(isset($_POST['imie']))
{
	$walidacja = true;
	
	//----------------IMIĘ-------------------------------------------------------------------------------------------------------------
	$imie = $_POST['imie'];
	if(strlen($imie)<2 || strlen($imie)>20 || !preg_match("/^[a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ]*$/",$imie))
	{
		$walidacja = false;
		$_SESSION['e_imie'] = "Proszę wpisać poprawne imię.";
	}
	else
		$_SESSION['OK_imie'] = $imie; //Jezeli imie jest poprawne to zostaje w polu inputa, nawet jezeli inne inputy beda niepoprawne
	
	//-------------NAZWISKO------------------------------------------------------------------------------------------------------
	$nazwisko = $_POST['nazwisko'];
	if(strlen($nazwisko)<2 || strlen($nazwisko)>30 || !preg_match("/^[a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ]*$/",$imie))
	{
		$walidacja = false;
		$_SESSION['e_nazwisko'] = "Proszę wpisać poprawne nazwisko.";
	}
	else
		$_SESSION['OK_nazwisko'] = $nazwisko; //Jezeli nazwisko jest poprawne to zostaje w polu inputa, nawet jezeli inne inputy beda niepoprawne
	
	
	//-------------LOGIN------------------------------------------------------------------------------------------------------------
	$login = $_POST['login'];
	if(ctype_alnum($login)==false)
	{
		$walidacja = false;
		$_SESSION['e_login'] = "Login może się składać tylko z liter lub liczb (bez polskich znaków)!";
	}	
	else if(strlen($login)<3 || strlen($login)>20)
	{
		$walidacja = false;
		$_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków!";
	}
	else
		$_SESSION['OK_login'] = $login; 
	
	
	//-------------HASŁA-----------------------------------------------------------------------------------------------------------
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];
	if($haslo1!=$haslo2)
	{
		$walidacja = false;
		$_SESSION['e_haslo'] = "Wpisane hasła się różnią!";
	}

	if(strlen($haslo1)<6 || strlen($haslo1)>20)
	{
		$walidacja = false;
		$_SESSION['e_haslo'] = "Hasło musi posiadać od 6 do 20 znaków";
	}
	if(ctype_alnum($haslo1)==false)
	{
		$walidacja = false;
		$_SESSION['e_haslo'] = "Hasło może się składać tylko z liter lub liczb (bez polskich znaków)!";
	}
	
	$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
	
	//-----------------EMAIL--------------------------------------------------------------------------------------------------------
	$email = $_POST['email'];
	$email_san = filter_var($email, FILTER_SANITIZE_EMAIL);
	if(filter_var($email_san, FILTER_VALIDATE_EMAIL)==false || $email!=$email_san)
	{
		$walidacja = false;
		$_SESSION['e_email'] = "Błędny adres email!";
	}
	else
		$_SESSION['OK_email'] = $email; 
	

	
	
	//----------------------REGULAMIN-------------------------------------------------------------------------------------------
	if(isset($_POST['regulamin'])==false)
	{
		$walidacja = false;
		$_SESSION['e_regulamin'] = "Żeby zarejestrować konto, musisz zaakceptować regulamin!";
	}
	else
		$_SESSION['OK_regulamin'] = true; 
	
	
	//------------RECAPTCHA------------------------------------------------------------------------------------------------------
	//weryfikacja recaptchy
	$secret_key = "6Le6JRwUAAAAAA_uHx2_IyhU8QLD1StjG-hjdYq0";
	$sprawdz_sk = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
	//odpowiedz z Google jest zakodowana w JSON wiec dekodujemy
	$odpowiedz = json_decode($sprawdz_sk);
	
	if($odpowiedz->success==false)
	{
		$walidacja = false;
		$_SESSION['e_recaptcha'] = "Potwierdź że jesteś człowiekiem!";
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
			$rezultat = $polaczenie->query("SELECT id FROM uczestnicy WHERE email='$email'");
			
			if(!$rezultat)
				throw new Exception($polaczenie->error);
			
			$liczba_maili = $rezultat->num_rows;
			if($liczba_maili>0)
			{
				$walidacja = false;
				$_SESSION['e_email'] = "Konto przypisane do tego maila już istnieje!";
			}
			
			$rezultat = $polaczenie->query("SELECT id FROM uczestnicy WHERE login='$login'");
			if(!$rezultat)
				throw new Exception($polaczenie->error);
			
			$liczba_loginow = $rezultat->num_rows;
			if($liczba_loginow>0)
			{
				$walidacja = false;
				$_SESSION['e_login'] = "Wybrany login jest już zajęty!";
			}
			
			$miasto = $_POST['miasto'];
			if(strlen($miasto)<1)
				$miasto = "BRAK DANYCH";
			else
				$_SESSION['OK_miasto'] = $miasto;
			
			$druzyna = $_POST['druzyna'];
			if(strlen($druzyna)<1)
				$druzyna = "BRAK DANYCH";
			else
				$_SESSION['OK_druzyna'] = $druzyna;
			
			if($walidacja==true)
			{
				$polaczenie->query("INSERT INTO uczestnicy VALUES ('', '$login', '$haslo_hash', '$email', '$imie', '$nazwisko', '$miasto', '$druzyna', '', 'member')");
				$_SESSION['uzytkownik_dodany'] = true;
				header('Location: witaj.php');
			}
			$polaczenie->close();
		}
		
	}
	catch(Exception $error)
	{
		echo '<span style="color: red">Błąd serwera, prosimy o rejestrację w innym terminie.</span>';
	}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="pl-PL">
	<head>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<title>Rejestracja</title>
	</head>

	<body>
	
		<div id="container">
			<div id="logo">
				<div id="logo_tytul">Rajd na orientację<div id="logo_tytul2"> Bałtycka Tułaczka</div><span style="color:#EDC40E; font-size: 22px">Rejestracja Konta</span></div>
				<div id="logo_img"><img src="img/slajd1.png"/></div>
			</div>
			<div id="menu_rej">
				<a href="logowanie.php" class="rejestracja_powrot">Powrót do strony logowania</a><br/><br/>
				<form  method="post">
					<div class="form_rej">Formularz rejestracyjny</div>
					<div class="pola_wym">(*pola wymagane)</div><br/>
					
					Login: <br/>
					<?php
						if(isset($_SESSION['e_login']))
						{
							echo '<div class="error">'.$_SESSION['e_login'].'</div>';
							unset($_SESSION['e_login']);
						}
						
					?>
					
					<input class="ps_input" type="text" name="login" value="<?php 
					if(isset($_SESSION['OK_login']))
					{
						echo $_SESSION['OK_login'];
						unset($_SESSION['OK_login']);
					}
					?>"/><span style="color:red"> *</span><br/><br/>
					
					Hasło: <br/>
						<?php
						if(isset($_SESSION['e_haslo']))
						{
							echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
						}
						
					?>
					<input class="ps_input" type="password" name="haslo1"><span style="color:red"> *</span><br/><br/>
					
					Powtórz hasło: <br/>
					<?php
						if(isset($_SESSION['e_haslo']))
						{
							echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
							unset($_SESSION['e_haslo']);
						}
					?>
					<input class="ps_input" type="password" name="haslo2"><span style="color:red"> *</span><br/><br/>
					
					Email: <br/>
					<?php
					if(isset($_SESSION['e_email']))
						{
							echo '<div class="error">'.$_SESSION['e_email'].'</div>';
							unset($_SESSION['e_email']);
						}
					?>
					<input class="ps_input" type="text" name="email" value="<?php 
					if(isset($_SESSION['OK_email']))
					{
						echo $_SESSION['OK_email'];
						unset($_SESSION['OK_email']);
					}
					?>"><span style="color:red"> *</span><br/><br/>
					
					Imię: <br/>
						<?php
					if(isset($_SESSION['e_imie']))
						{
							echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
							unset($_SESSION['e_imie']);
						}
					?>
					<input class="ps_input" type="text" name="imie" value="<?php 
					if(isset($_SESSION['OK_imie']))
					{
						echo $_SESSION['OK_imie'];
						unset($_SESSION['OK_imie']);
					}
					?>"><span style="color:red"> *</span><br/><br/>
					
					Nazwisko: <br/>
						<?php
					if(isset($_SESSION['e_nazwisko']))
						{
							echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
							unset($_SESSION['e_nazwisko']);
						}
					?>
					<input class="ps_input" type="text" name="nazwisko" value="<?php 
					if(isset($_SESSION['OK_nazwisko']))
					{
						echo $_SESSION['OK_nazwisko'];
						unset($_SESSION['OK_nazwisko']);
					}
					?>"><span style="color:red"> *</span><br/><br/>
					
					Miasto: <br/>
					<input class="ps_input" type="text" name="miasto" value="<?php 
					if(isset($_SESSION['OK_miasto']))
					{
						echo $_SESSION['OK_miasto'];
						unset($_SESSION['OK_miasto']);
					}
					?>"><br/><br/>
					
					Drużyna: <br/>
					<input class="ps_input" type="text" name="druzyna" value="<?php 
					if(isset($_SESSION['OK_druzyna']))
					{
						echo $_SESSION['OK_druzyna'];
						unset($_SESSION['OK_druzyna']);
					}
					?>"><br/><br/>
					
					<?php
					if(isset($_SESSION['e_regulamin']))
						{
							echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
							unset($_SESSION['e_regulamin']);
						}
					?>
					
					<input type="checkbox" name="regulamin" <?php 
					if(isset($_SESSION['OK_regulamin']))
					{
						echo "checked";
						unset($_SESSION['OK_regulamin']);
					}
					?>> <span style="font-size:13px">Akceptuję regulamin</span><span style="color:red"> *</span><br/><br/>
					
					<?php
					if(isset($_SESSION['e_recaptcha']))
						{
							echo '<div class="error">'.$_SESSION['e_recaptcha'].'</div>';
							unset($_SESSION['e_recaptcha']);
						}
					?>
					<div class="g-recaptcha" data-sitekey="6Le6JRwUAAAAAEzsZZMob3U07P-95B-RL5kYM39l"></div><br/>
					<input type="submit" value="Zarejestruj się">
				
				</form>
			</div>
			<div id="menu_rej2">
			  <img class="animate-fading" src="img/1.jpg" style="width:575px">
			  <img class="animate-fading" src="img/2.jpg" style="width:575px">
			  <img class="animate-fading" src="img/3.jpg" style="width:575px">
			  <img class="animate-fading" src="img/4.jpg" style="width:575px">
			  <img class="animate-fading" src="img/5.jpg" style="width:575px">
			  <img class="animate-fading" src="img/6.jpg" style="width:575px">
			</div>

			<script>
			var myIndex = 0;
			carousel();

			function carousel() {
				var i;
				var x = document.getElementsByClassName("animate-fading");
				for (i = 0; i < x.length; i++) {
				   x[i].style.display = "none";  
				}
				myIndex++;
				if (myIndex > x.length) {myIndex = 1}    
				x[myIndex-1].style.display = "block";  
				setTimeout(carousel, 7000);    
			}
			</script>
			<div style="clear: both"></div>
			<div id="stopka">Wszystkie prawa zastrzeżone &copy</div>
		</div>
	</body>

</html> 