<script type="text/javascript">
    $(function(){
            $('#minimizar_treatment').click(
		function() { $('#table_toggle_treatment').toggle(); });
                
    $("#new_treatment").fancybox({
                               // 'scrolling'     : 'no',
				'opacity'	: true,
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
                                'width'		: 675,
				'height'	: 675,
				'autoScale'	: true,
                                'titlePosition'	: 'outside',
				'type'		: 'iframe',
                                'enableEscapeButton' :	true,
                                'onClosed': function() {parent.location.reload(true);}
			});                
    $("a[rel=group_treatment]").fancybox({
				'opacity'	: true,
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
                                'width'		: 575,
				'height'	: 675,
				'autoScale'	: true,
                                'titlePosition'	: 'outside',
				'type'		: 'iframe',
                                'enableEscapeButton' :	true,
                                'onClosed': function() {parent.location.reload(true);}
			});                        
    });                            
</script>
<table>
    <tr>
        <td style="border-width: 0px; padding: 0;" id="title"><h4>Ultimos Diagnósticos</h4></td>
        <td style="border-width: 0px; padding: 0;">
          <ul id="buttons_head">
            <li class="ui-state-default ui-corner-all" title="Registrar Diagnostico">
              <?php echo link_to('<span class="ui-icon ui-icon-plus"></span>', '@treatment_new?slug='.$profile->getSlug(), array('id' => 'new_treatment'))?>
            </li>
            <li class="ui-state-default ui-corner-all" title="Mostrar/Ocultar">
              <span id="minimizar_treatment" class="ui-icon ui-icon-circlesmall-minus"></span>
            </li>
          </ul>
        </td>
    </tr>
</table>

<?php if($profile->getTreatments()->count() > 0):?>
<table id="table_toggle_treatment">
  <tr>
    <th>Id</th>
    <th>Doctor</th>
    <th>Diagnostico</th>
    <th>Fecha de Registro</th>
    <th>Acciones</th>
  </tr>
  <?php foreach($profile->findMyLastTreatments() as $key => $treatment):?>
  <tr>
    <td><?php echo $key+1; ?>                                   </td>
    <td><?php echo $treatment->getDoctor()->getFullname(); ?>   <br/><?php echo $treatment->getHospital()->getName(); ?></td>
    <td><?php echo $treatment->getDiagnosisNames(); ?>          </td>
    <td><?php echo $treatment->getFormattedDateOfTreatment(); ?></td>
    <td>
        <ul id="buttons">
          <li class="ui-state-default ui-corner-all" title="Editar">
            <?php echo link_to('<span class="ui-icon ui-icon-pencil"></span>', '@treatment_edit?slug='.$treatment->getSlug(), array('id' => 'edit_treatment','rel' => 'group_treatment'))?>
          </li>
          <li class="ui-state-default ui-corner-all" title="Eliminar"> 
              <?php echo link_to('<span class="ui-icon ui-icon-trash"></span>', '@treatment_delete?slug='.$treatment->getSlug(), 'confirm=Realmente quieres eliminar este Registro?')?>
          </li>
        </ul>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>