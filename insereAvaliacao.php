<!DOCTYPE html>
<?php
    require_once('scripts/functions.php');
  
    //Acesso permitido somente a usuários de nível adminGeral
    session_validaLoginRedirect('adminDeus', 'adminGeral');   

    //Informa se a variável foi iniciada
    if(isset($_POST['enviar'])){ 

        $strNome = $_POST['nome'];
        $strDescricao = $_POST['descricao'];
        $strAberta = $_POST['aberta'];
         
        if($strNome == ''){
            echo 'ATENÇÃO!! Campo NOME encontra-se vazio.';
        } 

        elseif ($strDescricao == '') {
            echo 'ATENÇÃO!! Campo DESCRIÇÃO encontra-se vazio.';
        }
         
        else{                      
                  
            $mysqli = bd_conecta();
            //$mysqli = new mysqli('localhost','root','','avaltreinamento');
        

            if (mysqli_connect_errno()){
                die('Não foi possível conectar-se ao banco de dados.<a href="insereAvaliacao.php"> Tente novamente</a>'/*.mysqli_connect_error()*/);
            }
                     
            if($mysqli){
                 
                mysqli_set_charset($mysqli, 'utf8');

                //Cria comando sql
                 
                $sql = "INSERT INTO aval (nome, dt_criacao, descricao, aberta, id_empresa)"
                ."values ('$strNome', NOW(), '$strDescricao', '$strAberta', ?)";

                $stmt = $mysqli->prepare($sql);
                
                $stmt->bind_param('i', $_SESSION['id_empresa']);
                 
                $ok = $stmt->execute();
                 
                if($ok){ ?>
                    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
                        alert ("Avaliação inserida com sucesso");
                    </SCRIPT>
 
                <?php
                }
                else{
                    echo "<SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\">
                        alert (\"Não foi possivel inserir a avaliação, por favor, tente novamente\");</SCRIPT>";
                     
                }  
 
                mysqli_close($mysqli);
            }
        }
}      
?>      

<html>
    <head>
        <title>Formulário de inserção de usuário</title>
    </head>
    <body>
         <?php require('layoutUp.php'); ?>
         <form method='POST' action="insereAvaliacao.php"  enctype="multipart/form-data"> 
            <fieldset>
                <center>
                    <legend>Inserir Avaliação</legend>
                </center>
                    <br>
                    ATENÇÃO! 
                    <br>
                    *Todos os campos são obrigatórios
                    <br><br>
                                        
                    <label for="nome">Nome</label>
                    <input type="text" placeholder="Digite o nome"  name="nome" />
                     
                    <br><br>
                     
                    <label for="nome">Data de Criação:</label>
                    <?php
                     echo $data = date("d/m/Y"); 
                     ?>
                     
                    <br><br>
 
                    <label for="nome">Descrição: </label>
                    <textarea  name="descricao"  placeholder="Digite aqui" rows=5 cols=35/></textarea>
                     
                    <label for="nome">Status: </label>
                    <select name="aberta">
                        <option selected>Aberta</option>
                        <option>Concluida</option>
                    </select>  
                       
                    <br><br>

                     <br><br>

                    <button type="submit" name="enviar">Inserir</button>
 
            </fieldset>
         </form>
         <?php require('layoutDown.php'); ?>
    </body>
</html>