<table class="alphabet">
  <?php $letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r','s', 't', 'u', 'v', 'w', 'x', 'y', 'z') ?>
  <tr>
    <td>
      <?php echo $filter != '0' ? link_to_get_url('All', $uri, array_merge($params, array('filter' => array('value' => '0')))) : '<span>All</span>' ?>
    </td>
    <?php foreach ($letters as $letter): ?>
      <td>
        <?php echo $filter != $letter 
                   ? link_to_get_url(sprintf('<b>%s</b>', strtoupper($letter)), $uri, array_merge($params, array('filter' => array('value' => $letter)))) 
                   : sprintf('<span><b>%s</b></span>', strtoupper($letter)) 
        ?>
      </td>
    <?php endforeach; ?>
  </tr>
</table>
