<?php

/**
 * MediaTemplate
 *
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class ResourceTemplate extends DoctrineTemplate
{
  public function getPathLink()
  {
    return link_to($this->getPath(), $this->getFilePath('path'));
  }
}
