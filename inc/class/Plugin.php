<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class Plugin
{
  private $path;
  private $name;
  private $version;
  private $author;
  private $versions;
  private $config;
  private $error;
  private $description;
  private $menu;

  public function __construct($name)
  {
      $this->load($name);
  }

  private function load($name)
  {
    $this->setPath(__DIR__ . '/../../plugins/' . $name . '/');
    if(file_exists($this->getPath()) && is_dir($this->getPath())){
      $this->setConfig(require_once ($this->path . 'plugin.php'));
      $this->setName($this->getConfig()['name']);
      $this->setAuthor($this->getConfig()['author']);
      $this->setVersion($this->getConfig()['version']);
      $this->setVersions($this->getConfig()['cms_versions']);
      $this->setDescription($this->getConfig()['description']);
      $this->setMenu($this->getPath() . 'menu.php');
    }else{
      $this->addError('Folder ' . $this->getName() . ' not found !');
      exit(0);
    }
  }

  public function delete()
  {
    foreach(glob($this->getPath().'/*') as $file){
      if(is_file($file))
        unlink($file);
    }
    rmdir($this->getPath());

    echo Auth::alert('Le plugin '.$this->getName().' a bien été supprimé !', 'success');
  }

  public static function selectAll()
  {
    $plugins = null;
    foreach (scandir(__DIR__ . '/../../plugins') as $folder) {
      if(is_dir(__DIR__ . '/../../plugins/'.$folder) && file_exists(__DIR__ . '/../../plugins/'.$folder.'/plugin.php')){
          $plugin = new plugin($folder);
          if($plugin->isPlugin())
            $plugins[$plugin->getName()]['name'] = $plugin->getName();
            $plugins[$plugin->getName()]['author'] = $plugin->getAuthor();
            $plugins[$plugin->getName()]['version'] = $plugin->getVersion();
            $plugins[$plugin->getName()]['cms_version'] = $plugin->getVersions();
            $plugins[$plugin->getName()]['path'] = $plugin->getPath();
            $plugins[$plugin->getName()]['active'] = $plugin->isActive();
            $plugins[$plugin->getName()]['compatible'] = $plugin->isCompatible();
            $plugins[$plugin->getName()]['description'] = $plugin->getDescription();
      }
    }
    return $plugins;
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

  public function loadMenu()
  {
    $this->setMenu(include_once($this->getMenu()));
  }

  public function isActive()
  {
    return true;
  }

  public function isPlugin()
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
     * Get the value of Description
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param mixed description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Get the value of Menu
     *
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set the value of Menu
     *
     * @param mixed menu
     *
     * @return self
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

}
