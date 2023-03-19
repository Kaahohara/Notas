<?php
include("conexao.php");
session_start();
$seleciona = mysqli_query($con, 'SELECT * FROM usuario WHERE login ="' . $_SESSION['login'] . '"');
while ($select = mysqli_fetch_assoc($seleciona)) {
    if (isset($_POST['add_cards'])) {
        $adicionar_card = mysqli_query($con, 'INSERT INTO cards(nome, ID_pessoa) VALUES("Adicionar Titulo","' . $select['ID_usuario'] . '");');

    }

    $ID_do_usuario = $select['ID_usuario'];
}
$cards = mysqli_query($con, 'SELECT * FROM cards WHERE ID_pessoa=' . $ID_do_usuario . '');
while ($seleciona_card = mysqli_fetch_assoc($cards)) {
    $ID = $seleciona_card['ID_card'];
}


if (isset($_POST['add_conteudo'])) {
   
    $adiciona_conteudo = mysqli_query($con, 'INSERT INTO conteudo(nome,valor,conteudo,ID_cards) VALUES("Adicione o nome","00","Descrição","'.$_POST['add_conteudo'].'")');
  
}
if (isset($_POST['alterar_titulo'])) {

    $adiciona_conteudo = mysqli_query($con, 'UPDATE cards SET nome = "' . $_POST['novo_titulo'] . '" WHERE ID_card="' . $_POST['alterar_titulo'] . '"');

}
if (isset($_POST['altera_conteudo'])) {

    $adiciona_conteudo = mysqli_query($con, 'UPDATE conteudo SET nome = "' . $_POST['novo_nome'] . '" WHERE ID_conteudo="' . $_POST['altera_conteudo'] . '"');


    $adiciona_conteudo = mysqli_query($con, 'UPDATE conteudo SET conteudo = "' . $_POST['novo_conteudo'] . '" WHERE ID_conteudo="' . $_POST['altera_conteudo'] . '"');

}


header("location:index.php");

?>