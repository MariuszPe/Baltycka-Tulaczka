<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="pl-PL">
	<head>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<title>Lista uczestników</title>
	</head>

	<body>
	
		<div id="container">
			<div id="logo">
				<div id="logo_tytul">Rajd na orientację<div id="logo_tytul2"> Bałtycka Tułaczka</div><span style="color:#EDC40E; font-size: 22px">Lista uczestników</span></div>
				<div id="logo_img"><img src="img/slajd1.png"/></div>
			</div>
			<div id="menu">
			<a href="index.php" class="link_cofnij">&lArr;Powrót do strony głównej</a><br/><br/>
			<h2 align="center"> Lista uczestników</h2>
			<table width="800" border="1" align="center"cellpadding="3" cellspacing="0" font-size="15">
			
			<?php
			require_once "connect.php";
			
			try
			{
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
				if($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$rezultat = $polaczenie->query("SELECT * FROM uczestnicy WHERE id>1");					
					
					echo<<<END
					<tr>
					<th>Imię</th>
					<th>Nazwisko</th>
					<th>Miasto</th>
					<th>Drużyna</th>
					<th>Opłata</th>
					<tr>				
END;
					
					while($lista = $rezultat->fetch_assoc())
					{	
											
					$imie = $lista['imie'];
					$nazwisko = $lista['nazwisko'];
					$miasto = $lista['miasto'];
					$druzyna =  $lista['druzyna'];
					$oplata = $lista['oplata'];
				
					echo<<<END
					<tr>
					<td>$imie</td>
					<td>$nazwisko</td>
					<td>$miasto</td>
					<td>$druzyna</td>
					<td>$oplata</td>
					<tr>
END;
										
					}
					$polaczenie->close();
				}
				
			}
			catch(Exception $error)
			{
				echo '<span style="color: red">Błąd serwera</span>';
			}
			
			
			
			?>
			</table>	
			</div>
			<div id="stopka">Wszystkie prawa zastrzeżone &copy</div>
		</div>
	</body>

</html> 