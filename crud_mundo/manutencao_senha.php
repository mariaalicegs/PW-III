<?php
require_once("auth.php");
exigirLogin();
include("conexao.php");

$mensagem = "";
$sucesso = "";

if (isset($_POST['alterar'])) {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    $username = $_SESSION['username'];

    // Busca a senha atual do usuário logado.
    $stmt = mysqli_prepare($conexao, "SELECT password FROM tb_usuarios WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);

    if (!$usuario || $senha_atual !== $usuario['password']) {
        $mensagem = "A senha atual está incorreta!";
    } elseif (strlen($nova_senha) < 6) {
        $mensagem = "A nova senha deve ter pelo menos 6 caracteres!";
    } elseif ($nova_senha !== $confirmar_senha) {
        $mensagem = "A nova senha e a confirmação não coincidem!";
    } elseif ($nova_senha === $senha_atual) {
        $mensagem = "A nova senha deve ser diferente da senha atual!";
    } else {
        $stmtUpdate = mysqli_prepare($conexao, "UPDATE tb_usuarios SET password = ? WHERE username = ?");
        mysqli_stmt_bind_param($stmtUpdate, "ss", $nova_senha, $username);

        if (mysqli_stmt_execute($stmtUpdate)) {
            $sucesso = "Senha alterada com sucesso!";
        } else {
            $mensagem = "Não foi possível alterar a senha. Tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção de Senha</title>
    <link rel="stylesheet" href="css/css_mundo.css">
</head>
<body>
<header>
    <h1>Manutenção de Senha</h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="continentes.php">Continentes</a></li>
        <li><a href="paises.php">Países</a></li>
        <li><a href="cidades.php">Cidades</a></li>
        <li><a href="governantes.php">Governantes</a></li>
        <li><a href="manutencao_senha.php">Alterar Senha</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>
</nav>

<main>
    <form method="post">
        <h2>Alterar Senha de Acesso</h2>

        <?php if ($mensagem !== ""): ?>
            <p style="color:red;"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <?php if ($sucesso !== ""): ?>
            <p style="color:green;"><?php echo htmlspecialchars($sucesso); ?></p>
        <?php endif; ?>

        <label>Senha Atual</label>
        <input type="password" name="senha_atual" required>

        <label>Nova Senha</label>
        <input type="password" name="nova_senha" minlength="6" required>

        <label>Confirmar Nova Senha</label>
        <input type="password" name="confirmar_senha" minlength="6" required>

        <button type="submit" name="alterar">Alterar Senha</button>
    </form>
</main>
</body>
</html>
