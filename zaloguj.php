<html>
<head>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<title>Logowanie</title>
</head>
<body>
<?php
session_start();
require_once "connect.php";


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
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		if($rezultat = $polaczenie->query(sprintf("SELECT * FROM uczestnicy WHERE login='%s'", mysqli_real_escape_string($polaczenie, $login))));
		{
			if(!$rezultat)
				throw new Exception($polaczenie->error);
			
			$ilu_uzytkownikow = $rezultat->num_rows;
			if($ilu_uzytkownikow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				if(password_verify($haslo, $wiersz['pass']))
				{
					$_SESSION['zalogowany'] = true;
					
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['imie'] = $wiersz['imie'];
					$_SESSION['nazwisko'] = $wiersz['nazwisko'];
					$_SESSION['miasto'] = $wiersz['miasto'];
					$_SESSION['druzyna'] = $wiersz['druzyna'];
					$_SESSION['login'] = $wiersz['login'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['level'] = $wiersz['level'];
					
						
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: panel_sterowania.php');
				}
				else
				{
					$_SESSION['blad'] = '<span style="color: red; font-size:15px">Nieprawidlowy login lub haslo</span>';
					header('Location: logowanie.php');
				}
			}
			else
			{
				$_SESSION['blad'] = '<span style="color: red; font-size:15px">Nieprawidlowy login lub haslo</span>';
				header('Location: logowanie.php');
			}
		}

		$polaczenie->close();
	}
}
catch(Exception $error)
{
	?><div id="powrot" ><a href="index.php" class="rejestracja_powrot">&lArr;Powrót do strony głównej</a></div><br/><?php
	echo '<span style="color: red">Błąd serwera, prosimy o zalogowanie się w późniejszym terminie.</span>';
}

?>
</body>
</html>