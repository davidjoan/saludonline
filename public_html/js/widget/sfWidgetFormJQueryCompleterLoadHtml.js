/**
 * sfWidgetFormJQueryCompleterLoadHtml.js
 * 
 * @package    symfext
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */

sfWidgetFormJQueryCompleterLoadHtml = function (options, input, select, config, div_id)
{
	var data, term = "";
	
	function fillList()
	{
		$("#" + div_id).html(data);
	}
	
	var ret =
	{
		display: function (d, q)
		{
			data = d,
			term = q;
			fillList();
		},
		visible: function () { },
		hide   : function () { },
		empty  : function () { $("#" + div_id).empty() },
		show   : function () { }
	}
	
	return ret;
}
