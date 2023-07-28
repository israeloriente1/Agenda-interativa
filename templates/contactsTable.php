<?php 
    require_once "./helpers/url.php";
    // From url.php = const BASE_URL
 ?>

<div class="container main-table-container">
    <table class="table table-striped caption-top">
        <img src="<?= BASE_URL ?>/img/list.svg" alt="list icon" class="main-icon">
        <caption class="text-center fs-3 fw-medium text-black">Lista de contatos</caption>

        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Número</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($contacts as $contact) {
                    print "
                        <tr>
                            <th scope='row'>". $contact["id"] ."</th>
                            <td>". ucwords($contact["userName"]) ."</td>
                            <td>". $contact["userPhone"] ."</td>
                            <td>
                                <a class='p-1' href='./show.php?id=". $contact["id"] ."'><img src='./img/eye.svg' alt='eye icon'></a>
                                <a class='p-1' href='./edit.php?id=". $contact["id"] ."'><img src='./img/edit.svg' alt='edit icon'></a>
                                <a class='p-1 pe-0' href='./delete.php?id=". $contact["id"] ."'><img src='./img/delete.svg' alt='delete icon'></a>
                                
                            </td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>