<?php

/**
 * default actions.
 *
 * @package    saludonline
 * @subpackage default
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class defaultActions extends ActionsProject
{
  /**
   * Module disabled in settings.yml
   */
  public function executeDisabled()
  {
  }
  /**
   * Error page for page not found (404) error
   */
  public function executeError404()
  {
  }
  /**
   * Warning page for restricted area - requires credentials
   */
  public function executeLogin()
  {
  }
  /**
   * Warning page for restricted area - requires login
   */
  public function executeSecure()
  {
  }
}
