<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class Theme
{
  private $path;
  private $name;
  private $version;
  private $author;
  private $versions;
  private $config;
  private $error;
  private $files;

  public function __construct($name)
  {
    $this->load($name);

  }

  private function load($name)
  {
    $this->setPath(__DIR__ . '/../../themes/' . $name . '/');
    if(file_exists($this->getPath()) && is_dir($this->getPath())){
      $this->setConfig(require_once ($this->path . 'theme.php'));
      $this->setName($this->getConfig()['name']);
      $this->setAuthor($this->getConfig()['author']);
      $this->setVersion($this->getConfig()['version']);
      $this->setVersions($this->getConfig()['cms_versions']);

      $this->files['views'] = [
        'home' => 'views/admin/',
        'manageItems' => 'views/admin/',
        'monitoring' => 'views/admin/',
        'plugins' => 'views/admin/',
        'settings' => 'views/admin/',
        'themes' => 'views/admin/',
        'layout' => 'views/admin/',
        'footer' => 'views/admin/',
        'header' => 'views/admin/',
        'users' => 'views/admin/',
        'footer' => 'views/',
        'header' => 'views/',
        'home' => 'views/',
        'login' => 'views/'
      ];

      $this->files['style'] = [
        'admin' => 'css/',
        'home' => 'css/',
        'login' => 'css/'
      ];

      $this->files['javascript'] = [
        'login' => 'js/'
      ];

      $this->files['config'] = array(
        'theme'
      );
    }else{
      $this->addError('Folder ' . $this->getName() . ' not found !');
      exit(0);
    }
  }

  public static function loadCss($file)
  {
    return '<link rel="stylesheet" href="'.APP_URL.'/themes/'.THEME_NAME.'/css/'.$file.'.css">';
  }

  public static function loadJs($file)
  {
    return '<script type="text/javascript" src="'.APP_URL.'/themes/'.THEME_NAME.'/js/'.$file.'.js"></script>';
  }

  public static function loadView($file)
  {
    if(is_dir(__DIR__ . '/../../themes/' . THEME_NAME)) {
      include_once(__DIR__ . '/../../themes/' . THEME_NAME . '/views/' . $file . '.php');
    }else{
      include_once(__DIR__ . '/../../themes/default/views/' . $file . '.php');
    }
  }

  public function delete()
  {

    $tmp = include(__DIR__ . "/../../config/app.php");
    $root = $tmp['root'];
    $themePath = $root . '/themes/' . $this->getName();

    AdminController::deleteDir($themePath);

    echo Auth::alert('Le theme '.$this->getName().' a été supprimé du système de fichiers', 'success');
  }

  public static function selectAll()
  {
    $themes = null;
    foreach (scandir(__DIR__ . '/../../themes') as $folder) {
      if(is_dir(__DIR__ . '/../../themes/'.$folder) && file_exists(__DIR__ . '/../../themes/'.$folder.'/theme.php')){
        $theme = new Theme($folder);
        if($theme->isTheme())
          $themes[$theme->getName()]['name'] = $theme->getName();
        $themes[$theme->getName()]['author'] = $theme->getAuthor();
        $themes[$theme->getName()]['version'] = $theme->getVersion();
        $themes[$theme->getName()]['cms_version'] = $theme->getVersions();
        $themes[$theme->getName()]['path'] = $theme->getPath();
        $themes[$theme->getName()]['active'] = $theme->isActive();
        $themes[$theme->getName()]['compatible'] = $theme->isCompatible();
      }
    }
    return $themes;
  }

  public function isCompatible()
  {
    foreach($this->getVersions() as $versions => $versions_)
    {
      $max = count($versions_);
      $current = 0;

      foreach ($versions_ as $key => $value) {
        $current ++;

        if(CMS_VERSION == $value)
          return true;
        else
          if($current == $max)
            return false;

      }
    }
  }

  public function isActive()
  {
    if(THEME_NAME == $this->getName())
      return true;
    else
      return false;
  }

  public function isTheme()
  {
    if($this->getError() == null)
    {
      return true;
    }else{
      return false;
    }
  }

  /**
   * Get the value of Path
   *
   * @return mixed
   */
  public function getPath()
  {
    return $this->path;
  }

  /**
   * Set the value of Path
   *
   * @param mixed path
   *
   * @return self
   */
  public function setPath($path)
  {
    $this->path = $path;

    return $this;
  }

  /**
   * Get the value of Name
   *
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set the value of Name
   *
   * @param mixed name
   *
   * @return self
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the value of Version
   *
   * @return mixed
   */
  public function getVersion()
  {
    return $this->version;
  }

  /**
   * Set the value of Version
   *
   * @param mixed version
   *
   * @return self
   */
  public function setVersion($version)
  {
    $this->version = $version;

    return $this;
  }

  /**
   * Get the value of Author
   *
   * @return mixed
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * Set the value of Author
   *
   * @param mixed author
   *
   * @return self
   */
  public function setAuthor($author)
  {
    $this->author = $author;

    return $this;
  }

  /**
   * Get the value of Versions
   *
   * @return mixed
   */
  public function getVersions()
  {
    return $this->versions;
  }

  /**
   * Set the value of Versions
   *
   * @param mixed versions
   *
   * @return self
   */
  public function setVersions($versions)
  {
    $this->versions = $versions;

    return $this;
  }

  /**
   * Get the value of Config
   *
   * @return mixed
   */
  public function getConfig()
  {
    return $this->config;
  }

  /**
   * Set the value of Config
   *
   * @param mixed config
   *
   * @return self
   */
  public function setConfig($config)
  {
    $this->config = $config;

    return $this;
  }

  /**
   * Get the value of Error
   *
   * @return mixed
   */
  public function getError()
  {
    return $this->error;
  }

  /**
   * Set the value of Error
   *
   * @param mixed error
   *
   * @return self
   */
  public function setError($error)
  {
    $this->error = $error;

    return $this;
  }

  /**
   * Add string to Error
   *
   * @param mixed error
   *
   * @return self
   */
  public function addError($error)
  {
    $this->error .= $error.' <br>';
  }

  public function displayError()
  {
    if(!empty($this->getError()))
      return '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  '.$this->getError().'
                </div>';
  }





  /**
   * Set the value of Files
   *
   * @param mixed files
   *
   * @return self
   */
  public function setFiles($files)
  {
    $this->files = $files;

    return $this;
  }


  /**
   * Get the value of Files
   *
   * @return mixed
   */
  public function getFiles()
  {
    return $this->files;
  }

}
