<?php
include "../db/comandos.php";
if (isset($_POST["criar-usuario"])) {
    unset($_POST["criar-usuario"]);
    $usuarioExistente = selectOne("users", ["Email" => $_POST["Email"]]);
    if (isset($usuarioExistente)) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Email já em uso"));
    } else {
        $_POST["Senha"] = password_hash($_POST["Senha"], PASSWORD_DEFAULT);
        $user_id = criar("users", $_POST);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Usuário criado com ID = " . $user_id));
    }
}
if (isset($_POST["edita-usuario"])) {
    unset($_POST["edita-usuario"]);
    $usuarioExistente = selectOne("users", ["Email" => $_POST["Email"]]);
    if (isset($usuarioExistente)) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Email já em uso"));
    } else {
        $id = $_POST["Id"];
        unset($_POST["Id"]);
        $_POST["Senha"] = password_hash($_POST["Senha"], PASSWORD_DEFAULT);
        $user_id = atualizar("users",$id, $_POST);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Usuário atualizado com sucesso"));
    }
}
if (isset($_GET["idexcluir"])) {
    $users = contarUsers();
    if ($users <= 1) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Pelo menos um Usuário deve Existir"));
    }else{
        deletar("users",$_GET["idexcluir"]);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ../admin.php?r=" . urlencode("Usuário ".$_GET["idexcluir"]." excluído com sucesso"));
    }
    
}