<?php
include "db/comandos.php";

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
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>ADMIN</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a href="../home.html" class="navbar-brand" href="#" bg-color><img src="../img/logo.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../home.html">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../sobre.html">SOBRE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../servicos.html">SERVIÇOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contato.php">CONTATO</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            PRODUTOS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../escavadeiras.html">Escavadeiras</a>
                            <a class="dropdown-item" href="../restroescavadeiras.html">Retroescavadeiras</a>
                            <a class="dropdown-item" href="../carregadeiras.html">Carregadeiras</a>
                            <a class="dropdown-item" href="../guindastes.html">Guindastes</a>
                            <a class="dropdown-item" href="../rolos.html">Rolos</a>
                            <a class="dropdown-item" href="../motoniveladoras.html">Motoniveladoras</a>
                            <a class="dropdown-item" href="../perfuratrizes.html">Perfuratrizes</a>
                            <a class="dropdown-item" href="../varredeiras.html">Varredeiras</a>
                            <a class="dropdown-item" href="../peças.html">Peças</a>
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
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="criar-posts-tab" data-toggle="tab" href="#criar-posts" role="tab" aria-controls="criar-posts" aria-selected="false">Criar post</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">Gerenciar posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab" aria-controls="usuarios" aria-selected="true">Usuarios</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="criar-posts" role="tabpanel" aria-labelledby="criar-posts-tab"> <!-- Criar posts -->
            <div class="container pt-2">
                <h5>Criar post</h5>
                <form action="controladores/post.php" method="post" enctype="multipart/form-data">
                    <div class="form-group"><input type="text" class="form-control" name="Titulo" placeholder="Titulo" required></div>
                    <div class="form-group"><textarea class="form-control" name="Corpo" placeholder="Corpo" rows="10" id="corpo" required></textarea></div>
                    <div class="custom-file"><input type="file" class="custom-file-input" id="customFile" required name="Imagem"><label class="custom-file-label" for="customFile">Escolha Imagem</label></div>
                    <button type="submit" name="criar-post" class="btn btn-danger mt-2">Criar</button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab"> <!-- Gerenciar posts -->
            <div class="container pt-2">
                <h6 class="text-muted">Posts não publicados não aparecerão no blog</h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 7%;">ID</th>
                            <th scope="col" style="width: 20%;">Titulo</th>
                            <th scope="col" style="width: 55%;">Corpo</th>
                            <th scope="col" style="width: 6%;">Editar</th>
                            <th scope="col" style="width: 6%;">Excluir</th>
                            <th scope="col" style="width: 6%;">Publicado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $posts = selectAll("posts");
                        foreach ($posts as $key => $post) {
                            echo ("<tr>
                            <th scope='row'>" . $post['Id'] . "</th>
                            <td>" . $post['Titulo'] . "</td>
                            <td>" . mb_strimwidth($post['Corpo'], 0, 75, "...") . "</td>
                            <td><a href='controladores/editaPosts.php?id=" . $post['Id'] . "' class='btn btn-primary'>Editar</a></td>
                            <td><a class='btn btn btn-danger' href='controladores/post.php?idexcluir=" . $post['Id'] . "&img=" . $post['Imagem'] . "'>Excluir</a></td>");
                            if ($post['Publicado']) {
                                echo ("<td><a href='controladores/post.php?iddespublicar=".$post['Id']."' class='btn btn-warning'>Despublicar</a></td></tr>");
                            } else {
                                echo ("<td><a href='controladores/post.php?idpublicar=".$post['Id']."' class='btn btn-success'>Publicar</a></td>");
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab"> <!-- Usuarios -->
            <div class="container pt-2">
                <h5>Criar Usuário</h5>
                <form action="controladores/user.php" method="post">
                    <div class="form-group"><input type="text" class="form-control" name="Nome" placeholder="Nome" required></div>
                    <div class="form-group"><input type="email" class="form-control" name="Email" placeholder="Email" required></div>
                    <div class="form-group"><input type="password" class="form-control" name="Senha" placeholder="Senha" required></div>
                    <button type="submit" name="criar-usuario" class="btn btn-danger">Criar</button>
                </form>
            </div>
            <div class="container pt-2">
                <h6 class="text-muted">Excluir ou editar o seu usuário atual fará você sair da sessão</h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = selectAll("users");
                        foreach ($users as $key => $user) {
                            echo ("<tr>
                            <th scope='row'>" . $user['Id'] . "</th>
                            <td>" . $user['Nome'] . "</td>
                            <td>" . $user['Email'] . "</td>
                            <td><a href='controladores/editaUsuario.php?id=" . $user['Id'] . "&nome=" . $user['Nome'] . "&email=" . $user['Email'] . "' class='btn btn-primary'>Editar</a></td>
                            <td><a class='btn btn btn-danger' onclick='confirmaExclusaoUser(" . $user['Id'] . ")'>Excluir</a></td>
                            </tr>");
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        function confirmaExclusaoUser(Id) {
            if (confirm("Excluir Usuário " + Id + "?")) {
                window.location.replace("controladores/user.php?idexcluir=" + Id);
            }
        }
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("customFile").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })
    </script>
    
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>