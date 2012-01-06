<?php use_javascript('chart/highcharts.js') ?>
<?php use_javascript('chart/modules/exporting.js') ?>
<script type="text/javascript">
                        var data_height  = new Array(<?php echo $profile->getHeightJson(); ?>);
                        var names_height = new Array(<?php echo $profile->getDateOfHeightJson(); ?>);
                        var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container_height',
						defaultSeriesType: 'line'
					},
					title: {
						text: 'Reporte Historico de Talla'
					},
					subtitle: {
						text: 'Fuente: Salud Online'
					},
					xAxis: {
						categories: names_height
					},
					yAxis: {
						title: {
							text: 'Centimetros (cm.)'
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
						data: data_height
					}]
				}); });
			
    $(function(){
            $('#minimizar_height').click(
		function() { $('#table_toggle_height').toggle(); });
    });                            
</script>
<div class="portlet-header">
  Control de Talla
  <ul id="buttons_head">
    <li class="ui-state-default ui-corner-all" title="Registrar Talla">
      <?php echo link_to('<span class="ui-icon ui-icon-plus"></span>', '@height_new?slug='.$profile->getSlug(), array('id' => 'new_height'))?>
    </li>
    <li class="ui-state-default ui-corner-all" title="Ver Reporte">
      <a id="report_height" href="#container_height" title="Reporte Talla">
        <span class="ui-icon ui-icon-image"></span>
      </a>
    </li>
  </ul>
</div>
<div class="portlet-content">
<?php if($profile->getHeights()->count() > 0):?>
<table id="table_toggle_height">
  <tr>
    <!--<th>Id</th>-->
    <th>Talla</th>
    <th>Fecha de Registro</th>
    <th>Acciones</th>
  </tr>
  <?php foreach($profile->findMyLastHeights() as $key => $height):?>
  <tr>
    <!--<td><?php //echo $key+1; ?>                             </td>-->
    <td><?php echo $height->getCurrentHeight(); ?> cm.    </td>
    <td><?php echo $height->getFormattedDateOfHeight(); ?></td>
    <td>
        <ul id="buttons">
          <li class="ui-state-default ui-corner-all" title="Editar">
            <?php echo link_to('<span class="ui-icon ui-icon-pencil"></span>', '@height_edit?slug='.$height->getSlug(), array('id' => 'edit_height','rel' => 'group_height'))?>
          </li>
          <li class="ui-state-default ui-corner-all" title="Eliminar"> 
              <?php echo link_to('<span class="ui-icon ui-icon-trash"></span>', '@height_delete?slug='.$height->getSlug(), 'confirm=Realmente quieres eliminar este Registro?')?>
          </li>
        </ul>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>
</div>
<div style="display: none;">
  <div id="container_height" style="width: 670px; height: 670px; margin: 0"></div>
</div>