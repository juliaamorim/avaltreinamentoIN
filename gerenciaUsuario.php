<?php
	require_once('scripts/functions.php');
	//Acesso permitido somente a usuários de nível adminGeral ou adminDeus
	//session_validaLoginRedirect('adminGeral','adminDeus');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Gerenciar usuários</title>
		<meta charset="UTF-8"/>
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

			
			$mysqli = bd_conecta();
             
			if (mysqli_connect_errno()){
                die('Não foi possível conectar-se ao banco de dados.<a href="formGerenciaUsuario.php"> Tente novamente</a>'/*.mysqli_connect_error()*/);
            }
			else{
				if($strBusca == ''){
					$sql = "select * from usuarios where (ativo = '1' OR ativo = '$tIntAtivo')";
				}
				else {
					$sql = "select * from usuarios where (nome ='$strBusca' AND ( ativo = '1' OR ativo = '$tIntAtivo')) ";
				}
				if(session_validaLogin('adminGeral')){
					$sql = $sql.' AND (id_empresa = '.$_SESSION['id_empresa'].')';
				}
				$query = $mysqli->query($sql);
			}
			
				if($query){
					
					echo 'Registros encontrados: '.$query->num_rows;
					
					if($query->num_rows > 0){
						echo "<table border='1'>
							<tr>
								<th>Nome</th>
								<th>Email</th>
								<th>Nível</th>
								<th>Ativo</th>
							</tr>";
						
				
						
						while ($objDados = $query->fetch_array()) { #indexação pelo nome ou indice
							echo "<tr>";

							echo "<td>" . $objDados['nome'] . "</td>";
				
							echo "<td>" . $objDados['email'] . "</td>";
							
							echo "<td>" . $objDados['nivel'] . "</td>";
							
							switch ($objDados['ativo']){
							case 0:
							$strAtivo = "Não";
							break;
							case 1:
							$strAtivo = "Sim";
							break;} 
							
							echo "<td>" . $strAtivo . "</td>";							
							

							echo '<td><a href="alteraUsuario.php?editar='.$objDados['id'].'">Editar</a></td>';
							
							echo '<td><a href="excluiUsuario.php?excluir='.$objDados['id'].'">Excluir</a></td>';
							
							echo "</tr>";
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