<?php 
    require_once "./helpers/redirect.php";
    // From redirect.php = redirect()

    $action = $_GET["action"] ?? null;
    $action = $action === "create" ? $action : null;

    switch ($action) {
        case "create":
            require_once "./crud/createContact.php";
        default:
            redirect("./index.php");
    }

    // close database
    require_once "./templates/footer.php";
?>