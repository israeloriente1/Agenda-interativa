<?php 
    require_once "./helpers/connection.php";
    // From connection.php = $sqlConn

    $queryGetAllContacts = $sqlConn->prepare("SELECT * FROM contato ORDER BY userName");
    $queryGetAllContacts->execute();
    $contacts = [];

    if ($queryGetAllContacts->rowCount()) {
        while ($contact = $queryGetAllContacts->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = $contact;
        }
    }
?>