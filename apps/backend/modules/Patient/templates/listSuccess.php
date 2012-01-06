<?php slot('title') ?>
  Patient
<?php end_slot() ?>

<?php include_component('Crud', 'list', array
      (
        'pager'              => $pager,
                                
        'uri'                => '@patient_list?filter_by=filter_by&filter=filter&order_by=order_by&order=order&max=max&page=page',
                                
        'edit_field'         => 'realname',
        'filter_fields'      => array
                                (
                                  'name'         => 'Name'
                                ),
        'columns'            => array
                                (
                                  array('2' , ''             , ''            , ''              ),
                                  array('20', 'realname'     , 'Names'       , 'getRealname'   ),
                                  array('20', 'username'     , 'Username'    , 'getUsername'   ),
                                  array('20', 'email'        , 'Email'       , 'getEmail'      ),
                                  array('20', 'phone'        , 'Phone'       , 'getPhone'      ),
                                  array('2' , ''             , ''            , 'checkbox'      ),
                                )
      ))
?>
