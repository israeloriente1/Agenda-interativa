<?php 
    require_once "./templates/header.php"; 
    require_once "./crud/createContact.php";
    
?>

    <main class="container">
        <a href='./index.php'>
            <button type='button' class='btn btn-outline-primary btn-sm mb-4'>Voltar</button>
        </a>

        <img src="./img/user.svg" alt="user icon" class="main-icon mt-custom">
        <h3 class="text-center mt-3">Adicionar contato</h3>
        <p class="text-center">Por favor, preencha os seguintes dados no formulário.</p>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="mb-3">
                <label for="userName" class="form-label">Nome</label>
                <input type="text" class="form-control" name="userName" id="userName" maxlength="50" required>
            </div>

            <div class="mb-3">
                <label for="userPhone" class="form-label">Telefone</label>
                <input type="tel" class="form-control" name="userPhone" id="userPhone" maxlength="15" placeholder="(00) 00000-0000" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" required>
            </div>

            <div class="mb-3">
                <label for="userObservation" class="form-label">Observação</label>
                <textarea class="form-control" id="userObservation" name="userObservation" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <input type="submit" value="Cadastrar" class='btn btn-primary btn-sm mt-4 px-4 mb-4 d-block m-auto'>
            </div>
        </form>
    </main>

    <script src="./js/autoCorrectPhone.js"></script>

<?php require_once "./templates/footer.php"; ?>