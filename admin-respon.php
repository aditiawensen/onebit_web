<?php
	/*if($_SESSION['ses_level']!="adminrespon") {
    	header('location:index.php?affect=login');
	}*/
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
<style>
.w3-lobster {
	font-family: "Lobster", serif;
}
.ex2 {
    font: italic bold 12px/30px Georgia, serif;
}
</style>

<div style="position:fixed; width:100%; height:100%">
	<div style="height:100%">
		<div class="w3-row w3-card-4 w3-margin-right w3-margin-left" style="height:100%">
			<div class="w3-col m2 w3-rightbar w3-border-indigo" style="height:100%">
				<div class="w3-row w3-padding-xlarge w3-center">
					<div class="w3-display-container w3-hover-opacity">
					    <img class="w3-circle" img src="img/headset_icon.jpg" alt="Avatar" style="width:100%; margin-top: 20px">
					    <div class="w3-display-middle w3-display-hover w3-tinny">
					      <button class="w3-button w3-round w3-black">Keluar</button>
					    </div>
				  	</div>
				  	<div>
						<span class="w3-small"><?php echo $_SESSION['ses_nama']; ?></span>
					</div>
				</div>
				<div class="w3-row">
					<div class="w3-bar-block w3-collapse" style="background:rgba(0,100,255,.3)"> 
					  <a href="?page=admin-respon" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Dashboard</a>
					  <a href="?page=admin-respon" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Daftar Pengaduan</a>
					  <a href="?page=admin-respon&status=Y" class="w3-bar-item w3-button w3-lobster w3-medium" style="font-size: 20px">&nbsp;&nbsp;<i class="fa fa-check"> Selesai</i></a>
					  <a href="?page=admin-respon&status=P" class="w3-bar-item w3-button w3-lobster w3-medium" style="font-size: 20px">&nbsp;&nbsp;<i class="fa fa-refresh"> Sementara Proses</i></a>
					  <a href="?page=admin-respon&status=N" class="w3-bar-item w3-button w3-lobster w3-medium" style="font-size: 20px">&nbsp;&nbsp;<i class="fa fa-file-text-o"> Menunggu Tindakan</i></a>
					  	<?php
						switch ($_SESSION['ses_username']) {
							default:
						?>
								<a href="?page=map" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Peta</a>
						<?php
								break;
						}
						?>
					  <a href="#" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Struktur Organisasi</a>
					  <?php
						switch ($_SESSION['ses_username']) {
							case 'adminrespon':
						?>
								<a href="?page=input-pengaduan" class="w3-bar-item w3-button w3-lobster" style="font-size: 20px">Facebook</a>
						<?php
								break;
						}
						?>
					</div>
				</div>
			</div>
			<div class="w3-col m10" style="height:100%; overflow:auto; background:rgba(0,100,255,.1);">
				<?php
				switch ($_SESSION['ses_username']) {
					case 'adminrespon':
						if(!empty($_GET['act'])) {
							switch ($_GET['act']) {
								case 'edit':
									include ('edit-pengaduan.php');
									break;
								case 'tindak-lanjut':
									include ('tindak-lanjut.php');
									break;
								case 'delete':
									$id = $_POST['id'];
									include ('data/aw-config/config.php');
									$con->query("DELETE FROM pengaduan WHERE id_pengaduan='$id'");
									$con->close();
									include ('body-admin-respon.php');
									break;
							}
						} else {
							include ('body-admin-respon.php');
						}
						break;
					default:
						if(!empty($_GET['act'])) {
							switch ($_GET['act']) {
								case 'edit':
									include ('edit-pengaduan.php');
									break;
								case 'tindak-lanjut':
									include ('tindak-lanjut.php');
									break;
								case 'delete':
									/*$id = $_POST['id'];
									include ('data/aw-config/config.php');
									$con->query("DELETE FROM pengaduan WHERE id_pengaduan='$id'");
									$con->close();*/
									include ('body-admin-respon-skpd.php');
									break;
							}
						} else {
							include ('body-admin-respon-skpd.php');
						}
						break;
				}
				?>
			</div>
		</div>		
	</div>
</div>

<script>
    	$(document).ready(function(){
    		$('#navbar').append(`<li class="w3-hide-small w3-right"><a href="logout.php" class="w3-hover-blue w3-tooltip"><i class="fa fa-sign-out"></i><span style="position:absolute;right:50px;bottom:17px" class="w3-border w3-border-blue w3-text w3-tag w3-small w3-round-large">Logout</span></a></li>`);
    	});
</script>