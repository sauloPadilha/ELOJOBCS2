<?php
require "../private/compilado.php";

$codigo = $_GET['id'];

$query_cliente = "DELETE FROM clientes WHERE codigo = $codigo";

$excluir_cliente = $db->prepare($query_cliente);
$excluir_cliente->execute();

header("Location:./home_lista_clientes.php");