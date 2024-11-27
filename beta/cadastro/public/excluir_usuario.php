<?php
require "../private/compilado.php";


$codigo = explode("=",$_SERVER["QUERY_STRING"]);

$query_usuario = "DELETE FROM usuarios WHERE codigo = $codigo[1]";

$excluir_usuario = $db->prepare($query_usuario);
$excluir_usuario->execute();

header("Location:./home_lista_usuarios.php");