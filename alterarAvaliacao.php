
<?php
	require 'layoutUp.php';
	$id = $_REQUEST['id'];
	$mysqli = new mysqli('localhost','root','','avaltreinamento');
	if (mysqli_connect_errno()){
		die('Não foi possível conectar-se ao banco de dados.');
	}		
	else{
		mysqli_set_charset($mysqli, 'utf8');
		$strNome = "select nome from aval where id = '$id' ";
		$datDtCriacao = "select dt_criacao from aval where id='$id'";
		$strDescricao = "select descricao from aval where id='$id'" ;
		$intAberta = "select aberta from aval where id='$id'";
		$sql = "select * from aval where id='$id'";
		$query = $mysqli->query($sql);
		if($query){						
			while ($dados = $query->fetch_array()) { #indexação pelo nome ou indice
				echo 'Nome: ' . $dados['nome'] . '<br>';	
				echo 'Data de criação: ' . $dados['dt_criacao'] . '<br>';
				echo 'Descrição: ' . $dados['descricao'] . '<br>';
				if ($dados['aberta']==0) {
					$strMsg = "concluída";
				}else
					$strMsg ="aberta para novas avaliações";			
				echo 'situação de avaliação: ' . $strMsg . '<br>';							
				echo '<br><br>';
			}
		}	
	}	
?>

	<form method="POST" action = "alterarAvaliacao.php" enctype="multipart/form-data">
		<p>Escolha o campo que deseja alterar: </p>
		<fieldset>
			Alterar nome:  <input type="text" name="nom" value=""><br>
			Alterar descrição:  <input type="text" name="descric" value=""><br>
			Alterar situação da avaliação (0 = concluída, 1 = em aberto):  <input type="text" name="abert" value=""><br>
			<button typ ="submit" name="alterar">Alterar</button>
		</fieldset>
	</form>



<?php
	if($_POST['nom']!== ""){
		$strNome = $_POST['nom'];
		$sql="update aval set nome= '$strNome' where id = '$id' ";
		mysqli_set_charset($mysqli, 'utf8');
		$query = $mysqli->query($sql);
		if($query){
			echo "Nome alterado: ".'<br>';			
			echo 'Nome: ' . $strNome . '<br>';
			echo '<br><br>';
		}
	}
	if($_POST['descric']!== ""){
		$strDescricao = $_POST['descric'];
		$sql="update aval set  descricao='$strDescricao' where id = '$id' ";
		$query = $mysqli->query($sql);
		if($query){
			echo "Descrição alterada: ".'<br>';			
			echo 'Descrição: ' . $strDescricao . '<br>';
			echo '<br><br>';
		}
	}
	if($_POST['abert']!== ""){
		$intAberta = $_POST['abert'];
		$sql="update aval set aberta='$intAberta]' where id = '$id' ";
		if($query){
			echo "Situação da avaliação alterada: ".'<br>';			
			if ($intAberta ==0) {
				$strMsg = "concluída";
			}else
				$strMsg ="aberta para novas avaliações";			
			echo 'situação de avaliação: ' . $strMsg . '<br>';							
			echo '<br><br>';
		}
	}
	require 'layoutDown.php';
?>

