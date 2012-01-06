/**
 * sfWidgetFormJQueryCompleterList.js
 * 
 * @package    symfext
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */

sfWidgetFormJQueryCompleterList = function (options, input, select, config)
{
	var data, term = "";
	var id         = "#" + options.id;
	var list_id    = "#list_" + options.id;
	
	function fillList()
	{
		$(list_id).empty();
		
		$.each(data, function(key, value)
		{
			$(list_id).append($("<div></div").html(value.content).addClass("option")
			.click(function ()
			{
				if ($(this).hasClass("selected"))
				{
					$(this).removeClass("selected");
					$(id).val("");
				}
				else
				{
					$(list_id + " div.selected").removeClass("selected");
					$(this).addClass("selected");
					
					$(id).val($(list_id + " div.selected :input").val());
				}
		  })
			.hover
      (
        function () { $(this).addClass("hover"); },
        function () { $(this).removeClass("hover"); }
      )
			.append("<input type='hidden' value='" + value.id +  "'/>"));
		});
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
		empty  : function () { $(list_id).empty() },
		show   : function () { }
	}
	
	return ret;
}
