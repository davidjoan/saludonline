<?php use_javascript('chart/highcharts.js') ?>
<?php use_javascript('chart/modules/exporting.js') ?>
<script type="text/javascript">
                        var data_weight   = new Array(<?php echo $profile->getWeightJson(); ?>);
                        var names_weight  = new Array(<?php echo $profile->getDateOfWeightJson(); ?>);
                        var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						defaultSeriesType: 'line'
					},
					title: {
						text: 'Reporte Historico de Peso'
					},
					subtitle: {
						text: 'Fuente: Salud Online'
					},
					xAxis: {
						categories: names_weight
					},
					yAxis: {
						title: {
							text: 'Peso (Kg)'
						}
					},
					tooltip: {
						enabled: false,
						formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y +'°C';
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: '<?php echo $profile->getFullname(); ?>',
						data: data_weight
					}]
				});
				
				
			});
    $(function(){
    $('ul#buttons li, ul#buttons_head li'). hover(
		function() { $(this).addClass('ui-state-hover'); }
	);
            $('#minimizar').click(
		function() { $('#table_toggle_weight').toggle(); }
	);            
    $("#new_weight, a[rel=group], #new_height,a[rel=group_height]").fancybox({
                                'scrolling'     : 'no',
				'opacity'	: true,
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
                                'width'		: 575,
				'height'	: 575,
				'autoScale'	: true,
                                'titlePosition'	: 'outside',
				'type'		: 'iframe',
                                'enableEscapeButton' :	true,
                                'onClosed': function() {parent.location.reload(true);}
			});
    $("#report_weight, #report_height").fancybox({
                                'scrolling'     : 'no',
				'opacity'	: true,
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
                                'width'		: 575,
				'height'	: 575,
				'autoScale'	: true,
                                'titlePosition'	: 'outside',
                                'enableEscapeButton' :	true
			});         
    });
</script>
<div class="portlet-header">
  Control de Peso
          <ul id="buttons_head">
            <li class="ui-state-default ui-corner-all" title="Registrar Peso">
              <?php echo link_to('<span class="ui-icon ui-icon-plus"></span>', '@weight_new?slug='.$profile->getSlug(), array('id' => 'new_weight','title'=> 'Agregar Registro de Peso'))?>
            </li>
            <li class="ui-state-default ui-corner-all" title="Ver Reporte">
                <a id="report_weight" href="#container" title="Reporte">
                  <span class="ui-icon ui-icon-image"></span>
                </a>
            </li>
          </ul>
</div>
<div class="portlet-content">        
<?php if($profile->getWeights()->count() > 0):?>
<table id="table_toggle_weight">
  <tr>
    <!--<th>Id</th>-->
    <th>Peso</th>
   <!-- <th>Peso Esperado</th> -->
    <th>Fecha de Registro</th>
    <th>Acciones</th>
  </tr>
  <?php foreach($profile->findMyLastWeights() as $key => $weight):?>
  <tr>
    <!--<td><?php //echo $key+1; ?>                             </td>-->
    <td><?php echo $weight->getCurrentWeight(); ?> Kg.    </td>
    <!--<td><?php //echo $weight->getExpectedWeight();?> Kg.    </td>-->
    <td><?php echo $weight->getFormattedDateOfWeight(); ?></td>
    <td>
        <ul id="buttons">
          <li class="ui-state-default ui-corner-all" title="Editar">
            <?php echo link_to('<span class="ui-icon ui-icon-pencil"></span>', '@weight_edit?slug='.$weight->getSlug(), array('id' => 'edit_weight','title'=> 'Editar Registro de Peso', 'rel' => 'group'))?>
          </li>
          <li class="ui-state-default ui-corner-all" title="Eliminar"> 
              <?php echo link_to('<span class="ui-icon ui-icon-trash"></span>', '@weight_delete?slug='.$weight->getSlug(), 'confirm=Realmente quieres eliminar este Registro?')?>
          </li>
        </ul>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>
</div>    
<div style="display: none;">
  <div id="container" style="width: 670px; height: 670px; margin: 0"></div>
</div>