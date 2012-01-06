<?php

/**
 * Stringkit
 *
 * @package    flexiwik
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Stringkit extends sfStringkitExt
{
  protected static
    $reUrlAccess = "/[^a-z0-9\-_\\/(\)\[\]'çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñ:]+/",
    $reTitle     = "/[^a-zA-Z0-9\-_\(\)\[\]'çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñ ÇÀÁÂÃÄÅĀÆÈÉÊËĖĒĘÌÍÎÏĪĮÒÓÔÕŌÖØŒÙÚÛÜŮŨŪŲÝŸŶÑ]+/";
}
