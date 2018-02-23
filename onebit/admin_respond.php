<!DOCTYPE html>
<html>
<title>PDAM Bitung</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body class="w3-light-grey">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
<style>
.w3-lobster {
	font-family: "Lobster", serif;
}
.ex2 {
    font: italic bold 12px/30px Georgia, serif;
}
</style>

<?php
include ('data/aw-config/config.php');
$pN = $con->query("SELECT COUNT(*) jumlah FROM pengaduan where status_pengaduan ='N'")->fetch_assoc();
$pP = $con->query("SELECT COUNT(*) jumlah FROM pengaduan where status_pengaduan ='P'")->fetch_assoc();
$pY = $con->query("SELECT COUNT(*) jumlah FROM pengaduan where status_pengaduan ='Y'")->fetch_assoc();
$pT = $con->query("SELECT COUNT(*) jumlah FROM pengaduan ")->fetch_assoc();

$pctN = ($pN['jumlah']/$pT['jumlah'])*100;
$pctP = ($pP['jumlah']/$pT['jumlah'])*100;
$pctY = ($pY['jumlah']/$pT['jumlah'])*100;
?>


<div class="w3-row w3-white w3-card-4 w3-margin-right w3-margin-left">
	<div class="w3-col m2">
		<div class="w3-row w3-padding-xlarge w3-center">
			<div class="w3-display-container w3-hover-opacity">
			    <img class="w3-circle" img src="img/avatar_male.png" alt="Avatar" style="width:100%; margin-top: 20px">
			    <div class="w3-display-middle w3-display-hover w3-tinny">
			      <button class="w3-button w3-round w3-black">Keluar</button>
			    </div>
		  	</div>
		</div>
		<div class="w3-row">
			<div class="w3-sidebar w3-bar-block" style="width: 15%; margin-top: 50px"> 
			  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Dashboard</a>
			  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Daftar Pengaduan</a>
			  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">&nbsp;&nbsp;<i class="fa fa-check"> Selesai</i></a>
			  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">&nbsp;&nbsp;<i class="fa fa-refresh"> Sementara Proses</i></a>
			  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">&nbsp;&nbsp;<i class="fa fa-file-text-o"> Menunggu Tindakan</i></a>
			  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">GIS</a>
			  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Struktur Organisasi</a>
			</div>
		</div>
	</div>
	<div class="w3-col m10">
		<div class="w3-row" style="background: url('img/smart.jpg'); background-size: 100% 100%">
			<div class="w3-col m2 w3-padding-128">
				&nbsp;
			</div>
			<div class="w3-col m3">
				<div class="w3-row w3-padding-128">
					<div class="w3-col m6 w3-right-align">
						<button class="w3-button w3-hover-green w3-xxlarge w3-circle w3-green w3-card-4" style="height: 77px; width: 77px"></button>
					</div>
					<div class="w3-col m6 w3-padding-8 w3-container">
						<span class="w3-xxlarge w3-text-black"><?php echo number_format($pctN, 2, ',', ''); ?>%</span>
					</div>
				</div>
			</div>
			<div class="w3-col m3 w3-padding-128">
				<div class="w3-row">
					<div class="w3-col m6 w3-right-align">
						<button class="w3-button w3-hover-orange w3-xxlarge w3-circle w3-orange w3-card-4" style="height: 77px; width: 77px"></button>
					</div>
					<div class="w3-col m6 w3-padding-8 w3-container">
						<span class="w3-xxlarge w3-text-black"><?php echo number_format($pctP, 2, ',', ''); ?>%</span>
					</div>
				</div>
			</div>
			<div class="w3-col m4 w3-padding-128">
				<div class="w3-row">
					<div class="w3-col m6 w3-right-align">
						<button class="w3-button w3-hover-red w3-xxlarge w3-circle w3-red w3-card-4" style="height: 77px; width: 77px"></button>
					</div>
					<div class="w3-col m6 w3-padding-8 w3-container">
						<span class="w3-xxlarge w3-text-black"><?php echo number_format($pctY, 2, ',', ''); ?>%</span>
					</div>
				</div>
			</div>
		</div>

		<div class="w3-row">
			<div class="w3-col m4">
				<H2 class="w3-lobster w3-center">Struktur Organisasi</H2>
				<ul class="w3-ul w3-card-2 w3-white">
				  <li class="w3-padding-16">
				    <img src="img/avatar_male.png" class="w3-left w3-circle w3-margin-right" style="width:50px">
				    <span class="w3-large">Mike</span><br>
				    <span>Kepala Dinas</span>
				  </li>
				  <li class="w3-padding-16">
				    <img src="img/avatar_male.png" class="w3-left w3-circle w3-margin-right" style="width:50px">
				    <span class="w3-large">Jill</span><br>
				    <span>Sekretaris</span>
				  </li>  
				  <li class="w3-padding-16">
				    <img src="img/avatar_male.png" class="w3-left w3-circle w3-margin-right" style="width:50px">
				    <span class="w3-large">Jane</span><br>
				    <span>Kepala Bidang</span>
				  </li> 
				</ul>
			</div>
			<div class="w3-col m8 w3-container">
				<H2 class="w3-lobster w3-center">Pengaduan</H2>
				<table class="w3-table w3-white w3-card-2 w3-bordered w3-margin-bottom">
				    <thead>
				      <tr class="w3-blue">
				        <th>ID</th>
				        <th width="120px">Kategori</th>
				        <th>Isi Pengaduan</th>
				        <th></th>
				      </tr>
				    </thead>

				    <?php
				    $q = $con->query("SELECT * FROM pengaduan ORDER BY id_pengaduan DESC LIMIT 20");
				    while ($r = $q->fetch_assoc()) {
				    ?>
				    	<tr>
					      <td><?php echo $r['id_pengaduan']; ?></td>
					      <td><?php echo tampilKategori($r['kategori']); ?></td>
					      <td>
					      	<div class="w3-row w3-padding-tiny">
					      		<div class="w3-row w3-leftbar w3-border-blue w3-padding-tiny">
					      			<span class="">
					      				<?php echo $r['isi_pengaduan']; ?>
					      			</span>
					      		</div>
					      	</div>
					      </td>
					      <td>
					      	<button class="w3-button w3-circle w3-blue w3-center w3-hover-pink" style="width: 50px; height: 50px"><i class="fa fa-search w3-large"></i></button>
					      </td>
					    </tr>
				    <?php
				    }
				    ?>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
function tampilKategori($x) {
	if (strlen($x) > 10) {
		return substr($x, 0, 10)."...";
	} else {
		return $x;
	}
}
?>

</body>
</html>
