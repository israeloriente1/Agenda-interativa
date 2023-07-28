<?php 
    require_once "./helpers/connection.php";
    // From connection.php = $sqlConn
    require_once "./helpers/redirect.php";
    // From redirect.php = redirect()
    require_once "./helpers/filterValue.php";
    // From filterValue.php = filterValue()
    session_start();

    $ID = $_GET["id"] ?? null;
    $ID = preg_match("/^[0-9]*$/", intval($ID)) ? intval($ID) : null;      

    $postUserName = filterValue($_POST["userName"] ?? null);
    $postUserPhone = filterValue($_POST["userPhone"] ?? null);
    $postUserObservation = filterValue($_POST["userObservation"] ?? null);

    $postUserName = preg_match("/^([a-z]|[A-Z]|\s)+$/", $postUserName) ? strtolower($postUserName) : null;
    $postUserPhone = preg_match("/^\(\d{2}\)\s\d{4,5}\-\d{4}$/", $postUserPhone) ? $postUserPhone : null;
    $postUserObservation = preg_match("/^[^\'\"\=\<\>\(\)]+$/", $postUserObservation) ? $postUserObservation : null;    

    $redirectUser = false; // Will receive true when it is necessary to redirect the user
    $queryError = false; // Will receive true when some query is not success.

    // Check if the contact exists
    // Returns: [$exists = boolean, $data = null/array];
    function checkContact($userID) {
        global $sqlConn;

        $queryGetContact = $sqlConn->prepare("SELECT * FROM contato WHERE id = :id");
        $queryGetContact->bindParam(":id", $userID, PDO::PARAM_INT);
        $resultGetContact = $queryGetContact->execute();

        $exists = $resultGetContact && $queryGetContact->rowCount() == 1;
        $data = null;

        if ($exists) {
            $data = $queryGetContact->fetch(PDO::FETCH_ASSOC);
        }

        return ["exists" => $exists, "data" => $data];
    }

    // Case 1: When the user makes no changes || first visit to the page
    if ($ID !== null && $ID !== "" && !$postUserName && !$postUserPhone && !$postUserObservation) {
        $contactInfo = checkContact($ID);
        $_SESSION["latestID"] = $ID; // Will be used in case 2

        if ($contactInfo["exists"]) {            
            // from edit.php = $userName, $userPhone, $userObservation
            if (count($contactInfo)) {
                $userName = $contactInfo["data"]["userName"];
                $userPhone = $contactInfo["data"]["userPhone"];
                $userObservation = $contactInfo["data"]["observation"];
            } else {
                $queryError = true;
                $redirectUser = true;
            }
        } else {
            // If the contact does not exists
            $queryError = true;
            $redirectUser = true;
        }
    }

    // Case 2: When the user makes any changes.
    if ($postUserName || $postUserObservation || $postUserPhone) {
        // check if the contact exists
        $contactInfo = checkContact($_SESSION["latestID"]);

        if ($contactInfo["exists"]) {
            $queryUpdateContact = $sqlConn->prepare("UPDATE contato SET userName = :userName, userPhone = :userPhone, observation = :observation WHERE id = :id LIMIT 1");

            $queryUpdateContact->bindParam(":userName", $postUserName, PDO::PARAM_STR);
            $queryUpdateContact->bindParam(":userPhone", $postUserPhone, PDO::PARAM_STR);
            $queryUpdateContact->bindParam(":observation", $postUserObservation, PDO::PARAM_STR);
            $queryUpdateContact->bindParam(":id", $_SESSION["latestID"], PDO::PARAM_INT);

            $resultUpdateContact = $queryUpdateContact->execute();

            // If the query was successful
            if ($resultUpdateContact) {
                $_SESSION["notification"] = [
                    "ok" => true,
                    "title" => "Contato alterado",
                    "subtitle" => "Foram alterado os seguites dados.",
                    "url" => BASE_URL . "/undo.php?action=create",
                    "contact" => null,
                    "undo" => false
                ];
            } else {
                $queryError = true;
            }
        } else {
            // If the contact does not exist
            $queryError = true;
        }

        $redirectUser = true;
    }

    if ($queryError) {
        $_SESSION["notification"] = [
            "ok" => false
        ];
    }

    if ($redirectUser) {
        redirect("/index.php");
    }
?>