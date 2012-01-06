<style>
	.column { width: 365px; float: left; padding-bottom: 100px; }
	.portlet { margin: 0 1em 1em 0; }
	.portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }
	.portlet-header .ui-icon { float: right; }
	.portlet-content { padding: 0.4em; }
	.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
	.ui-sortable-placeholder * { visibility: hidden; }
	</style>
	<script>
	$(function() {
		$( ".column" ).sortable({
			connectWith: ".column"
		});

		$( ".portlet" ).addClass( "ui-helper-clearfix ui-corner-all" )
			.find( ".portlet-header" )
				.addClass( "ui-widget-header ui-corner-all" )
				.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
				.end()
			.find( ".portlet-content" );

		$( ".portlet-header .ui-icon" ).click(function() {
			$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
			$( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
		});

		$( ".column" ).disableSelection();
	});
	</script>
<?php include_partial('Profile/resume', array('profile' =>  $object, 'redirect' => false));?>
        
<div class="post">
  <?php include_partial('Profile/treatment', array('profile' =>  $object));?>    
</div>
        
<div class="demo">
  <div class="column">
    <div class="portlet">
      <?php include_partial('Profile/weight', array('profile' =>  $object));?>
    </div>
  </div>
  <div class="column">
    <div class="portlet">
      <?php include_partial('Profile/height', array('profile' =>  $object));?>
    </div>
  </div>
</div>