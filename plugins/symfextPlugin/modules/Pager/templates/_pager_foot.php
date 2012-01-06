<?php use_stylesheet(sfConfig::get('sf_app').'/modules/pager.css') ?>

<table class="pager_foot" <?php if (!$pager->haveToPaginate()): ?> style="display: none;" <?php endif; ?>>
  <tr>
    <td>Page</td>
  </tr>
  
  <tr>
    <td>
      <?php $links = count($pager->getLinks(11)) ?>
      <?php if (10 < $links): ?>
        <?php echo link_to_get_url('&laquo;', $uri, array_merge($params, array('page' => array('value' => $pager->getFirstPage())))) ?>
        <?php echo link_to_get_url('&lt;'   , $uri, array_merge($params, array('page' => array('value' => $pager->getPreviousPage())))) ?>
      <?php endif; ?>
      
      <?php foreach ($pager->getLinks(10) as $page): ?>
        <?php echo $pager->getPage() == $page 
                   ? sprintf('<i class="current_page">%s</i>', $page) 
                   : link_to_get_url($page, $uri, array_merge($params, array('page' => array('value' => $page))))
        ?>
        <?php if ($page != $pager->getCurrentMaxLink()): ?> | <?php endif; ?>
      <?php endforeach; ?>
      
      <?php if (10 < $links): ?>
        <?php echo link_to_get_url('&gt;'   , $uri, array_merge($params, array('page' => array('value' => $pager->getNextPage())))) ?>
        <?php echo link_to_get_url('&raquo;', $uri, array_merge($params, array('page' => array('value' => $pager->getLastPage())))) ?>
      <?php endif; ?>
    </td>
  </tr>
</table>

<table class="pager_foot" <?php if (!$pager->haveToPaginate() && $sf_params->get('max') == "20"): ?> style="display: none;" <?php endif; ?>>
  <tr>
    <td>
      <?php echo input_hidden_tag('page', $pager->getPage(), array('size' => 2, 'maxlength' => 3)) ?>
      
      <label for="max">Number of records displayed:</label>
      <?php echo select_tag
                 (
                   'max', 
                   array
                   (
                     '20'  => '20', 
                     '40'  => '40', 
                     '60'  => '60', 
                     '100' => '100',
                     '200' => '200'
                   ), 
                   $sf_params->get('max'), 
                   array('onchange' => get_url($uri, $params))
                 )
      ?>
    </td>
  </tr>
</table>
