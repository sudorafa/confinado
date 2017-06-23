<?php
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 30 de Setembro de 2016
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	//include('../cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	if (($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "PREVENCAO") && ($_SESSION[perfil] != "CPD")){
		header("Location:/");
	}
	
	
	$servidor = `uname -a | awk -F" " '{print $2}'`;
	$servidor  = trim($servidor);
	
	$idusuario = $_SESSION["idusuario"];
	
	if ($busca == "listarTudo"){
		$estoque = mysql_query("select codInterno, descProduto, qtd, ultimaData from Confinado_Estoque where qtd <> 0 and filial = '$servidor' order by ultimaData desc");
		$linhasEstoque = mysql_num_rows($estoque);
		$uso_mov = $linhasEstoque;
	}
	
	if ($busca == "listarBuscar"){
		$codProduto = $_POST['codProduto']; 
		$descricao  = $_POST['descricao'];

		$sqlEstoque  = "select codInterno, descProduto, qtd, ultimaData from Confinado_Estoque where qtd <> 0 and filial = '$servidor' ";
		if(($codProduto) or ($codProduto <> "") or ($codProduto <> 0)){
			$sqlEstoque .= "and codInterno = $codProduto ";
		}
		
		if(($descricao) or ($descricao <> "")){
			$sqlEstoque .= "and descProduto like '%$descricao%' ";
		}
		
		$sqlEstoque .= "order by ultimaData desc";
		
		$estoque = mysql_query($sqlEstoque);
		
		$linhasEstoque = mysql_num_rows($estoque);
		$uso_mov = $linhasEstoque;
	}
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
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Estoque do Confinado Filial - <?php echo strtoupper($servidor) ?> </font></h2> 
					<br/> <br/> 
					<table cellpadding="0" border="1" width="70%" height="26" align="center">
					<tr height="26">
					<?php 
						if ($uso_mov == 0) { ?>
							<td class="title" height="26"> NADA PARA EXIBIR </td>
					</tr>
					</table>
					<br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> 
					<?php 
						} else {
					?>
							<td class="title" height="26"> Cód. Interno </td>
							<td class="title" height="26"> Desc. Produto </td>
							<td class="title" height="26"> Qtd. </td>
							<td class="title" height="26"> Ultimo Movimento </td>
					</tr>
					<?php
							while ($dadosEstoque = mysql_fetch_array($estoque)){
								//formatadando a data
								$data		= $dadosEstoque[ultimaData];
								$data	 	= explode("-", $data);
								$data		= $data[2] . "/" . $data[1] . "/" . $data[0];
					?>
								<td class="corpo" height="26" > <?php echo $dadosEstoque[codInterno]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosEstoque[descProduto]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosEstoque[qtd]?> </td>
								<td class="corpo" height="26" > <?php echo $data?> </td>
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
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>