<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

return [

  "global" => [

    "errors" => [
      "input-fields"  => "<strong>Error :</strong> Please fill all form fields.",
      "error-occured" => "An error has occured",
    ],

    "copyrights-nolink" => "Powered by SystemStatus",
    "maj-name"          => "Name",
    "maj-next"          => "Next",
    "maj-password"      => "Password",
    "maj-tutorial"      => "Tutorial",
    "maj-close"         => "Fermer",
    "maj-admin-panel"   => "Panel d'administration",

  ],

  "controllers" => [

    "install" => [
      "error-writing-config-file"      => "<strong>Error :</strong> An error has occured when writing in the config file.",
      "error-check-example-app-exists" => "<strong>Error :</strong> Please check that the file <code>config/app.example.php</code> does exist",
      "error-preg-match-user-create"   => "<strong>Error :</strong> Special characters aren't permitted. Pay attention to the minimum length required too.",
    ],

    "users" => [
      "success-created" => "The account has been created !",
      "limits-reached"  => "Your licence limits have been reached, please upgrade your licence in order to create more users.",
      "already-exists"  => "This username has already been taken.",
    ],

  ],

  "install" => [

    "head-html" => [

      "title"       => "SystemStatus | Installation",
      "description" => "This website has been powered by SystemStatus",

    ],

    "install_assistant"      => "Installation wizard",
    "home-page-welcome"      => "Hi and welcome to the SystemStatus installation wizard.<br> Please follow the following steps in order to initialize your website.",
    "cms-url"                => "SystemStatus URL",
    "cms-url-placeholder"    => "Please enter an URL",
    "cms-config"             => "CMS configuration ",
    "cms-name-placeholder"   => "Please enter your website name",
    "user-making"            => "Administrator account",
    "credentials"            => "Credentials",
    "username-chat-limit"    => "Username (3-16)",
    "username-placeholder"   => "Please enter your username",
    "password-placeholder"   => "Please enter your password",
    "finish-page-h4"         => "Before you start configuring your services thanks to te <strong>administrator panel</strong>, focus your attention on understanding how does SystemStatus work.",
    "finish-page-blockquote" => "Each infrastructure you old are identified as a <i>group</i> (or <i>category</i>). All the <i>service</i>, as we call them, are listed within this <i>group</i> for each of which a <i>status</i> like <span class=\"text-success status_dot\">Operational</span>, <span class=\"text-warning status_dot\">Partial failure</span>, <span class=\"text-danger status_dot\">Defective</span> or <span class=\"text-info status_dot\">Maintenance</span> is mentioned in order to enquire yoru customers about these <i>services</i> availability.<br> Also, you can create <strong>incident reports</strong> in order to detail the failure.",
    "finish-page-panel"      => "Here is how your customers will view your services<br> <i class=\"hidden-xs\">Hover to hide the indications</i>", "finish-page-div1" => "<div class=\"panel-heading\"> My category 1&nbsp;&nbsp;&nbsp; <span class=\"text-info tutorial hidden-xs\"> <i class=\"fa fa-question-circle\"></i>&nbsp;Services group. It allows your infrastructures to be organized. </span> <span class=\"pull-right text-danger status_dot\"> <span class=\"text-info tutorial hidden-xs\">Group global status&nbsp; <i class=\"fa fa-question-circle\"></i> </span> &nbsp;&nbsp;&nbsp;<i class=\"fa fa-circle text-warning pull-right\" style=\"margin-top: 5px;\"></i> </span> </div> <div class=\"panel-body\"> Mail server&nbsp;&nbsp;&nbsp; <span class=\"text-info tutorial hidden-xs\"> <i class=\"fa fa-question-circle\"></i>&nbsp;Service name. The services are defined within your administrator panel. </span> <small class=\"pull-right text-success status_dot\">Operational</small> </div> <div class=\"panel-body\"> Infrastructure <span class=\"pull-right text-danger status_dot\"> <span class=\"text-info tutorial hidden-xs\">Statut du service. Définit via le panel ou automatiquement grâce à des plugins&nbsp; <i class=\"fa fa-question-circle\"></i></span><small>&nbsp;&nbsp;&nbsp;Defective</small> </span> </div>",
    "understand"             => "I understand",
  ],

  "admin" => [

    "head-html" => [

      "",

    ],

    //"" => "",

  ],

  "public" => [

    "logged_as"              => "Logged as",
    "go-back-to-admin-panel" => "Go back to the admin panel",
    "some-services-not-op"   => "There is some dysfunctional services",
    "all-services-op"        => "All services are operational",
    "go-to-panel-to-manage"  => "Go now to your admin panel to configure your CMS !",
  ],

  "accidents" => [

    "viewing-report"           => "Report viewing",
    "accident-report"          => "Incident report",
    "accident-status"          => "Incident status",
    "accident-making"          => "Incident making",
    "made"                     => "Made",
    "by"                       => "by",
    "related-service"          => "Related service",
    "in-the-category"          => "in",
    "latest-update"            => "Latest update",
    "has-answered"             => "has answered to the incident",
    "posted"                   => "Posted",
    "has-made-accident-report" => "has created the incident report",
    "manage-accident"          => "Manage the incident",
    "last-7-days-accidents"    => "Incidents in the 7 last days",
    "accident-made"            => "Incident has been created",

  ],

];

?>