<?php
session_start();

if(!isset($_SESSION['uzytkownik_dodany']))
{
	header('Location: index.php');
	exit();
}
else
	unset($_SESSION['uzytkownik_dodany']);


if(isset($_SESSION['OK_imie']))
	unset($_SESSION['OK_imie']);
if(isset($_SESSION['OK_nazwisko']))
	unset($_SESSION['OK_nazwisko']);
if(isset($_SESSION['OK_login']))
	unset($_SESSION['OK_login']);
if(isset($_SESSION['OK_email']))
	unset($_SESSION['OK_email']);
if(isset($_SESSION['OK_regulamin']))
	unset($_SESSION['OK_regulamin']);


if(isset($_SESSION['e_imie']))
	unset($_SESSION['e_imie']);
if(isset($_SESSION['e_nazwisko']))
	unset($_SESSION['e_nazwisko']);
if(isset($_SESSION['e_login']))
	unset($_SESSION['e_login']);
if(isset($_SESSION['e_haslo']))
	unset($_SESSION['e_haslo']);
if(isset($_SESSION['e_email']))
	unset($_SESSION['e_email']);
if(isset($_SESSION['e_regulamin']))
	unset($_SESSION['e_regulamin']);
if(isset($_SESSION['e_rechaptcha']))
	unset($_SESSION['e_recaptcha']);

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
				<div id="logo_tytul">Puchar Polski Maratonów na Orientację <span style="color:#EDC40E; font-size: 22px"> <br/>Rejestracja</span></div>
			</div>
			<div id="menu"> Zostałeś zapisany na rajd. Możesz zalogować się na swoje konto by zaktualizować swoje dane.<br/>
				<a href="logowanie.php">Zaloguj się na swoje konto</a>
			</div>
			<div id="stopka">Wszystkie prawa zastrzeżone &copy</div>
		</div>
	</body>

</html> 