<?php
	require_once('scripts/functions.php');
    session_validaLoginRedirect('adminGeral','adminDeus');

    include "usuario.php";
    include "empresa.php";

    function alterarUsuario($objUsuario) {
        //Mock para um usuario já recuperado com id=2
        $id_usuario = 2;

        $nome=$objUsuario->getNome();
        $email=$objUsuario->getEmail();
        $senha=$objUsuario->getSenha();
        $nivel=$objUsuario->getNivel();
        $ativo=$objUsuario->getAtivo();
        $empresa=$objUsuario->getEmpresa();


        $strSQL = "UPDATE usuarios SET nome=?, email=?, senha=?, nivel=?, id_empresa=Coalesce($empresa), ativo=? WHERE id=?;";

        $objMysqli = bd_conecta();

        $objStmt = $objMysqli->prepare($strSQL);

        if(!$objStmt) {
            throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
        }

        $objStmt->bind_param('ssssii',
            $nome,
            $email,
            $senha,
            $nivel,
            $ativo,
            $id_usuario);

        $ok = $objStmt->execute();

        if(!$ok) {
            throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
        }

        $objStmt->close();
        $objMysqli->close();

    }

        //***Chamada para visualizar o Usuário a ser editado***

        $objUsuario = new Usuario();

        $objUsuario->setNome(isset($_POST['nome']) ? $_POST['nome'] : null);
        $objUsuario->setEmail(isset($_POST['email']) ? $_POST['email'] : null);
        $objUsuario->setSenha(isset($_POST['senha']) ? $_POST['senha'] : null);
        $objUsuario->setNivel(isset($_POST['nivel']) ? $_POST['nivel'] : null);
        $objUsuario->setEmpresa(isset($_POST['id_empresa']) ? $_POST['id_empresa'] : null);
        $objUsuario->setAtivo(1);

        if (!$objUsuario->getNome() || !$objUsuario->getEmail() || !$objUsuario->getSenha() || !$objUsuario->getNivel() || !$objUsuario->getEmpresa()) {
            echo 'Existe(m) campos(s) obrigatórios(s) em branco, <a href="window.history.go(-1)">clique aqui para tentar novamente</a>.';
        }
        else {
            try {
                alterarUsuario($objUsuario);
                echo 'Usuário alterado com sucesso';
            }
            catch (Exception $objE) {
                echo 'Erro: ' . $objE->getMessage();
            }
        }
?>
<html lang="pt-BR">
	<head>
		<title>Formulário de alteração de usuário</title>
	</head>
    <link
        href="css/style.css"
        title="style"
        type="text/css"
        rel="stylesheet"
        media="all"
        />

    <body>
    <?php require 'layoutUp.php';
		//Mock para select default do comboBox "Nível" para usuario de nivel admin
        $nivel="nivel_admin";
    ?>
		</header>
		<form action="alterarUsuario.php" method="POST">
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
    <?php
        require 'layoutDown.php';
    ?>
    </body>
</html>