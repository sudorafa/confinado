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
	if (($_SESSION[perfil] != "PREVENCAO")){
		header("Location:form_estoque.php");
	}
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.buscar.codBarrasEntrada.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script language="javascript">
	<!-- chama a função (buscar) -->
	function valida_dados (buscar)
	{
		if (buscar.codBarrasEntrada.value=="")
		{
			alert ("Por favor digite ou escaneie o código de barras para buscar.");
			buscar.codBarrasEntrada.focus();
			return false;
		}
	return true;
	}
	</script>
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Buscar Produto </font></h2> 
					<br/>
					<hr width="60%">
					<form action="form_registrar_entra_sai.php" method="post" name="buscar" align="center" onSubmit="return valida_dados(this)">
					<table cellpadding="0" border="1" width="80%" align="center">
					<tr>
						<td	align="center"> 
						</br> 
							<label> <font color="336699"/> Código de Barras: </label> &nbsp;
							<label> <input name="codBarrasEntrada" value="<?php echo $_POST["codBarrasEntrada"]; ?>" type="text" size="25" maxlength="20" onkeyup='if (isNaN(this.value)) {this.value = ""}'/> </label> &nbsp; 
						
							<input type="submit" name="buscar" value="buscar"/> &nbsp; &nbsp; &nbsp;
						</br> </br> 
						</td>
					</tr>
					</table>
					</form>
					<hr width="60%">
				</div>
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				<?php 
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>