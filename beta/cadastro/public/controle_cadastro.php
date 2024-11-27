<?php

require "../private/compilado.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        header("HTTP/1.1 400 Verifique o email informado.");
        exit();

    }

    if (!senha_forte($_POST['senha'])) {
        header("HTTP/1.1 400 Sua senha devera conter no minimo 8 caracteres, deve conter letra minuscula, maiuscula, caracteres especiais e numeros.");
        exit();
    }
    $senha = $_POST['senha'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefone'];
    $uf = $_POST['uf'];
    $cidade = $_POST['cidade'];
    



    $sql = "INSERT INTO usuarios (nome, email, senha, sexo, telefone, uf, cidade) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $inserir = $db->prepare($sql);
    $resultado = $inserir->execute([$nome, $email, $senha, $sexo, $telefone, $uf, $cidade]);

    if (!$resultado) {
        header("HTTP/1.1 500 Internal Server Error");
    }
}
?>