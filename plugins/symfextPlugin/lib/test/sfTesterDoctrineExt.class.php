<?php

/**
 * sfTesterDoctrineExt implements tests for doctrine.
 *
 * @package    symfext
 * @subpackage test
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfTesterDoctrineExt extends sfTesterDoctrine
{
  public function check($model, $query, $value = true)
  {
    if (is_null($query))
    {
      $query = Doctrine::getTable($model)
        ->createQuery('a');
    }

    if (is_array($query))
    {
      $conditions = $query;
      $query = $query = Doctrine::getTable($model)
        ->createQuery('a');
      foreach ($conditions as $column => $condition)
      {
        $column = Doctrine::getTable($model)->getFieldName($column);
        
        if ($column == 'page_a_id' || $column == 'page_b_id') // for content association testing
        {
          $query->andWhere('(a.page_a_id = ? OR a.page_b_id = ?)', array($condition, $condition));
          continue;
        }

        if (is_null($condition))
        {
          $query->andWhere('a.'.$column.' IS NULL');
          continue;
        }

        $operator = '=';
        if ('!' == $condition[0])
        {
          $operator = false !== strpos($condition, '%') ? 'NOT LIKE' : '!=';
          $condition = substr($condition, 1);
        }
        else if (false !== strpos($condition, '%'))
        {
          $operator = 'LIKE';
        }

        $query->andWhere('a.' . $column . ' ' . $operator . ' ?', $condition);
      }
    }

    $objects = $query->execute();

    if (false === $value)
    {
      $this->tester->is(count($objects), 0, sprintf('no %s object that matches the criteria has been found', $model));
    }
    else if (true === $value)
    {
      $this->tester->cmp_ok(count($objects), '>', 0, sprintf('%s objects that matches the criteria have been found', $model));
    }
    else if (is_int($value))
    {
      $this->tester->is(count($objects), $value, sprintf('"%s" %s objects have been found', $value, $model));
    }
    else
    {
      throw new InvalidArgumentException('The "check()" method does not takes this kind of argument.');
    }

    return $this->getObjectToReturn();
  }
}
