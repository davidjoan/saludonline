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

$.fn.clearForm = function()
{
  return this.each(function()
  {
    var type = this.type, tag = this.tagName.toLowerCase();
    if (tag == 'form')
      return $(':input',this).clearForm();
    if (type == 'text' || type == 'password' || tag == 'textarea')
      this.value = '';
    else if (type == 'checkbox' || type == 'radio')
      this.checked = false;
    else if (tag == 'select')
      this.selectedIndex = -1;
  });
};
