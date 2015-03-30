<?php
	require_once('scripts/functions.php');
	//função para mostrar o nome do usuario na barra
	function menu_printWelcomeMessage() {
		if ( isset( $_SESSION['nome']) ) {
			echo '<span>';
			echo 'Bem-vindo, '.$_SESSION['nome']. '.</span><span>';
			echo '<a href="alterarSenha.php"> Alterar Senha</a> | <a href="logout.php">Logout</a>' ;
			echo '</span>';
		}else{
			echo '<span>';
			echo htmlentities('Bem-vindo, Anônimo.');	//htmlentities() codifica os caracteres especiais em html
			echo '</span><span><a href="login.php"> Login </a>';
			echo '</span>';
		}
	}
// FIM DO MEU PHP
?>

<html lang="pt-BR">
	<head> <!--htmlentities() codifica os caracteres especiais em html-->
		<title><?php echo htmlentities('SAT - Sistema de Avaliação de Treinamento'); ?></title>
		<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>

		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="datatable/media/css/jquery.dataTables.css">
		
		<!-- jQuery -->
		<script type="text/javascript" src="datatable/media/js/jquery.js"></script>
  
		<!-- DataTables -->
		<script type="text/javascript" src="datatable/media/js/jquery.dataTables.js"></script>
	</head>
	<body>
		<header>
			
				<!-- <h1> Curso HTML</h1>
				<h2><em>IN</em><em>Junior</em></h2> -->
		</header>

		<section id="main">
			
			<div id="menuTab">
				<div style="display: table-row">
					<!-- esquerda -->
					<div id = 'usuarioMsg'>
						<?php menu_printWelcomeMessage(); ?>
					</div>
					<!-- direita -->
					<div id='cssmenu'>
				
						<ul> <!-- ul com os li e sub ul+li's, aka ul chefe -->
							<?php
								if(session_validaLogin() ){ //verifica se usuário está logado senão mostra somente link de login
									// mostra opção para AdminDeus
									if(session_validaLogin('adminDeus') ){
									?>
										<li class='has-sub'><a href='#'><span>Empresa</span></a>
										<ul>
											<li><a href='insereEmpresa.php'><span>Insere Empresa</span></a></li>
											<li class='last'><li><a href='gerenciarEmpresa.php'><span>Gerenciar Empresa</span></a></li>
										</ul>
									</li>
									<?php	
								}
								// mostra opção para AdminGeral e AdminDeus
								if(session_validaLogin('adminGeral','adminDeus') ){
									?>
									<li class='has-sub'><a href='#'><span>Usu&aacuterio </span></a>
										<ul>
											<li><a href='visualizarUsuario.php'><span>Visualizar Usu&aacuterio </span></a></li>
											<li><a href='insereUsuario.php'><span>Inserir Usu&aacuterio </span></a></li>
											<li class='last'><li><a href='gerenciaUsuario.php'><span>Gerenciar Usu&aacuterio </span></a></li>
										</ul>
									</li>
									<?php
								}
								?>
								<!-- mostrar para todos usuarios logados-->
								<li class='has-sub'><a href='#'><span>Avalia&ccedil&atildeo</span></a>
									<ul>
										<li><a href='visualizarAvaliacao.php'><span>Visualizar Avalia&ccedil&atildeo</span></a></li>
										<?php
										if(session_validaLogin('adminGeral','adminDeus')){
										?>
										<li><a href='insereAvaliacao.php'><span>Inserir Avalia&ccedil&atildeo</span></a></li>
										<li class='last'><a href='alterarAvaliacao.php'><span>Alterar Avalia&ccedil&atildeo</span></a></li>
										<?php
										}
										?>
									</ul>
								</li>
								
								<?php
									//fechamento do menu
								}
							?> 
						</ul> <!-- fim do ul chefe -->
							
					</div>
				</div>
			</div>
			
		<article id="content"> <!-- basicamente vai todo php que mostra página pro usuário -->
		<!-- resto fechado no layoutDown.php	-->
	