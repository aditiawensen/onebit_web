<?php
include ('data/aw-config/config.php');
$id = $_GET['id'];

$check = "w3-hide";
if (!empty($_POST['status'])) {
	$status = $_POST['status'];
	$warna = getWarna($status);
	$con->query("UPDATE pengaduan SET status_pengaduan='$status', warna_pengaduan='$warna' WHERE id_pengaduan='$id'");
	if ($con->affected_rows > 0) {
		$check = "w3-show";
	}
}

function getWarna($x){
	switch ($x) {
		case 'Y':
			$v = "green";
			break;
		case 'P':
			$v = "orange";
			break;
		default:
			$v = "red";
			break;
	}
	return $v;
}

$r = $con->query("SELECT * FROM pengaduan,pengguna WHERE pengaduan.id_perangkat=pengguna.id_pengguna AND id_pengaduan='$id'")->fetch_assoc();
?>

<div class="w3-row">

	<div class="w3-col m1 w3-padding w3-center">
		<a href="?page=admin-respon" class="w3-xxlarge"><i class="fa fa-arrow-left"></i></a>
		<a href="" class="<?php echo $check; ?> w3-xxlarge"><i class="fa fa-check-square w3-text-white"></i></a>
	</div>

	<div class="w3-col m5 w3-padding">
    	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
    		<div class="w3-container" style="background:rgba(0,100,255,.1)">
    			<form action="?page=admin-respon&act=delete" method="POST">
    			<input type="hidden" name="id" value="<?php echo $id; ?>">
				<h2>Pengaduan <button class="w3-right w3-container w3-hover-red w3-round w3-button w3-blue" style="cursor:pointer" type="submit"><i class="fa fa-trash w3-text-white w3-xxlarge"></i></button></h2>
				</form>
			</div>
	    	<form class="w3-container w3-padding" action="" method="POST" enctype="multipart/form-data">
					<div class="w3-padding-8">
						<label class="w3-text-white">Kategori Pengaduan</label>
	    				<input name="kategori" class="w3-input w3-hover-light-blue" type="text" value="<?php echo $r['kategori']; ?>" readonly>
	    			</div>
					<div class="w3-padding-8">
						<label class="w3-text-white">Isi Pengaduan</label>
	    				<textarea name="isi_pengaduan" class="w3-input w3-border w3-hover-light-blue w3-small" rows="7" readonly><?php echo $r['isi_pengaduan']; ?></textarea>
	    			</div>
	    			<div class="w3-padding-8">
		    			<label class="w3-text-white">Alamat</label>
		    			<textarea name="alamat" class="w3-input w3-border w3-hover-light-blue w3-small" rows="3" readonly><?php echo "(".$r['posisi_lat_pengaduan'].",".$r['posisi_lng_pengaduan'].") ".$r['kecamatan_posisi']; ?></textarea>
		    		</div>
	    			<div class="w3-padding-8">
						<label class="w3-text-white">Status Pengaduan</label>
						<div>
							<span class="w3-padding w3-large">
								<input class="w3-radio" type="radio" name="status" value="Y" <?php echo $r['status_pengaduan']=="Y" ? "checked" : ""; ?>>
								<span class="w3-green w3-padding-tiny w3-round">Selesai</span>
							</span>
						</div>
						<div>
							<span class="w3-padding w3-large">
								<input class="w3-radio" type="radio" name="status" value="P" <?php echo $r['status_pengaduan']=="P" ? "checked" : ""; ?>>
								<span class="w3-orange w3-text-white w3-padding-tiny w3-round">Sementara Proses</span>
							</span>
						</div>
						<div>
							<span class="w3-padding w3-large">
								<input class="w3-radio" type="radio" name="status" value="N" <?php echo $r['status_pengaduan']=="N" ? "checked" : ""; ?>>
								<span class="w3-red w3-padding-tiny w3-round">Menunggu Tindakan</span>
							</span>
						</div>
					</div>
					<div class="w3-right-align">
						<button name="button_upload" class="w3-button w3-blue">Update</button>
					</div>
			</form>
    	</div>
	</div>

    <div class="w3-col m6 w3-padding">
    	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
    		<div class="w3-container" style="background:rgba(0,100,255,.1)">
				<h2>Info <a href="?page=admin-respon&act=tindak-lanjut&id=<?php echo $id; ?>" class="w3-right w3-button w3-green w3-round-large w3-large"><i class="fa fa-search"></i> Tindak Lanjut</a></h2>				
			</div>
			<div class="w3-padding">
				<div class="w3-row">
					<div class="w3-col s3">
						ID
					</div>
					<div class="w3-col s1">
						:
					</div>
					<div class="w3-col s8">
						<?php echo $r['id_perangkat']; ?>
					</div>
				</div>
				<div class="w3-row">
					<div class="w3-col s3">
						Nama Pengirim
					</div>
					<div class="w3-col s1">
						:
					</div>
					<div class="w3-col s8">
						<?php echo $r['pengirim_pengaduan']; ?>
					</div>
				</div>
				<div class="w3-row">
					<div class="w3-col s3">
						Telp
					</div>
					<div class="w3-col s1">
						:
					</div>
					<div class="w3-col s8">
						<?php echo $r['telp_pengguna']; ?>
					</div>
				</div>
			</div>
    		<div class="w3-padding">
    			<img src="<?php echo 'data/aw-uploads/'.$r['link_gambar'].$r['gambar_pengaduan']; ?>" width="100%" alt="Tidak Ada Gambar">
    		</div>
    	</div>
    </div>
</div>

<div class="w3-round w3-card-2 w3-padding-small w3-text-black" style="position:fixed; width:300px; height:455px; left:10px; bottom:10px; background:rgba(255,255,255,.9)">
	<div class="w3-bottombar"><span><b>Komentar</b></span></div>
	<div class="w3-row" style="height:320px; overflow:auto">
		<ul class="w3-ul">
			<li class="w3-padding-16" id="load-komentar" style="display:none">
				<span class="w3-xlarge"><i class="fa fa-spinner w3-spin"></i></span>
			</li>
		</ul>
		<ul id="daftar-komentar" class="w3-ul"></ul>
	</div>
	<div style="width:100%; height:50px"></div>
</div>
<div class="w3-white w3-topbar" style="position:fixed; width:300px; left:10px; bottom:10px;">
	<div class="w3-row w3-padding-small">
		<div class="w3-col s10">
			<textarea id="isi-komentar" class="w3-input w3-border w3-small" rows="4"></textarea>
		</div>
		<div class="w3-col s2">
			<button class="w3-button w3-medium w3-blue w3-hover-pink" onclick="sendComment()"><i class="fa fa-send"></i></button>
		</div>
	</div>
</div>

<?php
$con->close();
?>

<script>
	var mainUrl = "http://onebit.asia/data/";
	$('#load-komentar').fadeIn();

	function sendComment() {
		var v = $('#isi-komentar').val();

		if (v.length > 0) {
			$('#load-komentar').fadeIn();
			$.post(mainUrl+"send-comment.php",
		    {
		        id_pengaduan: "<?php echo $id; ?>",
		        id_pengguna: "<?php echo $_SESSION['ses_username']; ?>",
		        isi_komentar: v
		    },
		    function(data, status){
		        if (data.success > 0) {
		        	$('#isi-komentar').val("");
		        }
		    });
		} else {
			alert("Tidak Boleh Kosong!");
		}
	}

	$(document).ready(function(){
		setInterval(function(){
			loadComments();
		},2000);
	});

	function loadComments() {
		$.getJSON(mainUrl+"select-comment.php?id_pengaduan=<?php echo $id; ?>",function(result){
			$('#daftar-komentar').empty();
			$.each(result,function(i,data){
				var c = `<li class="w3-padding-16">
						    <img src="`+mainUrl+`aw-uploads/profile/`+data.gambar_pengguna+`" class="w3-left w3-circle w3-margin-right" style="width:50px;height:50px">
						    <span class="w3-small w3-text-blue"><b>`+data.nama_pengguna+`</b></span><br>
						    <span class="w3-tiny w3-text-grey"><b>`+data.waktu_komentar+`</b></span><br>
						    <div class="w3-row w3-padding-4"><span class="w3-small">`+data.isi_komentar+`</span></div>
						  </li>`;
				$('#daftar-komentar').append(c);
			});
		}).done(function(){
			$('#load-komentar').fadeOut();
		});
	}
</script>

<br>
<br>
<br>