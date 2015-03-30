<?php

	require_once('scripts/functions.php');
	//Acesso permitido somente a usuários de nível adminDeus
	session_validaLoginRedirect('adminDeus');
	require 'layoutUp.php';


		
		$mysqli = bd_conecta();
		$sql = "select id, nome, ativa from empresas ";
		$query = $mysqli->query($sql);
			  
		if(mysql_num_rows($consultar) < 0){
			echo "Tabela vazia";
		} else{

			if($query){
						echo 
						"<table border='1'>
						<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Ativa</th>
						</tr>";

						while ($dados = $query->fetch_array()) { 
							echo "<tr>";
							
							echo "<td>" . $dados['id'] . "</td>";
						
							echo "<td>" . "<a href='visualizaEmpresa.php?id=". $dados['nome'] . "'> " . $dados['nome'] . " </a>" .  "</td>";
					
							echo "<td>" . $dados['ativa'] . "</td>";
							
							echo "<td>" . "<a href='excluiEmpresa.php?id=".$dados['id']."'> Excluir </a>" .  "</td>";
							echo "<td>" . "<a href='alteraEmpresa.php?id=".$dados['id']."'> Alterar </a>" .  "</td>";
							
							
						}
						
						mysqli_free_result($query);
				
						mysqli_close($mysqli);
			}
		}
	 
	require 'layoutDown.php';	
?>

