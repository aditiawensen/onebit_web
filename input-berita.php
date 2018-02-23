<?php
	if($_SESSION['ses_level']!="adminberita") {
    	header('location:index.php?affect=login');
	}
?>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>

<div class="w3-row">

	<div class="w3-col m5 w3-padding">
    	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
    		<div class="w3-container" style="background:rgba(0,100,255,.1)">
				<h2>Input Berita</h2>
			</div>
	    	<form class="w3-container w3-padding" action="?page=input-berita" method="POST" enctype="multipart/form-data">
	    		<div class="w3-padding-8">
	    			<label class="w3-text-white">Judul Berita</label>
	    			<input name="input_judul_berita" class="w3-input w3-hover-light-blue" type="text" required>
	    		</div>
					<div class="w3-padding-8">
						<label class="w3-text-white">Sub Judul Berita</label>
	    				<input name="input_sub_judul_berita" class="w3-input w3-hover-light-blue" type="text" required>
	    			</div>
					<div class="w3-padding-8">
						<label class="w3-text-white">Isi Berita</label>
	    				<textarea name="input_isi_berita" class="w3-input w3-border w3-hover-light-blue w3-small" rows="7" required></textarea>
	    			</div>
	    			<div class="w3-padding-8">
						<label class="w3-text-white">Gambar Berita</label>
						<input name="image" class="w3-input" type="file" required>
					</div>
					<div class="w3-right-align">
						<button name="button_upload" class="w3-button w3-blue">Upload</button>
					</div>
			</form>
    	</div>
	</div>

    <div class="w3-col m7 w3-padding">
    	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
    		<div class="w3-container" style="background:rgba(0,100,255,.1)">
				<h2>Daftar Berita</h2>
			</div>
    			<table class="w3-table w3-bordered">
				    <thead>
				      <tr>
				        <th class="w3-center">No</th>
				        <th>Judul Berita</th>
				        <th class="w3-center">Waktu Terbit Berita</th>
				      </tr>
				    </thead>
				    <tbody id="body-table">
				    	
				    </tbody>
				</table>
    	</div>
    </div>
</div>

    	<script>
    	$(document).ready(function(){
    		$('#navbar').append(`<li class="w3-hide-small w3-right"><a href="logout.php" class="w3-hover-blue w3-tooltip"><i class="fa fa-sign-out"></i><span style="position:absolute;right:50px;bottom:17px" class="w3-border w3-border-blue w3-text w3-tag w3-small w3-round-large">Logout</span></a></li>`);
    		loadDataBerita();
    	});

    	function loadDataBerita(){
    		$.getJSON("http://onebit.asia/data/load-data-berita.php",function(result){
    			var no = 1;
    			$.each(result, function(i, field){
    				var c = `<tr class="w3-hover-blue" style="cursor:pointer">
					      <td class="w3-center">`+(no++)+`</td>
					      <td>`+field.judul_berita+`</td>
					      <td class="w3-center">`+field.tanggal_berita+`</td>
					    </tr>`;
		            $('#body-table').append(c);
		        });
    		});
    	}
    	</script>

<?php
if(!empty($_POST['input_judul_berita']) && !empty($_POST['input_isi_berita'])) {

	$id = "b".date("YmdHis");

	$data_judul_berita = $_POST['input_judul_berita'];
	$data_sub_judul_berita = $_POST['input_sub_judul_berita'];
	$data_isi_berita = $_POST['input_isi_berita'];

	$data_judul_berita = str_replace('"', '``', $data_judul_berita);
	$data_sub_judul_berita = str_replace('"', '``', $data_sub_judul_berita);
	$data_isi_berita = str_replace('"', '``', $data_isi_berita);
	
	include('data/aw-plugins/aw-image-compress.php');
	include('data/aw-config/config.php');

	makeDirectory();
	if (!empty($_FILES['image']['name'])) {
		$periode = date('Ym');
        $img = $id.".jpg";
        $source = 'data/aw-uploads/berita/'.$periode.'/';
        move_uploaded_file( $_FILES['image']['tmp_name'], $source.$img );

        $dest100 = 'data/aw-uploads/berita/'.$periode.'/compress100/';
        thumbnail( $img, $source, $dest100, 100, 100 );

        $dest400 = 'data/aw-uploads/berita/'.$periode.'/compress400/';
        thumbnail( $img, $source, $dest400, 400, 400 );

        $dest700 = 'data/aw-uploads/berita/'.$periode.'/compress700/';
        thumbnail( $img, $source, $dest700, 700, 700 );
        $imgname = "http://onebit.asia/".$dest700.$img;
    } else {
        $imgname = 'empty';
    }

	$con->query("INSERT INTO berita(id_berita,gambar_berita,judul_berita,sub_judul_berita,tanggal_berita,isi_berita) VALUES('$id','$imgname','$data_judul_berita','$data_sub_judul_berita',NOW(),'$data_isi_berita')");
	if ($con->affected_rows > 0) {
		echo "Upload Berhasil!";
		$con->query("INSERT INTO notifikasi(gambar_notifikasi,gambar2_notifikasi,judul_notifikasi,isi_notifikasi,waktu_notifikasi,dibaca,halaman,id_pengguna) VALUES('http://pdambitung.96.lt/bsc/aw-pages/include/images/notifikasi/notif.png','http://pdambitung.96.lt/bsc/aw-pages/include/images/notifikasi/clock.png','$data_judul_berita','$data_sub_judul_berita',NOW(),'N','berita','publik')");
	} else {
		echo "Upload Gagal!";
	}

	$con->close();
}

function makeDirectory(){
    $periode = date('Ym');
    if (!file_exists('data/aw-uploads/berita/'.$periode)) {
        mkdir('data/aw-uploads/berita/'.$periode, 0777, true);
        if (!file_exists('data/aw-uploads/berita/'.$periode.'/compress100')) {
            mkdir('data/aw-uploads/berita/'.$periode.'/compress100', 0777, true);
        }
        if (!file_exists('data/aw-uploads/berita/'.$periode.'/compress400')) {
            mkdir('data/aw-uploads/berita/'.$periode.'/compress400', 0777, true);
        }
        if (!file_exists('data/aw-uploads/berita/'.$periode.'/compress700')) {
            mkdir('data/aw-uploads/berita/'.$periode.'/compress700', 0777, true);
        }
    }
}
?>
<br>
<br>
<br>