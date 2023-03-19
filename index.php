<?php
include('conexao.php');
session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = rand(0, 500);
    $adicionar_usuario = mysqli_query($con, 'INSERT INTO usuario(login) VALUES("' . $_SESSION['login'] . '");');

}

$seleciona = mysqli_query($con, 'SELECT * FROM usuario WHERE login ="' . $_SESSION['login'] . '"');
while ($select = mysqli_fetch_assoc($seleciona)) {

    $ID_do_usuario = $select['ID_usuario'];
}
$cards = mysqli_query($con, 'SELECT * FROM cards WHERE ID_pessoa=' . $ID_do_usuario . '');

if(empty(mysqli_num_rows($cards)))
$adicionar_card = mysqli_query($con, 'INSERT INTO cards(nome, ID_pessoa) VALUES("Adicionar Titulo","' . $ID_do_usuario . '");');
$selecionar_card_conteudos = mysqli_query($con, 'SELECT * FROM cards WHERE ID_pessoa=' . $ID_do_usuario . '');
while ($seleciona_card_e_conteudo = mysqli_fetch_assoc($selecionar_card_conteudos)) {
    $ID = $seleciona_card_e_conteudo['ID_card'];
}
$conteudo = mysqli_query($con, 'SELECT * FROM conteudo WHERE ID_cards=' . $ID . '');
if(empty(mysqli_num_rows($conteudo))) {
      $adiciona_conteudo = mysqli_query($con, 'INSERT INTO conteudo(nome,valor,ID_cards) VALUES("Adicione o nome","00","' . $ID . '")');
}

?>
<html>

<head>
    <title>Portifolio-Karina Ohara</title>
    <meta charset="utf-8">
    <meta enctype="multipart/form-data">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<script>
function altera_titulo(id_do_titulo) {
    document.getElementById('card_'+id_do_titulo).click();
}
function adiciona_conteudo(id_do_conteudo){
  
    document.getElementById('add_conteudo_'+id_do_conteudo).click();
}
    
    function abre_modal(id_do_modal) {
      
        document.getElementById('div_modal_'+id_do_modal).style.display='block';
        document.getElementById('div_'+id_do_modal).style.display='block';
        window.onclick = function (event) {
                if (event.target == document.getElementById('div_modal_'+id_do_modal)) {
                    document.getElementById('conteudo_'+id_do_modal).click(); 
                    document.getElementById('div_modal_'+id_do_modal).style.display = "none";
                    document.getElementById('div_'+id_do_modal).style.display = "none";
                }
            }
    }
    </script>
    <style>
    .fora {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
        }

        .modal_conteudo {

                background-color: #fff;
                margin-top: 1%;
                margin-left:auto;
                margin-right:auto;
                min-height: 700px;
                
                border: 1px solid #888;
                width: 50%;
                position:relative;

        }
        .invisivel {
            display: none;
        }
    </style>
    <div class="card" style="background-color:#006699;height:30px;"></div>
<br><br> 
<div class="container">
    <div class="row">
        <?php

        $cards = mysqli_query($con, 'SELECT * FROM cards WHERE ID_pessoa="' . $ID_do_usuario . '"');
        while ($seleciona_card = mysqli_fetch_assoc($cards)) {
           
            echo '
        <div class="col">
            <div class="card" style="background-color:#006699;">
                <form action="index_php.php" method="POST">
                  <center>  <input type="text" style="color:white;background-color: transparent; border:none;" name="novo_titulo" onblur="altera_titulo('.$seleciona_card['ID_card'].');" value="'. $seleciona_card['nome'] .'"> 
                    </center><button type="submit" style="display:none;" value="'.$seleciona_card['ID_card'].'" name="alterar_titulo" id="card_'.$seleciona_card['ID_card'].'"></button>
                </form>   
            </div>';

            $conteudo = mysqli_query($con, 'SELECT * FROM conteudo WHERE ID_cards="'.$seleciona_card['ID_card'].'"');
            while ($seleciona_conteudo = mysqli_fetch_assoc($conteudo)) {
               
                echo '
            <div class="card" style="background-color:#fff;">
                <button type="submit" style="border:none;"onclick="abre_modal('.$seleciona_conteudo['ID_conteudo'].');">
                '. $seleciona_conteudo['nome'] . '
                </button>
            </div>';
            }
            echo '    
                
                ';
            
                
                $modal_do_conteudo = mysqli_query($con, 'SELECT * FROM conteudo WHERE ID_cards="' . $seleciona_card['ID_card'] . '"');
                while ($seleciona_conteudo_modal = mysqli_fetch_assoc($modal_do_conteudo)) {
                    
                echo '
                <div class="fora" id="div_modal_'.$seleciona_conteudo_modal['ID_conteudo'].'"> 
                <div class="modal_conteudo">
                <form action="index_php.php" method="POST" enctype="multipart/form-data">
                    <div class="invisivel" id="div_'.$seleciona_conteudo_modal['ID_conteudo'].'">
            
                    <center>
                  <div style="background-color:006699;">
                        <input type="text" style="color:white;background-color: transparent; border:none;" name="novo_nome"  value="'. $seleciona_conteudo_modal['nome'] .'"> 
                        </div>
                        <br>';
                        
                       echo' 
                        <br> <br> <br>
                        <textarea style="height:400px; width:300px; background-color: transparent;border-radius:5px; border-color:#c0c0c0;" name="novo_conteudo" >'. $seleciona_conteudo_modal['conteudo'] .' </textarea>
                        <br>
                      
                    </center>
            
                    </div>
                 
                    <button type="submit" id="conteudo_'.$seleciona_conteudo_modal['ID_conteudo'].'" style="display:none;" value="'.$seleciona_conteudo_modal['ID_conteudo'].'" name="altera_conteudo" ></button>
            
                    </form>
                    </div>    
                    </div> 
              
                 ';
                }
                echo '
               
          
         
                <form action="index_php.php" method="POST">
                <div class="card" style="background-color:#fff;">  
                     <button type="submit"  id="add_conteudo_'.$seleciona_card['ID_card'].'" onclick="adiciona_conteudo('.$seleciona_card['ID_card'].');" name="add_conteudo" value="'.$seleciona_card['ID_card'].'" class="btn btn-outline-primary"style="width:100%;">Adicionar</button>
                    </div>
                    </form> 
            
        </div>
   ';
        }
        ?>


        <div class="col-sm-1">
        
                <form action="index_php.php" method="POST">
                <div class="card" >
                    <button type="submit" class="btn btn-outline-primary" style="width:100%;" id="add_cards"
                        name="add_cards">+</button>
                        </div>
                    </form>
            
        </div>