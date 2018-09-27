<?php
session_start();


if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true)
{
	header('Location: panel_sterowania.php');
	exit();
}

$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
if($pageWasRefreshed ) 
   unset($_SESSION['blad']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="pl-PL">
	<head>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<title>Logowanie</title>
	</head>

	<body>
	
		<div id="container">
			<div id="logo">
				<div id="logo_tytul">Rajd na orientację<div id="logo_tytul2"> Bałtycka Tułaczka</div> <span style="color:#EDC40E; font-size: 22px">Zapisy na zawody</span></div>
				<div id="logo_img"><img src="img/slajd1.png"/></div>
			</div>
			<div id="opis" style="text-align: center">Żeby zapisać się na rajd wymagane jest rejestracja konta.</div>
			<div id="login">
				<form action="zaloguj.php" method="post">
					<span style="padding-left: 30px; text-shadow: 2px 2px 8px white;">Zaloguj sie:</span>
					<div id="input1"><input name="login" type="text" placeholder="login" /></div> 
					<div id="input2"><input name="haslo" type="password" placeholder="hasło"/>	</div> 
					<div id="submit"><input type="submit" value="Zaloguj"/>	</div>
					<?php
						if(isset($_SESSION['blad']))
							echo $_SESSION['blad'];
					?>
					<div id="rejestracja"><a href="rejestracja.php" id="link_rejestracja">Rejestracja</a></div>
				
				
				</form>
			</div>
			
			<div id="powrot" ><a href="index.php" class="link_cofnij">&lArr;Powrót do strony głównej</a></div>
			<div id="stopka">Wszystkie prawa zastrzeżone &copy</div>
		</div>
	</body>

</html> 