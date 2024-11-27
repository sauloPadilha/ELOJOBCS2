<?php

require "../private/compilado.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $codigo = empty($_POST['codigo']) ? 0 : $_POST['codigo'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        header("HTTP/1.1 400 Verifique o email informado.");
        exit();

    }


    $sql = "SELECT * FROM clientes WHERE email='$email' AND IF($codigo, codigo <>$codigo, true)";
    $resultado = $db->prepare($sql);
    $resultado->execute();

    if(!empty($resultado->fetchAll())){
        header("HTTP/1.1 400 Email ja cadastrado");
        exit();
    }
    $documento = $_POST['documento'];
    $telefone = $_POST['telefone'];

    $origem = json_encode($_POST['origem'],JSON_UNESCAPED_UNICODE);

    $uf = $_POST['uf'];
    $cidade = $_POST['cidade'];
    $observacao = $_POST['observacao'];
    $situacao = !isset($_POST['situacao'])?1:$_POST['situacao'];

    if (!$codigo) {

        $sql = "INSERT INTO clientes (nome, email, documento, telefone, origem, uf, cidade, observacao, situacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $inserir = $db->prepare($sql);
        $resultado = $inserir->execute([$nome, $email, $documento, $telefone, $origem, $uf, $cidade, $observacao, $situacao]);
    }else{
        $sql = "UPDATE clientes SET nome='$nome', email='$email', documento='$documento', telefone='$telefone', origem='$origem', uf='$uf', cidade='$cidade', observacao='$observacao', situacao='$situacao' WHERE codigo='$codigo'";
        $inserir = $db->prepare($sql);
        $resultado = $inserir->execute();
    }
    if (!$resultado) {
        header("HTTP/1.1 500 Internal Server Error");
    }
}
?>