<!DOCTYPE html>

<html>

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

</head>

<body>

<!-- Button pour appeller la modal #newsletterModal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsletterModal">S'inscrire dans l'Auto-Alert</button>

<!-- Modal #newsletterModal -->
<div class="modal fade" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Auto-Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Inscription dans l'Auto-Alert :
                    <input type="email" class="form-control" name="email-auto-alert" placeholder="Email" required="required" />
                </div>
                <div class="form-group">
                    Vous recevrez automatiquement un email si un service est défaillant ou si il y a un incident.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>

<!-- Script PHP -->
<?php

    // Vérifie si 'email-auto-alert' contient un email
    if(isset($_POST['email-auto-alert']) && !empty($_POST['email-auto-alert'])){
        $email_auto_alert = htmlentities($_POST['email-auto-alert']);
        // Vérifie si la chaine ressemble à un email
        if(filter_var($email_auto_alert, FILTER_VALIDATE_EMAIL)) {
            // Sépare l'email en 2 parties
            list($user_auto_alert, $domaine_auto_alert) = explode('@', $email_auto_alert);
            // Initialisation de CURL
            $curl_auto_alert = curl_init();
            // On choisi l'url à atteindre,
            // le domaine est ajouté à la fin de l'adresse
            curl_setopt($curl_auto_alert, CURLOPT_URL, 'https://www.validator.pizza/domain/' . $domaine_auto_alert);
            // On souhaite stocker la réponse
            curl_setopt($curl_auto_alert, CURLOPT_RETURNTRANSFER, 1);
            // On désactive la vérification du certificat pour éviter certaines erreurs
            curl_setopt($curl_auto_alert, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl_auto_alert, CURLOPT_SSL_VERIFYPEER, 0);
            // On exécute la requête et on stock la réponse.
            $reponse_auto_alert = curl_exec($curl_auto_alert);
            // On ferme la requête CURL
            curl_close($curl_auto_alert);
            // On decode la réponse
            $reponse_auto_alert = json_decode($reponse_auto_alert);
            // On vérifie si la requête a fonctionnée
            if($reponse_auto_alert->status==200){
                if($reponse_auto_alert->disposable === true){
                    echo "Veuillez rentrer une email non jetable.";
                }else{
                    $pdo_auto_alert = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root');
                    $check_auto_alert = $pdo_auto_alert->query('SELECT * FROM auto_alert');
                    while ($email_auto_alert = $check_auto_alert->fetch()){
                        echo "L'email est déjà utilisé.";
                        $check_auto_alert->closeCursor();
                        exit;
                    }
                    $insert_auto_alert = $pdo_auto_alert->prepare();
                    $insert_auto_alert->execute(array($_POST['email-auto-alert']));
                    $insert_auto_alert->closeCursor();
                    echo "Votre email à bien était enregistré.";
                }
            } else {
                echo "La vérification de l'email à échoué.";
            }
        } else {
            echo "Cette adresse email est invalide.";
        }
    } else {
        echo "Aucun email est renseigné.";
    }

?>

</html>