<?php

require "../private/compilado.php";

if (!empty($_GET['id'])) {

    $codigo = $_GET['id'];

    $sql = "SELECT * FROM usuarios WHERE codigo=$codigo";
    $consulta = $db->prepare($sql);
    $consulta->execute();

   

 

    while($base_usuarios = $consulta->fetch(PDO::FETCH_ASSOC)){
        extract($base_usuarios);

        $nome = $base_usuarios['nome'];
        $email = $base_usuarios['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            header("HTTP/1.1 400 Verifique o email informado.");
            exit();

        }
        $senha = $base_usuarios['senha'];
        $sexo = $base_usuarios['sexo'];
        $telefone = $base_usuarios['telefone'];
        $uf = $base_usuarios['uf'];
        $cidade = $base_usuarios['cidade'];

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
                <form data-codigo="<?= $codigo?>" method="post" id="formucaduser">

                    <h1 class="text-center">Editar Usuários</h1>
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
                        <input class="form-control" type="password" id="senha" name="senha" placeholder="Senha"
                            value="<?= $senha?>"required>
                    </div>

                    <div class="form-group mb-2">
                        <select class="form-control" type="text" id="sexo" name="sexo"required>
                            <option value="Masculino" <?= $sexo=="Masculino"?"selected":""?>>Masculino</option>
                            <option value="Feminino" <?= $sexo=="Feminino"?"selected":""?>>Feminino</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <input class="form-control" type="text" id="telefone" name="telefone" placeholder="Telefone"
                            maxlength="15" pattern="\(\d{2}\)\s*\d{5}-\d{4}" value="<?= $telefone?>"required>
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
                        <button class="form-control button" type="submit" id="editar">Salvar</button>
                    </div>

                    <div class="link login-link text-center">Deseja voltar para a área de Acesso? <br><a
                            href="home_lista_usuarios.php">Clique aqui</a>
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
    
        $(function () {
            $("#formucaduser").on("submit", function (event) {
                event.preventDefault();


                var codigo = $(event.currentTarget).attr("data-codigo");
                var nome = $('#nome').val();
                var email = $('#email').val();
                var senha = $('#senha').val();
                var telefone = $('#telefone').val();
                var sexo = $('#sexo').val();
                var uf = $('#uf').val();
                var cidade = $('#cidade').val();

                $.post("./controle_cadastro_usuario.php", { codigo, nome, email, senha, telefone, sexo, uf, cidade}).done(function (retorno) {
                    Swal.fire({
                        title: 'Pronto',
                        text: 'Cadastro realizado com sucesso!',
                        icon: 'success'
                    }).then(function () {
                        window.location.href="./home_lista_usuarios.php"
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