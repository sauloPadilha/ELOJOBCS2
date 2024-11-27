<?php

require "../private/compilado.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (empty($_POST['email']) or empty($_POST['senha'])) {
        header("HTTP/1.1 400 Verifique os dados inseridos");
    } else {

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $sql = "SELECT *FROM usuarios WHERE email= '$email' and senha= '$senha'";
        $consultar = $db->prepare($sql);
        $consultar->execute();

        if (empty($consultar->fetchAll())) {
            $_SESSION["Autenticado"] = false;
            header("HTTP/1.1 404 Cadastro inexistente.");
        } else {
            $_SESSION["Autenticado"] = true;
            header("Location: home_lista_clientes.php");
        }

    }
}