<?php
require 'db_config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo = $_POST['nome_completo'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash seguro da senha

    try {
        $sql = "INSERT INTO clientes (
                    nome_completo, cpf, data_nascimento, genero, email, username, senha_hash
                ) VALUES (
                    :nome_completo, :cpf, :data_nascimento, :genero, :email, :username, :senha_hash
                )";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_completo', $nome_completo);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':senha_hash', $senha);

        $stmt->execute();

        // Redirecionar com mensagem de sucesso
        header("Location: formulario_cliente.html?mensagem=Cliente cadastrado com sucesso!&tipo=sucesso");
    } catch (PDOException $e) {
        if ($e->getCode() == 2006) { // MySQL server has gone away
            error_log("Tentando reconectar ao banco de dados...");
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
        }
        // Redirecionar com mensagem de erro
        header("Location: formulario_cliente.html?mensagem=" . urlencode("Erro ao cadastrar cliente: " . $e->getMessage()) . "&tipo=erro");
    }
} else {
    echo "<p style='color: red;'>Método inválido.</p>";
}
?>
