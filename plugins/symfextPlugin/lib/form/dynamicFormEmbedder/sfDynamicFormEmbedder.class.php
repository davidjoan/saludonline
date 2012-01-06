<?php

/**
 * sfDynamicFormEmbedder embeds dynamically a form in another form and
 * manages all its functionality. 
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 * @TODO       Move all the view related info to a new renderer class, to leave just
 *             the functionality logic in here.
 */
class sfDynamicFormEmbedder
{
  protected static
    $decorator = "<table id=\"%s\" class=\"embedded_form\">\n <tr>\n<th class=\"title\" colspan=\"100\">\n %%label%% \n</th>\n</tr>\n %%content%% \n</table>",
    $key       = '987654321';
  
  protected
    $name                      = '',
    $relation                  = '',
    $parentForm                = null,
    $containerLabel            = '',
    $containerForm             = null,
    $existentChildObjects      = null,
    $childFormCreationCallable = null,
    
    $imageAdd                  = '',
    $imageLoading              = '',
    $imageRemove               = '';
  
  public function __construct($name, $relation, sfForm $parentForm, sfForm $containerForm, $existentChildObjects, sfCallable $childFormCreationCallable)
  {
    $this->name                      = $name;
    $this->relation                  = $relation;
    $this->parentForm                = $parentForm;
    $this->containerLabel            = sfInflector::humanize($this->getContainerName());
    $this->containerForm             = $containerForm;
    $this->existentChildObjects      = $existentChildObjects;
    $this->childFormCreationCallable = $childFormCreationCallable;
    
    $this->imageAdd                  = 'general/icons/add.png';
    $this->imageLoading              = 'general/snake.gif';
    $this->imageRemove               = 'general/icons/delete.png';
  }
  
  public function embed()
  {
    $current_count = self::getFormsCount($this->name);
    $removed_list  = self::getRemovedList($this->name);
    
    $containerForm = clone $this->containerForm;
    
    $count = 0;
    foreach ($this->existentChildObjects as $childObject)
    {
      $count++;
      if (in_array($count, $removed_list))
      {
        $this->parentForm->getObject()->{$this->relation}->removeRecord($childObject);
        continue;
      }
      
      $this->addChildFormToContainerForm($count, $containerForm, $childObject);
    }
    
    if ($count == 0 && $current_count == 0) // no form embedded yet, must be at least one when starting
    {
      $current_count++;
    }

    if ($count < $current_count) // already added forms
    {
      $count++;
      for ($count = $count; $count <= $current_count; $count++)
      {
        if (in_array($count, $removed_list))
        {
          continue;
        }
        
        $this->addChildFormToContainerForm($count, $containerForm);
      }
    }
    
    if ($current_count == 0)
    {
      $current_count = $count;
    }
    $this->parentForm->embedForm($this->getContainerName(), $containerForm, $this->getContainerDecorator());
    $this->parentForm->getWidgetSchema()->setLabel($this->getContainerName(), $this->getContainerLabel().'&nbsp;'.$this->getLinkAdd());
    
    self::setFormsCount($this->name, $current_count);
  }
  /**
   * Saves in session a template of a new child form that will be used when
   * adding a new form dynamically. This method should be called once the 
   * whole form is built, that is when all the form names are set up.
   */
  public function saveTemplateForm()
  {
    $containerForm = clone $this->containerForm;
    
    $this->addChildFormToContainerForm(self::$key, $containerForm);
    
    $parentForm = clone $this->parentForm;
    $parentForm->embedForm($this->getContainerName(), $containerForm, $this->getContainerDecorator());
    
    $form = $parentForm[$this->getContainerName()][self::$key]->renderRow();
    
    self::setFormTemplate($this->name, $form);
  }
  protected function addChildFormToContainerForm($count, $containerForm, $childObject = null)
  {
    $childForm = $this->childFormCreationCallable->call($childObject);
    $containerForm->embedForm($count, $childForm, $this->getChildDecorator($count));
    $containerForm->getWidgetSchema()->setLabel($count, $count.'&nbsp;'.$this->getLinkRemove($count));
  }
  protected function getChildDecorator($count)
  {
    return sprintf(self::$decorator, $this->name.'_'.$count);
  }
  protected function getContainerDecorator()
  {
    return sprintf(self::$decorator, $this->getContainerName());
  }
  public function getContainerName()
  {
    return $this->name.'_container';
  }
  public function getParentForm()
  {
    return $this->parentForm;
  }
  public function getContainerLabel()
  {
    return $this->containerLabel;
  }
  public function setContainerLabel($container_label)
  {
    return $this->containerLabel = $container_label;
  }
  
  public function getImageAdd()
  {
    return $this->imageAdd;
  }
  public function setImageAdd($image_add)
  {
    $this->imageAdd = $image_add;
  }
  public function getImageLoading()
  {
    return $this->imageLoading;
  }
  public function setImageLoading($image_loading)
  {
    $this->imageLoading = $image_loading;
  }
  public function getImageRemove()
  {
    return $this->imageRemove;
  }
  public function setImageRemove($image_remove)
  {
    $this->imageRemove = $image_remove;
  }
  protected function getLinkAdd()
  {
    $this->parentForm->loadHelpers(array('Asset', 'Tag', 'JavascriptBase', 'Url', 'Partial'));
    
    return link_to_function
           (
             image_tag($this->getImageAdd()), 
             sprintf
             (
               'addDynamicForm("%s", "%s", "%s", "%s", "%s", event)', 
               $this->name, 
               $this->getContainerName(), 
               sfConfig::get('sf_images_path').'/'.$this->getImageLoading(),
               url_for('@generic_get_attribute_value'), 
               url_for('@generic_add_dynamic_form')
             )
           );
  }
  protected function getLinkRemove($count)
  {
    $this->parentForm->loadHelpers(array('Asset', 'Tag', 'JavascriptBase', 'Url', 'Partial'));
    
    return link_to_function
           (
             image_tag($this->getImageRemove()), 
             sprintf
             (
               'removeDynamicForm("%s", "%s", "%s", event)', 
               $this->name, 
               $count, 
               url_for('@generic_remove_dynamic_form')
             )
           );
  }
  
  
  public static function getProcessedFormTemplate($name)
  {
    $next_form_count = self::getFormsCount($name) + 1;
    self::setFormsCount($name, $next_form_count);
    
    $form = self::getFormTemplate($name);
    $form = str_replace(self::$key, $next_form_count, substr($form, 4, -6)); // replacing and deleting <tr></tr>

    return $form;
  }
  public static function addToRemovedList($name, $form_count)
  {
    $removed_list = self::getRemovedList($name);
    
    $removed_list[] = $form_count;
    
    self::setRemovedList($name, $removed_list);
  }
  public static function resetParams($name)
  {
    self::setFormsCount($name, 0);
    self::setRemovedList($name, array());
    self::setFormTemplate($name, '');
  }
  public static function getFormsCount($name)
  {
    return self::getUser()->getAttribute($name.'_forms_count'  , 0             , ActionsProject::GENERAL_NAMESPACE);
  }
  public static function setFormsCount($name, $forms_count)
  {
    return self::getUser()->setAttribute($name.'_forms_count'  , $forms_count  , ActionsProject::GENERAL_NAMESPACE);
  }
  public static function getRemovedList($name)
  {
    return self::getUser()->getAttribute($name.'_removed_list' , array()       , ActionsProject::GENERAL_NAMESPACE);
  }
  public static function setRemovedList($name, $removed_list)
  {
    return self::getUser()->setAttribute($name.'_removed_list' , $removed_list , ActionsProject::GENERAL_NAMESPACE);
  }
  public static function getFormTemplate($name)
  {
    return self::getUser()->getAttribute($name.'_form_template', ''            , ActionsProject::GENERAL_NAMESPACE);
  }
  public static function setFormTemplate($name, $form_template)
  {
    return self::getUser()->setAttribute($name.'_form_template', $form_template, ActionsProject::GENERAL_NAMESPACE);
  }
  public static function getUser()
  {
    return sfContext::getInstance()->getUser();
  }
}
