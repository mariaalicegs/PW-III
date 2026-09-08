<?php
require_once("auth.php");
exigirLogin();
include("conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Sistema Mundo</title>
<link rel="stylesheet" href="css/css_mundo.css"><script src="js/script.js"></script>
</head>
<body>
<header>
<h1>Sistema de Gerenciamento do Mundo</h1>
<p style="text-align:center;color:white;">Olá, <?=htmlspecialchars($_SESSION['nome'])?>! Tipo de usuário: <?=htmlspecialchars($_SESSION['tipo'])?></p>
</header>
<nav><ul>
<li><a href="index.php">Início</a></li><li><a href="continentes.php">Continentes</a></li>
<li><a href="paises.php">Países</a></li><li><a href="cidades.php">Cidades</a></li><li><a href="governantes.php">Governantes</a></li>
<li><a href="logout.php">Sair</a></li>
</ul></nav>
<main>
<section class="cards">
<div class="card"><h2>Continentes</h2><img src="css/imgs/cont.png" height="150" width="150"><p>Cadastro e gerenciamento dos continentes.</p><a href="continentes.php">Acessar</a></div>
<div class="card"><h2>Países</h2><img src="css/imgs/count.png" height="150" width="150"><p>Cadastro e gerenciamento dos países.</p><a href="paises.php">Acessar</a></div>
<div class="card"><h2>Cidades</h2><img src="css/imgs/city.png" height="150" width="150"><p>Cadastro e gerenciamento das cidades.</p><a href="cidades.php">Acessar</a></div>
<div class="card"><h2>Governantes</h2><img src="css/imgs/gov.png" height="150" width="150"><p>Cadastro e gerenciamento dos governantes.</p><a href="governantes.php">Acessar</a></div>
</section>
</main>
</body></html>
