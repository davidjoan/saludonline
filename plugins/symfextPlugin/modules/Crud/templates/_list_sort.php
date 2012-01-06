<table class="list">
  <tr>
    <?php foreach ($listColumns as $listColumn): ?>
      <th class="column_title" align="<?php echo $listColumn->align ?>" width="<?php echo $listColumn->columnWidth ?>%"><?php echo $listColumn->title ?></th>
    <?php endforeach ?>
  </tr>
</table>

<ul id="sort_list" class="sort_list">
  <?php foreach ($pager->getResults() as $record): ?>
    <li id="item_<?php echo $record->getId() ?>" class="sortable">
      <table class="list">
        <tr class="normal_row">
        
          <?php foreach ($listColumns as $listColumn): ?>
            <td  align="<?php echo $listColumn->align ?>" width="<?php echo $listColumn->columnWidth ?>%">
              <?php if ($listColumn->method == 'partial'): ?>
                <?php include_partial($modelClass.'/'.$listColumn->field, array($usClass => $record)) ?>
              <?php elseif ($listColumn->method == 'checkbox'): ?>
                <input type="checkbox" id="<?php echo $record->getSlug() ?>" name="<?php echo $record->getSlug() ?>" value="<?php echo $record->getSlug() ?>" onclick="toggleSlug(this, '<?php echo $usClass ?>_slug')" />
              <?php else: ?>
                <?php if ($listColumn->field == '' || $record->{$listColumn->method}() == ''):?>
                  &nbsp;
                <?php elseif ($listColumn->field == $edit_field):?>
                  <?php echo link_to($record->{$listColumn->method}(), sprintf($edit_uri, $usClass).'?slug='.$record->getSlug()) ?>
                <?php else: ?>
                  <?php echo $record->{$listColumn->method}() ?>
                <?php endif ?>
              <?php endif ?>
            </td>
          <?php endforeach ?>
          
        </tr>
      </table>
    </li>
  <?php endforeach ?>
</ul>

<table class="list">
  <tr>
    <?php foreach ($listColumns as $listColumn): ?>
      <th class="column_title" align="<?php echo $listColumn->align ?>" width="<?php echo $listColumn->columnWidth ?>%"><?php echo $listColumn->title ?></th>
    <?php endforeach ?>
  </tr>
</table>

<?php echo javascript_tag(sprintf('sortList("%s")', $sort_url)) ?>
