<?php
//require_once '/home/saludon/symfony/lib/autoload/sfCoreAutoload.class.php';
require_once 'D://Apps//xampp//htdocs//symfony//lib/autoload/sfCoreAutoload.class.php';
//require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();
require_once(dirname(__FILE__).'/../plugins/symfextPlugin/config/sfProjectConfigurationExt.class.php');
require_once(dirname(__FILE__).'/../lib/vendor/geshi/geshi.php');
setlocale(LC_ALL,'spanish_peru');

class ProjectConfiguration extends sfProjectConfigurationExt
{
  protected function getActivePlugins()
  {
    return array
           (
             'sfDoctrinePlugin',
             'sfImageTransformPlugin',
             'symfextPlugin',
             'sfFeed2Plugin'
           );
  }
  
  public function setup()
  {
    parent::setup();
  }
  
  protected function setConfigVariables()
  {
    $this->setWebDir($this->getRootDir().'/public_html');      
    sfConfig::set('sf_web_path','/');    
    sfConfig::set('sf_web_dir_name','public_html');    
    parent::setConfigVariables();
    sfConfig::set('site_name', 'Salud Online');
    $this->setConfigDirPathVariable('company', sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'company');
    $this->setConfigDirPathVariable('post'   , sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'post'   );
    $this->setConfigDirPathVariable('profile', sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'profile');
    $this->setConfigDirPathVariable('resource', sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'resource');
    
  }
}