<?php 
    require_once "./helpers/connection.php";
    // From connection.php = $sqlConn
    require_once "./helpers/redirect.php";
    // From redirect.php = redirect()
    require_once "./helpers/url.php";    
    // From url.php = const BASE_URL

    $ID = $_GET["id"] ?? null;
    $ID = preg_match("/^[0-9]*$/", intval($ID)) ? intval($ID) : null;

    if ($ID && $ID !== "") {
        // Check if the contact exists
        $queryGetContact = $sqlConn->prepare("SELECT * FROM contato WHERE id = :id");
        $queryGetContact->bindParam(":id", $ID, PDO::PARAM_INT);
        $resultGetContact = $queryGetContact->execute();

        // If exists
        if ($resultGetContact && $queryGetContact->rowCount()) {
            $contact = $queryGetContact->fetch(PDO::FETCH_ASSOC);

            $deleteContact = $sqlConn->prepare("DELETE FROM contato WHERE id = :id LIMIT 1");
            $deleteContact->bindParam(":id", $ID, PDO::PARAM_INT);

            $resultDeleteContact = $deleteContact->execute();

            session_start();

            // Success
            if ($resultDeleteContact) {                
                $_SESSION["notification"] = [
                    "ok" => true,
                    "title" => "Contato deletado",
                    "subtitle" => "Os seguintes dados foram apagados.",
                    "url" => BASE_URL . "/undo.php?action=create",
                    "contact" => $contact,
                    "undo" => true
                ];
            
            // Failed
            } else {
                $_SESSION["notification"] = [
                    "ok" => false
                ];
            }

            redirect("/index.php");
        }
        
    } else {
        redirect("/index.php");
    }
?>