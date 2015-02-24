<?php

	//Cria conexão ao banco de dados e retorna o objeto de link
	function bd_conecta() {
		$mysqli = new mysqli('localhost','root','injunior','avaltreinamento');
		
		if ($mysqli->connect_errno){
			die('Falha na conexão ao banco de dados: '.mysqli_connect_error());
		}
		
		$mysqli->set_charset('latin1_swedish_ci');

		return $mysqli;
	}

	//Caso de Uso: Inserir Usuário
	//TODO: Armazenar senha em HASH e valida senha usando HASH
	function bd_insereUsuario($usuario) {
		$mysqli = bd_conecta();
		
		//Cria comando SQL
		$sql = 'INSERT INTO usuarios(nome,email,senha,nivel,id_empresa,ativo)'.'VALUES (?,?,?,?,?,?);';
		$stmt = $mysqli->prepare($sql);

		//Informa mensagem de erro na criação do comando SQL
		if(!$stmt) {
			throw new Exception($mysqli->errno .', ' . $mysqli->error);
		}

		//Preenche parâmetros SQL de forma segura
		$stmt->bind_param('ssssii',
			$usuario->nome,
			$usuario->email,
			$usuario->senha,
			$usuario->nivel,
			$usuario->id_empresa,
			$usuario->ativo);		
		$ok = $stmt->execute();
		
		//Tratamento do resultado da operação
		if(!$ok) {			
			throw new Exception($mysqli->errno .', ' . $mysqli->error);
		}
		
		//Finaliza conexão ao BD
		$stmt->close();
		$mysqli->close();
		
	}

	function alterarUsuario($usuario) {

		$sql = "UPDATE usuarios SET (nome, email, senha, nivel, ativo) 
		VALUES (?, ?, ?, ?, ?);";
		
		$stmt = $mysqli->prepare($sql);

		if(!$stmt) {
			throw new Exception($mysqli->errno .', ' . $mysqli->error);
		}

		$stmt->bind_param('ssssi',
			$usuario->nome,
			$usuario->email,
			$usuario->senha,
			$usuario->nivel,
			$usuario->ativo);		
		
		$ok = $stmt->execute();
		
		if(!$ok) {			
			throw new Exception($mysqli->errno .', ' . $mysqli->error);
		}

		$stmt->close();
		$mysqli->close();

	}	

	//TODO: Armazenar senha em HASH e valida senha usando HASH
	function bd_buscaUsuario($email, $senha) {
		$usuario = null;
		$mysqli = bd_conecta();
		
		//Cria comando SQL
		$sql = 'SELECT nome, email, nivel, id_empresa, ativo FROM usuarios WHERE email = ? AND senha = ?;';
             
        if ($stmt = $mysqli->prepare($sql)) {
        	//Preenche parâmetros SQL de forma segura
			$stmt->bind_param('ss',$email,$senha);

			//Executa query SQL
			if ($stmt->execute()) {
				$usuario = new Usuario();

				//Configura em que variáveis serão guardados os retornos da query
				$stmt->bind_result(
					$usuario->nome,
					$usuario->email,
					$usuario->nivel,
					$usuario->id_empresa,
					$usuario->ativo);

				//Se não houve retorno (não achou usuario), então $usuario = null
				if( !$stmt->fetch() ) {
					$usuario = null;
				}
			}

			$stmt->close();
        }

        //Se ocorreu algum erro, mostra mensagem de erro.
        if($mysqli->errno) {
        	throw new Exception($mysqli->errno .', ' . $mysqli->error);
        }

		//Finaliza conexão ao BD		
		$mysqli->close();

		//Retorna objeto $usuario
		return $usuario;
	}

	function bd_printOptionsEmpresas() {
		$mysqli = bd_conecta();
		
		//Cria comando SQL
		$sql = 'SELECT id, nome FROM empresas;';
             
        if ($stmt = $mysqli->prepare($sql)) {
        	
			//Executa query SQL
			if ($stmt->execute()) {
				$empresa = new Empresa();

				//Configura em que variáveis serão guardados os retornos da query
				$stmt->bind_result(
					$empresa->id,
					$empresa->nome);
				
				//Para cada empresa no banco de dados, imprime uma opção para ela
				while( $stmt->fetch() ) {
					echo '<option value="'.$empresa->id.'">'.$empresa->nome.'</option>';
				}
			}

			$stmt->close();
        }

        //Se ocorreu algum erro, mostra mensagem de erro.
        if($mysqli->errno) {
        	throw new Exception($mysqli->errno .', ' . $mysqli->error);
        }

		//Finaliza conexão ao BD		
		$mysqli->close();		
	}

	class Usuario {
		public $nome;
		public $email;
		public $senha;
		public $nivel;
		public $id_empresa;
		public $ativo;
	}

	class Empresa {
		public $id;
		public $nome;
	}

?>