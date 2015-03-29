<?php
	require_once('scripts/functions.php');
	class Usuario {
		public $strNome;
		public $strEmail;
		public $strNivel;
		public $intIdEmpresa;
		public $intAtivo;
	}
	//TODO: Armazenar senha em HASH e valida senha usando HASH
	function buscaUsuario($strEmail, $strSenha) {
		$objUsuario = null;
		$objMysqli = bd_conecta();
		
		//Cria comando SQL
		$strSQL = 'SELECT nome, email, nivel, id_empresa, ativo FROM usuarios WHERE email = ? AND senha = ?;';
             
        if ($objStmt = $objMysqli->prepare($strSQL)) {
        	//Preenche parâmetros SQL de forma segura
			$objStmt->bind_param('ss',$strEmail,$strSenha);
			//Executa query SQL
			if ($objStmt->execute()) {
				$objUsuario = new Usuario();
				//Configura em que variáveis serão guardados os retornos da query
				$objStmt->bind_result(
					$objUsuario->strNome,
					$objUsuario->strEmail,
					$objUsuario->strNivel,
					$objUsuario->intIdEmpresa,
					$objUsuario->intAtivo);
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
		return $objUsuario;
	}
	
	//Se já estiver logado, então pula tudo isso e simplesmente mostra sua Home
	//Se não está logado, entra nesse if e verifica se houve tentativa de login (o usuário está vindo do formulário de login)
	//Se não está logado e não houve tentativa de login, então pula isso e mostra a Home para usuário anônimo
	if(!session_validaLogin()) {
		//Pega login e senha passados pelo formulário de login
		$strEmail = (isset($_POST['email']) ? $_POST['email'] : null);		
		$strSenha = (isset($_POST['senha']) ? sha1($_POST['senha']) : null); //modificação pegando o sha-1 da senha
		
		//Tentativa de login
		if ( $strEmail && $strSenha) {
			$objUsuario = buscaUsuario($strEmail, $strSenha);
			//Se $usuario é null, então email e/ou senha são inválidos
			if ( is_null($objUsuario) ) {
				include_once('layoutUp.php');
				setaMensagem('Email e/ou senha inv&aacutelidos.', 'erro');
				imprimeMenssagem();
			}
			else { 
			//modificado para testar se o usuário está ativo na empresa
			//caso esteja inicializa a session, caso contrario exibe mensagem de erro
				if($objUsuario->intAtivo != 0){
					$_SESSION['nome'] = $objUsuario->strNome;
					$_SESSION['email'] = $objUsuario->strEmail;
					$_SESSION['nivel'] = $objUsuario->strNivel;
					$_SESSION['id_empresa'] = $objUsuario->intIdEmpresa;
					$_SESSION['ativo'] = $objUsuario->intAtivo;
				}else{
					include_once('layoutUp.php');
					setaMensagem('O usu&aacuterio é inv&aacutelido.', 'erro');
					imprimeMenssagem();
				}
			}
		}
		//Preencheu somente um campo do formulário de login
		else if ( $strEmail || $strSenha) {
			include_once('layoutUp.php');
			setaMensagem('Todos os campos do formulário de login são obrigatórios.', 'erro');
			imprimeMenssagem();
		}
	}
	
?>

<?php include_once('layoutUp.php'); ?>

<?php
	session_printWelcomeMessage();
?>	
			
<?php include('layoutDown.php'); ?>
	