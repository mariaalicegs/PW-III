<?php

if(!isset($_POST['turma']) || !isset($_POST['quantidade'])){
    header("Location: index.php");
    exit();
}

$turma = $_POST['turma'];
$quantidade = $_POST['quantidade'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">

    <title>Cadastro de Notas</title>

    <link rel="stylesheet" href="css/css_estatistica.css">

</head>

<body>

<div class="container">

    <h1>Cadastro de Notas</h1>

    <h2>Turma: <?php echo $turma; ?></h2>

    <form action="relatorio.php" method="post">

        <input
            type="hidden"
            name="turma"
            value="<?php echo $turma; ?>"
        >

        <input
            type="hidden"
            name="quantidade"
            value="<?php echo $quantidade; ?>"
        >

        <?php

        for($i = 1; $i <= $quantidade; $i++){

        ?>

            <div class="aluno">

                <h3>Aluno <?php echo $i; ?></h3>

                <label>Nome</label>
                <input
                    type="text"
                    name="nome[]"
                    required
                >

                <label>Nota da Prova 1</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    max="10"
                    name="nota1[]"
                    required
                >

                <label>Nota da Prova 2</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    max="10"
                    name="nota2[]"
                    required
                >

                <label>Nota do Trabalho</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    max="10"
                    name="trabalho[]"
                    required
                >

            </div>

        <?php
        }
        ?>

        <button type="submit">
            Gerar Relatório
        </button>

    </form>

</div>

</body>
</html>