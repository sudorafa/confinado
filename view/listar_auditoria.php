<?php
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 30 de Setembro de 2016
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	include('../cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	if (($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "PREVENCAO") && ($_SESSION[perfil] != "CPD")){
		header("Location:/");
	}
	
	$idusuario 		= $_SESSION["idusuario"];
	
	$servidor 		= `uname -a | awk -F" " '{print $2}'`;
	$filialUserAqui = trim($servidor);
	
	//dados para o select
	$idUsuarioBusca		= $_POST['usuario'];
	$codInternoBusca	= $_POST['produto'];
	$motivoBusca1		= $_POST['motivo'];
	if ($motivoBusca1 == 1){
		$motivoBusca 	= "entrada";
	}else if ($motivoBusca1 == 2){
		$motivoBusca 	= "saida";
	}
	$data_inicio0 		= $_POST[data_inicio];
	$data_inicio1 		= str_replace('-', '/', $data_inicio0);
	$data_inicio1 		= explode("/", $data_inicio1);
	$data_fim0 			= $_POST[data_fim];
	$data_fim1 			= str_replace('-', '/', $data_fim0);
	$data_fim1 			= explode("/", $data_fim1);

	if ((!(Checkdate($data_fim1[1], $data_fim1[0], $data_fim1[2]))) and ( !(Checkdate($data_inicio1[1], $data_inicio1[0], $data_inicio1[2])))) {
		echo "<script>window.alert('Data Invalida !'); window.location.replace('form_auditoria.php');</script>";
	}
	$data_fim1 = $data_fim1[2] . "-" . $data_fim1[1] . "-" . $data_fim1[0];
	$data_inicio1 = $data_inicio1[2] . "-" . $data_inicio1[1] . "-" . $data_inicio1[0];
	
	$sqlRegistro  = "select r.id, u.matricula, u.nomusuario, r.codInterno, e.descProduto, r.data, r.hora, r.motivo, r.qtd, r.obs ";
	$sqlRegistro .= "from Confinado_Registro as r ";
	$sqlRegistro .= "inner join usuariosc as u on r.idusuario = u.idusuario ";
	$sqlRegistro .= "inner join Confinado_Estoque as e on r.codInterno = e.codInterno ";
	$sqlRegistro .= "where u.filial = '$filialUserAqui' and r.data between '$data_inicio1' and '$data_fim1'";
	
	if ($idUsuarioBusca <> 999){
		$sqlRegistro .= " and r.idusuario = $idUsuarioBusca ";
	}
	if ($codInternoBusca <> 999){
		$sqlRegistro .= " and r.codInterno = '$codInternoBusca' ";
	}
	if ($motivoBusca1 <> 999){
		$sqlRegistro .= " and r.motivo = '$motivoBusca' ";
	}
	$sqlRegistro .= "order by r.id";
	$registros		= mysql_query($sqlRegistro);
	
	$linhasRegistro = mysql_num_rows($registros);
	$uso_mov 		= $linhasRegistro;
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body> 
	<!-- --------------------------------------------------------------------------------------- -->
	
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Registros Data - <?php echo $data_inicio0 . " à " . $data_fim0 ?> </font></h2> 
					<br/>
					<div align="center">
						<label><a href="form_auditoria.php "><img src="/_imagens/btn_voltar.png"></a></label>
					</div>
					</br> 
					<table cellpadding="0" border="1" width="99%" height="26" align="center">
					<tr height="26">
					<?php
						if ($uso_mov == 0) { ?>
							<td class="title" height="26"> NADA PARA EXIBIR </td>
					</tr>
					</table>
					</br> </br> </br> </br> </br> </br> </br> </br> </br> </br> </br> </br> 
					<?php 
						} else {
					?>
							<td class="title" height="26"> Usuário </td>
							<td class="title" height="26"> Produto </td>
							<td class="title" height="26"> Date </td>
							<td class="title" height="26"> Motiv </td>
							<td class="title" height="26"> Qtd. </td>
							<td class="title" height="26"> Observação. </td>
					</tr>
					<?php
							while ($dadosRegistros = mysql_fetch_array($registros)){
								$matric = $dadosRegistros[matricula];
								$matric = substr($matric,(strlen($matric)-5),strlen($matric));
								
								$dataFormat	= $dadosRegistros[data];
								$dataFormat = explode("-", $dataFormat);
								$dataFormat	= $dataFormat[2] . "/" . $dataFormat[1] . "/" . $dataFormat[0];
								
								if($dadosRegistros[motivo] == "entrada"){
									$motiv = "ENT";
								}else if($dadosRegistros[motivo] == "saida") {
									$motiv = "SAI";
								}
								
					?>
								<td class="corpo" height="26" > <?php echo $matric . " " . $dadosRegistros[nomusuario];?> </td>
								<td class="corpo" height="26" > <?php echo $dadosRegistros[codInterno] . " " . $dadosRegistros[descProduto]?> </td>
								<td class="corpo" height="26" > <?php echo $dataFormat . " " . $dadosRegistros[hora];?> </td>
								<td class="corpo" height="26" > <?php echo $motiv?> </td>
								<td class="corpo" height="26" > <?php echo $dadosRegistros[qtd]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosRegistros[obs]?> </td>
					</tr>
					<?php 
							};
					?>
					</table>
					<?php 
						};
					?>
				</div>
				<br/><br/>
				<?php 
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>