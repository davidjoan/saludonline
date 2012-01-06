<?php

/**
 * sfProjectConfigurationExt
 *
 * @package    symfext
 * @subpackage action
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfProjectConfigurationExt extends sfProjectConfiguration
{
  /**
   * @see sfProjectConfiguration
   */
  public function setup()
  {
    $this->enablePlugins($this->getActivePlugins());
    
    sfWidgetFormSchema::setDefaultFormFormatterName('ext');
    
    $this->setConfigVariables();
  }
  
  /**
   * Returns the list of the active plugins.
   * 
   * @return array The active plugins list
   */
  protected function getActivePlugins()
  {
    return array('symfextPlugin');
  }
  
  /**
   * Sets general configuration variables.
   */
  protected function setConfigVariables()
  {
    $this->setConfigDirPathVariable('web'            , sfConfig::get('sf_web_dir')                                           , 'sf');
    $this->setConfigDirPathVariable('images'         , sfConfig::get('sf_web_dir')   .DIRECTORY_SEPARATOR.'images'           , 'sf');
    $this->setConfigDirPathVariable('test_images'    , sfConfig::get('sf_test_dir')  .DIRECTORY_SEPARATOR.'images'           , 'sf');
    $this->setConfigDirPathVariable('cron'           , sfConfig::get('sf_root_dir')  .DIRECTORY_SEPARATOR.'cron'             , 'sf');
  }
  
  /**
   * Sets three variables in the configuration class:
   *   1.- "app_$name_dir"     , holding the dir parameter, the entire dir path. (C:\wamp\www\project\web\uploads\example)
   *   2.- "app_$name_path"    , holding the dir path since the root project.    (\project\web\uploads\example)
   *   3.- "app_$name_dir_name", holding the name of the main dir.               (example)
   * 
   * @param string $name   The main part of the name
   * @param string $dir    The entire dir path
   * @param string $prefix The prefix of the name
   */
  protected function setConfigDirPathVariable($name, $dir, $prefix = 'app')
  {
    sfConfig::set(sprintf('%s_%s_dir'     , $prefix, $name), $dir);
    //sfConfig::set(sprintf('%s_%s_path'    , $prefix, $name), str_replace('\\', '/', substr($dir, strpos($dir, $this->getProjectName()) + 19)));
	sfConfig::set(sprintf('%s_%s_path'    , $prefix, $name), str_replace('\\', '/', substr($dir, strpos($dir, $this->getProjectName()) + 23)));
    sfConfig::set(sprintf('%s_%s_dir_name', $prefix, $name), substr($dir, strrpos($dir, DIRECTORY_SEPARATOR) + 1));
  }
  
  /**
   * Configures the project with the Doctrine attributes.
   * 
   * @param Doctrine_Manager $manager The doctrine manager
   */
  public function configureDoctrine(Doctrine_Manager $manager)
  {
    $options = array('baseClassName' => 'DoctrineRecord');
    sfConfig::set('doctrine_model_builder_options', $options);
    
    $manager->setAttribute(Doctrine_Core::ATTR_COLLECTION_CLASS  , 'DoctrineCollection');
    $manager->setAttribute(Doctrine_Core::ATTR_QUERY_CLASS       , 'DoctrineQuery');
    $manager->setAttribute(Doctrine_Core::ATTR_TABLE_CLASS       , 'DoctrineTable');
    $manager->setAttribute(Doctrine_Core::ATTR_DEFAULT_TABLE_TYPE, 'INNODB');
    $manager->setCharset('utf8');
    $manager->setCollate('utf8_bin');
  }
  
  /**
   * Returns the project name.
   * 
   * @param string The project name
   */
  public function getProjectName()
  {
    return substr($this->getRootDir(), strrpos($this->getRootDir(), DIRECTORY_SEPARATOR) + 1);
  }
}