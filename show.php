<?php 
    require_once "./templates/header.php"; 
    require_once "./helpers/connection.php";
    // From connection.php = $sqlConn
    require_once "./helpers/redirect.php";
    // From redirect.php = redirect()
?>

<?php 
    $ID = $_GET["id"] ?? null;
    $ID = preg_match("/^[0-9]*$/", intval($ID)) ? intval($ID) : null;

    if ($ID &&  $ID !== "") {
        // Check if the contact exists
        $queryGetContact = $sqlConn->prepare("SELECT * FROM contato WHERE id = :id");
        $queryGetContact->bindParam(":id", $ID, PDO::PARAM_INT);
        $resultGetContact = $queryGetContact->execute();

        // if exists
        if ($resultGetContact && $queryGetContact->rowCount()) {
            $user = $queryGetContact->fetch(PDO::FETCH_ASSOC); 

            print "
            <div class='container'>
                <a href='./index.php'><button type='button' class='btn btn-outline-primary btn-sm mb-4'>Voltar</button></a>

                <div class='main-table-container d-block m-auto'>
                    <img src='./img/contact.svg' alt='contact icon' class='main-icon mt-custom'>
                    <h2 class='mb-3 text-center'>". ucwords($user["userName"]) ."</h2>
                    <p><strong>Telefone</strong>: ". $user["userPhone"] ."</p>
                    <p><strong>Observação</strong>: ". $user["observation"] ."</p>
                </div>
            </div>";
        } else {
            redirect("/index.php");
        }
    } else {
        redirect("/index.php");
    }
?>

<?php require_once "./templates/footer.php"; ?>