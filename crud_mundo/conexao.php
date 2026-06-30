<?php

$conexao = mysqli_connect("localhost", "root", "", "bd_mundo");

if (!$conexao) {
    die("Erro ao conectar ao banco.");
}

?>