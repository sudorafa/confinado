<?php
/*
	Form Criado para carregar o menu do Portal
	Rafael Eduardo L - @sudorafa
	Recife, 29 de Setembro de 2016
*/
	session_start();
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>
		<script>
			//window.location.href='#foo';
		</script>
	</head>
    <body>
		<!--<a href="#" id="foo"></a>-->
		<!-- -------------------------------------------------------------------- -->
		<!-- ------------------------- Barra de Menu ---------------------------- -->
		<!-- -------------------------------------------------------------------- -->
			<section id="menu">
                <ul>
					<li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descrição" target="_blank">MENU SYS</a></li>
				</ul>
			</section>
			<section id="menuLogado3">
				<ul>
					<?php if (($_SESSION[perfil] == "PREVENCAO")){ ?>
						<li><a href="/confinado/view/form_entra_sai.php" title="Inicio/Registrar Entradas e Saídas - Confinado">ENTRADA E SAÍDA DE PRODUTO</a></li>
							<li><a> | </a></li>
					<?php } ?>
					<li><a href="/confinado/view/form_estoque.php" title="Estoque - Confinado">ESTOQUE</a></li>
						<li><a> | </a></li>
					<li><a href="/confinado/view/form_auditoria.php" title="Auditorias - Confinado">AUDITORIA DE MOVIMENTAÇÃO</a></li>
				</ul>
			</section>
		<!-- ---------------------------------------------------------------------- -->
		<!-- ----------------------- Barra de Menu Fim ---------------------------- -->
		<!-- ---------------------------------------------------------------------- -->
    </body>
</html>