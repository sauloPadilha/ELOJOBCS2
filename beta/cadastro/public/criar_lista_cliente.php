<?php
require "../private/compilado.php";

$dados_request = $_REQUEST;

$pagina = $_GET["pagina"] > 1 ? ($_GET["pagina"] - 1) * 5 : 0;
$buscar = strtoupper($_GET["buscar"]);

$qtd_cliente = "SELECT COUNT(codigo) AS qtd_clientes FROM clientes";
$consulta_qtd = $db->prepare($qtd_cliente);
$consulta_qtd->execute();

$show_qtd = $consulta_qtd->fetch(PDO::FETCH_ASSOC);

$base_clientes = "SELECT codigo, nome, email, documento, telefone, origem, uf, cidade, situacao, observacao FROM clientes WHERE  nome LIKE '%$buscar%' OR cidade LIKE '%$buscar%' OR uf LIKE '%$buscar%' OR  origem LIKE '%$buscar%' OR situacao = IF('$buscar' = 'ATIVO', 1, IF('$buscar' = 'INATIVO', 0, null)) LIMIT 5 OFFSET $pagina";
$consulta_clientes = $db->prepare($base_clientes);
$consulta_clientes->execute();

$dados = ["registro" => [], "total" => $show_qtd["qtd_clientes"]];


while ($row_clientes = $consulta_clientes->fetch(PDO::FETCH_ASSOC)) {
    extract($row_clientes);

    $registro = [];
    $registro["codigo"] = $codigo;
    $registro["nome"] = $nome;
    $registro["email"] = $email;
    $registro["documento"] = $documento;
    $registro["telefone"] = $telefone;
    $registro["origem"] = $origem;
    $registro["estado_cidade"] = $uf . " - " . $cidade;
    $registro["situacao"] = $situacao ? "Ativo" : "Inativo";
    $registro["observacao"] = $observacao;
    $dados["registro"][] = $registro;



}

echo json_encode($dados);
?>