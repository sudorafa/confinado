<?php
/*
	Query para registrar a tabela de movimentos de entradas ou saidas e estoque.
	Desenvolvido por Rafael Eduardo - @sudorafa
	Recife, 13 de Setembro de 2016
*/

	session_start();
	include('../../global/conecta.php');
	include('../../global/libera.php');

	//recebendo dados do form_registrar_entra_sai
	$idUsuario 	= $_SESSION["idusuario"];
	$data		= date('Y-m-d');
	$hora		= date('H:i');
	$codInterno	= $_POST['codInterno'];
	$codBarras	= $_POST['codBarrasTela'];
	$qtd		= $_POST['qtd'];
	$mut		= $_POST['mut'];
	$qtdBanco	= $qtd * $mut;
	$obs		= $_POST['observacao'];
	$descricao	= $_POST['desc'];
	$servidor		= `uname -a | awk -F" " '{print $2}'`;
	$filial  	= trim($servidor);
	
	$op			= $_POST['op'];
	
	
	//Insert Entrada ou Saida na tabela Confinado_Registro
	
	$motivo = $op;
	
	$queryRegistro = "insert into Confinado_Registro (idusuario, data, hora, codInterno, qtd, motivo, obs, filial) values ($idUsuario, '$data', '$hora', '$codInterno', $qtd, '$motivo', '$obs', '$filial')";
	if(mysql_query($queryRegistro)) {
		//$msg = "Registro salvo !";
	} else {
		echo 
		"<script>window.alert('Algo Errado no queryRegistro !');
			window.location.replace('../view/form_registrar_entra_sai.php');
		</script>";		
	}
	
	
	//Verificar se existe esse produto na tabela Confinado_Estoque
	$consutaProduto 	= mysql_fetch_array(mysql_query("select codInterno from Confinado_Estoque where codInterno = '$codInterno' and filial = '$filial'"));
	$produtoConsultado 	= $consutaProduto[codInterno];
	
	if ($produtoConsultado <> $codInterno){
		$queryEstoque = "insert into Confinado_Estoque (codInterno, descProduto, qtd, ultimaData, filial) values ('$codInterno', '$descricao', $qtdBanco, '$data', '$filial')";
	} else {
		if($op == "entrada"){
			$queryEstoque = "update Confinado_Estoque set qtd = qtd + $qtdBanco, ultimaData = '$data', filial = '$filial' where codInterno = '$codInterno' and filial = '$filial'";
		}else{
			$queryEstoque = "update Confinado_Estoque set qtd = qtd - $qtdBanco, ultimaData = '$data', filial = '$filial' where codInterno = '$codInterno' and filial = '$filial'";
		}		
	}
	if(mysql_query($queryEstoque)) {
		echo 
		"<script>window.alert('Registro Salvo !');
			window.location.replace('../view/form_entra_sai.php');
		</script>";		
	} else {
		echo 
		"<script>window.alert('Algo Errado no queryEstoque !');
			window.location.replace('../view/form_entra_sai.php');
		</script>";		
	}
	
	
	
?>