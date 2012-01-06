/**
 * sfWidgetFormJQueryCompleterDoubleList.js
 * 
 * @package    symfext
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */

var sfWidgetFormJQueryCompleterDoubleList =
{
  init: function(id, className)
  {
		var associated_div = id + "_associated_div";
		
    form = sfWidgetFormJQueryCompleterDoubleList.get_current_form(document.getElementById(id));
		
		$(form).submit(function ()
		{
			sfWidgetFormJQueryCompleterDoubleList.submit(id);
		});
    
    $("#" + id + " option").each(function (key, object)
    {
      $("#" + associated_div).append($("<div></div").html($(object).text()).addClass("option")
      .click
      (
        function ()
        {
          if ($(this).hasClass("selected"))
          {
            $(this).removeClass("selected");
          }
          else
          {
            $("#" + associated_div + " div.selected").removeClass("selected");
            
            $(this).addClass("selected");
          }
        }
      )
      .hover
      (
        function () { $(this).addClass("hover"); },
        function () { $(this).removeClass("hover"); }
      )
      .append("<input type='hidden' value='" + $(object).val() +  "'"));
    });
  },
  
  associate: function(id)
  {
    var associated_div = id + "_associated_div";
    var value = $("#list_" + id + "_search div.selected :input").val();
    if ($("#" + associated_div + " div :input[value=" + value + "]").length == 0 && value)
    {
      $("#" + associated_div).append($("<div></div").html($("#list_" + id + "_search div.selected").html()).addClass("option")
      .click
      (
        function ()
        {
          if ($(this).hasClass("selected"))
          {
            $(this).removeClass("selected");
          }
          else
          {
            $("#" + associated_div + " div.selected").removeClass("selected");
            
            $(this).addClass("selected");
          }
        }
      )
      .hover
      (
        function () { $(this).addClass("hover"); },
        function () { $(this).removeClass("hover"); }
      ));
    }
  },
  
  disassociate: function(id)
  {
		var associated_div = id + "_associated_div";
		
    $("#" + associated_div + " div.selected").remove();
  },

  submit: function(id)
  {
		var associated_div = id + "_associated_div";
    
    $("#" + id).empty();
    
    $("#" + associated_div + " div input").each(function (index)
		{
      $("#" + id).append($("<option selected='selected'></option>").val($(this).val()));
    });
  },

  get_current_form: function(el)
  {
    if ("form" != el.tagName.toLowerCase())
    {
      return sfWidgetFormJQueryCompleterDoubleList.get_current_form(el.parentNode);
    }
    
    return el;
  }
}
