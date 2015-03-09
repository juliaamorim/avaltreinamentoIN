<?php
	require_once('scripts/session.php');
	require_once('scripts/bd.php');
	//Acesso permitido somente a usuários de nível adminGeral ou adminDeus
	// session_validaLoginRedirect('adminGeral','adminDeus');
?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Gerenciar usuários</title>
	</head>
	<body>
		<header>
			<?php
				session_printWelcomeMessage();
			?>
		</header>		
		<nav>
			<?php	
			
				$strBusca = $_POST['busca'];
				$tIntAtivo = $_POST['ativo'];

			
			$mysqli = new mysqli('localhost','root','','avaltreinamento');
             
			if (mysqli_connect_errno()){
                die('Não foi possível conectar-se ao banco de dados.<a href="formGerenciaUsuario.php"> Tente novamente</a>'/*.mysqli_connect_error()*/);
            }
			else{
				
				if($strBusca == ''){
					$sql = "select * from usuarios where ativo = '1' OR ativo = '$tIntAtivo'";
				}
				else {
					$sql = "select * from usuarios where nome ='$strBusca' AND ( ativo = '1' OR ativo = '$tIntAtivo') ";
				}
				$query = $mysqli->query($sql);
			}
			
				if($query){
					
					echo 'Registros encontrados: '.$query->num_rows;
					
					if($query->num_rows > 0){
						
						echo '<br><br>Listagem de usuários: <br><br>';
						
				
						
						while ($objDados = $query->fetch_array()) { #indexação pelo nome ou indice
	
							echo 'Nome: ' . $objDados['nome'] . '<br>';
				
							echo 'Email: ' . $objDados['email'] . '<br>';
							
							echo 'Nível: ' . $objDados['nivel'] . '<br>';
							
							switch ($objDados['ativo']){
							case 0:
							$strAtivo = "Não";
							break;
							case 1:
							$strAtivo = "Sim";
							break;} 
							
							echo 'Ativo: ' . $strAtivo . '<br>';							
							

							echo '<a href="alteraUsuario.php?editar='.$objDados['id'].'">Editar</a> &nbsp;&nbsp;';
							
							echo '<a href="excluiUsuario.php?excluir='.$objDados['id'].'">Excluir</a>';
							

							echo '<br><br>';
						}
						
						mysqli_free_result($query);
				
						mysqli_close($mysqli);
					}
					
				}
				else{ ?>
					Não foi possível realizar a busca dos dados. <a href="javascript:window.history.go(-1)">Clique aqui para tentar novamente</a>
				<?php }
				
			
		
	?>
	
		</nav>
	</body>
</html>