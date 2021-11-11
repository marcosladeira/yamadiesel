<?php
include "../db/comandos.php";
if(isset($_POST["criar-post"])){
    unset($_POST["criar-post"]);
    
    $imagem = time() . "_" . $_FILES["Imagem"]["name"];
    $destino = "../imagens/" . $imagem;
    $resultado = move_uploaded_file($_FILES["Imagem"]["tmp_name"], $destino);

    if ($resultado) {
        $_POST["Imagem"] = $imagem;
        $_POST["Corpo"] = htmlentities($_POST["Corpo"]);
        $post_id = criar("posts", $_POST);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Post criado com ID = " . $post_id. ". Publique ele na area de gerenciamento"));
    } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Erro ao salvar a imagem"));
    }
    

}
if(isset($_POST["edita-post"])){
    unset($_POST["edita-post"]);
    if ($_FILES["Imagem"]["name"] == "") {
        $id = $_POST["Id"];
        unset($_POST["Id"] , $_POST["Imagem"]);
        $_POST["Corpo"] = htmlentities($_POST["Corpo"]);
        $post_id = atualizar("posts", $id, $_POST);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Post atualizado com sucesso"));
    } else {
        $imagem = time() . "_" . $_FILES["Imagem"]["name"];
        $destino = "../imagens/" . $imagem;
        $resultado = move_uploaded_file($_FILES["Imagem"]["tmp_name"], $destino);
    
        if ($resultado) {
            $id = $_POST["Id"];
            unset($_POST["Id"]);
            $_POST["Imagem"] = $imagem;
            $_POST["Corpo"] = htmlentities($_POST["Corpo"]);
            $post_id = atualizar("posts", $id, $_POST);
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ../admin.php?r=" . urlencode("Post atualizado com sucesso"));
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ../admin.php?r=" . urlencode("Erro ao salvar a imagem"));
        }
    }
}
if (isset($_GET["iddespublicar"])) {
    atualizar("posts",$_GET["iddespublicar"],["Publicado" => 0]);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ../admin.php?r=" . urlencode("Post ".$_GET["iddespublicar"]." despublicado"));
}
if (isset($_GET["idpublicar"])) {
    atualizar("posts",$_GET["idpublicar"],["Publicado" => 1]);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ../admin.php?r=" . urlencode("Post ".$_GET["idpublicar"]." publicado"));
}
if (isset($_GET["idexcluir"])) {
    unlink("../imagens/" . $_GET["img"]);
    deletar("posts",$_GET["idexcluir"]);   
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ../admin.php?r=" . urlencode("Post ".$_GET["idexcluir"]." excluído com sucesso"));
}