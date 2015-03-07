<?php
	//Se a sessão ainda não foi iniciada, inicia a sessão
	if ( !isset ( $_SESSION ) ) {
		session_start();
	}

	//Cria conexão ao banco de dados e retorna o objeto de link
	function bd_conecta() {
		$objMysqli = new mysqli('localhost','root','130293','avaltreinamento');
		
		if ($objMysqli->connect_errno){ //htmlentities() codifica os caracteres especiais em html
			die(htmlentities('Falha na conexão ao banco de dados: ').mysqli_connect_error()); 
		}
		
		$objMysqli->set_charset('latin1_swedish_ci');

		return $objMysqli;
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
			foreach (func_get_args() as $strParam) {
		        if ( $_SESSION['nivel'] == $strParam ) {
					return true;
				}
		    }
		    return false;
		}
		return true;
	}

	function session_validaLoginRedirect() {
		$arrayArgs = func_get_args();
		$boolValidado = call_user_func_array('session_validaLogin', $arrayArgs);
		if ( !$boolValidado ) {
			header('Location: semPermissao.php');
		}
	}

	function session_printWelcomeMessage() {
		if ( isset( $_SESSION['nome']) ) {
			echo 'Bem-vindo, '.$_SESSION['nome']. '. ';
			echo '<a href="logout.php"> Logout </a>';
			echo '<br/>';
			echo '<br/>';
		}else{
			echo htmlentities('Bem-vindo, Anônimo. ');	//htmlentities() codifica os caracteres especiais em html
			echo '<a href="login.php"> Login </a>';
			echo '<br/>';
			echo '<br/>';
		}
	}

	function session_logout() {
		echo 'Logging out...';
		session_destroy();
		header('Location: index.php');
	}

	
	//função para enviar menssagens. para enviar uma menssagem por ela, basta setar a mensagem e seu tipo no caso de uso anterior por meio da função setaMenssagem()
	function imprimeMenssagem(){
		//testa se tem alguma mensagem, se tiver, printa
		if(isset($_SESSION['msg']) && isset($_SESSION['tipo'])){
			$strClasse = "";
			switch($_SESSION['tipo']){
				case "info":
					$strClasse = "info";
					break;
				case "sucesso":
					$strClasse = "sucesso";
					break;
				case "erro":
					$strClasse = "erro";
					break;
			}
				
			?>
				<div class="<?php=$strClasse?>">
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
