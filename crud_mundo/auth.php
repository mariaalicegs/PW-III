<?php
// auth.php - controle de sessão e permissões

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function exigirLogin() {
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Enquanto o usuário não trocar a senha no primeiro acesso,
    // ele só pode permanecer na tela de troca.
    if (
        isset($_SESSION['primeiro_acesso']) &&
        $_SESSION['primeiro_acesso'] === 'S' &&
        basename($_SERVER['PHP_SELF']) !== 'trocar_senha.php'
    ) {
        header("Location: trocar_senha.php");
        exit();
    }
}

function ehAdministrador() {
    return isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'A';
}

function exigirTipoA() {
    exigirLogin();

    if (!ehAdministrador()) {
        http_response_code(403);
        echo "<h2 style='text-align:center;'>Acesso negado</h2>";
        echo "<p style='text-align:center;'>Seu usuário possui permissão somente para consulta.</p>";
        echo "<p style='text-align:center;'><a href='index.php'>Voltar ao início</a></p>";
        exit();
    }
}
?>
