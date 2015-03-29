<!DOCTYPE html>

<?php
	require_once ('layoutUp.php');
	require_once('scripts/functions.php');
	session_validaLoginRedirect('adminGeral','adminDeus');
?>

<html lang="pt-BR">
	<head>
		<title>Visualizar Usuário</title>
	</head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<body>
<?php

	$intIdUsuario = $_GET['num'];
	
	$mysqli = bd_conecta();
		
		
		#consulta SQL: Fazendo a junção de tabelas e renomeando a coluna empresas.nome para empresa.
		
		$strSql = "select empresas.nome 'empresa', usuarios.nome, usuarios.email, usuarios.nivel, usuarios.ativo 
					from usuarios, empresas 
					where usuarios.id = $intIdUsuario and empresas.id = usuarios.id_empresa";
		
		$query = $mysqli->query($strSql);
		
		if($query){
			
					while ($dados = $query->fetch_array()) { #indexação pelo nome ou indice
							
							echo 'Nome: ' . $dados['nome'] . '<br>';	
												
							echo 'Email: ' . $dados['email'] . '<br>';
							
							echo 'Nível: '; 
							
							switch($dados['nivel']){	#Switch case para identificar o nível do usuário.
								
								case ("admin"):
									echo 'Admin';
									break;
								
								case ("adminGeral"):
									echo 'Admin Geral';
									break;
								
								case ("adminDeus"):
									echo 'Admin Deus'; 
									break;
								}
							
							
							
							echo '<br>';
																					
							echo 'Empresa: ' . $dados['empresa'] . '<br>';
							
							echo 'Ativo: ';
								if ($dados['ativo'] == 1){		#If para informar se o usuário ta ativo ou não.
									echo 'Sim';
								} 
								
								else{
									echo 'Não';
								}
							
							echo '<br>';
						
							echo '<a href="editarUsuario.php">Editar</a>';
							
							echo '<br>';
							
							echo '<a href="excluirUsuario.php">Excluir</a>';
							
							echo '<br>';
							
							echo '<a href="gerenciaUsuario.php">Voltar</a>';
							
							echo '<br><br>';
						}
						
						mysqli_free_result($query);

						mysqli_close($mysqli);
			}
						require 'layoutDown.php';
?>

	 </body>
	 
</html>
