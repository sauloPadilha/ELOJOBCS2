<?php

ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurações de banco de dados
$host = 'ftp.elojobcs21.hospedagemdesites.ws';
$port = '21';
$dbname = 'elojobcs2';
$username = 'ELOJOBCS2';
$password = 'Banco@2024';

// Configuração do arquivo de log
$logFile = 'meu_log.txt';

// Função para registrar mensagens no log
function registrarLog($mensagem, $arquivo) {
    $hora = date('Y-m-d H:i:s');
    file_put_contents($arquivo, "[$hora] $mensagem" . PHP_EOL, FILE_APPEND);
}

try {
    // Estabelecendo conexão com o banco de dados
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
    registrarLog("Conexão com o banco de dados estabelecida com sucesso.", $logFile);

    // Exemplo de consulta ao banco de dados
    $sql = "SELECT * FROM teste"; // Substitua 'tabela' pelo nome real da tabela
    registrarLog("Executando consulta: $sql", $logFile);

    $stmt = $pdo->query($sql);

    // Log do número de resultados
    $count = $stmt->rowCount();
    registrarLog("Consulta executada com sucesso. Total de linhas: $count", $logFile);

    // Exibindo e logando os resultados
    foreach ($stmt as $row) {
        registrarLog("Resultado: " . print_r($row, true), $logFile);
        echo "<pre>" . print_r($row, true) . "</pre>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erro ao conectar ou executar consulta: " . $e->getMessage() . "</p>";
    registrarLog("Erro ao conectar ou executar consulta: " . $e->getMessage(), $logFile);
    die();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log MySQL</title>
</head>
<body>
    <h1>Log MySQL - Monitoramento</h1>
    <p>Consulte o arquivo <strong>meu_log.txt</strong> para detalhes das operações realizadas.</p>
</body>
</html>
