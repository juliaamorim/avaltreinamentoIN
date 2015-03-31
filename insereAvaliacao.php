<!DOCTYPE html>
<?php
    require_once('scripts/functions.php');
  
    //Acesso permitido somente a usuários de nível adminGeral
    session_validaLoginRedirect('adminDeus', 'adminGeral');   

    //Informa se a variável foi iniciada
    if(isset($_POST['enviar'])){

        $strNome = $_POST['nome'];
        $strDescricao = $_POST['descricao'];
       // $strAberta = $_POST['aberta']
       
        $strStatus = $_POST['status'];
         

        if(!$strNome || !$strDescricao){
            if($strNome == '' && $strDescricao == '' ){
                setaMensagem ('ATENÇÃO!! Campos NOME e DESCRIÇÃO encontra-se vazio.',"erro");
            } 

            elseif ($strDescricao == '') {
                setaMensagem ('ATENÇÃO!! Campo DESCRIÇÃO encontram-se vazios.',"erro");
            }else{
                setaMensagem ('ATENÇÃO!! Campo NOME encontra-se vazio.',"erro");
            }
        }
         
        else{                      
                  
            $mysqli = bd_conecta();
            //$mysqli = new mysqli('localhost','root','','avaltreinamento');
            
            $intAberta = 0;

            if($strStatus == "Aberta"){
                $intAberta = 1;
            }

            if (mysqli_connect_errno()){
                die('Não foi possível conectar-se ao banco de dados.<a href="insereAvaliacao.php"> Tente novamente</a>'/*.mysqli_connect_error()*/);
            }
                     
            if($mysqli){

                //Cria comando sql
                 
                $sql = "INSERT INTO aval (nome, dt_criacao, descricao, aberta, id_empresa)"
                ."values ('$strNome', NOW(), '$strDescricao', ?, ?)";

                $stmt = $mysqli->prepare($sql);

                /* if(!$stmt) {
                    throw new Exception($mysqli->errno .', ' . $mysqli->error);
                } */

                $stmt->bind_param('ii', $intAberta, $_SESSION['id_empresa']);
                
                $ok = $stmt->execute();

                /* if(!$ok) {          
                    throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
                } */
                 
                if($ok){ 
                        setaMensagem ("Avaliação inserida com sucesso","sucesso");
                }
                else{
                    
                        setaMensagem ("Não foi possivel inserir a avaliação, por favor, tente novamente","erro");
                }  
 
                //Finaliza conexão ao BD
                $stmt->close();
                $mysqli->close();
                
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
         <?php imprimeMenssagem(); ?>
         <h2>Inserir Avaliação</h2>
         <form method='POST' action="insereAvaliacao.php"  enctype="multipart/form-data"> 
            <fieldset>
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
                    <select name="status">
                        <option value = "Aberta" selected>Aberta</option> 
                        <option value = "Fechada">Fechada</option>

                    </select>  
                       
                    <br><br>

                    <button type="submit" name="enviar">Inserir</button>
 
            </fieldset>
         </form>
         <?php require('layoutDown.php'); ?>
    </body>
</html>