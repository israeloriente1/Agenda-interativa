<?php 
  require_once "./templates/header.php";
  require_once "./templates/notification.php";
  // From notification.php = $notification
?>


<?php 
    require_once "./crud/readAllContacts.php";
    // From realAllUsers.php = $contacts 

    if (count($contacts)) {
        // Table with all users
        require_once "./templates/contactsTable.php";
    } else {
        print "
        <div class='container'>
            <img src='./img/archive.svg' alt='archive icon' class='main-icon'>
            <h3 class='text-center mt-3'>Nenhum contato cadastrado</h3>
            <p class='text-center mb-4'>Não foi encontrado nenhum contato em nosso banco de dados.</p>
            <a href='./create.php'><button type='button' class='btn btn-primary px-3 d-block mx-auto'>Adicionar contato</button></a>
        </div>
        ";
    }
?>
<?php require_once "./templates/footer.php";?>