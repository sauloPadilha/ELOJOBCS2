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
    <title>Cadastro Clientes</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="controle_cadastro_cliente.php" method="post" id="formucadclient">

                    <h1 class="text-center">Cadastro de Clientes</h1>
                    <p class="text-center">Insira informações válidas</p>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome Completo"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="email" name="email" placeholder="Endereço de E-mail"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="documento" name="documento" placeholder="Documento"
                            maxlength="18" required>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="telefone" name="telefone" placeholder="Telefone"
                            maxlength="15" pattern="\(\d{2}\)\s*\d{5}-\d{4}" required>
                    </div>

                    <div class="form-check mb-2">
                        <p>Origem</p>
                        <label class="form-check-label" for="site">Site</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Site"><br>

                        <label class="form-check-label" for="boca">Boca a Boca</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Boca a Boca"><br>

                        <label class="form-check-label" for="facebook">Facebook</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Facebook"><br>

                        <label class="form-check-label" for="indicacao">Indicação</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Indicação"><br>
                    </div>

                    <div class="form-group mb-2">
                        <select class="form-control" id="uf" name="uf" required>
                            <option value="" disabled selected hidden>Selecione um Estado</option>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <select class="form-control" id="cidade" name="cidade" required>
                            <option value="" disabled selected hidden>Selecione uma Cidade</option>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="observacao" name="observacao"
                            placeholder="Observação">
                    </div>

                    <div class="form-group mb-2">
                        <button class="form-control button" type="submit" id="registrador"
                            name="criar">Cadastrar</button>
                    </div>

                    <div class="link login-link text-center">Deseja voltar para a área de Acesso? <br><a
                            href="home_lista_clientes.php">Clique aqui</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="../public/js/buscacidade.js"></script>
    <script type="text/javascript">

        const tel = document.getElementById('telefone')

        tel.addEventListener('keypress', (e) => mascaraTelefone(e.target.value))
        tel.addEventListener('change', (e) => mascaraTelefone(e.target.value))

        const mascaraTelefone = (valor) => {
            valor = valor.replace(/\D/g, "")
            valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2")
            valor = valor.replace(/(\d)(\d{4})$/, "$1-$2")
            tel.value = valor
        }

        const doc = document.getElementById('documento')

        doc.addEventListener('keypress', (e) => mascaraDocumento(e.target.value))
        doc.addEventListener('change', (e) => mascaraDocumento(e.target.value))

        const mascaraDocumento = (valor) => {
            valor = valor.replace(/\D/g, '')
            valor = valor.replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, "$1.$2.$3/$4-$5");
            doc.value = valor
        }


        $(function () {
            $("#formucadclient").on("submit", function (event) {
                event.preventDefault();



                var nome = $('#nome').val();
                var email = $('#email').val();
                var documento = $('#documento').val();
                var telefone = $('#telefone').val();
                var origem = [];

                $('[name="origem[]"]:checked').each(function (i) {
                    origem[i] = $(this).val();
                });

                var uf = $('#uf').val();
                var cidade = $('#cidade').val();
                var observacao = $('#observacao').val();

                $.post("./controle_cadastro_cliente.php", { nome, email, documento, telefone, origem, uf, cidade, observacao }).done(function (retorno) {
                    Swal.fire({
                        title: 'Pronto',
                        text: 'Cadastro realizado com sucesso!',
                        icon: 'success'
                    }).then(function () {
                        location.reload();
                    })

                }).fail(function (retorno) {
                    Swal.fire({
                        title: 'Erro',
                        text: retorno.statusText,
                        icon: 'error'
                    })
                })
            });

        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#registrador').click(function () {

                var valid = this.form.checkValidity();

                if (!valid) {
                    Swal.fire({
                        title: 'Erro',
                        text: 'Por favor, verifique os dados inseridos.',
                        icon: 'error'
                    })
                }
            });
        });

    </script>

</body>

</html>