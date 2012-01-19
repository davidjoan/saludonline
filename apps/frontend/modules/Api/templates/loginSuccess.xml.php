<?php header("Content-Type:text/xml"); ?>
<user>
<?php foreach ($object as $key => $value): ?>
    <<?php echo $key ?>><?php echo $value ?></<?php echo $key ?>>
<?php endforeach ?>
</user>
