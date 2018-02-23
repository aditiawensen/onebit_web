<?php
session_start();
?>
<!DOCTYPE html>
<html>
<title>One BIT</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="©Aditia_Wensen - One BIT (One Best Information System) menjadikan kota lebih baik dengan pemanfaatan teknologi informatika. #Pengaduan #Berita #Pariwisata #InfoKota #Obrolan #Belanja #Lainnya">
<meta name="keywords" content="onebit one bit smartcity smart city">
<meta name="author" content="Aditia Wensen">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/w3-theme-blue.css">
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<body class="w3-black">

<script type='text/javascript' src='js/background.js'></script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
          particleground(document.getElementById('particles'), {
            dotColor: '#0077FF',
            lineColor: '#0077FF'
          });
          var intro = document.getElementById('intro');
          intro.style.marginTop = - intro.offsetHeight / 2 + 'px';
        }, false);
</script>
<div id="particles" style="position:fixed;width:100%;height:100%;overflow:hidden;z-index:-9" class="w3-black"></div>

<div id="body" style="position:fixed;width:100%;height:100%;margin-top:52px;overflow:auto">
    <?php
    if(!empty($_GET['page'])){
        $page = $_GET['page'];
        include($page.'.php');
    }else{
        include('login.php');
    }
    ?>
</div>

<div class="w3-top w3-card-4" style="z-index:777">
    <ul id="navbar" class="w3-navbar w3-xlarge" style="background:rgba(0,100,255,.3)">
        <li class="w3-navitem w3-font-sansation-bold w3-hide-small">One BIT</li>
        <li><a href="#" onclick="w3.toggleShow('#myDropnav');w3.toggleShow('#overlay')" class="w3-left w3-hover-blue"><i class="fa fa-bars"></i> <span class="w3-hide-medium w3-hide-large w3-font-sansation-bold w3-xlarge">One BIT</span></a></li>
    </ul>
</div>

<div id="overlay" class="w3-overlay w3-animate-opacity" onclick="w3.hide('#myDropnav');w3.hide('#overlay')" style="display:none"></div>

</body>

</html>