<?php
	require_once('scripts/functions.php');
	session_validaLoginRedirect('adminDeus');
?>
<?php 
	include_once('layoutUp.php');	
	imprimeMenssagem();
?>
			
<form method = "POST" action = "gerenciarEmpresa1.php" enctype = "multipart/form-data">
	<fieldset>
		<label for = "busca">Buscar</label>
		<input type = "text" name = "busca"/>
		

		<br><br>
			Incluir empresas inativas?<br>
			<input type="radio" name="ativo" value=0>Sim<br>
			<input type="radio" name="ativo" value=1 checked>Não<br>
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
        die('Não foi possível conectar-se ao banco de dados.<a href="gerenciarEmpresa.php"> Tente novamente</a>'/*.mysqli_connect_error()*/);
    }
	else{
		if($strBusca == ''){
			$sql = "select * from empresas where (ativa = '1' OR ativa = '$tIntAtivo')";
		}
		else {
			$sql = "select * from empresas where (nome = '$strBusca' AND ( ativa = '1' OR ativa = '$tIntAtivo'))";
		}
		
		$query = $mysqli->query($sql);
	}
	
		if($query){
			
			echo 'Registros encontrados: '.$query->num_rows;
			
			if($query->num_rows > 0){ ?>
				
				<div><table id="empresaTabela" class="display">
					<thead>
					<tr>
						<th>Nome</th>
						<th>Ativo</th>
						<th> </th>
						<th> </th>
					</tr>
					</thead>
					<tbody>
					
					<?php				
				
				while ($objDados = $query->fetch_array()) { #indexação pelo nome ou indice ?>
					<tr>

					<td><a href="visualizaEmpresa.php?id=<?$objDados['id']?>"><?$objDados['nome']?></a></td>
					
					<?php switch ($objDados['ativa']){
					case 0:
					$strAtivo = "Não";
					break;
					case 1:
					$strAtivo = "Sim";
					break;} ?>
					
					<td><?=$strAtivo ?></td>							
					

					<td><a href="alteraEmpresa.php?editar=<?=$objDados['id'] ?>">Editar</a></td>
					
					<td><a href="excluiEmpresa.php?excluir=<?=$objDados['id'] ?>">Excluir</a></td>
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
<script type="text/javascript"> 
$(document).ready( function () {
	$('#empresaTabela').dataTable();
} );
</script>
<?php include_once('layoutDown.php');?>