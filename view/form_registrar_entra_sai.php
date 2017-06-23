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
	
	$idusuario = $_SESSION["idusuario"];
	
	$fd =fopen('../produtos.txt', 'r');
	
	$codBarrasEntrada 	= $_POST['codBarrasEntrada'];
	
	$servidor 	= `uname -a | awk -F" " '{print $2}'`;
	$filial  	= trim($servidor);
	
	while(!feof($fd)){
		$fda = fgets($fd, 256);
		$codInterno = substr($fda, 30, 5);
		$descricao = substr($fda, 10,20);
		$codBarras = substr($fda, 85, 20);
		$multiplicador = substr($fda, 38, 5);
		$compleDescricao = substr($fda, 38,12);
		$descTotal = $descricao . " " . $compleDescricao;
		
		if ($codBarras == $codBarrasEntrada) {
			$encontrou = true;
			break;
		}
	}
	
	//Dados do usuario:
	$sql = "select matricula, nomusuario from usuariosc where idusuario = $idusuario";
	$dadosUsuario = mysql_fetch_array(mysql_query($sql));
	
	$matricula 		= $dadosUsuario[matricula];
	$nomeUsuario	= $dadosUsuario[nomusuario];
	
	
	if($encontrou != true){
		/*
		// o produto não existe;
	
		// multiple recipients
		//$to  = '' . ', '; // note the comma

		// subject
		$subject = 'Sistema de Confinado';

		// message
		$message = "
			<br> <br> <br> <br> 
			<table border=1 align=center>
			<tr align=center>
				<td align=center>
				<br>
				<font color=#006600 size=+3> Alerta do Sistema de Confinado </font>
				<br> <br> <br> <br>
					O usuario <font color=#006600 size=+1> $nomeUsuario </font> tentou registrar o produto cod. barras: <font color=#006600 size=+1> $codBarrasEntrada</font>, que nao consta no Sistema de Confinado.
				<br>
					Se a informacao for valida, favor execute no Save o comando abaixo.
				<br>
					Caso contrario, ignore este email!
				<br> <br> <br> 
					<font color=#006600 size=+2> /files/relger/shell/atualizaConfinado </font>
				<br> <br> 
				</td>
			</tr>
			</table>
		";
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: CPD Recife<cpdrecife@atacadao.com.br>' . "\r\n";
		$headers .= "From: prevencao $filial perdas <prevencaoperdas$filial@atacadao.com.br>" . "\r\n";
		
		// Mail it
		if (mail($to, $subject, $message, $headers)) {
			$msgEmail =  "Foi enviado um email para o CPD atualizar os produtos no sistema. !";
		} else {
			$msgEmail =  "Ocorreu um erro durante o envio do email para o CPD atualizar os produtos no sistema. !";
		}
		*/
		echo 
		"<script>window.alert('Produto não cadastrado !')
			window.location.replace('form_entra_sai.php');
		</script>";	
	}
	
	//Dados do produto na tabela estoque:
	$consutaProduto 	= mysql_fetch_array(mysql_query("select qtd from Confinado_Estoque where codInterno = '$codInterno' and filial = '$filial'"));
	$qtdEstoque 		= $consutaProduto[qtd];
	if ($qtdEstoque == ""){
		$qtdEstoque = 0;		
	}
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.registrarEntraSai.qtd.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script language="javascript">
	<!-- chama a função (buscar) -->
	function valida_dados (registrarEntraSai)
	{
		if (registrarEntraSai.qtd.value=="")
		{
			alert ("Por favor digite a quantidade.");
			registrarEntraSai.qtd.focus();
			return false;
		}
		if (registrarEntraSai.op[0].checked == false && registrarEntraSai.op[1].checked == false) {
			alert ("ATENÇÃO ! ! ! !\n\nPor favor escolha se é entrada ou saída !");
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
					<h2 align="center"> <font color="336699"> Registrar Entrada ou Saída de Produto </font></h2> 
					<form action="../controller/query_entra_sai.php" method="post" name="registrarEntraSai" align="center" onSubmit="return valida_dados(this)">
					<table cellpadding="0" border="1" width="100%" align="center">
					<tr>
						<td	align="center"> 
						</br> 
							<hr width="30%">
							<font color="336699" size="+2">
								<input type="radio" name="op" value="entrada"/> Entrada &nbsp; &nbsp;
								<input type="radio" name="op" value="saida" /> Saída
							</font>
							<hr width="30%">
						</br>
						<hr width="95%">
						</br> </br>
							<label> <font color="336699"/> Mátricula: </label>
							<label> <input readonly="false" name="matricula" value="<?php echo $matricula; ?>" type="text" size="11" maxlength="11"/> </label>
						&nbsp; &nbsp;
							<label> <font color="336699"/> Usuário: </label>
							<label> <input readonly="false" name="usuario" value="<?php echo $nomeUsuario; ?>" type="text" size="40" maxlength="40"/> </label>
						&nbsp; &nbsp;
							<label> <font color="336699"/> Data: </label>
							<label> <input readonly="false" name="data" value="<?php echo date("d/m/Y"); ?>" type="text" size="11" maxlength="11"/> </label>
						&nbsp; &nbsp;
							<label> <font color="336699"/> Hora: </label>
							<label> <input readonly="false" name="hora" value="<?php echo date("H:i"); ?>" type="text" size="5" maxlength="5"/> </label>
						</br> </br>
							<label> <font color="336699"/> Cód. Interno: </label>
							<label> <input readonly="false" name="codInterno" value="<?php echo $codInterno; ?>" type="text" size="8" maxlength="8"/> </label>
						&nbsp; &nbsp;
							<label> <font color="336699"/> Cód. Barras: </label>
							<label> <input readonly="false" name="codBarrasTela" value="<?php echo $codBarras; ?>" type="text" size="30" maxlength="30"/> </label>
						&nbsp; &nbsp;
							<label> <font color="336699"/> Descrição: </label>
							<label> <input readonly="false" name="descricao" value="<?php echo $descTotal; ?>" type="text" size="40" maxlength="40"/> </label>
						</br> </br>
							<label> <font color="336699"/> Quantidade: </label>
							<label> <input name="qtd" type="text" size="4" maxlength="4" onkeyup='if (isNaN(this.value)) {this.value = ""}'/><?php echo $compleDescricao ?> </label>
						&nbsp; &nbsp;	
							<label> <font color="336699"/> Quantidade no Estoque: </label>
							<label> <input readonly="false" name="qtdEstoque" value="<?php echo $qtdEstoque; ?>" type="text" size="5" maxlength="5"/> </label>
						</br> </br>
							<label> <font color="336699"/> Observação: </label>
							<label> <input name="observacao" value="-" type="text" size="55" maxlength="40"/> </label>
						</br> </br> 
							<input type="submit" name="salvar" value="  REGISTRAR  "/> &nbsp; &nbsp; &nbsp;
						</br> </br> 
						</td>
					</tr>
					</table>
					<hr width="95%">
					<label> <input type="hidden" readonly="false" name="desc" value="<?php echo $descricao; ?>" size="20" maxlength="20"/> </label>
					<label> <input type="hidden" readonly="false" name="mut" value="<?php echo $multiplicador; ?>" size="5" maxlength="5"/> </label>
					</form>
				</div>
				<br/><br/>
				<?php 
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>