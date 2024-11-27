<?php

require "../private/compilado.php";

if ($_SESSION["Autenticado"] == false) {

    session_destroy();
    header("Location:../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    
    <div class="container">
    <h1 class="titulo d-flex">Clientes</h1>
        <div class="box-sizing-unset tabela table table-bordered">
            <div class="cabecalho">
                <div>
                    <a href="./home_lista_usuarios.php" class="botao-tabela btn btn-primary " role="button">
                        <i class="fa-solid fa-user"></i> Usuários</a>
                    <a href="./home_lista_clientes.php" class="botao-tabela btn btn-primary" role="button">
                        <i class="fa-solid fa-building"></i> Clientes</a>
                </div>
                <div class="d-flex">
                    <input type="text" class="form-control" id="buscar" placeholder="Buscar" aria-label="Buscar">
                    <button class="botao-tabela btn btn-primary" id="bot-buscar" type="button">
                        <i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
            <br>
            <table id="lista_cliente" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Origem</th>
                        <th scope="col">Estado/Cidade</th>
                        <th scope="col">Situação</th>
                        <th scope="col">Observação</th>
                        <th scope="col">Ações</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="rodape">
                <a class="adicionar fa-solid fa-user-plus" href="./tela_cadastro_cliente.php"></a>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" id="primeira" data-pagina="1"><a class="page-link" href="#">Primeira</a>
                        </li>
                        <span id="botoes-paginas" class="d-flex"></span>
                        <li class="page-item" id="ultima"><a class="page-link" href="#">Última</a></li>
                    </ul>
                </nav>
            </div>
            <div class="justify-content-right">
            <a href="../index.php" class="botao-tabela btn btn-primary " role="button" id="logoff">
                <i class="fa-solid fa-right-to-bracket"></i> Logoff</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://kit.fontawesome.com/e11d02a183.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on("click", ".pagination li", function (evento) {
                var pagina = $(evento.currentTarget).attr("data-pagina")
                var buscar = $("#buscar").val()

                $("#lista_cliente").find("tbody").empty()
                $.getJSON("./criar_lista_cliente.php", { pagina, buscar }).done(function (resultado) {
                    const tabela = $("#lista_cliente").find("tbody")

                    resultado.registro.forEach(element => {
                        var origens = JSON.parse(element.origem)

                        tabela.append(`<tr>
                            <td scope"row" class="linhas">${element.nome}</td>
                            <td scope"row">${element.email}</td>
                            <td scope"row">${element.documento}</td>
                            <td scope"row" class="linhas">${element.telefone}</td>
                            <td scope"row">${origens.join(", ")}</td>
                            <td scope"row">${element.estado_cidade}</td>
                            <td scope"row">${element.situacao}</td>
                            <td scope"row">${element.observacao}</td>
                            <td scope"row"><a class=" editar fas fa-user-edit" href="./editar_cliente.php?id=${element.codigo}"></a>&nbsp;<a class="excluir fa-solid fa-user-minus" href="./excluir_cliente.php?id=${element.codigo}"></a></td>
                        </tr>`)
                    });
                    if ($("#botoes-paginas").html() == "") {
                        var paginacao = Math.ceil(resultado.total / 5)
                        var x
                        for (x = 1; x <= paginacao; x++) {
                            $("#botoes-paginas").append(`<li data-pagina="${x}"><a class="page-link" href="#">${x}</a></li>`)
                        }
                        $("#ultima").attr("data-pagina", paginacao)
                    }
                })
            })
            $("#bot-buscar").on("click", function () {
                $(".pagination li#primeira").trigger("click")
            })
            $(".pagination li#primeira").trigger("click")

        });
    </script>
</body>

</html>