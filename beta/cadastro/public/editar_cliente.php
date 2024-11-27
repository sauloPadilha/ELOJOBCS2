<?php

require "../private/compilado.php";

if (!empty($_GET['id'])) {

    $codigo = $_GET['id'];

    $sql = "SELECT * FROM clientes WHERE codigo=$codigo";
    $consulta = $db->prepare($sql);
    $consulta->execute();

   

 

    while($base_cliente = $consulta->fetch(PDO::FETCH_ASSOC)){
        extract($base_cliente);

        $nome = $base_cliente['nome'];
        $email = $base_cliente['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            header("HTTP/1.1 400 Verifique o email informado.");
            exit();

        }
        $documento = $base_cliente['documento'];
        $telefone = $base_cliente['telefone'];

        $origem = json_decode($base_cliente['origem']);

        $uf = $base_cliente['uf'];
        $cidade = $base_cliente['cidade'];
        $observacao = $base_cliente['observacao'];

        $situacao =  json_decode($base_cliente['situacao']);
    }

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
    <title>Editar Cliente</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form data-codigo="<?= $codigo?>" method="post" id="formucadclient">

                    <h1 class="text-center">Editar Cliente</h1>
                    <p class="text-center">Insira informações válidas</p>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome Completo"
                            value="<?= $nome?>"required>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="email" name="email" placeholder="Endereço de E-mail"
                            value="<?= $email?>"required>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="documento" name="documento" placeholder="Documento"
                            maxlength="18" value="<?= $documento?>"required>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="telefone" name="telefone" placeholder="Telefone"
                            maxlength="15" pattern="\(\d{2}\)\s*\d{5}-\d{4}" value="<?= $telefone?>"required>
                    </div>

                    <div class="form-check mb-2">
                        <p>Origem</p>
                        <label class="form-check-label" for="site">Site</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Site"<?= in_array("Site",$origem)?"checked":"" ?>><br>

                        <label class="form-check-label" for="boca">Boca a Boca</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Boca a Boca"<?= in_array("Boca a Boca",$origem)?"checked":"" ?>><br>

                        <label class="form-check-label" for="facebook">Facebook</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Facebook"<?= in_array("Facebook",$origem)?"checked":"" ?>><br>

                        <label class="form-check-label" for="indicacao">Indicação</label>
                        <input class="form-check-input" type="checkbox" name="origem[]" value="Indicação"<?= in_array("Indicação",$origem)?"checked":"" ?>><br>
                    </div>

                    <div class="form-group mb-2">
                        <select class="form-control" id="uf" name="uf" value="<?= $uf?>"required>
                            <option value="" disabled selected hidden>Selecione um Estado</option>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <select class="form-control" id="cidade" name="cidade" value="<?= $cidade?>"required>
                            <option value="" disabled selected hidden>Selecione uma Cidade</option>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="observacao" name="observacao"
                            placeholder="Observação" value="<?= $observacao?>">
                    </div>

                    <div class="form-group mb-2">
                        <p>Situação</p>
                        <label>
                        <input class="radio form-check-input" type="radio" name="situacao" value="1"<?= $situacao==1?"checked":"" ?>/>Ativo</label><br>
                        <label>
                        <input class="radio form-check-input" type="radio" name="situacao" value="0"<?= $situacao==0?"checked":"" ?>/>Inativo</label>
                    </div>

                    <div class="form-group mb-2">
                        <button class="form-control button" type="submit" id="editar">Salvar</button>
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


                var codigo = $(event.currentTarget).attr("data-codigo");
                var nome = $('#nome').val();
                var email = $('#email').val();
                var documento = $('#documento').val();
                var telefone = $('#telefone').val();
                var origem = [];
                var situacao = $('[name="situacao"]:checked').val();

                $('[name="origem[]"]:checked').each(function (i) {
                    origem[i] = $(this).val();
                });

                var uf = $('#uf').val();
                var cidade = $('#cidade').val();
                var observacao = $('#observacao').val();

                $.post("./controle_cadastro_cliente.php", { codigo, nome, email, documento, telefone, origem, uf, cidade, observacao, situacao }).done(function (retorno) {
                    Swal.fire({
                        title: 'Pronto',
                        text: 'Cadastro realizado com sucesso!',
                        icon: 'success'
                    }).then(function () {
                        window.location.href="./home_lista_clientes.php"
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