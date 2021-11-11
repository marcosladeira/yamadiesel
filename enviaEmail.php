<?php
    if($_POST){
        // $para = "contato@yamadiesel.com.br";
        $para = "marcosladeirarolim@gmail.com";
        $assunto = $_POST["assunto"];

        $texto = $_POST["texto"];
        $texto = wordwrap($texto,70);
        $texto = str_replace("\n.", "\n..", $texto);

        $corpo = "Nome: ".$_POST["nome"]."<br>";
        $corpo .= "Email: ".$_POST["email"]."<br> <br>";
        $corpo .= $texto;

        $cabecalho = "Content-Type: text/html; charset=UTF-8"."\r\n";
        $cabecalho .= "From: ".($_POST["email"]."\r\n");
        $cabecalho .= "Reply-to: ".($_POST["email"]."\r\n");

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $resultado = mail($para, $assunto, $corpo, $cabecalho);
            if ($resultado) {
                $mensagem = "Email enviado com sucesso";
            } else {
                $mensagem = "Falha ao enviar o email. Revise suas informações ou tente novamente mais tarde";
            }
        } else {
            $mensagem = "Falha ao enviar, Email incorreto";
        }            
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: contato.php?r=" . urlencode($mensagem));
    }                    
?>