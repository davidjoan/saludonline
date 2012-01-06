<?php slot('title') ?>
  Sponsor
<?php end_slot() ?>

<?php include_component('Crud', 'list', array
      (
        'pager'              => $pager,
                                
        'uri'                => '@sponsor_list?filter_by=filter_by&filter=filter&order_by=order_by&order=order&max=max&page=page',
                                
        'edit_field'         => 'name',
        'filter_fields'      => array
                                (
                                  'name'         => 'Name',
                                  'url'          => 'Url',
                                  'description'  => 'Description'
                                ),
        'columns'            => array
                                (
                                  array('2' , ''             , ''            , ''              ),
                                  array('20', 'name'         , 'Name'        , 'getName'       ),
                                  array('20', 'url'          , 'Url'         , 'getUrl'        ),
                                  array('20', 'description'  , 'Description' , 'getDescription'),
                                  array('2' , ''             , ''            , 'checkbox'      ),
                                )
      ))
?>
