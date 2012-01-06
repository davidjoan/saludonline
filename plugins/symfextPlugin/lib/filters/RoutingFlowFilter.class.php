<?php

/**
 * RoutingFlowFilter
 *
 * @package    symfext
 * @subpackage filters
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 * @see RoutingFlow
 */
class RoutingFlowFilter extends sfFilter
{
  public function execute($filterChain)
  {
  	$current_route_name = $this->getRouting()->getCurrentRouteName();
  	$routes             = $this->getRouting()->getRoutes();
  	$route              = $routes[$current_route_name];
  	
  	$defaults = $route->getDefaults();
  	if (isset($defaults['rflow']))
    {
  	  $module = $this->getRequest()->getParameter('module');
  	  $ns     = constant(sprintf('ActionsProject::%s_NAMESPACE', strtoupper(sfInflector::underscore($module))));
      $this->flow($ns);
    }
    
    if (isset($defaults['rf_module']))
  	{
  	  $modules = explode(',', $defaults['rf_module']);	
  	  foreach ($modules as $module)
  	  {
  	    $ns = constant(sprintf('ActionsProject::%s_NAMESPACE', strtoupper(sfInflector::underscore($module))));
  	    $this->flow($ns);
  	  }
  	}
  	
    $filterChain->execute();
  }
  
  protected function flow($ns)
  {
  	$user = $this->getContext()->getUser();
  	
  	// adding three reminders for the last three actions according to the namespace
  	$current_route = $this->getRouting()->getCurrentInternalUri(true);
  	$user->setAttribute('third_last_route' , $user->getAttribute('second_last_route', null, $ns), $ns);
  	$user->setAttribute('second_last_route', $user->getAttribute('first_last_route' , null, $ns), $ns);
  	$user->setAttribute('first_last_route' , $user->getAttribute('current_route'    , null, $ns), $ns);
  	$user->setAttribute('current_route'    , $current_route, $ns);
  }
  
  protected function getRequest()
  {
  	return $this->getContext()->getRequest();
  }
  protected function getRouting()
  {
  	return $this->getContext()->getRouting();
  }
}
