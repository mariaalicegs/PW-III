<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$mensagem = "";

if (isset($_POST['alterar'])) {
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $username = $_SESSION['username'];

    if ($nova_senha === $confirmar_senha) {
        if (strlen($nova_senha) < 6) {
            $mensagem = "A nova senha deve ter pelo menos 6 caracteres!";
        } else {
            $primeiro_acesso = 'N';

            $stmt = mysqli_prepare($conexao, "UPDATE tb_usuarios SET password = ?, primeiro_acesso = ? WHERE username = ?");
            mysqli_stmt_bind_param($stmt, "sss", $nova_senha, $primeiro_acesso, $username);
            mysqli_stmt_execute($stmt);

            $_SESSION['primeiro_acesso'] = 'N';

            header("Location: index.php");
            exit();
        }
    } else {
        $mensagem = "As senhas não coincidem!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Primeiro Acesso - Troca de Senha</title>
    <link rel="stylesheet" href="css/css_mundo.css">
</head>
<body>
<header><h1>Primeiro Acesso Detectado</h1></header>
<main>
    <form method="post">
        <h2>Trocar Senha Obrigatória</h2>
        <p>Por segurança, você precisa cadastrar uma nova senha antes de acessar o sistema.</p>

        <?php if ($mensagem !== ""): ?>
            <p style="color:red;"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <label>Nova Senha</label>
        <input type="password" name="nova_senha" minlength="6" required>

        <label>Confirmar Nova Senha</label>
        <input type="password" name="confirmar_senha" minlength="6" required>

        <button type="submit" name="alterar">Salvar Nova Senha</button>
    </form>
</main>
</body>
</html>
