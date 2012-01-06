/* ****************************************** Crud ************************************************ */

/*************************** List *******************************/

function toggleSlug(control, slug_field)
{
  var slugField = $("#" + slug_field);
  
  var slug = "[" + control.value + "]";
  var tr   = $(control).parents().filter("tr").get(0);
  if (control.checked)
  {
    slugField.val(slugField.val() + slug);
    $(tr).addClass("selected");
  }
  else
  {
    slugField.val(slugField.val().replace(slug, ""));
    $(tr).removeClass("selected");
  }
}

function getUrl(url, data)
{
  eval("data = " + data);
  
  for (var url_name in data)
  {
    field = data[url_name];
    
    var value = field.value ? field.value : $("#" + field.id).val();
    
    if (field.list)
    {
      value = value.substr(1, value.length - 2);
      value = value.replace(/\]\[/g, ",");
    }
    
    if (field.validate)
    {
      var values = value.split(",");
      if (value.length == 0)
      {
        alert("You must select a record to perform this action");
        return;
      }
      
      if (values.length > 1 && field.single)
      {
        alert("You can select just one record to perform this action");
        return;
      }
      
      if (field.to_delete)
      {
        if (!confirm("Do you really want to delete this record(s)?"))
        {
          return;
        }
      }
    }
    
    if (field.filter && value)
    {
      value = getUrlFromName(value);
    }
    
    value = value != "" ? value : 0;
    
    var field = "(.*)(/)?(" + url_name + ")(/)?(.*)(\3){0}";
    var re    = new RegExp(field);
    url       = url.replace(re, "$1$2" + value + "$4$5");
  }
  
  location.href = url;
}

function getUrlFromName(name)
{
  name = name.replace(/\./g, ' ');
  name = name.replace(/\s/g, '|');
  
  return name;
}

function executeListSearch(e)
{
  if (isEnter(e))
  {
    $("#button_list_search").click();
  }
}


function sortList(url)
{
  $(document).ready(function ()
  {
    $("#sort_list").sortable
    ({
      accept:      "sortable",
      opacity:     "0.5",
      update:      function(e, ui)
      {
        serial = $(this).sortable("serialize");
        $.ajax
        ({
          url:      url,
          type:     "POST",
          data:     serial,
          success:  function(feedback)
          {
          },
          error:    function()
          {
          }
        });
      }
    });
  });
}



/*************************** Edit *******************************/

function giveEditToggle()
{
  $(document).ready(function ()
  {
    $("div.crud_edit table.form th.title, div.crud_edit table.embedded_form th.title").click(function ()
    {
      $(this).parent().parent().children().not(":first").toggle();
    });
  })
}


function submitForm(form)
{
  var result = true;
  if (typeof(preSubmitForm) == "function")
  {
    result = preSubmitForm();
  }
  
  if (result)
  {
    document.getElementById("form_submit").click();
  }
}
