<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

return [

  "global" => [

    "errors" => [
      "input-fields"  => "<strong>Attention :</strong> Veuillez remplir tout les champs du formulaire.",
      "error-occured" => "Une erreur est survenue",
    ],

    "copyrights-nolink" => "Propulsé par SystemStatus",
    "maj-name"          => "Nom",
    "maj-next"          => "Suivant",
    "maj-password"      => "Mot de passe",
    "maj-tutorial"      => "Tutoriel",
    "maj-close"         => "Fermer",
    "maj-admin-panel"   => "Panel d'administration",
    "maj-monitoring"    => "Monitoring",
    "maj-admin" => "Admin",
  ],

  "controllers" => [

    "install" => [
      "error-writing-config-file"      => "<strong>Erreur :</strong> pendant la modification du fichier de configuration.",
      "error-check-example-app-exists" => "<strong>Attention :</strong> Veuillez vérifier que le fichier <code>config/app.example.php</code> existe.",
      "error-preg-match-user-create"   => "<strong>Attention :</strong> Les caractères spéciaux sont interdits ou la longueur requise n'est pas respectée !",
    ],

    "users" => [
      "success-created" => "Le compte a été ajouté avec succès !",
      "limits-reached"  => "Votre licence a atteint la limite d'utilisateurs, veuillez mettre à niveau votre licence pour en créer davantage.",
      "already-exists"  => "Un utilisateur avec cet identifiant existe déjà.",
    ],

    "services" => [
      "operational"     => "Opérationnel",
      "partial-failure" => "Panne partielle",
      "defective"       => "Défaillant",
      "maintenance"     => "Maintenance",
      "already-exists"  => "Le service existe déjà dans la catégorie sélectionnée !",
    ],

    "admin" => [
      "resolved"    => "Résolu",
      "in-progress" => "En cours",
    ],

    "auth" => [
      "successful" => "<strong>Succès :</strong> vous êtes maintenant connecté !",
      "error" => "<strong>Attention : </strong> Veuillez vérifier votre mot de passe !",
    ]

  ],

  "install" => [

    "head-html" => [

      "title"       => "SystemStatus | Installation",
      "description" => "Ce site est propulsé par le CMS SystemStatus",

    ],

    "install_assistant"      => "Assistant d'installation",
    "home-page-welcome"      => "Bonjour, bienvenue dans l'assistant d'installation de SystemStatus.<br> Veuillez suivre les étapes décrites dans ce script d'installation afin de pouvoir utiliser votre système.",
    "cms-url"                => "URL du cms",
    "cms-url-placeholder"    => "Veuillez saisir l'url du cms",
    "cms-config"             => "Configuration du CMS",
    "cms-name-placeholder"   => "Veuillez saisir le nom du cms",
    "user-making"            => "Création du compte administrateur",
    "credentials"            => "Identifiants de connexion",
    "username-chat-limit"    => "Nom d'utilisateur (3-16)",
    "username-placeholder"   => "Veuillez saisir l'utilisateur de connexion",
    "password-placeholder"   => "Veuillez saisir le mot de passe de connexion",
    "finish-page-h4"         => "Avant de vous lancer dans la configuration de vos services via votre <strong>panel d'administration</strong>, prenez le temps de bien comprendre comment fonctionne SystemStatus.",
    "finish-page-blockquote" => "Chaque infrastructure que vous controlez doit être identifiée comme un <i>groupe</i> (également appelé <i>catégorie</i>). Dans ce <i>groupe</i> seront listés tout les <i>services</i>, comme nous les appelons, pour chacun desquels un <i>statut</i> tel que <span class=\"text-success status_dot\">Opérationnel</span>, <span class=\"text-warning status_dot\">Panne partielle</span>, <span class=\"text-danger status_dot\">Défaillant</span> ou encore <span class=\"text-info status_dot\">Maintenance</span> sera mentionné afin de renseigner vos clients sur la disponibilité de ces-dits <i>services</i>.<br> Il vous est également possible de créer des <strong>rapports d'incident</strong> afin d'apporter une touche d'information supplémentaire à vos clients/visiteurs concernant le dysfonctionement de vos services.",
    "finish-page-panel"      => "Voici comment vos visiteurs visualiseront le statut de vos services<br> <i class=\"hidden-xs\">Survolez la zone afin de cacher les indications</i>", "finish-page-div1" => "<div class=\"panel-heading\"> Ma catégorie 1&nbsp;&nbsp;&nbsp; <span class=\"text-info tutorial hidden-xs\"> <i class=\"fa fa-question-circle\"></i>&nbsp;Groupe de services. Permet de rassembler vos différentes infrastructures. </span> <span class=\"pull-right text-danger status_dot\"> <span class=\"text-info tutorial hidden-xs\">Statut global du groupe de services&nbsp; <i class=\"fa fa-question-circle\"></i> </span> &nbsp;&nbsp;&nbsp;<i class=\"fa fa-circle text-warning pull-right\" style=\"margin-top: 5px;\"></i> </span> </div> <div class=\"panel-body\"> Serveur Mail&nbsp;&nbsp;&nbsp; <span class=\"text-info tutorial hidden-xs\"> <i class=\"fa fa-question-circle\"></i>&nbsp;Nom du service. Les services sont définis via votre panel d'administration. </span> <small class=\"pull-right text-success status_dot\">Opérationnel</small> </div> <div class=\"panel-body\"> Infrastructure <span class=\"pull-right text-danger status_dot\"> <span class=\"text-info tutorial hidden-xs\">Statut du service. Définit via le panel ou automatiquement grâce à des plugins&nbsp; <i class=\"fa fa-question-circle\"></i></span><small>&nbsp;&nbsp;&nbsp;Défaillant</small> </span> </div>",
    "understand"             => "J'ai compris",
  ],

  "admin" => [

    "login" => [

      "connection"                => "Connexion",
      "go-back-to-public-section" => "Retourner au site",
      "sign-in"                   => "Se connecter",

    ],

    "side-bar" => [

      "info-license" => "Information de licence",
      "maj-license" => "Licence",
      "kind-license" => "Type de license",
      "assigned-ip" => "IP assignée",
      "assigned-host" => "Hôte assignée",
      "account-manager" => "Gestionnaire de licence",
      "go-back-to-public-site" => "Retourner sur le site public",

      "maj-home" => "Accueil",
      "maj-users" => "Utilisateurs",
      "maj-infra" => "Infrastructures",
      "maj-monitoring" => "Monitoring",
      "maj-themes" => "Thèmes",
      "maj-config" => "Paramètres",
      "maj-news" => "Actualité",

      "about-license" => "A propos de ma licence",
      "info-license-basic" => "Vous possédez une licence de type \"Basic\" ce qui impose une limitation concernant le nombre possible de catégories, services etc... Plus d'infos sur notre",
      "website" => "site internet",

    ],

    "placeholder" => [

      "title-incident" => "Titre de l'incident",
      "report-incident" => "Rapport de l'incident",
      "maj-cancel" => "Annuler",

    ],

  ],

  "public" => [

    "logged_as"              => "Connecté en temps que",
    "go-back-to-admin-panel" => "Retourner à l'administration",
    "some-services-not-op"   => "Certains services ne sont pas opérationnels",
    "all-services-op"        => "Tout les services sont opérationnels",
    "go-to-panel-to-manage"  => "Rendez-vous dès à présent sur votre panel afin de gérer vos catégories et services !",
  ],

  "accidents" => [

    "viewing-report"           => "Consultation du rapport",
    "accident-report"          => "Rapport d'incident",
    "accident-status"          => "Statut de l'incident",
    "accident-making"          => "Création de l'incident",
    "made"                     => "Créé",
    "by"                       => "par",
    "related-service"          => "Service lié",
    "in-the-category"          => "dans la catégorie",
    "latest-update"            => "Dernière mise à jour",
    "has-answered"             => "a répondu à l'incident",
    "posted"                   => "Posté",
    "has-made-accident-report" => "a créé le rapport d'incident",
    "manage-accident"          => "Gérer l'incident",
    "last-7-days-accidents"    => "Incidents résolus ces 7 derniers jours",
    "accident-made"            => "Incident créé",

  ],

];

?>