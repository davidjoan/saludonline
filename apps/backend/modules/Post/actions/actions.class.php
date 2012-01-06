<?php

/**
 * Post actions.
 *
 * @package    saludonline
 * @subpackage Post
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class PostActions extends ActionsCrud
{
  protected function getExtraFilterAndArrangeFields()
  {
    return array('u' => array('user_realname' => 'realname'));
  }
  protected function complementList(sfWebRequest $request, DoctrineQuery $q)
  {
    Doctrine::getTable($this->modelClass)->updateQueryForList($q);
  }
}
