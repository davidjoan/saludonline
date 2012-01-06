<?php slot('title') ?>
  Posts
<?php end_slot() ?>

<?php include_component('Crud', 'list', array
      (
        'pager'              => $pager,
                                
        'uri'                => '@post_list?filter_by=filter_by&filter=filter&order_by=order_by&order=order&max=max&page=page',
                                
        'edit_field'         => 'title',
        'filter_fields'      => array
                                (
                                  'title'         => 'Title', 
                                  'user_realname' => 'Author', 
                                ),
        'columns'            => array
                                (
                                  array('2' , ''             , ''        , ''               ),
                                  array('20', 'title'        , 'Title'   , 'getTitle'       ),
                                  array('20', 'user_realname', 'Author'  , 'getUserRealname'),
                                  array('30', 'datetime'     , 'Datetime', 'getDatetime'    ),
                                  array('26', 'status'       , 'Status'  , 'getStatusName'  ),
                                  array('2' , ''             , ''        , 'checkbox'       ),
                                )
      ))
?>
