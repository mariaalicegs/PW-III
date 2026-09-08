<?php
session_start();
include("conexao.php");

$erro = "";

if (isset($_POST['entrar'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conexao, "SELECT username, password, nome, qtd_acesso, status, tipo, tentativas, primeiro_acesso FROM tb_usuarios WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($resultado)) {

        if ($user['status'] === 'B') {
            $erro = "Usuário bloqueado por exceder 3 tentativas incorretas.";
        } elseif ($user['password'] === $password) {

            // Login correto: zera a contagem de erros e registra o acesso.
            $stmtUpdate = mysqli_prepare($conexao, "UPDATE tb_usuarios SET tentativas = 0, qtd_acesso = qtd_acesso + 1 WHERE username = ?");
            mysqli_stmt_bind_param($stmtUpdate, "s", $username);
            mysqli_stmt_execute($stmtUpdate);

            $data = date('Y-m-d');
            $hora = date('H:i:s');
            $descricao = 'Login realizado com sucesso';
            $partido = 'N/A';

            $stmtLog = mysqli_prepare($conexao, "INSERT INTO tb_logs (descricao, partido, data_log, hora_log, username) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmtLog, "sssss", $descricao, $partido, $data, $hora, $username);
            mysqli_stmt_execute($stmtLog);

            session_regenerate_id(true);

            $_SESSION['username'] = $user['username'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['tipo'] = $user['tipo'];
            $_SESSION['primeiro_acesso'] = $user['primeiro_acesso'];

            if ($user['primeiro_acesso'] === 'S') {
                header("Location: trocar_senha.php");
            } else {
                header("Location: index.php");
            }
            exit();

        } else {
            // Senha incorreta: soma uma tentativa.
            $novas_tentativas = (int)$user['tentativas'] + 1;

            if ($novas_tentativas >= 3) {
                $status = 'B';
                $stmtUpdate = mysqli_prepare($conexao, "UPDATE tb_usuarios SET tentativas = ?, status = ? WHERE username = ?");
                mysqli_stmt_bind_param($stmtUpdate, "iss", $novas_tentativas, $status, $username);
                mysqli_stmt_execute($stmtUpdate);

                $erro = "Senha incorreta! Usuário bloqueado após 3 tentativas erradas.";
            } else {
                $stmtUpdate = mysqli_prepare($conexao, "UPDATE tb_usuarios SET tentativas = ? WHERE username = ?");
                mysqli_stmt_bind_param($stmtUpdate, "is", $novas_tentativas, $username);
                mysqli_stmt_execute($stmtUpdate);

                $restantes = 3 - $novas_tentativas;
                $erro = "Senha incorreta! Você ainda tem $restantes tentativa(s).";
            }
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Autenticação</title>
    <link rel="stylesheet" href="css/css_mundo.css">
</head>
<body>
<header><h1>Autenticação de Usuário</h1></header>
<main>
    <form method="post">
        <h2>Entrar no Sistema</h2>
        <?php if ($erro !== ""): ?>
            <p style="color:red;"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>

        <label>Usuário</label>
        <input type="text" name="username" required>

        <label>Senha</label>
        <input type="password" name="password" required>

        <button type="submit" name="entrar">Entrar</button>
    </form>
</main>
</body>
</html>
