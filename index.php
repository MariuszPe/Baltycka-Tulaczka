<?php
session_start();
unset($_SESSION['blad']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="pl-PL">
	<head>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<title>Rajd na orientację</title>
	</head>

	<body>
	
		<div id="container">
			<div id="logo">
				<div id="logo_tytul">Rajd na orientację<div id="logo_tytul2"> Bałtycka Tułaczka</div></div>
				<div id="logo_img"><img src="img/slajd1.png"/></div>
			</div>
			<div id="menu">
				<div id="menu2">
						<div id="menu2_title">MENU:</div>						
						<a href="informacje.php" class="link_str_glowna"><div class="podpunkt_menu">Informacje o  rajdzie</div></a>	
						<a href="mapa.php" class="link_str_glowna"><div class="podpunkt_menu">Lokalizacja rajdu</div></a>
						<a href="regulamin.php" class="link_str_glowna"><div class="podpunkt_menu">Regulamin</div></a>
						<a href="logowanie.php" class="link_str_glowna"><div class="podpunkt_menu">Zapisy</div></a>
						<a href="lista_uczestnikow.php" class="link_str_glowna"><div class="podpunkt_menu">Lista uczestników</div></a>	
				</div>
				<div id="menu2_obraz"><img id="obraz" src="img/landscape.jpg"></div>
				<div style="clear:both"></div>
			</div>
			<div id="stopka">Wszystkie prawa zastrzeżone &copy</div>
		</div>
	</body>

</html> 