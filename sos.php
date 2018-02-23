<?php
  if($_SESSION['ses_level']!="polres") {
    header('location:index.php?affect=login');
  }
?>

<div id="welcome" class="w3-panel w3-text-white w3-animate-opacity" style="background:rgba(0,255,70,.3);position:fixed;width:100%">
  <h3 class="w3-center">Selamat Datang!</h3>
  <p class="w3-center">Silahkan menggunakan fitur scanning SOS One BIT...</p>
</div> 
<script>
  setTimeout(function(){
    $('#welcome').fadeOut('slow');
  },4000);
</script>

      <style>
        .alert {
            background-color: red;
            position: relative;
            -webkit-animation-name: alert; /* Safari 4.0 - 8.0 */
            -webkit-animation-duration: 1s; /* Safari 4.0 - 8.0 */
            -webkit-animation-iteration-count: 21; /* Safari 4.0 - 8.0 */
            animation-name: alert;
            animation-duration: 1s;
            animation-iteration-count: 21;
        }
        @-webkit-keyframes alert {
            0%   {background-color:red;}
            50%  {background-color:pink;}
            100% {background-color:red;}
        }
        @keyframes alert {
            0%   {background-color:red;}
            50%  {background-color:pink;}
            100% {background-color:red;}
        }
      </style>

    	<audio id="sound1" src="alert1.mp3"></audio>

      <div id="content" style="position:fixed;width:100%;height:100%;overflow:auto;padding-bottom:55px"></div>
      <div style="position:fixed;bottom:70px;width:100%;z-index:-7" class="w3-center"><span class="w3-text-white w3-xlarge">...SCANNING...</span></div>
      <i class="fa fa-warning w3-text-white" style="position:fixed;top:7px;right:7px"></i>

      <script>
        var id = 0;
        var s1 = $('#sound1');

        $(document).ready(function(){
          $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="logout.php" class="w3-hover-blue w3-tooltip"><i class="fa fa-sign-out"></i><span style="position:absolute;right:50px;bottom:17px" class="w3-border w3-border-blue w3-text w3-tag w3-small w3-round-large">Logout</span></a></li>`);
          $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="?page=daftar-sos" class="w3-hover-blue w3-tooltip"><i class="fa fa-list"></i><span class="w3-xlarge"> Daftar</span></a></li>`);
          $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="?page=sos" class="w3-hover-blue w3-tooltip"><i class="fa fa-spinner w3-spin"></i><span class="w3-xlarge"> Standby</span></a></li>`);
          loadDataSOS();
        });
        function loadDataSOS(){
          $.getJSON('http://onebit.asia/data/select-sos.php',function(result){
            $.each(result, function(i, field){
              id = field.id_sos;
            });
            detectSOS();
          })
        }

        function detectSOS(){
          setInterval(function(){
            loadNewDataSOS();
          },5000);
        }

        function loadNewDataSOS(){
          $.getJSON('http://onebit.asia/data/select-sos.php',function(result){
            $.each(result, function(i, field){
              if(id < parseInt(field.id_sos)) {
                var c = `<br><div class="w3-text-white w3-padding w3-topbar w3-bottombar w3-animate-top alert" style="background:rgba(255,0,0,.5)">
                          <h1 class="w3-center w3-jumbo"><i class="fa fa-warning"></i>WARNING!!!</h1>
                          <h3 class="w3-center">`+field.nama_pengguna+` <span class="w3-medium">Telp.`+field.telp_pengguna+`</span></h3>`+
                          `<h5 class="w3-center">`+field.waktu_sos+
                          ` (`+field.lat+','+field.lng+`) <button class="w3-button w3-green w3-small" onclick="openLocation(`+field.lat+`,`+field.lng+`)">Lihat Lokasi</button></h5>`+
                        `</div>`;
                $('#content').prepend(c);
                s1.get(0).play();
                $('#content').animate({scrollTop:0}, 'slow');
              }
              id = field.id_sos;
            });
          })
        }

        function openLocation(lat,lng){
          window.open(`http://onebit.asia/index.php?page=show-location&lat=`+lat+`&lng=`+lng);
        }
      </script>

<br>
<br>
<br>