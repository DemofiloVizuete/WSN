// This file is based on jquery ajax.
// You don't have to make use of jquery. You can use prototype, mootools or your
// own ajax call.


function saveAlert()
{
    notify("saving", "Saving data...");
}

function notify(icon, content)
{
    $("#notification").html("<img src='core/images/"+icon+"' style='float: left; margin-right: 15px;' />");
    $("#notification").append(content);
    $("#notification").show();
}

function endnotify()
{
    $("#notification").hide();
}

function fadenotify()
{
    setTimeout( function()
      {
         $("#notification").fadeOut(3000);
      }, 3000);
}

function complex_ajax_call(form_id,output_id,section,plugin,action)
{
    // This script will serialize the form indicated by an id and submit it
    // to the desired page.
    // Once the response has arrived it display the response inside the id
    // defined in output_id
    //var fields = $("#"+form_id+" :input").serializeArray();
    if (!ms_check_form_fields(form_id))
    {
        document.body.style.cursor = 'wait';
        var json_field=json_encode(form_id);
        submit_data="section="+section+"&plugin="+plugin+"&type=complex&action="+action+"&form_fields="+json_field;
        //alert (submit_data);
        notify("loadinfo.net.gif", "Loading...");

        $.ajax({
                   type: "POST",
                   url: "index.php",
                   data: submit_data,
                   success: function(datos){
                          document.body.style.cursor = 'default';
                           // A JSON array is expected
                          var ret = eval('(' + datos + ')');
                          $.each(ret.item, function(i,item){
                              if (item['type']=="script")
                              {
                                  eval(item['value']);
                              }
                              else if (item['type']=="html")
                              {
                                  $('#'+item['id']).html(item['value']);
                              }
                              else if (item['type']=="value")
                              {
                                  $('#'+item['id']).val(item['value']);
                              }
                              else if (item['type']=="append")
                              {
                                  $('#'+item['id']).append(item['value']);
                              }
                              else if (item['type']=="return")
                              {
                                  $('#'+output_id).html(item['value']);
                              }
                          });
                   }
                });
    }
}

function put_help(string)
{
	$('#help').html(string);
}