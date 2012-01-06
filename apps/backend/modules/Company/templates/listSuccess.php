<?php slot('title') ?>
  Company
<?php end_slot() ?>

<?php include_component('Crud', 'list', array
      (
        'pager'              => $pager,
                                
        'uri'                => '@company_list?filter_by=filter_by&filter=filter&order_by=order_by&order=order&max=max&page=page',
                                
        'edit_field'         => 'name',
        'filter_fields'      => array
                                (
                                  'name'         => 'Name'
                                ),
        'columns'            => array
                                (
                                  array('2' , ''             , ''            , ''              ),
                                  array('20', 'name'         , 'Name'        , 'getName'       ),
                                  array('20', 'address'      , 'Address'     , 'getAddress'    ),
                                  array('20', 'phones'       , 'Phones'      , 'getPhones'     ),
                                  array('20', 'mail'         , 'Mail'        , 'getMail'       ),
                                  array('2' , ''             , ''            , 'checkbox'      ),
                                ),
        'buttons'            => array('delete' => false,'add' => false)                                
      ))
?>
