<?php
	require_once('scripts/functions.php');
	session_validaLoginRedirect('adminGeral','adminDeus');
?>
<?php include_once('layoutUp.php'); ?>

<?php
		$id = $_REQUEST['id'];
		$mysqli = bd_conecta();
		mysqli_set_charset($mysqli, 'utf8');
		$sql = "select * from aval where id='$id'";
		$query = $mysqli->query($sql);
		imprimeMenssagem();
		if($query){						
			while ($dados = $query->fetch_array()) { 
				$strNome = $dados['nome'];
				$datDtCriacao = date('d/m/Y', strtotime($dados['dt_criacao']));
				$strDescricao= $dados['descricao'] ;
				$intAberta =$dados['aberta'];
				if ($dados['aberta']==0) {
					$strMsg = "concluída";
				}else{
					$strMsg ="aberta";	
				}
				if(!isset($_POST['alterar'])){
					echo'Nome:'. $strNome.'<br>';
					echo 'Data de criação: '. $datDtCriacao.'<br>';
					echo'Descricao: '. $strDescricao.'<br>';
					echo 'Situação da avaliação: '.$strMsg.'<br><br>';
				}
			}
?>
			<?php if(!isset($_POST['alterar'])){ ?>

				<form method="POST" action = "alterarAvaliacao.php" enctype="multipart/form-data">
					<p>Clique no campo que deseja alterar: </p>
					<fieldset>
						Alterar nome:  <input type="text" name="nom" value="<?php echo $strNome; ?>"><br>
						Alterar descrição:  <input type="text" name="descric" value="<?php echo $strDescricao; ?>"><br>
						Alterar situação da avaliação:  
						<select name="abert" value="">
							<option value="1">Aberta</option>
							<option value="0">Concluída</option>
						</select> <br> 
						<button type="submit" name="alterar">Alterar</button>
					</fieldset>
				</form>
		  <?php } ?>	
				<?php
					if(isset($_POST['alterar'])){
						if($_POST['nom']=== $strNome &&  $_POST['descric']===$strDescricao  && $_POST['abert']==="1" ){
							setaMensagem('Nenhum campo foi preenchido','info');
							echo '<a href="javascript:window.history.go(-1)">Voltar</a>';
						} else{
							setaMensagem('Avaliação alterada com sucesso','sucesso')
							if($_POST['nom']!== ""){
								$strNome = $_POST['nom'];
								$sql="update aval set nome= '$strNome' where id = '$id' ";
								 $mysqli->query($sql);
							}
							if($_POST['descric']!== ""){
								$strDescricao = $_POST['descric'];
								$sql="update aval set  descricao='$strDescricao' where id = '$id' ";
								 $mysqli->query($sql);;
							}
							if($_POST['abert']!== ""){
								$intAberta = $_POST['abert'];
								$sql="update aval set aberta='$intAberta' where id = '$id' ";
								 $mysqli->query($sql);
							}
							echo'<br><br>'.'Nome: '. $strNome.'<br>';
							echo 'Data de criação: '. $datDtCriacao.'<br>';
							echo'Descricao: '. $strDescricao.'<br>';
							echo 'Situação da avaliação: '.$strMsg.'<br><br>';
							echo 'Caso deseje fazer outras alterações nessa avaliação. <a href="alterarAvaliacao.php">Clique aqui.</a>'; 
						}
					}
				?>
<?php   } ?>	
<?php include_once('layoutDown.php'); ?>