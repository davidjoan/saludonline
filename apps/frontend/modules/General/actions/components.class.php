<?php

/**
 * General components.
 *
 * @package    iceblog
 * @subpackage General
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class GeneralComponents extends ComponentsProject
{
  public function executeSidebar()
  {
    $this->form = new LoginFrontendForm();
    $this->posts    = Doctrine::getTable('Post')->findLastPosts(10);
    $this->sponsors = Doctrine::getTable('Sponsor')->findAll();
    $this->company  = Doctrine::getTable('Company')->findOneById(1);
    $this->actions = $this->getActions();
  }
  
  public function executeFooter()
  {
      $this->actions = $this->getActions();
      $this->company = Doctrine::getTable('Company')->findOneById(1);
      $this->comments = Doctrine::getTable('Comment')->findLastComments(10);
      $this->actions = $this->getActions();
  }
  
  protected function getActions()
  {
    $actions    = array();
    $actions[0] = array('url' => '@homepage', 'name' => 'Inicio');
    $actions[1] = array('url' => '@contact', 'name' => 'Contactenos');
    $actions[2] = array('url' => '@register', 'name' => 'Registrate');
    
    $posts = Doctrine::getTable('post')->findAll();
    
    foreach($posts as $key => $post)
    {
      $actions[3+$key] = array('url' => '@post_show?slug='.$post->getSlug(), 'name' => $post->getTitle());    
    }
    
    return $actions;
  }
}
