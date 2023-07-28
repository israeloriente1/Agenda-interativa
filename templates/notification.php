<?php 
    session_start();
    $notification = null;

    // The variable $notification will receive an array when some (delete/create/update) happens.

    if (isset($_SESSION["notification"]) && $_SESSION["notification"] !== null) {
        $notification = $_SESSION["notification"];
        
        $_SESSION["lastNotification"] = $_SESSION["notification"];
        $_SESSION["notification"] = null;

        // modal main button
        print "
        <button type='button' id='notificationButton' class='btn btn-primary d-none' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>
        Launch static backdrop modal
        </button>";

        // script to set the modal to visible
        print "
        <script>
            setTimeout(() => {
                ntButton = document.getElementById('notificationButton');
                ntButton.click();
            }, 10);
        </script>";

        // If any (delete/create/update) happened
        if ($notification["ok"]) { 
            
            $contactData = null;
            $buttonUndo = null;

            // if the notification contains data
            if ($notification["contact"]) {
                $contactData = "
                    <div class='modal-body'>
                        <p class='fw-medium'>Os seguintes dados foram apagados.</p>
                        <p class='mb-1'><span class='fw-medium'>Nome</span>: ". ucwords($notification["contact"]["userName"]) ."</p>
                        <p class='mb-1'><span class='fw-medium'>Telefone</span>: ". $notification["contact"]["userPhone"] ."</p>
                        <p class='mb-1'><span class='fw-medium'>Observação</span>: ". $notification["contact"]["observation"] ."</p>
                    </div>";
            }

            // if the notification contains an undo button
            if ($notification["undo"]) {
                $buttonUndo = "
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                        <a href='". $notification["url"] ."'><button type='button' class='btn btn-primary'>Desfazer</button></a>
                    </div>";
            }

            // modal notification
            print "
                <div class='modal fade' id='staticBackdrop' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='false'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='staticBackdropLabel'>". $notification["title"] ."</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            ". $contactData ."
                            ". $buttonUndo ."
                        </div>
                    </div>
                </div>";
        } else {
            // if notification["ok"] is not true.
            print "
                <div class='modal fade' id='staticBackdrop' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='false'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='staticBackdropLabel'>Ação não realizada</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <p class='fw-medium'>Não foi possível realizar a seguinte ação, por favor tente novamente mais tarde ou entre em contato conosco.</p>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>";
        }
    }
?>