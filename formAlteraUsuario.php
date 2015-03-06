<?php
	require_once('scripts/functions.php');
	require 'layoutUp.php';
	//Acesso permitido somente a usuários de nível adminGeral ou adminDeus
	session_validaLoginRedirect('adminGeral','adminDeus');

	class Empresa {
		public $intId;
		public $strNome;
	}

	function bd_printOptionsEmpresas() {
		$objMysqli = bd_conecta();
		
		//Cria comando SQL
		$strSQL = 'SELECT id, nome FROM empresas;';
             
        if ($objStmt = $objMysqli->prepare($strSQL)) {
        	
			//Executa query SQL
			if ($objStmt->execute()) {
				$objEmpresa = new Empresa();

				//Configura em que variáveis serão guardados os retornos da query
				$objStmt->bind_result(
					$objEmpresa->intId,
					$objEmpresa->strNome);
				
				//Para cada empresa no banco de dados, imprime uma opção para ela
				while( $objStmt->fetch() ) {
					echo '<option id="empresa_option_'.$objEmpresa->intId.'" value="'.$objEmpresa->intId.'">'.$objEmpresa->strNome.'</option>';
				}
			}

			$objStmt->close();
        }

        //Se ocorreu algum erro, mostra mensagem de erro.
        if($objMysqli->errno) {
        	throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
        }

		//Finaliza conexão ao BD		
		$objMysqli->close();		
	}

?>
<html>
	<head>
		<title>Formulário de alteração de usuário</title>
	</head>
	<body>
		<header>
			<?php
				session_printWelcomeMessage();
                		//Mock para select default do comboBox "Nível" para usuario de nivel admin
				$nivel="nivel_admin";
			?>
		</header>
		<form action="alteraUsuario.php" method="POST">
			Nome: <input name='nome' type='text' required></input><br/>
			Email: <input name='email' type='text' required></input><br/>
			Senha: <input name='senha' type='password' required></input><br/>
			Nível:

            <select name="nivel" id="usuario_nivel" required>
                <option id="nivel_aluno" value="aluno">Aluno</option>
                <option id="nivel_admin" value="admin">Membro de RH</option>
                <?php
                if ( session_validaLogin('adminDeus') ) {
                    ?>
                    <option id="nivel_adminGeral" value="adminGeral">Diretor de RH</option>
                    <option id="nivel_adminDeus" value="adminDeus">Admin Deus</option>
                <?php
                }
                ?>
            </select><br/>
            <script>
                
                	function changeSelectedOption(optionId) {
						var optionElement = document.getElementById(optionId);
                		optionElement.setAttribute("selected","selected");
                	}
                	changeSelectedOption("<?php echo $nivel ?>");
            
            </script>

			<?php 
				if ( session_validaLogin('adminDeus') ) {
			?>
					Id_Empresa:
					<select name="id_empresa" required>
										
						<?php
							try {
								bd_printOptionsEmpresas();							
							}
							catch (Exception $objE) {
								echo '</select>';
								die('Erro: ' . $objE->getMessage());
							}
							//Mock para select default do comboBox com empresa de usario 1
							$empresa=1;
						?>

					</select><br/>
				<script>
                	
                	var empresaOption = "empresa_option_" + "<?php echo $empresa ?>"; 
                	changeSelectedOption(empresaOption);
            
            	</script>

			<?php
				}
				else {
					echo '<input name="id_empresa" type="hidden" value="'.$_SESSION['id_empresa'].'"></input>';
				}
			?>			
			<button type='submit'>Alterar</button>
		</form>
	</body>
<?php
	require 'layoutDown.php';
?>
