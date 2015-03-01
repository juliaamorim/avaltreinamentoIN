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

	
	//função para enviar menssagens. para enviar uma menssagem por ela, basta setar a menssagem e seu tipo no caso de uso anteriro por meio da função setaMenssagem()
	function imprimeMenssagem(){
		//testa se tem alguma mensagem, se tiver, printa
		if(isset($_SESSION['msg']) && isset($_SESSION['tipo'])){
			$classe = "";
			switch($_SESSION['tipo']){
				case "info":
					$classe = "info";
					break;
				case "sucesso":
					$classe = "sucesso";
					break;
				case "erro":
					$classe = "erro";
					break;
			}
				
			?>
				<div class="<?php=$classe?>">
					<?php
					switch($_SESSION['tipo'])
					{
						case "info":
							echo "<strong>Info:</strong><br />" . $_SESSION['msg'];
							break;
						case "sucesso":
							echo "<strong>Successo:</strong><br />" . $_SESSION['msg'];
							break;
						case "erro":
							echo "<strong>Erro:</strong><br />" . $_SESSION['msg'];
							break;
					}
					?>
				</div>
			<?php

			unset($_SESSION['msg']);
			unset($_SESSION['tipo']);
		}
	}
	
	//essa função serve para setar menssagem e seu tipo. menssagem essa que será impressa no proximo caso de uso em que o usuário entrar através da função anterior, imprimeMenssagem()
	function setaMenssagem($strMenssagem, $strTipo){
		$_SESSION['tipo'] = strTipo;
		$_SESSION['msg'] = strMenssagem;
	}
	
	
	
	
	
?>