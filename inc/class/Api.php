<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class Api
{

  /* //////////////:============================://////////////////////
   *                        Storage API
   */
  public static function getCategories()
  {
    $api = new API();

    return $api->callStorage([
      'request' => 'getCategories',
    ]);
  }
  /*
  * //////////////:============================:////////////////////// */

  //Categories

  public function callStorage($request)
  {

    $api_url = "https://api.systemstatus.fr/v3/";
    $auth = "?licence=" . CMS_LICENCE . "&api_key=" . CMS_API;
    $filteredRequest = "";

    foreach ($request as $key => $value) {

      if (is_array($request[ $key ])) {

        foreach ($request[ $key ] as $key2 => $value2) {
          $filteredRequest .= "&" . $key2 . "=" . urlencode($value2);
        }

      } else {
        $filteredRequest .= "&" . $key . "=" . urlencode($value);
      }

    }

    $url = $api_url . $auth . $filteredRequest;

    //  Initiate curl
    $ch = curl_init();
    // Disable SSL verification (because it's loaded over SSL by default)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    // Set the url
    curl_setopt($ch, CURLOPT_URL, $url);
    // Execute
    $result = curl_exec($ch);
    // Closing
    curl_close($ch);

    return $result;


  }

  public static function addCategory($category_name)
  {
    $api = new API();

    return $api->callStorage([
      'request'       => 'addCategory',
      'category_name' => $category_name,
    ]);
  }

  public static function deleteCategory($category_id)
  {
    $api = new API();

    return $api->callStorage([
      'request'     => 'deleteCategory',
      'category_id' => intval($category_id),
    ]);
  }

  public static function deleteAllCategory($category_id)
  {
    $api = new API();

    return $api->callStorage([
      'request'     => 'deleteAllCategory',
      'category_id' => intval($category_id),
    ]);
  }

  //Services
  public static function getServices()
  {
    $api = new API();

    return $api->callStorage([
      'request' => 'getServices',
    ]);

  }

  public static function addService($service_name, $category_id, $service_status)
  {
    $api = new API();

    return $api->callStorage([
      'request'        => 'addService',
      'service_name'   => $service_name,
      'category_id'    => $category_id,
      'service_status' => $service_status,
    ]);
  }

  public static function deleteService($service_id)
  {
    $api = new API();

    return $api->callStorage([
      'request'    => 'deleteService',
      'service_id' => intval($service_id),
    ]);

  }

  public static function detachServices($category_id)
  {
    $api = new API();

    return $api->callStorage([
      'request'     => 'detachServices',
      'category_id' => intval($category_id),
    ]);
  }

  public static function assignService($service_id, $category_id)
  {
    $api = new API();

    return $api->callStorage([
      'request'     => 'assignService',
      'service_id'  => intval($service_id),
      'category_id' => intval($category_id),
    ]);
  }

  public static function updateService($new_status, $service_id)
  {
    $status = intval($new_status);
    $service = intval($service_id);

    $api = new API();

    return $api->callStorage([
      'request'    => 'updateService',
      'service_id' => intval($service),
      'new_status' => intval($status),
    ]);
  }

  //Accidents
  public static function addAccident($title, $content, $serviceID, $serviceStatus, $author_id)
  {
    $title = htmlspecialchars($title);
    $content = htmlspecialchars($content);
    $serviceID = intval($serviceID);
    $serviceStatus = intval($serviceStatus);
    $author_id = intval($author_id);

    $api = new API();

    return $api->callStorage([
      'request'       => 'addAccident',
      'title'         => $title,
      'content'       => $content,
      'serviceID'     => $serviceID,
      'serviceStatus' => $serviceStatus,
      'author_id'     => $author_id,
    ]);

  }

  public static function getAccident($accident_serial_id)
  {
    $accident_serial_id = htmlspecialchars($accident_serial_id);

    $api = new API();

    return $api->callStorage([
      'request'            => 'getAccident',
      'accident_serial_id' => $accident_serial_id,
    ]);

  }

  public static function closeAccident($accident_serial_id, $author_id)
  {
    $accident_serial_id = htmlspecialchars($accident_serial_id);

    $api = new API();

    return $api->callStorage([
      'request'            => 'closeAccident',
      'accident_serial_id' => $accident_serial_id,
      'author_id'          => $author_id,
    ]);

  }

  public static function updateAccident($accident_serial_id, $content, $newStatus, $author_id)
  {
    $api = new API();

    return $api->callStorage([
      'request'            => 'updateAccident',
      'accident_serial_id' => htmlspecialchars($accident_serial_id),
      'content'            => $content,
      'newStatus'          => $newStatus,
      'author_id'          => $author_id,
    ]);
  }

  public static function deleteAccident($accident_serial_id)
  {
    $api = new API();

    return $api->callStorage([
      'request'            => 'deleteAccident',
      'accident_serial_id' => htmlspecialchars($accident_serial_id),
    ]);
  }

  public static function getAllAccidents()
  {
    $api = new API();

    return $api->callStorage([
      'request' => 'getAllAccidents',
    ]);
  }

  //Users
  public static function getUsers()
  {

    $api = new API();

    return $api->callStorage([
      'request' => 'getUsers',
    ]);

  }

  public static function authUser($username, $password)
  {

    $api = new API();

    return $api->callStorage([
      'request'  => 'authUser',
      'username' => $username,
      'password' => $password,
    ]);

  }

  public static function addUser($username, $password, $rank)
  {

    $api = new API();

    return $api->callStorage([
      'request'  => 'addUser',
      'username' => $username,
      'password' => $password,
      'rank'     => $rank,
    ]);

  }

  public static function updateUser($userID, $postData)
  {

    $api = new API();

    $userID = intval($userID);
    $username = $postData["username"];
    $rank = $postData["rank"];
    $password = $postData["password"];

    return $api->callStorage([
      'request'  => 'updateUser',
      'userID'   => $userID,
      'username' => $username,
      'rank'     => $rank,
      'password' => $password,
    ]);

  }

  public static function deleteUser($userID)
  {

    $api = new API();

    return $api->callStorage([
      'request' => 'deleteUser',
      'userID'  => $userID,
    ]);

  }

  //Monitorings
  public static function getMonitorings()
  {
    $api = new API();

    return $api->callStorage([
      'request' => 'getMonitorings',
    ]);
  }

  public static function createMonitoring($target, $serviceID)
  {
    $api = new API();

    return $api->callStorage([
      'request'   => 'addMonitoring',
      'target'    => $target,
      'serviceID' => $serviceID,
    ]);
  }

  public static function updateTargetStatus($serviceID, $status)
  {
    $api = new API();

    return $api->callStorage([
      'request'   => 'updateTargetStatus',
      'serviceID' => $serviceID,
      'status'    => $status,
    ]);
  }

  public static function deleteMonitoring($monitoringID)
  {
    $api = new API();

    return $api->callStorage([
      'request'      => 'deleteMonitoring',
      'monitoringID' => $monitoringID,
    ]);
  }


  //Others
  public static function updateStats()
  {
    $api = new API();

    return json_decode($api->callStorage([
      'request'  => 'updateStats',
      'version'  => CMS_VERSION,
      'language' => 'FR',
      'theme'    => THEME_NAME,
    ]));
  }

  public static function getGlobalNews()
  {
    $api = new API();

    return json_decode($api->callStorage([
      'request' => 'getGlobalNews',
    ]));
  }

  /* //////////////:============================://////////////////////
   *                  [END] Storage API [END] love cookies <3
   * //////////////:============================:////////////////////// */

  public static function generateToken($lenght)
  {
    $api = new API();

    return $api->request([
      'action' => 'generateToken',
      'lenght' => $lenght,
    ]);
  }

  public function request($params)
  {

    $postData = '';
    foreach ($params as $k => $v) {
      $postData .= $k . '=' . $v . '&';
    }
    $postData = rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, API_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $output = curl_exec($ch);
    $info = curl_getinfo($ch);

    $data = json_decode($output);
    curl_close($ch);

    if (!empty($data) && $data->status == "success" || $info['http_code'] == 200) {
      return $output;
    } else if ($data->status == "error" || $info['http_code'] != 200) {
      switch ($data->reason->name) {
        case 'Empty arguments':
          return 'Veuillez vérifier les paramètres de votre requete !';
          break;

        case 'Not found':
          return 'Objet introuvable !';
          break;

        case 'Invalid Token':
          return 'Veuillez vérifier votre token !';
          break;

        case 'Banned Licence':
          return 'Votre licence a été bannie du système centrale, veuillez lire nos CGU pour comprendre la raison de votre bannisement !';
          break;

        case 'Invalid API':
          return 'Veuillez vérifier votre clé d\'api !';
          break;

        case 'Invalid Licence':
          return 'Veuillez vérifier votre clé de licence !';
          break;

        case 'API & Licence not corresponding':
          return 'Vos clés d\'api et de licence ne correspondent pas !';
          break;

        case 'Method Not Allowed':
          return 'La méthode que vous utiliser n\'est pas autorisée !';
          break;

        case 'Invalid Action':
          return 'Cette action n\'existe pas !';
          break;

        default:
          return 'Erreur inconnue';
          break;
      }
    } else {
      return "ERROR";
    }
  }

  public static function getUpdateScript()
  {
    $api = new API();
    $data = json_decode($api->request([
      'action' => 'getUpdateScript',
    ]));

    return $data->file;
  }

  public static function getDate($date)
  {
    if(CMS_LANGUAGE == "fr") {

      $api = new API();
      $date = $api->request([
        'action' => 'getDate',
        'date'   => $date,
      ]);

    }else{
      return date('m/d/Y H:i', $date);
    }


    return $date;
  }

  public static function serialID()
  {
    $api = new Api();
    $return = json_decode($api->request([
      'action' => 'serialID',
    ]));

    return $return->result;
  }

  public static function crontabDelete($id)
  {
    $api = new Api();

    return json_decode($api->request([
      'action' => 'deleteCrontab',
      'ID'     => $id,
      'token'  => CMS_LICENCE . '-' . CMS_API,
    ]));
  }

  public static function createLicence()
  {
    $api = new API();

    return json_decode($api->request([
      'action' => 'createLicence',
      'source' => APP_URL,
    ]));
  }

  public static function getLicenceInfos()
  {
    $api = new API();

    return json_decode($api->request([
      'action'  => 'getLicenceInfos',
      'token'   => CMS_LICENCE . '-' . CMS_API,
      'licence' => CMS_LICENCE,
    ]));
  }

  public static function pingCrontab()
  {
    $api = new API();

    return json_decode($api->request([
      'action'  => 'pingCrontab',
      'token'   => CMS_LICENCE . '-' . CMS_API,
      'licence' => CMS_LICENCE,
    ]));
  }

  public static function isBanned()
  {
    if (App::isInstalled()) {
      $api = new API();
      $infos = json_decode($api->request([
        'action'  => 'getLicenceInfos',
        'token'   => CMS_LICENCE . '-' . CMS_API,
        'licence' => CMS_LICENCE,
      ]));
      if ($infos->status == 1)
        return FALSE;
      else
        return TRUE;
    } else {
      return FALSE;
    }
  }
}
