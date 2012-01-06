<?php slot('title') ?>
  Specialty
<?php end_slot() ?>

<?php include_component('Crud', 'list', array
      (
        'pager'              => $pager,
                                
        'uri'                => '@specialty_list?filter_by=filter_by&filter=filter&order_by=order_by&order=order&max=max&page=page',
                                
        'edit_field'         => 'name',
        'filter_fields'      => array
                                (
                                  'code'         => 'Code',
                                  'name'         => 'Name',
                                ),
        'columns'            => array
                                (
                                  array('2' , ''             , ''            , ''              ),
                                  array('20', 'code'     , 'Code'       , 'getCode'   ),
                                  array('20', 'name'     , 'Name'    , 'getName'   ),
                                  array('2' , ''             , ''            , 'checkbox'      ),
                                )
      ))
?>
