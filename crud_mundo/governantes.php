<?php
include("conexao.php");

if(isset($_GET['excluir'])){
    $id = (int)$_GET['excluir'];
    mysqli_query($conexao, "DELETE FROM tb_governantes WHERE id_governante = $id");
    header("Location: governantes.php");
    exit();
}

$editar = false;
$id_governante = "";
$nome = "";
$partido = "";
$dt_nascimento = "";
$idade = "";
$inicio_mandato = "";
$fim_mandato = "";

if(isset($_GET['editar'])){
    $editar = true;
    $id_edit = (int)$_GET['editar'];
    $sql = mysqli_query($conexao, "SELECT * FROM tb_governantes WHERE id_governante = $id_edit");
    
    if($dados = mysqli_fetch_assoc($sql)){
        $id_governante = $dados['id_governante'];
        $nome = $dados['nome'];
        $partido = $dados['partido'];
        $dt_nascimento = $dados['dt_nascimento'];
        $idade = $dados['idade'];
        $inicio_mandato = $dados['inicio_mandato'];
        $fim_mandato = $dados['fim_mandato'];
    }
}

// =========================
// CADASTRAR / ATUALIZAR
// =========================
if(isset($_POST['salvar'])){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $partido = $_POST['partido'];
    $dt_nascimento = $_POST['dt_nascimento'];
    $idade = (int)$_POST['idade'];
    $inicio_mandato = $_POST['inicio_mandato'];
    $fim_mandato = $_POST['fim_mandato'] != "" ? "'".$_POST['fim_mandato']."'" : "NULL";

    if($id == ""){
        // Inserir novo
        mysqli_query($conexao, "INSERT INTO tb_governantes (nome, partido, dt_nascimento, idade, inicio_mandato, fim_mandato) 
        VALUES ('$nome', '$partido', '$dt_nascimento', $idade, '$inicio_mandato', $fim_mandato)");
    } else {
        // Atualizar existente
        mysqli_query($conexao, "UPDATE tb_governantes SET 
        nome = '$nome', 
        partido = '$partido', 
        dt_nascimento = '$dt_nascimento', 
        idade = $idade, 
        inicio_mandato = '$inicio_mandato', 
        fim_mandato = $fim_mandato 
        WHERE id_governante = $id");
    }
    header("Location: governantes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Governantes</title>
    <link rel="stylesheet" href="css/css_mundo.css">
    <script src="js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <h1>Cadastro de Governantes</h1>
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

<main>
    <form method="post" onsubmit="return validarFormulario();">
        
        <input type="hidden" name="id" value="<?php echo $id_governante; ?>">

        <label>Nome</label>
        <input type="text" name="nome" required value="<?php echo htmlspecialchars($nome); ?>">

        <label>Partido</label>
        <input type="text" name="partido" required value="<?php echo htmlspecialchars($partido); ?>">

        <label>Data de Nascimento</label>
        <input type="date" name="dt_nascimento" required value="<?php echo $dt_nascimento; ?>">

        <label>Idade</label>
        <input type="number" name="idade" required value="<?php echo $idade; ?>">

        <label>Início do Mandato</label>
        <input type="date" name="inicio_mandato" required value="<?php echo $inicio_mandato; ?>">

        <label>Fim do Mandato (Opcional)</label>
        <input type="date" name="fim_mandato" value="<?php echo $fim_mandato ? str_replace("'", "", $fim_mandato) : ''; ?>">

        <button type="submit" name="salvar">
            <?php echo $editar ? "Atualizar Governante" : "Cadastrar Governante"; ?>
        </button>
    </form>

    <hr>

    <h2 style="text-align:center; margin-top:20px; color:white;">Lista de Governantes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Partido</th>
            <th>Idade</th>
            <th>Início Mandato</th>
            <th>Fim Mandato</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = mysqli_query($conexao, "SELECT * FROM tb_governantes ORDER BY nome");
        while($dados = mysqli_fetch_assoc($sql)){
        ?>
        <tr>
            <td><?php echo $dados['id_governante']; ?></td>
            <td><?php echo htmlspecialchars($dados['nome']); ?></td>
            <td><?php echo htmlspecialchars($dados['partido']); ?></td>
            <td><?php echo $dados['idade']; ?> anos</td>
            <td><?php echo date('d/m/Y', strtotime($dados['inicio_mandato'])); ?></td>
            <td><?php echo $dados['fim_mandato'] ? date('d/m/Y', strtotime($dados['fim_mandato'])) : 'Em exercício'; ?></td>
            <td>
                <a class="editar" href="governantes.php?editar=<?php echo $dados['id_governante']; ?>">Editar</a>
                |
                <a class="excluir" href="governantes.php?excluir=<?php echo $dados['id_governante']; ?>" onclick="return confirmarExclusao();">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</main>
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