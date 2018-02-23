<!-- VIEW -->
<div id="show-modal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-container w3-blue">
      <span onclick="document.getElementById('show-modal').style.display='none'" class="w3-closebtn">&times;</span>
      <h5>View</h5>
      <input type="hidden" id="image-value">
    </div>
    <div class="w3-center"><img id="item-image" src="#" style="max-height:700px;max-width:100%;"/></div>
  </div>
</div>
<!-- END VIEW -->

<?php
$lat = $_GET['lat'];
$lng = $_GET['lng'];
?>

<script>
var map;
getmarkers = [];
var mainUrl = 'http://onebit.asia/data/';

function initialize(){
    var styles = [{ stylers: [{ hue:"#0077FF" },{ saturation:100 }] }];

    var center = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lng;?>);
    map = new google.maps.Map(document.getElementById('googleMap'),{
        center: center,
        zoom: 15,
        styles: styles
    });

    getMarker(center,"","marker","Position","Target");

    function getMarker(location,icon,category,title,description){
        var marker = new google.maps.Marker({
            map: map,
            position: location,
            //icon: setIcon(icon),
            category: category
        });
        google.maps.event.addListener(marker,'click',function(){
            createInfoWindow(marker,title,description);
        });
        getmarkers.push(marker);
    }

    function createInfoWindow(marker,title,description){
        var infowindow = new google.maps.InfoWindow({ content: '' });
        infowindow.setContent(contentInfoWindow(title,description));
        infowindow.open(map, marker);
        map.panTo(marker.getPosition());
        google.maps.event.addListener(map,'click',function(){
            infowindow.close();
        });
    }

    function contentInfoWindow(title,description){
        var c = '';
        c += '<div class="w3-row w3-blue">',
        c +=    '<div class="w3-indigo w3-padding-small w3-large"><b>'+title+'</b></div>',
        c +=        '<div class="w3-padding-small">',
        c +=            '<div class="w3-row">'+description+'</div>',
        c +=        '</div>',
        c += '</div>';
        return c;
    }

    function createDescriptionInfoWindow(pengirim,waktupengaduan,isi,img){
        var c = '';
        c += '<div>',
        c += '<span class="w3-text-white"><b>'+pengirim+'</b></span> <span class="w3-small w3-text-light-grey">- '+waktupengaduan+'</span>',
        c += '<hr>',
        c += '<div class="w3-center"><span class="w3-text-white"><i>"'+isi+'"</i></span></div>',
        c += '<img onclick="showPicture(`'+img+'`)" src="'+mainUrl+'aw-uploads/images/201702/compress400/'+img+'" style="max-width:100%;max-height:250px;cursor:pointer">',
        c += '</div>';
        return c;
    }
}

function setIcon(url){
    var image = {
        url: url,
        scaledSize: new google.maps.Size(40, 40)
    };
    return image;
}

function getDirections(source,destination){
    window.open('http://maps.google.com/?saddr='+source+'&daddr='+destination);
}

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8TLRYpMLYcS_4JZpTVrfVwkA8e4CLOp4&callback=initialize"></script>

<div id="googleMap" style="width:100%;height:100%;color:black;bottom:50px"></div>