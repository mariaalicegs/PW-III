<?php
require_once("auth.php");
exigirLogin();
include("conexao.php");

// Somente usuários tipo A podem cadastrar, editar e excluir.
if (isset($_POST['salvar']) || isset($_GET['excluir']) || isset($_GET['editar'])) {
    exigirTipoA();
}

if (isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $pop = $_POST['populacao'];
    $area = $_POST['area'];
    $total = $_POST['qtd_paises'];

    if ($id == "") {
        mysqli_query($conexao, "INSERT INTO tb_continentes(nome,populacao,area,qtd_paises) VALUES('$nome','$pop','$area','$total')");
    } else {
        mysqli_query($conexao, "UPDATE tb_continentes SET nome='$nome', populacao='$pop', area='$area', qtd_paises='$total' WHERE id_continente='$id'");
    }
    header("Location: continentes.php");
    exit();
}

if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    mysqli_query($conexao, "DELETE FROM tb_continentes WHERE id_continente=$id");
    header("Location: continentes.php");
    exit();
}

$editar=false;
$id=$nome=$pop=$area=$total="";
if (isset($_GET['editar'])) {
    $editar=true;
    $id=(int)$_GET['editar'];
    $r=mysqli_query($conexao, "SELECT * FROM tb_continentes WHERE id_continente=$id");
    if ($d=mysqli_fetch_assoc($r)) {
        $id=$d['id_continente']; $nome=$d['nome']; $pop=$d['populacao'];
        $area=$d['area']; $total=$d['qtd_paises'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Continentes</title>
<link rel="stylesheet" href="css/css_mundo.css"><script src="js/script.js"></script>
</head>
<body>
<header><h1>Cadastro de Continentes</h1></header>
<nav><ul>
<li><a href="index.php">Início</a></li><li><a href="continentes.php">Continentes</a></li>
<li><a href="paises.php">Países</a></li><li><a href="cidades.php">Cidades</a></li><li><a href="governantes.php">Governantes</a></li>
</ul></nav>

<?php if (ehAdministrador()): ?>
<form method="post" onsubmit="return validarFormulario();">
<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
<label>Nome</label><input type="text" name="nome" required value="<?= htmlspecialchars($nome) ?>">
<label>População</label><input type="number" name="populacao" required value="<?= htmlspecialchars($pop) ?>">
<label>Área (km²)</label><input type="number" step="0.01" name="area" required value="<?= htmlspecialchars($area) ?>">
<label>Total de Países</label><input type="number" name="qtd_paises" required value="<?= htmlspecialchars($total) ?>">
<button type="submit" name="salvar"><?= $editar ? "Atualizar" : "Cadastrar" ?></button>
</form>
<?php endif; ?>

<table>
<tr><th>ID</th><th>Nome</th><th>População</th><th>Área</th><th>Total Países</th><?php if(ehAdministrador()): ?><th>Ações</th><?php endif; ?></tr>
<?php
$res=mysqli_query($conexao,"SELECT * FROM tb_continentes ORDER BY nome");
while($c=mysqli_fetch_assoc($res)){
echo "<tr><td>{$c['id_continente']}</td><td>".htmlspecialchars($c['nome'])."</td><td>{$c['populacao']}</td><td>{$c['area']}</td><td>{$c['qtd_paises']}</td>";
if(ehAdministrador()) echo "<td><a class='editar' href='continentes.php?editar={$c['id_continente']}'>Editar</a> | <a class='excluir' onclick='return confirmarExclusao()' href='continentes.php?excluir={$c['id_continente']}'>Excluir</a></td>";
echo "</tr>";
}
?>
</table>
<p style="text-align:center;margin:20px;"><a href="index.php">Voltar ao início</a> | <a href="logout.php">Sair</a></p>
</body></html>
