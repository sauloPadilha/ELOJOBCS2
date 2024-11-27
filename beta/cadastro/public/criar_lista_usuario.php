<?php
require "../private/compilado.php";

$dados_request = $_REQUEST;

$pagina = $_GET["pagina"] > 1 ? ($_GET["pagina"] - 1) * 5 : 0;
$buscar = strtoupper($_GET["buscar"]);

$qtd_usuario = "SELECT COUNT(codigo) AS qtd_usuarios FROM usuarios";
$consulta_qtd = $db->prepare($qtd_usuario);
$consulta_qtd->execute();

$show_qtd = $consulta_qtd->fetch(PDO::FETCH_ASSOC);

$base_usuarios = "SELECT codigo, nome, email, sexo, telefone, uf, cidade, situacao FROM usuarios WHERE  nome LIKE '%$buscar%' OR cidade LIKE '%$buscar%' OR uf LIKE '%$buscar%' OR situacao = IF('$buscar' = 'ATIVO', 1, IF('$buscar' = 'INATIVO', 0, null)) LIMIT 5 OFFSET $pagina";
$consulta_usuarios = $db->prepare($base_usuarios);
$consulta_usuarios->execute();

$dados = ["registro" => [], "total" => $show_qtd["qtd_usuarios"]];


while ($row_usuarios = $consulta_usuarios->fetch(PDO::FETCH_ASSOC)) {
    extract($row_usuarios);

    $registro = [];
    $registro["codigo"] = $codigo;
    $registro["nome"] = $nome;
    $registro["email"] = $email;
    $registro["sexo"] = $sexo;
    $registro["telefone"] = $telefone;
    $registro["estado_cidade"] = $uf . " - " . $cidade;
    $registro["situacao"] = $situacao ? "Ativo" : "Inativo";
    $dados["registro"][] = $registro;



}

echo json_encode($dados);
?>