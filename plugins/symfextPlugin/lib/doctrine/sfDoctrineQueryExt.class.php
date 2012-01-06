<?php

/**
 * sfDoctrineQueryExt
 *
 * @package    symfext
 * @subpackage doctrine
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfDoctrineQueryExt extends Doctrine_Query
{
  public function resetType()
  {
    $this->_type = self::SELECT;
  }
  
  /**
   * Filter and arrange the query according some params and fields
   * 
   * Important: When using "addSelect" must specify manually all the fields of the wanted tables,
   *            to improve performance and retrieve a join object directly consider to use "*",
   *            e.g. "c.*".
   *
   * @param array $params
   * @param array $array_fields
   * @return DoctrineQuery
   */
  public function filterAndArrange(array $params, $array_fields = array())
  {
    $table       = $params['module'];
    $table_alias = strtolower(substr($table, 0, 1));
    
    $filter_alias = $order_alias = $table_alias;
    foreach ($array_fields as $alias => $fields)
    {
      if (isset($params['filter_by']))
      {
        if (in_array($params['filter_by'], array_keys($fields), true))
        {
          $filter_alias = $alias;
        }
      }
      if (isset($params['order_by']))
      {
        if (in_array($params['order_by'], array_keys($fields), true))
        {
          $order_alias  = $alias;
        }
      }
    }
    
    if (isset($params['filter']))
    {
      $filter_by = $params['filter_by'];
      if (!empty($array_fields))
      {
        if (array_key_exists($filter_alias, $array_fields) && array_key_exists($params['filter_by'], $array_fields[$filter_alias]))
        {
          $filter_by = $array_fields[$filter_alias][$params['filter_by']];
        }
      }
      
      $filter_alias = $filter_alias != 'extra' ? $filter_alias.'.' : '';
      $field        = $filter_alias.$filter_by;
      $this->filterFieldByString($field, $params['filter']);
    }
    
    if (isset($params['order']))
    {
      $order_by = $params['order_by'];
      if (!empty($array_fields))
      {
        if (array_key_exists($order_alias, $array_fields) && array_key_exists($params['order_by'], $array_fields[$order_alias]))
        {
          $order_by = $array_fields[$order_alias][$params['order_by']];
        }
      }
      
      $order        = $params['order'] == 'a' ? 'ASC' : 'DESC';
      $order_alias  = $order_alias != 'extra' ? $order_alias.'.' : '';
      $field        = $order_alias.$order_by;
      $this->orderBy(sprintf('%s %s', $field, $order)); // TODO: ADD LOWER SUPPORT: CATEGORY LIST
    }
    
    return $this;
  }
  public function filterFieldByString($field, $filter)
  {
    if ($filter)
    {
      $filters = explode('|', Stringkit::strtolower($filter));
      $filters = array_diff($filters, array(''));
      foreach ($filters as $filter)
      {
        $this->addWhere(sprintf('LOWER(%s) LIKE "%%%s%%"', $field, addslashes($filter)));
     }
    }
    
    return $this;
  }
  
  public function andIntervalWhere($from, $to, $field)
  {
  	$where = '';
    if ($from || $to)
  	{
  	  if ($from)
  	  {
  	    $this->andWhere(sprintf('DATE_FORMAT(%s, \'%%Y-%%m-%%d\') >= ?', $field), $from);
  	  }
  	  if ($to)
  	  {
  	    $this->andWhere(sprintf('DATE_FORMAT(%s, \'%%Y-%%m-%%d\') <= ?', $field), $to);
  	  }
  	}

  	return $this;
  }
  
  /* use DoctrineCollection::toCustomArray
  //<ToRefactor>
  //</ToRefactor>
  public function fetchMainMediaArrayForSelect()
  {
    $info = array();
    $i = 1; // for problems with the json_encode function, an index must be set explicitly
    foreach ($this->execute() as $media)
    {
      $info[$i] = array
                  (
                    'id'      => $media->getId(),
                    'title'   => $media->getPage()->getLongTitle(),
                    'content' => $media->getPage()->getEnhancedTitle(),
                    'path'    => $media->getThumbnailImagePath()
                  );
      $i++;
    }
    
    return $info;
  }
  */
}
