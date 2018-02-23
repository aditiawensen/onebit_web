<?php
    if($_SESSION['ses_level']!="adminpengaduan") {
        header('location:index.php?affect=login');
    }
?>

<script>
$(document).ready(function(){
    $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="logout.php" class="w3-hover-blue w3-tooltip"><i class="fa fa-sign-out"></i><span style="position:absolute;right:50px;bottom:17px" class="w3-border w3-border-blue w3-text w3-tag w3-small w3-round-large">Logout</span></a></li>`);
});
</script>

<!-- VIEW -->
<div id="show-modal" class="w3-modal" onclick="this.style.display='none'">
	<span class="w3-button w3-black w3-hover-red w3-xlarge w3-display-topright">&times;</span>
  	<div class="w3-modal-content w3-animate-zoom">
  		<div class="w3-row w3-center w3-black w3-padding-tiny">
  			<span id="item-text" class="w3-small w3-text-white"></span>
  		</div>
     	<img id="item-image" src="#" style="width:100%">
    </div>
</div>
<!-- END VIEW -->

<script>
var map;
getmarkers = [];
var onebitUrl = 'http://onebit.asia/';
var mainUrl = 'http://onebit.asia/data/';

function initialize(){
    var styles = [{ stylers: [{ hue:"#000000" },{ saturation:100 }] }];

    var center = new google.maps.LatLng(1.4447044,125.1822173);
    map = new google.maps.Map(document.getElementById('googleMap'),{
        center: center,
        zoom: 15,
        styles: [
            {elementType: 'geometry', stylers: [{color: '#0099FF'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#00FF00'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#FF66CC'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#FFFFFF'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#FFFFFF'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#003377'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
        ],
        mapTypeControl: true,
          mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
              position: google.maps.ControlPosition.BOTTOM_CENTER
          },
          zoomControl: true,
          zoomControlOptions: {
              position: google.maps.ControlPosition.RIGHT_CENTER
          },
          scaleControl: true,
          streetViewControl: true,
          streetViewControlOptions: {
              position: google.maps.ControlPosition.BOTTOM_CENTER
          },
          fullscreenControl: true,
          fullscreenControlOptions: {
            position: google.maps.ControlPosition.BOTTOM_CENTER
          }
    });

    loadMarkerFirst();
    //setInterval(function(){loadMarkerNew()},5000);

    function loadMarkerFirst(){
        $.getJSON(mainUrl+'load-data-pengaduan.php?lastId=100&startRow=0&limitRow=100&idDevice=777',function(result){
            $.each(result,function(i,data){
                if(data.posisi_lat_pengaduan>0 || data.posisi_lng_pengaduan>0){
                    getMarker(new google.maps.LatLng(data.posisi_lat_pengaduan,data.posisi_lng_pengaduan),data.status_pengaduan+data.icon_kategori,[data.id_kategori,data.id_sub_kategori,data.id_pengaduan],data.kategori,createDescriptionInfoWindow(data.status_pengaduan+data.icon_kategori,data.pengirim_pengaduan,mainUrl+'aw-uploads/profile/'+data.gambar_pengirim_pengaduan,data.waktu_pengaduan,data.isi_pengaduan,mainUrl+'aw-uploads/'+data.link_gambar+'compress700/'+data.gambar_pengaduan,mainUrl+'aw-uploads/'+data.link_gambar+'compress700/'+data.gambar_pengaduan));
                }
            });
        }).complete(function(){
            createFilterCategory();
            createFilterSubCategory();
        });
    }

    function loadMarkerNew(){
        $.getJSON(mainUrl+'load-data-pengaduan-baru.php',function(result){
            $.each(result,function(i,data){
                if(data.posisi_lat_pengaduan>0 || data.posisi_lng_pengaduan>0){
                    var result = 0;
                    for (var i = getmarkers.length - 1; i >= 0; i--) {
                        if(getmarkers[i].category[2]==data.id_pengaduan){
                            result = 1;
                        }
                    }
                    if(result < 1){
                        getMarkerAnimation(new google.maps.LatLng(data.posisi_lat_pengaduan,data.posisi_lng_pengaduan),data.status_pengaduan+data.icon_kategori,[data.id_kategori,data.id_sub_kategori,data.id_pengaduan],data.kategori,createDescriptionInfoWindow(data.status_pengaduan+data.icon_kategori,ata.pengirim_pengaduan,mainUrl+'aw-uploads/profile/'+data.gambar_pengirim_pengaduan,data.waktu_pengaduan,data.isi_pengaduan,mainUrl+'aw-uploads/'+data.link_gambar+'compress700/'+data.gambar_pengaduan,mainUrl+'aw-uploads/'+data.link_gambar+'compress700/'+data.gambar_pengaduan));
                        $('#jumlah'+data.id_kategori).text((parseInt($('#jumlah'+data.id_kategori).val()) || 0) + 1);
                        $('#jumlah'+data.id_kategori).val((parseInt($('#jumlah'+data.id_kategori).val()) || 0) + 1);
                        $('#jumlah'+data.id_sub_kategori).text((parseInt($('#jumlah'+data.id_sub_kategori).val()) || 0) + 1);
                        $('#jumlah'+data.id_sub_kategori).val((parseInt($('#jumlah'+data.id_sub_kategori).val()) || 0) + 1);
                    }
                }
            });
        });
    }

    function getMarker(location,icon,category,title,description){
        var marker = new google.maps.Marker({
            map: map,
            position: location,
            icon: setIcon(icon),
            category: category
        });
        google.maps.event.addListener(marker,'click',function(){
            createInfoWindow(marker,icon,title,description);
        });
        getmarkers.push(marker);
        marker.setVisible(false);
    }

    function getMarkerAnimation(location,icon,category,title,description){
        var marker = new google.maps.Marker({
            map: map,
            position: location,
            //icon: setIcon(icon),
            category: category,
            animation: google.maps.Animation.BOUNCE,
        });
        google.maps.event.addListener(marker,'click',function(){
            createInfoWindow(marker,icon,title,description);
        });
        getmarkers.push(marker);
        google.maps.event.addListener(marker,'click',function(){
            infowindow.close();
        });
    }

    function createInfoWindow(marker,icon,title,description){
        var infowindow = new google.maps.InfoWindow({ content: '' });
        infowindow.setContent(contentInfoWindow(icon,title,description));
        infowindow.open(map, marker);
        //map.panTo(marker.getPosition());
        google.maps.event.addListener(map,'click',function(){
            infowindow.close();
        });
    }

    function contentInfoWindow(icon,title,description){
        var c = ``;
        c += `<div class="w3-row" style="width:300px">`,
        c +=    `<div class="w3-bottombar w3-border-blue w3-padding-small w3-large"><b>`+title+`</b></div>`,
        c +=        `<div class="w3-padding-small">`,
        c +=            `<div class="w3-row">`+description+`</div>`,
        c +=        `</div>`,
        c += `</div>`;
        return c;
    }

    function createDescriptionInfoWindow(imgkategori,pengirim,imgpengirim,waktupengaduan,isi,img,preview){
        var c = ``;
        c += `<div class="w3-row">`,
        c += `<div class="w3-row">
        		<div class="w3-col s2 w3-padding-tiny w3-center">
        			<img src="`+imgpengirim+`" class="w3-circle" alt="Tidak Ada Foto" style="height:50px;width:50px;object-fit:cover;object-position:center">
        		</div>
        		<div class="w3-col s10 w3-padding-large">
        			<div class="w3-row">
        				<span class="w3-small w3-text-blue"><b>`+pengirim+`</b></span>
        			</div>
        			<div class="w3-row">
        				<span class="w3-tiny">`+waktupengaduan+`</span>
        			</div>
        		</div>
        		<div class="w3-row">
        			<img onclick="showPicture('`+preview+`','`+isi+`')" style="width:100%;height:200px;object-fit:cover;object-position:center" class="w3-card-4" src="`+img+`" />
        		</div>
        	</div>`,
        c += `</div>`;
        return c;
    }
}

function setIcon(url){
    var image = {
        url: "img/"+url,
        scaledSize: new google.maps.Size(40, 40)
    };
    return image;
}

function getDirections(source,destination){
    window.open('http://maps.google.com/?saddr='+source+'&daddr='+destination);
}

function createFilterCategory(){
    $.getJSON('data/filter-kategori.php',function(result){
        $.each(result,function(i,data){
            var c = '';
            c += '<li class="w3-small">',
            c +=    '<input onclick="filter(this)" type="checkbox" class="w3-check" value="'+data.id_kategori+'"/> '+data.nama_kategori+' <span id="jumlah'+data.id_kategori+'" class="w3-badge w3-indigo"></span>',
            c += '</li>';
            $('#filter-menu').append(c);
        });
    }).complete(function(){
        getCategoryRows();
    });
}

function createFilterSubCategory(){
    $.getJSON('filter-sub-kategori.php',function(result){
        $.each(result,function(i,data){
            var c = '';
            c += '<li class="w3-small">',
            c +=    '<input onclick="filter(this)" type="checkbox" class="w3-check" value="'+data.id_sub_kategori+'" checked/> '+data.nama_sub_kategori+' <span id="jumlah'+data.id_sub_kategori+'" class="w3-badge w3-indigo"></span>',
            c += '</li>';
            $('#'+data.id_kategori).append(c);
        });
    }).complete(function(){
        getSubCategoryRows();
    });
}

function getCategoryRows(){
    $.getJSON('data/jumlah-filter-kategori.php',function(result){
        $.each(result,function(i,data){
            $('#jumlah'+data.id_kategori).text(data.jumlah);
            $('#jumlah'+data.id_kategori).val(data.jumlah);
        });
    });
}

function getSubCategoryRows(){
    $.getJSON('jumlah-filter-sub-kategori.php',function(result){
        $.each(result,function(i,data){
            $('#jumlah'+data.id_sub_kategori).text(data.jumlah);
            $('#jumlah'+data.id_sub_kategori).val(data.jumlah);
        });
    });
}

function showPicture(url,text){
    document.getElementById("show-modal").style.display = "block";
    document.getElementById("item-image").src = url;
    $('#item-text').text(text);
}

function filter(event){
    if(event.checked){
        show(event.value);
    }else{
        hide(event.value);
    }
}

function show(category){
    for (i = 0; i < getmarkers.length; i++) {
        marker = getmarkers[i];
        if(marker.category.indexOf(category) >= 0){
            marker.setVisible(true);
        }
    }
}

function hide(category){
    for (i = 0; i < getmarkers.length; i++) {
        marker = getmarkers[i];
        if(marker.category.indexOf(category) >= 0){
            marker.setVisible(false);
        }
    }
}

function accordion(id){
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-indigo w3-text-white";
    } else {
        x.className = x.className.replace(" w3-show", "");
        x.previousElementSibling.className =
        x.previousElementSibling.className.replace(" w3-indigo w3-text-white", "");
    }
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8TLRYpMLYcS_4JZpTVrfVwkA8e4CLOp4&callback=initialize"></script>

<div id="googleMap" style="width:100%;height:100%;bottom:50px;color:black;"></div>

<span id="search-btn" class="w3-tag w3-large w3-round-xlarge w3-green w3-hover-yellow" style="position:fixed;top:15px;left:265px;cursor:pointer"><b>==</b></span>
<div id="side-left" style="display:block;position:fixed;left:0px;bottom:50px;width:250px;overflow:auto;height:100%;background:rgba(0,100,255,0.7);">
    <div style="height:50px"></div>
    <ul id="filter-menu" class="w3-ul"></ul>
</div>

<div class="w3-row w3-card-4 w3-padding-tiny" style="position:fixed;bottom:65px;right:10px;width:400px;background:rgba(0, 77, 255, 0.5);">
            
                <div class="w3-row w3-padding-tiny">

                    <div class="w3-col s9">
                        <span class="w3-button w3-circle w3-red">&nbsp;</span>
                        <label class="w3-validate w3-text-white"><b>Menunggu Tindakan</b></label>
                    </div>

                    <div class="w3-col s3">
                        <div class="w3-padding w3-center w3-text-white" style="background: rgba(0, 100, 255, 0.3);">
                            <span id="pengaduan-n"></span>
                        </div>
                    </div>

                </div>

                <div class="w3-row w3-padding-tiny">

                    <div class="w3-col s9">
                        <span class="w3-button w3-circle w3-orange">&nbsp;</span>
                        <label class="w3-validate w3-text-white"><b>Sementara Proses</b></label>
                    </div>

                    <div class="w3-col s3">
                        <div class="w3-padding w3-center w3-text-white" style="background: rgba(0, 100, 255, 0.3);">
                            <span id="pengaduan-p"></span>
                        </div>
                    </div>

                </div>

                <div class="w3-row w3-padding-tiny">

                    <div class="w3-col s9">
                        <span class="w3-button w3-circle w3-green">&nbsp;</span>
                        <label class="w3-validate w3-text-white"><b>Selesai</b></label>
                    </div>

                    <div class="w3-col s3">
                        <div class="w3-padding w3-center w3-text-white" style="background: rgba(0, 100, 255, 0.3);">
                            <span id="pengaduan-y"></span>
                        </div>
                    </div>

                </div>

                <div class="w3-row w3-padding-tiny">

                    <div class="w3-col s9">
                        <span class="w3-button w3-circle w3-purple">&nbsp;</span>
                        <label class="w3-validate w3-text-white"><b>Total</b></label>
                    </div>

                    <div class="w3-col s3">
                        <div class="w3-padding w3-center w3-text-white" style="background: rgba(0, 100, 255, 0.3);">
                            <span id="pengaduan-total"></span>
                        </div>
                    </div>

                </div>

</div>

<script>
    $('#search-btn').click(function(){
        $('#side-left').slideToggle();
    });
</script>

<script>
    $.getJSON('data/total-pengaduan-n.php',function(result){
        var v = result[0].jumlah;
        $('#pengaduan-n').text(v);
    });
    $.getJSON('data/total-pengaduan-p.php',function(result){
        var v = result[0].jumlah;
        $('#pengaduan-p').text(v);
    });
    $.getJSON('data/total-pengaduan-y.php',function(result){
        var v = result[0].jumlah;
        $('#pengaduan-y').text(v);
    });
    $.getJSON('data/total-pengaduan.php',function(result){
        var v = result[0].jumlah;
        $('#pengaduan-total').text(v);
    });
</script>