<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // 'login', 'register', 'forgot'
    
    if ($action === 'login') {
        // Lógica de login
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($email === 'user@exemplo.com' && $password === '123456') {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
        }
    } elseif ($action === 'register') {
        // Lógica de cadastro
        echo json_encode(['success' => true, 'message' => 'Usuário cadastrado']);
    } elseif ($action === 'forgot') {
        // Lógica de recuperação
        echo json_encode(['success' => true, 'message' => 'E-mail enviado']);
    }
}
?>
