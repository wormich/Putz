<?
session_start() ;

if ($_POST['captcha'] && $_POST['captcha'] > 0) {

    if ($_SESSION["primer"] != $_POST['captcha']) {

        echo 'неверный код';exit;


    } else {


        echo 'ok';exit;
    }

}
?>