<?php 
    require_once __DIR__ . "./url.php";

    function redirect($url) {
        header("location: " . BASE_URL . $url);
        die();
    }
?>