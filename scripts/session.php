<?php
	//Se a sessão ainda não foi iniciada, inicia a sessão
	if ( !isset ( $_SESSION ) ) {
		session_start();
	}

	/*
	Descrição:
	Esta função verifica se o usuário está logado.
	Se não estiver, retorna false.
	Se estiver logado, a função verifica se o usuário logado é de algum dos níveis especificados pelos parâmetros.
	Se não for, retorna false.
	Esta função pode receber quantos parâmetros forem necessários.

	Exemplo de uso:
	Para validar apena se o usuário está logado: validaLogin()
	Para validar se o usuário está logado e é de nível adminGeral: validaLogin('adminGeral')
	Para validar se o usuário está logado e é de nível adminGeral ou adminDeus: validaLogin('adminGeral', 'adminDeus')
	*/
	function session_validaLogin() {
		//Se não logado, retorna false
		if ( !isset( $_SESSION['nome'] ) ) {
			return false;			
		}
		//Se logado e possui argumentos, valida nível do usuário
		else if (func_num_args() > 0) {
			foreach (func_get_args() as $param) {
		        if ( $_SESSION['nivel'] == $param ) {
					return true;
				}
		    }
		    return false;
		}
		return true;
	}

	function session_validaLoginRedirect() {
		$args = func_get_args();
		$validado = call_user_func_array('session_validaLogin', $args);
		if ( !$validado ) {
			header('Location: semPermissao.php');
		}
	}

	function session_printWelcomeMessage() {
		if ( isset( $_SESSION['nome']) ) {
			echo 'Bem-vindo, '.$_SESSION['nome']. '. ';
			echo '<a href="logout.php"> Logout </a>';
			echo '<br/>';
			echo '<br/>';
		}
		else {
			echo 'Bem-vindo, Anônimo. ';	
			echo '<a href="login.php"> Login </a>';
			echo '<br/>';
			echo '<br/>';
		}
	}

	function logout() {
		echo 'Logging out...';
		session_destroy();
		header('Location: index.php');
	}

?>