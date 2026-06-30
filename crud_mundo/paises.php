<?php
include("conexao.php");

if(isset($_GET['excluir'])){

    $id = $_GET['excluir'];

    mysqli_query($conexao,"DELETE FROM tb_paises WHERE id_pais = '$id'");

    header("Location: paises.php");
    exit();

}

$id_pais = "";
$id_continente = "";
$nome = "";
$area = "";
$populacao = "";
$idioma = "";
$id_governante = "";
$clima = "";
$regime = "";
$moeda = "";

if(isset($_GET['editar'])){

    $editar = $_GET['editar'];

    $sql = mysqli_query($conexao,"SELECT * FROM tb_paises WHERE id_pais = '$editar'");

    $dados = mysqli_fetch_assoc($sql);

    $id_pais = $dados['id_pais'];
    $id_continente = $dados['id_continente'];
    $nome = $dados['nome'];
    $area = $dados['area'];
    $populacao = $dados['populacao'];
    $idioma = $dados['idioma'];
    $id_governante = $dados['id_governante'];
    $clima = $dados['clima'];
    $regime = $dados['regime'];
    $moeda = $dados['moeda'];

}

// =========================
// CADASTRAR / ATUALIZAR
// =========================

if(isset($_POST['salvar'])){

    $id = $_POST['id_pais'];
    $continente = $_POST['id_continente'];
    $nome = $_POST['nome'];
    $area = $_POST['area'];
    $populacao = $_POST['populacao'];
    $idioma = $_POST['idioma'];
    $governante = $_POST['id_governante'];
    if($governante == ""){
    $governante = "NULL";
}else{
    $governante = "'$governante'";
}
    $clima = $_POST['clima'];
    $regime = $_POST['regime'];
    $moeda = $_POST['moeda'];

    if($id == ""){

        mysqli_query($conexao,"INSERT INTO tb_paises
        (
            id_continente,
            nome,
            area,
            populacao,
            idioma,
            id_governante,
            clima,
            regime,
            moeda
        )
        VALUES
        (
            '$continente',
            '$nome',
            '$area',
            '$populacao',
            '$idioma',
            $governante,
            '$clima',
            '$regime',
            '$moeda'
        )");

    }else{

        mysqli_query($conexao,"UPDATE tb_paises SET

            id_continente='$continente',
            nome='$nome',
            area='$area',
            populacao='$populacao',
            idioma='$idioma',
            id_governante=$governante,
            clima='$clima',
            regime='$regime',
            moeda='$moeda'

            WHERE id_pais='$id'

        ");

    }

    header("Location: paises.php");
    exit();

}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Países</title>

<link rel="stylesheet" href="css/css_mundo.css">

<script src="js/script.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

</head>

<body>

<header>

<h1>Cadastro de Países</h1>

</header>

<nav>
    <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="continentes.php">Continentes</a></li>
        <li><a href="paises.php">Países</a></li>
        <li><a href="cidades.php">Cidades</a></li>
        <li><a href="governantes.php">Governantes</a></li>
    </ul>
</nav>

<form method="POST" onsubmit="return validarFormulario();">

<input type="hidden" name="id_pais" value="<?php echo $id_pais; ?>">

<label>Nome do País</label>
<input type="text" name="nome" required value="<?php echo $nome; ?>">

<label>Continente</label>

<select name="id_continente" required>

    <option value="">Selecione</option>

    <?php

    $continentes = mysqli_query($conexao,"SELECT * FROM tb_continentes ORDER BY nome");

    while($cont = mysqli_fetch_assoc($continentes)){

        $selected = "";

        if($id_continente == $cont['id_continente']){

            $selected = "selected";

        }

        echo "<option value='".$cont['id_continente']."' $selected>".$cont['nome']."</option>";

    }

    ?>

</select>

<label>População</label>
<input type="number" name="populacao" required value="<?php echo $populacao; ?>">

<label>Área (km²)</label>
<input type="number" step="0.01" name="area" required value="<?php echo $area; ?>">

<label>Idioma</label>
<input type="text" name="idioma" required value="<?php echo $idioma; ?>">

<label>Governante</label>

<select name="id_governante">

    <option value="">Selecione</option>

    <?php

    $governantes = mysqli_query($conexao,"SELECT * FROM tb_governantes ORDER BY nome");

    while($gov = mysqli_fetch_assoc($governantes)){

        $selected = "";

        if($id_governante == $gov['id_governante']){

            $selected = "selected";

        }

        echo "<option value='".$gov['id_governante']."' $selected>".$gov['nome']."</option>";

    }

    ?>

</select>

<label>Clima</label>
<input type="text" name="clima" required value="<?php echo $clima; ?>">

<label>Regime Político</label>
<input type="text" name="regime" required value="<?php echo $regime; ?>">

<label>Moeda</label>
<input type="text" name="moeda" required value="<?php echo $moeda; ?>">

<button type="submit" name="salvar">

<?php

if($id_pais == ""){

    echo "Cadastrar País";

}else{

    echo "Atualizar País";

}

?>

</button>

</form>

<hr>

<h2 style="text-align:center; color:white;">Lista de Países</h2>

<table>

<tr>

    <th>ID</th>

    <th>País</th>

    <th>Continente</th>

    <th>População</th>

    <th>Idioma</th>

    <th>Governante</th>

    <th>Ações</th>

</tr>

<?php

$sql = mysqli_query($conexao,"
SELECT
tb_paises.*,
tb_continentes.nome AS continente,
tb_governantes.nome AS governante

FROM tb_paises

LEFT JOIN tb_continentes
ON tb_paises.id_continente = tb_continentes.id_continente

LEFT JOIN tb_governantes
ON tb_paises.id_governante = tb_governantes.id_governante

ORDER BY tb_paises.nome
");

while($dados = mysqli_fetch_assoc($sql)){

?>

<tr>

    <td><?php echo $dados['id_pais']; ?></td>

    <td><?php echo $dados['nome']; ?></td>

    <td><?php echo $dados['continente']; ?></td>

    <td><?php echo number_format($dados['populacao'],0,",","."); ?></td>

    <td><?php echo $dados['idioma']; ?></td>

    <td><?php echo $dados['governante']; ?></td>

    <td>

        <a class="editar"
        href="paises.php?editar=<?php echo $dados['id_pais']; ?>">
        Editar
        </a>

        |

        <a class="excluir"
        href="paises.php?excluir=<?php echo $dados['id_pais']; ?>"
        onclick="return confirmarExclusao();">
        Excluir
        </a>

    </td>

</tr>

<?php

}

?>

</table>

<br>

<div style="text-align:center;">

<a href="index.php">

<button type="button">

Voltar ao Início

</button>

</a>

</div>

</body>

</html>