/**
 * sfDynamicFormEmbedder.js
 * 
 * This file has the functions related with the sfDynamicFormEmbedder PHP class.
 * 
 * @package    symfext
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */

function addDynamicForm(name, container_name, img_loading_src, url_get_attribute_value, url_add_dynamic_form, event)
{
	stopEventPropagation(event);
	
	var containerTable = $("#" + container_name);
	var imageLoading = $("<tr><td><img src='" + img_loading_src + "' /></td/</tr>");
	
	// if a "GET" request and need new return values must add in the params rand = Math.random() because of IE caching
	// if a "POST" request then the workaround is not needed
	$.ajax 
	({
		type           : "GET",
		url            : url_get_attribute_value,
		data           : { "attribute": name + "_forms_count", "namespace": "General", "rand": Math.random()},
		dataType       : "json",
		beforeSend     : function ()
		                 {
										   containerTable.append(imageLoading);
										 },
		success        : function (form_count)
		                 {
											 form_count++;
											 
											 var tableRow = $("<tr/>");
											 containerTable.append(tableRow);
											 
											 tableRow.load(url_add_dynamic_form, { "name": name }, function () 
											 {
											 	 imageLoading.remove();
												 
												 $("#" + name + "_" + form_count + " th.title").click(function()
												 {
												   $(this).parent().parent().children().not(":first").toggle();
												 });
											 });
										 }
	});
	
	return false;
}

function removeDynamicForm(name, form_count, url_remove_dynamic_form, event)
{
	stopEventPropagation(event);
	
  if (!confirm("Are you sure about removing this form?"))
  {
  	return false;
  }
  
  $("#" + name + "_" + form_count).parent().parent().remove();
	
	$.get(url_remove_dynamic_form, { "name": name, "form_count" : form_count, "rand" : Math.random() });
	
	return false;
}
