<?php

$idAvaliacao = 1;

$mysqli = new mysqli('localhost','root','','avaltreinamento');
			
	if (mysqli_connect_errno()){
		die('Não foi possível conectar-se ao banco de dados.');
	}
			
	else{
		mysqli_set_charset($mysqli, 'utf8');
		$sql = "select * from aval where id = 1 ";
		$query = $mysqli->query($sql);

		if($query){
						
						while ($dados = $query->fetch_array()) { #indexação pelo nome ou indice
	
							echo 'Nome: ' . $dados['nome'] . '<br>';
					
							echo 'Data de criação: ' . $dados['dt_criacao'] . '<br>';
							
							echo 'Descrição: ' . $dados['descricao'] . '<br>';
							
							echo 'aberta: ' . $dados['aberta'] . '<br>';							

							echo '<br><br>';
						}
						
						mysqli_free_result($query);
				
						mysqli_close($mysqli);
					}


	}	






?>