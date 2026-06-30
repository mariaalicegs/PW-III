<?php
include("conexao.php");

// =========================
// EXCLUIR
// =========================
if(isset($_GET['excluir'])){
    $id = (int)$_GET['excluir'];
    mysqli_query($conexao, "DELETE FROM tb_cidades WHERE id_cidade = $id");
    header("Location: cidades.php");
    exit();
}

// =========================
// EDITAR (BUSCAR DADOS)
// =========================
$editar = false;
$id_cidade = "";
$nome = "";
$id_pais = "";
$populacao = "";
$id_governante = "";
$clima = "";
$dt_fundacao = "";

if(isset($_GET['editar'])){
    $editar = true;
    $id_edit = (int)$_GET['editar'];
    $sql = mysqli_query($conexao, "SELECT * FROM tb_cidades WHERE id_cidade = $id_edit");
    
    if($dados = mysqli_fetch_assoc($sql)){
        $id_cidade = $dados['id_cidade'];
        $nome = $dados['nome'];
        $id_pais = $dados['id_pais'];
        $populacao = $dados['populacao'];
        $id_governante = $dados['id_governante'];
        $clima = $dados['clima'];
        $dt_fundacao = $dados['dt_fundacao'];
    }
}

// =========================
// CADASTRAR / ATUALIZAR
// =========================
if(isset($_POST['salvar'])){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $id_pais = (int)$_POST['id_pais'];
    $populacao = (int)$_POST['populacao'];
    $id_governante = $_POST['id_governante'] != "" ? (int)$_POST['id_governante'] : "NULL";
    $clima = $_POST['clima'];
    $dt_fundacao = $_POST['dt_fundacao'];

    if($id == ""){
        // Inserir novo
        mysqli_query($conexao, "INSERT INTO tb_cidades (nome, id_pais, populacao, id_governante, clima, dt_fundacao) 
        VALUES ('$nome', $id_pais, $populacao, $id_governante, '$clima', '$dt_fundacao')");
    } else {
        // Atualizar existente
        mysqli_query($conexao, "UPDATE tb_cidades SET 
        nome = '$nome', 
        id_pais = $id_pais, 
        populacao = $populacao, 
        id_governante = $id_governante, 
        clima = '$clima', 
        dt_fundacao = '$dt_fundacao' 
        WHERE id_cidade = $id");
    }
    header("Location: cidades.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cidades</title>
    <link rel="stylesheet" href="css/css_mundo.css">
    <script src="js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <h1>Cadastro de Cidades</h1>
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
        <h2><?php echo $editar ? "Editar Cidade" : "Cadastrar Cidade"; ?></h2>
        
        <input type="hidden" name="id" value="<?php echo $id_cidade; ?>">

        <label>Nome da Cidade</label>
        <input type="text" name="nome" required value="<?php echo htmlspecialchars($nome); ?>">

        <label>País</label>
        <select name="id_pais" required>
            <option value="">Selecione um País</option>
            <?php
            $res_paises = mysqli_query($conexao, "SELECT id_pais, nome FROM tb_paises ORDER BY nome");
            while($p = mysqli_fetch_assoc($res_paises)){
                $selected = ($p['id_pais'] == $id_pais) ? "selected" : "";
                echo "<option value='{$p['id_pais']}' $selected>{$p['nome']}</option>";
            }
            ?>
        </select>

        <label>População</label>
        <input type="number" name="populacao" required value="<?php echo $populacao; ?>">

        <label>Governante / Prefeito (Opcional)</label>
        <select name="id_governante">
            <option value="">Selecione um Governante</option>
            <?php
            $res_gov = mysqli_query($conexao, "SELECT id_governante, nome FROM tb_governantes ORDER BY nome");
            while($g = mysqli_fetch_assoc($res_gov)){
                $selected = ($g['id_governante'] == $id_governante) ? "selected" : "";
                echo "<option value='{$g['id_governante']}' $selected>{$g['nome']}</option>";
            }
            ?>
        </select>

        <label>Clima</label>
        <input type="text" name="clima" required value="<?php echo htmlspecialchars($clima); ?>">

        <label>Data de Fundação</label>
        <input type="date" name="dt_fundacao" required value="<?php echo $dt_fundacao; ?>">

        <button type="submit" name="salvar">
            <?php echo $editar ? "Atualizar Cidade" : "Cadastrar Cidade"; ?>
        </button>
    </form>

    <hr>

    <h2 style="text-align:center; margin-top:20px; color:white;">Lista de Cidades</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Cidade</th>
            <th>País</th>
            <th>População</th>
            <th>Clima</th>
            <th>Governante</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = mysqli_query($conexao, "
            SELECT tb_cidades.*, 
                   tb_paises.nome AS pais, 
                   tb_governantes.nome AS governante 
            FROM tb_cidades
            LEFT JOIN tb_paises ON tb_cidades.id_pais = tb_paises.id_pais
            LEFT JOIN tb_governantes ON tb_cidades.id_governante = tb_governantes.id_governante
            ORDER BY tb_cidades.nome
        ");
        while($dados = mysqli_fetch_assoc($sql)){
        ?>
        <tr>
            <td><?php echo $dados['id_cidade']; ?></td>
            <td><?php echo htmlspecialchars($dados['nome']); ?></td>
            <td><?php echo htmlspecialchars($dados['pais']); ?></td>
            <td><?php echo number_format($dados['populacao'], 0, ",", "."); ?></td>
            <td><?php echo htmlspecialchars($dados['clima']); ?></td>
            <td><?php echo $dados['governante'] ? htmlspecialchars($dados['governante']) : 'Não informado'; ?></td>
            <td>
                <a class="editar" href="cidades.php?editar=<?php echo $dados['id_cidade']; ?>">Editar</a>
                |
                <a class="excluir" href="cidades.php?excluir=<?php echo $dados['id_cidade']; ?>" onclick="return confirmarExclusao();">Excluir</a>
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