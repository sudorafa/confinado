<?php
	session_start();
	/*
	Form Home do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 29 de Setembro de 2016
	*/
	include('../global/libera.php');
	//include('cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	
	if (($_SESSION[perfil] != "PREVENCAO")){
		header("Location:view/form_estoque.php");
	}else{
		header("Location:view/form_entra_sai.php");
	}
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	
</html>