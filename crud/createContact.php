<?php 
    require_once "./helpers/connection.php";
    // From connection.php = $sqlConn
    require_once "./helpers/redirect.php";
    // From redirect.php = redirect()
    require_once "./helpers/filterValue.php";
    // From redirect.php = filterValue()
    require_once "./helpers/url.php";
    // From url.php = const BASE_URL
    session_start();

    $queryCreateContact = $sqlConn->prepare("INSERT INTO contato VALUE (DEFAULT, :userName, :userPhone, :observation)");
    $resultCreateContact = false; // Will get true when any contact is created
    $redirectUser = false; // Will receive true when it is necessary to redirect the user
    $queryError = false; // Will receive true when some query is not success.

    // Case 1: When the user is creating a new contact
    $userName = filterValue($_POST["userName"] ?? null);
    $userPhone = filterValue($_POST["userPhone"] ?? null);
    $userObservation = filterValue($_POST["userObservation"] ?? null);

    $userName = preg_match("/^([a-z]|[A-Z]|\s)+$/", $userName) ? strtolower($userName) : null;
    $userPhone = preg_match("/^\(\d{2}\)\s\d{4,5}\-\d{4}$/", $userPhone) ? $userPhone : null;
    $userObservation = preg_match("/^[^\'\"\=\<\>\(\)]+$/", $userObservation) ? $userObservation : null;

    if ($userName !== null && $userPhone !== null && $userObservation !== null) {
        // Check if the contact exists
        $redirectUser = true;

        $queryGetContact = $sqlConn->prepare("SELECT * FROM contato WHERE userName = :userName");
        $queryGetContact->bindParam(":userName", $userName);
        $resultGetContact = $queryGetContact->execute();

        if ($resultGetContact && $queryGetContact->rowCount() == 0) {
            $queryCreateContact->bindParam(":userName", $userName);
            $queryCreateContact->bindParam(":userPhone", $userPhone);
            $queryCreateContact->bindParam(":observation", $userObservation);

            $resultCreateContact = $queryCreateContact->execute();

            // If the contact was created
            if ($resultCreateContact) {
                $_SESSION["notification"] = [
                    "ok" => true,
                    "title" => "Contato adicionado",
                    "subtitle" => "Foram adicionados os seguites dados.",
                    "url" => BASE_URL . "/undo.php?action=create",
                    "contact" => null,
                    "undo" => false
                ];
            }else {
                $queryError = true;
            }
        } else {
            // If the contact already exists or the query retursn an error
            $resultCreateContact = false;
            $queryError = true;
        }
    }


    // Case 2: When the user is undoing some deletion
    // $action come from undo.php
    if (isset($action)) {
        if ($action == "create" && isset($_SESSION["lastNotification"]) && $_SESSION["lastNotification"] !== null) {
            $userName = $_SESSION["lastNotification"]["contact"]["userName"];
            $userPhone = $_SESSION["lastNotification"]["contact"]["userPhone"];
            $userObservation = $_SESSION["lastNotification"]["contact"]["observation"];
            
            $_SESSION["lastNotification"] = null;
    
            $queryCreateContact->bindParam(":userName", $userName, PDO::PARAM_STR);
            $queryCreateContact->bindParam(":userPhone", $userPhone, PDO::PARAM_STR);
            $queryCreateContact->bindParam(":observation",$userObservation, PDO::PARAM_STR);
    
            $resultCreateContact = $queryCreateContact->execute();
            $queryError = $resultCreateContact ? false : true;
            $redirectUser = true;
        }
    }

    // If the process fail
    if ($queryError) {
        $_SESSION["notification"] = [
            "ok" => false
        ];
    }

    if ($redirectUser) {
        redirect("/index.php");
    }
