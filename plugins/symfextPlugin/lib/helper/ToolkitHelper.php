<?php

/**
 * ToolkitHelper
 *
 * @package    symfext
 * @subpackage helper
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */

function get_url($uri, $params, $function = 'getUrl')
{
  return sprintf('%s(\'%s\', \'%s\')', $function, url_for($uri), json_encode($params));
}

function link_to_get_url($name, $uri, $params, $html_options = array())
{
  $function = get_url($uri, $params);
	
  return link_to_function($name, $function, $html_options);
}

function button_to_get_url($name, $uri, $params, $html_options = array())
{
  $function = get_url($uri, $params);
	
  return button_to_function($name, $function, $html_options);
}


function div_button_to($name, $internal_uri, $options = array())
{
  $html_options = _parse_attributes($options);
  
  $onclick = sprintf('document.location.href = \'%s\' ', url_for($internal_uri));
  $html_options['onclick'] = $onclick;
  
  $html_options = _convert_options_to_javascript($html_options);
  
  if (!isset($html_options['class']))
  {
  	$html_options['class'] = 'button';
  }
  
  return content_tag('div', $name, $html_options);
}

function div_button_to_function($name, $javascript, $options = array())
{
  $html_options = _parse_attributes($options);
  
  $html_options = _convert_options_to_javascript($html_options);
  
  $html_options['onclick'] = $javascript;
  
  if (!isset($html_options['class']))
  {
  	$html_options['class'] = 'button';
  }
  
  return content_tag('div', $name, $html_options);
}

function div_button_to_get_url($name, $uri, $params, $options = array(), $function = 'getUrl')
{
  $javascript = get_url($uri, $params, $function);

  return div_button_to_function($name, $javascript, $options);
}


function order_link($current, $field, $label, $order, $uri, $params, $show_link, $sort_sense = true)
{
  $params['order_by']['value'] = $field;
  
  $link = '';
  if ($show_link == false)
  {
    $link = $label;
  }
  elseif (!$field && !$label)
  {
  	$link = '&nbsp;';
  }
  elseif ($current != $field)
  {
    $params['order']['value'] = $sort_sense ? 'a' : 'd';
  	$link = link_to_get_url($label, $uri, $params);
  }
  elseif ($order == 'a')
  {
    $params['order']['value'] = 'd';
  	$link = link_to_get_url($label.' &darr;', $uri, $params);
  }
  else
  {
    $params['order']['value'] = 'a';
  	$link = link_to_get_url($label.' &uarr;', $uri, $params);
  }
  
  return $link;
}

function get_filter_from_url($url)
{
  return Stringkit::fixFilter($url);
}

function get_url_from_filter($filter)
{
  return Stringkit::unfixFilter($filter);
}

function get_entrance_route($module = null)
{
  $module = $module ? $module : sfContext::getInstance()->getRequest()->getParameter('module');
  
  return Toolkit::getEntranceRoute($module);
}



function get_objective_vars($vars)
{
  $new_vars      = array();
  $vars_to_unset = array
                   (
                     'this', 
                     '_sfFile', 
                     'sf_type', 
                     'sf_context', 
                     'sf_request', 
                     'sf_params', 
                     'sf_response', 
                     'sf_user', 
                     'sf_data'
                   );
  
  foreach ($vars as $var => $value)
  {
    if (!in_array($var, $vars_to_unset))
    {
      $new_vars[$var] = $value;
    }
  }
  
  return $new_vars;
}
