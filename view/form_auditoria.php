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
	
	$idusuario = $_SESSION["idusuario"];
	
	$servidor 		= `uname -a | awk -F" " '{print $2}'`;
	$filialUserAqui	= trim($servidor);
	
	//Dados do usuario:
	$sqlUsuario 	= mysql_query("select matricula, idusuario, nomusuario from usuariosc where descsetor = 'PREVENCAO' and filial = '$filialUserAqui'");
	
	//Dados do produto na tabela estoque:
	$sqlProduto		 = mysql_query("select codInterno, descProduto from Confinado_Estoque where qtd <> 0 and filial = '$filialUserAqui'");
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.ListarAuditoria.data_inicio.focus()">
	<!-- --------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
		function Formatadata(Campo, teclapres)
		{
			var tecla = teclapres.keyCode;
			var vr = new String(Campo.value);
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			tam = vr.length + 1;
			if (tecla != 8 && tecla != 8)
			{
				if (tam > 0 && tam < 2)
					Campo.value = vr.substr(0, 2) ;
				if (tam > 2 && tam < 4)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
				if (tam > 4 && tam < 7)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 7);
			}
		}
	</script>

	<script language="javascript">
	function valida_dados (agenda_outro_dia)
		if (agenda_outro_dia.data_inicio.value=="") {
			alert ("Por favor digite a data inicio !");
			agenda_outro_dia.data_inicio.focus();
			return false;
		}
		if (agenda_outro_dia.data_fim.value=="") {
			alert ("Por favor digite a data fim !");
			agenda_outro_dia.data_fim.focus();
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
					<h2 align="center"> <font color="336699"> Gerar Relatorio </font></h2> 
					</br>
					<hr width="60%">
					<form action="listar_auditoria.php" method="post" name="ListarAuditoria" align="center" onSubmit="return valida_dados(this)">
					<table cellpadding="0" border="1" width="80%" align="center">
					<tr>
						<td	align="center"> 
						</br >
							<label> <font color="336699">  Data Inicio: </label> &nbsp;
							<input type="text" name="data_inicio" size="10" maxlength="10" onkeyup="Formatadata(this,event)" />&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;
							<label> <font color="336699">  Data Fim: </label> &nbsp;
							<input type="text" name="data_fim" size="10" maxlength="10" onkeyup="Formatadata(this,event)" />&nbsp; &nbsp; &nbsp;
						</br>
							<label> <font color="336699">  (**Digite apenas numeros para ficar assim: 01/02/2016) </label> &nbsp;
						</br> </br> 
							<label> <font color="336699">  Usuário: </label> &nbsp;
							<select size="1" name="usuario">
								<option value="999"> Todos </option>
								<?php
									while ($dadosUsuario = mysql_fetch_array($sqlUsuario)){
										$matric = $dadosUsuario[matricula];
										$matric = substr($matric,(strlen($matric)-2),strlen($matric));
								?>
										<option value="<?php echo $dadosUsuario[idusuario]?>"> <?php echo $matric . " - " . $dadosUsuario[nomusuario]?></option>
								<?php }?>	
							</select> &nbsp; &nbsp;
						</br > 	</br > 	
							<label> <font color="336699">  Produto: </label> &nbsp;
							<select size="1" name="produto">
								<option value="999"> Todos </option>
								<?php
									while ($dadosProduto = mysql_fetch_array($sqlProduto)){
								?>
										<option value="<?php echo $dadosProduto[codInterno]?>"> <?php echo $dadosProduto[codInterno] . " - " . $dadosProduto[descProduto]?></option>
								<?php }?>	
							</select> &nbsp; &nbsp;
						</br > 	</br > 	
							<label> <font color="336699">  Motivo: </label> &nbsp;
							<select size="1" name="motivo">
								<option value="999"> Ambos </option>
								<option value="1"> Entrada </option>
								<option value="2"> Saída </option>
							</select> &nbsp; &nbsp;
						</br> </br> </br>
							<input type="submit" name="listar" value="  LISTAR  "/> &nbsp; &nbsp; &nbsp;
						</br> </br> 
						</td>
					</tr>
					</table>
					<label> <input type="hidden" readonly="false" name="desc" value="<?php echo $descricao; ?>" size="20" maxlength="20"/> </label>
					<label> <input type="hidden" readonly="false" name="mut" value="<?php echo $multiplicador; ?>" size="5" maxlength="5"/> </label>
					</form>
					<hr width="60%">
				</div>
				<br/><br/>
				<?php 
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>