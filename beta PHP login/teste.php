<?php
require 'db_config.php';

try {
    // Inserir um registro de teste
    $sql = "INSERT INTO teste (texto_teste) VALUES (:texto_teste)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':texto_teste' => 'Teste de Conexão com MySQL']);

    // Consultar os registros
    $sql = "SELECT * FROM teste";
    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Registros na Tabela de Teste:</h3>";
    foreach ($resultados as $linha) {
        echo "ID: " . $linha['id_teste'] . " - Texto: " . $linha['texto_teste'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Erro ao interagir com a tabela de teste: " . $e->getMessage();
}
?>
