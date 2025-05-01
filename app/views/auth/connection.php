<!DOCTYPE html>
<html lang="fr">
<?php
$url="http://".$_SERVER["HTTP_HOST"];
?>    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url."/assets/css/login.css" ?>">
    <title>Document</title>
</head>
<body>
    <div class="container">

        <div class="entSonatel">
        <img src="<?= $url."/assets/images/logo_odc.png"?>" alt="logo sonatel">
        </div>
    
        <div class="mBienvenue">
            <h5>Bienvenue sur</h5>
            <h5 class="ECSA">Ecole du code Sonatel Academy</h5>
        </div>
        <div class="seConnecter">Se Connecter</div>
    
            <form action="" method="post">
                <div class="login">
                    <label for="login">Login</label>
                    <input type="text" id="login" name="login" placeholder="matricule ou email">
                </div>
                <div class="mdp">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="mot de passe">
                </div>
                <div class="mdpOublie">
                    <a href="#">Mot de passe oublié ?</a>
                </div>
                <div class="bc">
                    <input class="btnSeConnecter" type="submit" value="Se connecter">
                </div>
            </form>

    </div>
</body>
</html>


dans mes input utilise des message pour dire que le champ est obligatoire aulieu des required  ; dans chaque fichier ranger les fonctions dans un tableau et les cles des fonction annonyme de meme les chemain(url) son des enumeration (enum){│── /app

│   ├── /controllers ⇒contient les fichiers qui traites les requêtes HTTP(request,response).

                   ├── controller.php ⇒factorise les fonction communes aux controllers

                   ├── error.controller.php

│   ├── /models⇒.

                   ├── model.php ⇒contient les fonctions qui interagissent avec le fichiers Json

       ├── /route

                   ├ route.web.php ⇒ contient la fonction de chargement d’un controller

     ├── /services ⇒.

                   ├── session.service.php

                   ├── validator.service.php

     ├── /enums ⇒. };integer mes maquet que je vais vous partager