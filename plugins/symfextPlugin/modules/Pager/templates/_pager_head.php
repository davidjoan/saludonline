<?php use_stylesheet(sfConfig::get('sf_app').'/modules/pager.css') ?>

<table class="pager_head">
  <tr>
    <td>
      Displaying <?php echo $pager->getFirstIndice() ?> - <?php echo $pager->getLastIndice() ?> out of over 
      <?php echo $pager->getNbResults() ?> result<?php echo $pager->getNbResults() > 1 ? 's' : '' ?>
    </td>
  </tr>
</table>
