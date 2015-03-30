
	 <?php
	 	include('layoutUp.php');

		$idAvaliacao = $_GET['id'];

		$mysqli = new mysqli('localhost','root','','avaltreinamento');
				
		if (mysqli_connect_errno()){
			die('Não foi possível conectar-se ao banco de dados.');
		}
				
		else{
			mysqli_set_charset($mysqli, 'utf8');
			$sql = "select * from aval where id = $idAvaliacao ";
			$query = $mysqli->query($sql);

			if($query){
							
							while ($dados = $query->fetch_array()) { #indexação pelo nome ou indice
		
								echo 'Nome: ' . $dados['nome'] . '<br>';
						
								echo 'Data de crição: ' . date('d/m/Y', strtotime($dados['dt_criacao']))  . '<br>';
								
								echo 'Descrição: ' . $dados['descricao'] . '<br>';

								//apresentar de forma melhor se a avaliação está em aberto
								if ($dados['aberta']==0) {
									$strMsg = "concluída";
								}else
									$strMsg ="aberta para novas avaliações";
								//apresentar de forma melhor se a avaliação está em aberto
								
								echo 'situação de avaliação: ' . $strMsg . '<br>';							

								echo '<br><br>';
							}
							
							mysqli_free_result($query);
					
							mysqli_close($mysqli);
						}

		}	

		include('layoutDown.php');
	?>

 