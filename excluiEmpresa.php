<?php

	// require_once('scripts/session.php');
	require_once('scripts/bd.php');
	//Acesso permitido somente a usuários de nível adminDeus
	// session_validaLoginRedirect('adminDeus');
	
	require 'layoutUp.php';

$mysqli = new mysqli('localhost','root','','avaltreinamento');
			
	if (mysqli_connect_errno()){
		die('Não foi possível conectar-se ao banco de dados.');
	}
			
	else{
		mysqli_set_charset($mysqli, 'utf8');
		$sql = "select id, nome, ativa from empresas ";
	}

	$sql = "DELETE FROM empresas WHERE id = ?";

	if (!$result = $mysqli->prepare($sql))
	{
		die('Falha na Query: (' . $mysqli->errno . ') ' . $mysqli->error);
	}

	if (!$result->bind_param('i', $_GET['id']))
	{
		die('Binding parameters failed: (' . $result->errno . ') ' . $result->error);
	}

	if (!$result->execute())
	{
		die('Falha na Execução: (' . $result->errno . ') ' . $result->error);
	}

	if ($result->affected_rows > 0)
	{
		echo "Empresa deletada com sucesso.";
	}
	else
	{
		echo "Nao foi possivel deletar a Empresa";
	}
	$result->close();	
	$mysqli->close();
	
	echo "<a href='gerenciarEmpresa.php'> Retornar</a>";
	
	require 'layoutDown.php';

?>