<?php

/**
 * sfBrowserExt
 * 
 * @package    symfext
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfBrowserExt extends sfBrowser
{
  /**
   * Simulates a click on the supplied DOM element.
   *
   * This method is called internally by the {@link click()} method.
   * 
   * This methods is overwritten a cause of image uploading. It have 
   * to used finfo class to get the correct type of the file. This feature
   * is needed for image testing.
   *
   * @param  DOMElement $item      The element being clicked
   * @param  array      $arguments The arguments to pass to the link
   * @param  array      $options   An array of options
   *
   * @return array An array composed of the URI, the method and the arguments to pass to the call() call
   *
   * @uses getResponseDomXpath()
   */
  public function doClickElement(DOMElement $item, $arguments = array(), $options = array())
  {
    $method = strtolower(isset($options['method']) ? $options['method'] : 'get');

    if ('a' == $item->nodeName)
    {
      if (in_array($method, array('post', 'put', 'delete')))
      {
        if (isset($options['_with_csrf']) && $options['_with_csrf'])
        {
          $arguments['_with_csrf'] = true;
        }

        return array($item->getAttribute('href'), $method, $arguments);
      }
      else
      {
        return array($item->getAttribute('href'), 'get', $arguments);
      }
    }
    else if ('button' == $item->nodeName || ('input' == $item->nodeName && in_array($item->getAttribute('type'), array('submit', 'button', 'image'))))
    {
      // add the item's value to the arguments
      $this->parseArgumentAsArray($item->getAttribute('name'), $item->getAttribute('value'), $arguments);

      // use the ancestor form element
      do
      {
        if (null === $item = $item->parentNode)
        {
          throw new Exception('The clicked form element does not have a form ancestor.');
        }
      }
      while ('form' != $item->nodeName);
    }

    // form attributes
    $url = $item->getAttribute('action');
    if (!$url || '#' == $url)
    {
      $url = $this->stack[$this->stackPosition]['uri'];
    }
    $method = strtolower(isset($options['method']) ? $options['method'] : ($item->getAttribute('method') ? $item->getAttribute('method') : 'get'));

    // merge form default values and arguments
    $defaults = array();
    $arguments = sfToolkit::arrayDeepMerge($this->fields, $arguments);

    $xpath = $this->getResponseDomXpath();
    foreach ($xpath->query('descendant::input | descendant::textarea | descendant::select', $item) as $element)
    {
      $elementName = $element->getAttribute('name');
      $nodeName    = $element->nodeName;
      $value       = null;

      if ($nodeName == 'input' && ($element->getAttribute('type') == 'checkbox' || $element->getAttribute('type') == 'radio'))
      {
        if ($element->getAttribute('checked'))
        {
          $value = $element->hasAttribute('value') ? $element->getAttribute('value') : '1';
        }
      }
      else if ($nodeName == 'input' && $element->getAttribute('type') == 'file')
      {
        $filename = array_key_exists($elementName, $arguments) ? $arguments[$elementName] : sfToolkit::getArrayValueForPath($arguments, $elementName, '');

        if (is_readable($filename))
        {
          $fileError = UPLOAD_ERR_OK;
          $fileSize  = filesize($filename);
          $finfo     = new finfo(FILEINFO_MIME); // overwritten a cause of image uploading
          $type      = $finfo->file($filename);
        }
        else
        {
          $fileError = UPLOAD_ERR_NO_FILE;
          $fileSize  = 0;
          $type      = '';
        }

        unset($arguments[$elementName]);

        $this->parseArgumentAsArray($elementName, array('name' => basename($filename), 'type' => $type, 'tmp_name' => $filename, 'error' => $fileError, 'size' => $fileSize), $this->files);
      }
      else if ('input' == $nodeName && !in_array($element->getAttribute('type'), array('submit', 'button', 'image')))
      {
        $value = $element->getAttribute('value');
      }
      else if ($nodeName == 'textarea')
      {
        $value = '';
        foreach ($element->childNodes as $el)
        {
          $value .= $this->getResponseDom()->saveXML($el);
        }
      }
      else if ($nodeName == 'select')
      {
        if ($multiple = $element->hasAttribute('multiple'))
        {
          $elementName = str_replace('[]', '', $elementName);
          $value = array();
        }
        else
        {
          $value = null;
        }

        $found = false;
        foreach ($xpath->query('descendant::option', $element) as $option)
        {
          if ($option->getAttribute('selected'))
          {
            $found = true;
            if ($multiple)
            {
              $value[] = $option->getAttribute('value');
            }
            else
            {
              $value = $option->getAttribute('value');
            }
          }
        }

        // if no option is selected and if it is a simple select box, take the first option as the value
        $option = $xpath->query('descendant::option', $element)->item(0);
        if (!$found && !$multiple && $option instanceof DOMElement)
        {
          $value = $option->getAttribute('value');
        }
      }

      if (null !== $value)
      {
        $this->parseArgumentAsArray($elementName, $value, $defaults);
      }
    }

    // create request parameters
    $arguments = sfToolkit::arrayDeepMerge($defaults, $arguments);
    if (in_array($method, array('post', 'put', 'delete')))
    {
      return array($url, $method, $arguments);
    }
    else
    {
      $queryString = http_build_query($arguments, null, '&');
      $sep = false === strpos($url, '?') ? '?' : '&';

      return array($url.($queryString ? $sep.$queryString : ''), 'get', array());
    }
  }
}
