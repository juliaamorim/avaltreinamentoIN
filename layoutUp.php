<header>
	
		<!-- <h1> Curso HTML</h1>
		<h2><em>IN</em><em>Junior</em></h2> -->
</header>
<section id="main">
<div class="menuLogoDiv">
		<img src="img/logo-menu.png"/>
	</div>
	
	<div id='cssmenu'>
		<ul>
			<li class='has-sub'><a href='#'><span><img src="img/menu.png"/></span></a>
				<ul> <!-- ul com os li e sub ul+li's, aka ul chefe -->
					<?php
						if(session_validaLogin() ){ //verifica se usuário está logado senão mostra somente link de login
							// mostra opção para AdminDeus
							if(session_validaLogin('adminDeus') ){
							?>
								<li class='has-sub'><a href='#'><span>Empresa</span></a>
								<ul>
									<li><a href='insereEmpresa.php'><span>Insere Empresa</span></a></li>
									<li><a href='alteraEmpresa.php'><span>Altera Empresa</span></a></li>
									<li class='last'><a href='gerenciarEmpresa.php'><span>Gerenciar Empresa.php</span></a></li>
								</ul>
							</li>
							<?php	
						}
						// mostra opção para AdminGeral e AdminDeus
						if(session_validaLogin('adminGeral','adminDeus') ){
							?>
							<li class='has-sub'><a href='#'><span>Usuario</span></a>
								<ul>
									<li><a href='formInserirUsuario.php'><span>Inserir Usuario</span></a></li>
									<li><a href='visualizarUsuario.php'><span>Visualizar Usuario</span></a></li>
									<li><a href='alteraUsuario.php'><span>Alterar Usuario</span></a></li>
									<li class='last'><li><a href='formGerenciaUsuario.php'><span>Gerenciar Usuario</span></a></li>
								</ul>
							</li>
							<?php
						}
						?>
						<!-- mostrar para todos usuarios logados-->
						<li class='has-sub'><a href='#'><span>Avaliacao</span></a>
							<ul>
								<li><a href='inserir_avaliacaoComSession.php'><span>Inserir Avaliacao</span></a></li>
								<li><a href='visualizarAvaliacao.php'><span>Visualizar Avaliacao</span></a></li>
								<li class='last'><a href='alterarAvaliacao.php'><span>Alterar Avaliacao</span></a></li>
							</ul>
						</li>
						
						<li class='last'><a href='logout.php'><span>Logout</span></a></li>
						
						<?php
							//mostrar apenas para usuários não logados
						}else{
						?>
							<li class='last'><a href='login.php'><span>Login</span></a></li>
						<?php
						}
					?> 
				</ul> <!-- fim do ul chefe -->
			</li> <!-- fim icone do menu -->
		</ul>
	</div>