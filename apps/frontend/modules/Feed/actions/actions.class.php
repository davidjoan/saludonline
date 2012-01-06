<?php

/**
 * Feed actions.
 *
 * @package    saludonline
 * @subpackage Feed
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class FeedActions extends ActionsProject
{
  public function executeLastPosts(sfWebRequest $request)
  {
    $feed = new sfRss201Feed();
    
    $feed->setTitle('Salud Online Noticias');
    $feed->setLink('http://saludonline.org');
    $feed->setAuthorName('Equipo de Salud Online');
    $feed->setAuthorEmail('dtataje@saludonline.org');
    
    $feedImage = new sfFeedImage();
    $feedImage->setTitle('saludonline');
    $feedImage->setLink('http://saludonline.org/images/general/favicon.ico');
    $feed->setImage($feedImage);
    
    $category_slug = $request->getParameter('category_slug');
    if (!$category_slug)
    {
      $posts = Doctrine::getTable('Post')->findLastPosts(20);
    }
    else
    {
      $posts = Doctrine::getTable('Post')->findLastPostsByCategorySlug($category_slug, 20);
    }
    
    foreach ($posts as $post)
    {
      $item = new sfFeedItem();
      $item->setTitle($post->getTitle());
      $item->setLink('@post_show?slug='.$post->getSlug());
      $item->setAuthorName($post->getUser()->getRealname());
      $item->setAuthorEmail($post->getUser()->getEmail());
      $item->setPubdate(strtotime($post->getDatetime()));
      $item->setUniqueId($post->getSlug());
      $item->setDescription($post->getExcerpt());
      
      $feed->addItem($item);
    }
    
    $this->feed = $feed;
  }
}