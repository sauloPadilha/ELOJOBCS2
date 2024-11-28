<?php

ini_set('max_execution_time', 300); // Tempo máximo de execução (em segundos)
ini_set('memory_limit', '512M'); // Aumenta o limite de memória
ini_set('mysql.connect_timeout', 300); // Tempo de espera para conectar ao MySQL
ini_set('default_socket_timeout', 300); // Tempo de espera para resposta

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'ftp.elojobcs21.hospedagemdesites.ws';
$port = '21';
$dbname = 'elojobcs2';
$username = 'ELOJOBCS2';
$password = 'Banco@2024';

try {
    // Configuração PDO com parâmetros adicionais
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
    echo "<p style='color: green;'>Conexão com o banco de dados estabelecida com sucesso.</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erro ao conectar ao banco de dados: " . $e->getMessage() . "</p>";
    error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-br">