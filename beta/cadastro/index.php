<?php
require "./private/database.php";
require "./private/funcoes.php";
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link rel="stylesheet" type="text/css" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./public/css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XD Eventos Área de acesso</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form action="./public/controle_login.php" method="post" id="loginctrl">
                    <h1 class="text-center">Login</h1>
                    <p class="text-center">Bem Vindo a XD Eventos!</P>

                    <div class="form-group mb-2">
                        <input class="form-control" type="email" name="email" id="email"
                            placeholder="Endereço de E-mail" required>
                    </div>
                    <div class="form-group mb-2">
                        <input class="form-control" type="password" name="senha" id="senha" placeholder="Senha"
                            required>
                    </div>
                    <div class="link forget-pass text-left"><a href="./public/recuperar_senha.php">Esqueci minha senha</a></div>
                    <div class="form-group mb-2">
                        <input class="form-control button" type="submit" name="botao" value="Login">
                    </div>
                    <div class="link login-link text-center">Não possui Cadastro? <a
                            href="./public/tela_cadastro.php">Cadastre-se</a></div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="./public/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#loginctrl").on("submit", function (event) {
                event.preventDefault();

                var email = $('#email').val();
                var senha = $('#senha').val();

                $.post("./public/controle_login.php", { email, senha }).done(function (retorno) {
                    window.location = "./public/home_lista_clientes.php"
                }).fail(function (retorno) {

                    Swal.fire({
                        title: 'Erro',
                        text: retorno.statusText,
                        icon: 'error'
                    })

                })
            })
        });
    </script>
</body>

</html>