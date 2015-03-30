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

        function buscarUsuario($intID) {
            $objUsuario = null;
            $objMysqli = bd_conecta();
            
            //Cria comando SQL
            $strSQL = 'SELECT nome, email, nivel, id_empresa, ativo FROM usuarios WHERE id = ?;';
                 
            if ($objStmt = $objMysqli->prepare($strSQL)) {
                //Preenche parâmetros SQL de forma segura
                $objStmt->bind_param('i',$intID);
                //Executa query SQL
                if ($objStmt->execute()) {
                    //Configura em que variáveis serão guardados os retornos da query
                    $objStmt->bind_result(
                        $nome,
                        $email,
                        $nivel,
                        $empresa,
                        $ativo);
                    //Se não houve retorno (não achou usuario), então $objUsuario = null
                    if( !$objStmt->fetch() ) {
                        $objUsuario = null;
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
            //Retorna objeto $objUsuario
            $objUsuario = new Usuario();
            
            $objUsuario->setNome($nome);
            $objUsuario->setEmail($email);
            $objUsuario->setNivel($nivel);
            $objUsuario->setEmpresa($empresa);
            $objUsuario->setAtivo($ativo);

            return $objUsuario;
    }


    $usuario_id = $_GET['editar'];
    
    $usuario_buscado = buscarUsuario($usuario_id);

    $objUsuario = new Usuario();

    $objUsuario->setNome(isset($_POST['nome']) ? $_POST['nome'] : null);
    $objUsuario->setEmail(isset($_POST['email']) ? $_POST['email'] : null);
    $objUsuario->setSenha(isset($_POST['senha']) ? sha1($_POST['senha']) : null);
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
        #$nivel="nivel_admin";
        $nivel = 'nivel_' . $usuario_buscado->getNivel();
    ?>
		</header>
		<form action="alteraUsuario.php" method="POST">
			<h2>Editar Usuário</h2>

            Nome: <input name='nome' value="<?php echo $usuario_buscado->getNome() ?>" type='text' required></input><br/>
			Email: <input name='email' type='text' value="<?php echo $usuario_buscado->getEmail() ?>" required></input><br/>
			Senha: <input name='senha' type='password' value="<?php echo $usuario_buscado->getSenha() ?>" required></input><br/>
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
					Empresa:
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
							$empresa=$usuario_buscado->getEmpresa();
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