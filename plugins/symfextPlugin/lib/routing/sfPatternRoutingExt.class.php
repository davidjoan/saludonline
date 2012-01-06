<?php

/**
 * sfPatternRoutingExt
 * 
 * @package    symfext
 * @subpackage lib
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfPatternRoutingExt extends sfPatternRouting
{
  public function getCurrentInternalRouteName()
  {
    return '@'.parent::getCurrentRouteName();
  }
}
