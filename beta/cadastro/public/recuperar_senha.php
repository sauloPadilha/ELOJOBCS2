<?php

require "../private/compilado.php";


    if(isset($_POST['validar-email'])){

        $email = $_POST['email'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erro[] = "E-mail inválido";
        }

        $novasenha = substr(md5(time()), 0, 6);
        

        if(mail($email, "Sua nova senha", "Sua nova senha: ".$novasenha)){

        $sql = "UPDATE usuario SET senha = '$novasenha' WHERE email ='$email'";
        $consulta = $db->prepare($sql);
        $consulta->execute();
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
    <title>Recuperar Senha</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="recuperar_senha.php" method="post">
                    <h1 class="text-center">Recuperação de Senha</h1>
                    <p class="text-center">Nos informe seu e-mail Cadastrado</p>

                    <div class="form-group mb-2">
                        <input class="form-control" type="email" name="email" placeholder="Digite seu endereço de e-mail" required >
                    </div>
                    <div class="form-group mb-2">
                        <input class="form-control button" type="submit" name="validar-email" value="Redefinir Senha">
                    </div>

                    <div class="link login-link text-center"><a href="../index.php">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>