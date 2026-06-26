<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Análise Estatística da Turma</title>

    <link rel="stylesheet" href="css/css_estatistica.css">

</head>

<body>

<div class="centralizado">

    <div class="container card">

        <h1>Análise Estatística da Turma</h1>

        <form action="cadastro.php" method="post">

            <label for="turma">
                Nome da Turma
            </label>

            <input
                type="text"
                id="turma"
                name="turma"
                required
            >

            <label for="quantidade">
                Quantidade de Alunos
            </label>

            <input
                type="number"
                id="quantidade"
                name="quantidade"
                min="1"
                required
            >

            <button type="submit">
                Continuar
            </button>

        </form>

    </div>

</div>

</body>
</html>