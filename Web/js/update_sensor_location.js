$(document).ready(function() {
var mapCenter = new google.maps.LatLng(1.296372, 103.775313); //Google map Coordinates
var map;
map_initialize(); // load map
function map_initialize(){
    //Google map option
    var googleMapOptions = 
    { 
        center: mapCenter, // map center
        zoom: 17, //zoom level, 0 = earth view to higher value
        panControl: true, //enable pan Control
        zoomControl: true, //enable zoom control
        zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL //zoom control size
        },
        scaleControl: true, // enable scale control
        mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
    };
    map = new google.maps.Map(document.getElementById("google_map"), googleMapOptions); 
    
    //Load Markers from the XML File, Check (map_process.php)
	$.get("map_process.php", function (data) {
		$(data).find("marker").each(function () {
			 //Get user input values for the marker from the form
			  var name      = $(this).attr('name');
			  var address   = '<p>'+ $(this).attr('address') +'</p>';
			  var type      = $(this).attr('type');
			  var point     = new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));

			  //call create_marker() function for xml loaded maker
			  create_marker(point, name, address, false, false, false, "/img/pin_blue.png");
		});
	}); 
	
	
	//##### drop a new marker on right click ######
    google.maps.event.addListener(map, 'rightclick', function(event) {
		//Edit form to be displayed with new marker
		var EditForm = '<p><div class="marker-edit">'+
		'<form action="ajax-save.php" method="POST" name="SaveMarker" id="SaveMarker">'+
		'<label for="pName"><span>Place Name :</span><input type="text" name="pName" class="save-name" placeholder="Enter Title" maxlength="40" /></label>'+
		'<label for="pDesc"><span>Description :</span><textarea name="pDesc" class="save-desc" placeholder="Enter Address" maxlength="150"></textarea></label>'+
		'<label for="pType"><span>Type :</span> <select name="pType" class="save-type"><option value="restaurant">Rastaurant</option><option value="bar">Bar</option>'+
		'<option value="house">House</option></select></label>'+
		'</form>'+
		'</div></p><button name="save-marker" class="save-marker">Save Marker Details</button>';

	//call create_marker() function
	create_marker(event.latLng, 'New Marker', EditForm, true, true, true, "/img/pin_green.png");
        
	});
}

//############### Create Marker Function ##############
function create_marker(MapPos, MapTitle, MapDesc,  InfoOpenDefault, DragAble, Removable, iconPath)
{                 
    //new marker
    var marker = new google.maps.Marker({
        position: MapPos,
        map: map,
        draggable:DragAble,
        animation: google.maps.Animation.DROP,
        title:"Hello World!",
        icon: iconPath
    });
    
    //Content structure of info Window for the Markers
    var contentString = $('<div class="marker-info-win">'+
    '<div class="marker-inner-win"><span class="info-content">'+
    '<h1 class="marker-heading">'+MapTitle+'</h1>'+
    MapDesc+ 
    '</span><button name="remove-marker" class="remove-marker" title="Remove Marker">Remove Marker</button>'+
    '</div></div>');    

    
    //Create an infoWindow
    var infowindow = new google.maps.InfoWindow();
    //set the content of infoWindow
    infowindow.setContent(contentString[0]);

    //Find remove button in infoWindow
    var removeBtn   = contentString.find('button.remove-marker')[0];

   //Find save button in infoWindow
    var saveBtn     = contentString.find('button.save-marker')[0];

    //add click listner to remove marker button
    google.maps.event.addDomListener(removeBtn, "click", function(event) {
        //call remove_marker function to remove the marker from the map
        remove_marker(marker);
    });
    
    if(typeof saveBtn !== 'undefined') //continue only when save button is present
    {
        //add click listner to save marker button
        google.maps.event.addDomListener(saveBtn, "click", function(event) {
            var mReplace = contentString.find('span.info-content'); //html to be replaced after success
            var mName = contentString.find('input.save-name')[0].value; //name input field value
            var mDesc  = contentString.find('textarea.save-desc')[0].value; //description input field value
            var mType = contentString.find('select.save-type')[0].value; //type of marker
            
            if(mName =='' || mDesc =='')
            {
                alert("Please enter Name and Description!");
            }else{
                //call save_marker function and save the marker details
                save_marker(marker, mName, mDesc, mType, mReplace);
            }
        });
    }
    
    //add click listner to save marker button        
    google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker); // click on marker opens info window 
    });
      
    if(InfoOpenDefault) //whether info window should be open by default
    {
      infowindow.open(map,marker);
    }
}

//############### Remove Marker Function ##############
function remove_marker(Marker)
{
    /* determine whether marker is draggable 
    new markers are draggable and saved markers are fixed */
    if(Marker.getDraggable()) 
    {
        Marker.setMap(null); //just remove new marker
    }
    else
    {
        //Remove saved marker from DB and map using jQuery Ajax
        var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
        var myData = {del : 'true', latlang : mLatLang}; //post variables
        $.ajax({
          type: "POST",
          url: "map_process.php",
          data: myData,
          success:function(data){
                Marker.setMap(null); 
                alert(data);
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //throw any errors
            }
        });
    }
}

//############### Save Marker Function ##############
function save_marker(Marker, mName, mAddress, mType, replaceWin)
{
    //Save new marker using jQuery Ajax
    var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
    var myData = {name : mName, address : mAddress, latlang : mLatLang, type : mType }; //post variables
    console.log(replaceWin);        
    $.ajax({
      type: "POST",
      url: "map_process.php",
      data: myData,
      success:function(data){
            replaceWin.html(data); //replace info window with new html
            Marker.setDraggable(false); //set marker to fixed
            Marker.setIcon('/img/pin_green.png'); //replace icon
        },
        error:function (xhr, ajaxOptions, thrownError){
            alert(thrownError); //throw any errors
        }
    });
}

});
