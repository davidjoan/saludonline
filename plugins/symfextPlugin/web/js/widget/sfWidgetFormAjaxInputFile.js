/**
 * sfWidgetFormAjaxInputFile.js
 * 
 * @package    symfext
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */

function sfWidgetFormAjaxInputFile(url, input_file_id, image_id, delete_button_id, image_loading_src)
{
	$(function ()
	{
		var uploadFunction = function ()
		{
			if ("" != image_loading_src)
			{
				$("#" + input_file_id).ajaxStart(function ()
				{
					loadingImage = $("<img/>").attr("src", image_loading_src).css("display", "inline").insertAfter($("#" + input_file_id));
					inputFile    = document.getElementById(input_file_id); // need to handle the input like this
				})
				.ajaxComplete(function ()
				{
					loadingImage.remove();
				})
			}
			
			$.ajaxFileUpload
			({
				url          : url,
				secureuri    : false,
				fileElementId: input_file_id,
				dataType     : 'json',
				success      : function (data, status)
				{
					inputFile.value = '';
					if ("SUCCESS" == data.status)
					{
						image = $("#" + image_id);
						var src = data.src + "?time=" + new Date(); // to avoid cache images
						image.attr("src", src).parent().attr("href", data.src);
						image.css("display", data.src ? "block" : "none");
						
						$("#" + delete_button_id).css("display", data.src ? "inline" : "none");
						
						inputFile.style.display = data.src ? "none" : "inline";
					}
					else
					{
						$("#msg_" + image_id).html(data.text).fadeOut(10000, function ()
						{
							$("#msg_" + image_id).html("").css("display", "block");
						});
					}
					
					$("#" + input_file_id).change(uploadFunction);
				},
				error        : function (data, status, e)
        {
          alert(e);
        }
			});
			
			return false;
		}
		
		$("#" + input_file_id).change(uploadFunction);
    $("#" + delete_button_id).click(uploadFunction);
	})
}
