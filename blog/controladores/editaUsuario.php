<?php
include "../db/comandos.php";

session_start();
if ($_POST) {
    $user = selectOne("users", ["Email" => $_POST["email"]]);
    if ($user && password_verify($_POST["senha"], $user["Senha"])) {
        $_SESSION["Email"] = $user["Email"];
        $_SESSION["Senha"] = $user["Senha"];
        $_SESSION["Nome"] = $user["Nome"];
        $_SESSION["Login"] = true;
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: admin.php?");
    } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: blog.php?r=" . urlencode("Informações inválidas"));
    }
} else if ($_SESSION) {
    $user = selectOne("users", ["Email" => $_SESSION["Email"]]);
    if ($user && ($_SESSION["Senha"] == $user["Senha"])) {
        if ($_SESSION["Login"]) {
            echo ("<script> alert('Login efetuado com sucesso') </script>");
            $_SESSION["Login"] = false;
        }
    } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: blog.php?r=" . urlencode("Informações inválidas"));
    }
} else {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: blog.php?r=" . urlencode("Acesso Negado"));
}
if (isset($_GET['r'])) {
    echo ("<script>alert('" . $_GET['r'] . "');</script>");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>ADMIN</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a href="home.html" class="navbar-brand" href="#" bg-color><img src="../../img/logo.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.html">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre.html">SOBRE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="servicos.html">SERVIÇOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contato.php">CONTATO</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            PRODUTOS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="escavadeiras.html">Escavadeiras</a>
                            <a class="dropdown-item" href="restroescavadeiras.html">Retroescavadeiras</a>
                            <a class="dropdown-item" href="carregadeiras.html">Carregadeiras</a>
                            <a class="dropdown-item" href="guindastes.html">Guindastes</a>
                            <a class="dropdown-item" href="rolos.html">Rolos</a>
                            <a class="dropdown-item" href="motoniveladoras.html">Motoniveladoras</a>
                            <a class="dropdown-item" href="perfuratrizes.html">Perfuratrizes</a>
                            <a class="dropdown-item" href="varredeiras.html">Varredeiras</a>
                            <a class="dropdown-item" href="peças.html">Peças</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">BLOG</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link"><?php echo ($_SESSION["Nome"]) ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container pt-2">
        <h5>Editar Usuário</h5>
        <form autocomplete="off" action="user.php"  method="post">
            <div class="form-group"><input type="hidden" class="form-control" name="Id" readonly value="<?php echo($_GET["id"]);?>"></div>
            <div class="form-group"><input type="text" class="form-control" name="Nome" placeholder="Nome" value="<?php echo($_GET["nome"]);?>" required></div>
            <div class="form-group"><input type="text" class="form-control" name="Email" placeholder="Email" value="<?php echo($_GET["email"]);?>" required></div>
            <div class="form-group"><input type="password" class="form-control" name="Senha" placeholder="Senha" required></div>
            <button type="submit" name="edita-usuario" class="btn btn-danger">Editar</button>
        </form>
    </div>




    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap.bundle.js"></script>
</body>

</html>