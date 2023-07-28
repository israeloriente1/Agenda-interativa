<?php 
    $host = "localhost";
    $dbname = "agenda";
    $dbUsername = "root";
    $dbPassword = "";

    try {
        $sqlConn = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
        $sqlConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        $error = $e->getMessage();
        print "Erro: $error";
    }
?>