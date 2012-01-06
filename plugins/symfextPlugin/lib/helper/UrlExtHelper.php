<?php

function url_for_fix_urlencode()
{
  // for BC with 1.1
  $arguments = func_get_args();
  if (is_array($arguments[0]) || '@' == substr($arguments[0], 0, 1) || false !== strpos($arguments[0], '/'))
  {
    return Toolkit::decodeUrl(call_user_func_array('url_for1', $arguments));
  }
  else
  {
    return Toolkit::decodeUrl(call_user_func_array('url_for2', $arguments));
  }
}

function link_to_fix_urlencode()
{
  // for BC with 1.1
  $arguments = func_get_args();
  if (empty($arguments[1]) || '@' == substr($arguments[1], 0, 1) || false !== strpos($arguments[1], '/'))
  {
    return Toolkit::decodeUrl(call_user_func_array('link_to1', $arguments));
  }
  else
  {
    if (!array_key_exists(2, $arguments))
    {
      $arguments[2] = array();
    }
    return Toolkit::decodeUrl(call_user_func_array('link_to2', $arguments));
  }
}
