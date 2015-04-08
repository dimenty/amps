<?php

function writeConf($txt) {
    if( isset( $_POST['my_button'] ) ) {
        file_put_contents("testwrite.txt", $txt, FILE_APPEND | LOCK_EX);
        header('Location: localhost/amps/index.php');
        die();
    }
}

?>