<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
	session_validaLoginRedirect('adminGeral', 'adminDeus');
?>
<html lang="pt-BR">
	<head>
		<meta charset="UTF-8" />
		<title>Login SAT</title>
		<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>
		<!-- <section id="main"> aberto no layoutUp-->
		
		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="datatable/media/css/jquery.dataTables.css">
		
		<!-- jQuery -->
		<script type="text/javascript" src="datatable/media/js/jquery.js"></script>
  
		<!-- DataTables -->
		<script type="text/javascript" src="datatable/media/js/jquery.dataTables.js"></script>
		
		
		<script type="text/javascript"> 
		$(document).ready( function () {
		$('#usuarioTabela').dataTable();
		} );
		</script>
		
	</head>
	<body>
		<?php include('layoutUp.php'); ?>
			
		<article id="content" > <!-- basicamente botar todo php que mostra página pro usuário -->
			
		<form method = "POST" action = "gerenciaUsuario.php" enctype = "multipart/form-data">
			<fieldset>
				<label for = "busca">Buscar</label>
				<input type = "text" name = "busca"/>

				<br><br>
				<!--<form action="gerenciaUsuario.php">-->
					Incluir usuário inativos?<br>
					<input type="radio" name="ativo" value=0>Sim<br>
					<input type="radio" name="ativo" value=1 checked>Não<br>
				<!--</form>-->

				<br><br>

				<button type = "submit" name = "enviar">Buscar</button>
			</fieldset>

		</form>
		
		<?php	
			if (isset ($_POST['busca']) && isset ($_POST['ativo'])){
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
					
					if($query->num_rows > 0){ ?>

						
						<div><table id="usuarioTabela" class="display">
							<thead>
							<tr>
								<th>Nome</th>
								<th>Email</th>
								<th>Nível</th>
								<th>Ativo</th>
								<th> </th>
								<th> </th>
							</tr>
							</thead>
							<tbody>
							
							<?php				
						
						while ($objDados = $query->fetch_array()) { #indexação pelo nome ou indice ?>
							<tr>

							<td><?=$objDados['nome'] ?></td>
				
							<td><?=$objDados['email'] ?></td>
							
							<td><?=$objDados['nivel'] ?></td>
							
							<?php switch ($objDados['ativo']){
							case 0:
							$strAtivo = "Não";
							break;
							case 1:
							$strAtivo = "Sim";
							break;} ?>
							
							<td><?=$strAtivo ?></td>							
							

							<td><a href="alteraUsuario.php?editar=<?=$objDados['id'] ?>">Editar</a></td>
							
							<td><a href="excluiUsuario.php?excluir=<?=$objDados['id'] ?>">Excluir</a></td>
							</tr>
							
					
						<?php } ?>
						</tbody>
						</table>
						</div> 
						<?php
						
						
						mysqli_free_result($query);
				
						mysqli_close($mysqli);
						
						
					}
					
				}
				else{ ?>
					Não foi possível realizar a busca dos dados. <a href="javascript:window.history.go(-1)">Clique aqui para tentar novamente</a>
				<?php }
				
			}
		
		?>

	</article> 
		</section> <!-- fechando o <section id="main"> aberto no layoutUp-->
		<?php include('layoutDown.php');?>
	</body>
	</html>
	