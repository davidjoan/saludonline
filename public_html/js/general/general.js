/* ************************************** General ************************************************* */

function stopEventPropagation(e)
{
	var event = e || window.event;
  
  if (event.stopPropagation)
	{
	  event.stopPropagation();
  }
	else
	{
	  event.cancelBubble = true;
  }
}

function isEnter(e)
{
  if (e.keyCode == 13)
  {
    return true;
  }
  
  return false;
}

function giveEditToggle()
{
	$(document).ready(function ()
	{
	  $("div.crud_edit table.form th.title, div.crud_edit table.embedded_form th.title, table.tr.td.ul.li, ul#buttons li ui-icon ui-icon-circlesmall-minus").click(function ()
	  {
	    $(this).parent().parent().children().not(":first").toggle();
	  });
	})
}