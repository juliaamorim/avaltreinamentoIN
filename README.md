# avaltreinamentoIN
projeto de sistema de avaliação de treinamento IN Junior


PADRÕES DE CÓDIGO

Cammel Case:
Consiste em juntar as palavras mantendo a primeira letra das palavras após a primeira como maiúsculas.
EX: inserirUsuário.php,  $strNome, alterarAvaliacao.php
Deve ser usado em nome de arquivos e variáveis.


Tipo da variável no nome da variável.
PHP é uma linguagem confusa no sentido de tipos de variáveis, logo vamos tentar colocar o tipo daquela variavel antes do nome da mesma.
EX: $intNumero, $strNome, $blnAtivo, $fltPreco

#Novo padrão de página pro HTML!

agora vc pode utilizar apenas o PHP sem se importar com Tags Lembrando de colocar o nome do seu caso de Uso.
dica coloque o nome do seu caso de uso em tag &lt; h2 &gt; antes do seu php caso ele não tenha, vide login(para exemplo).

Exemplo de código:

<?php include_once('layoutUp.php'); ?>

<?php
	//Seu php aqui
?>

<?php include_once('layoutDown.php'); ?>