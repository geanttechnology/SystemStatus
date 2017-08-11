<?php if(!Api::isBanned()){header('Location: '.APP_URL.'/');}?>
<!DOCTYPE html>
<html>
<head>
    <title><?=APP_NAME?> | Bannie</title>
</head>
<body>
<style>
    body { text-align: center; padding: 150px; }
    h1 { font-size: 50px; }
    body { font: 20px Helvetica, sans-serif; color: #333; }
    article { display: block; text-align: left; width: 650px; margin: 0 auto; }
    a { color: #dc8100; text-decoration: none; }
    a:hover { color: #333; text-decoration: none; }
</style>

<article>
    <h1>Oops!</h1>
    <div>
        <p>
            Votre licence a été bannie du système central.<br>
            Cliquez <a href="https://forum.systemstatus.fr/viewtopic.php?f=4&t=3">ici</a> pour lire nos CGU.<br><br>
            S'il s'agit d'une erreur, veuillez prendre contact avec nous dès maintenant en <a href="mailto:contact@systemstatus.fr">cliquant ici</a>
        </p>

        <p>&mdash; L'equipe de SystemStatus</p>
    </div>
</article>
</body>
</html>
