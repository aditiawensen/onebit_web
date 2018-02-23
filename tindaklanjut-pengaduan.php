<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>

<div class="w3-row">

    <div class="w3-col m12 w3-padding">
    	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
    		<div class="w3-container" style="background:rgba(0,100,255,.1)">
				<h2>Daftar Pengaduan</h2>
			</div>
    			<table class="w3-table w3-bordered">
				    <thead>
				      <tr>
				        <th class="w3-center">Kode</th>
				        <th>Pengirim</th>
				        <th class="w3-center">Isi</th>
				        <th class="w3-center">Kategori</th>
				        <th class="w3-center">Status</th>
				        <th class="w3-center">Aksi</th>
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
    		$.getJSON("http://onebit.asia/data/load-data-pengaduan.php?lastId=100&startRow=0&limitRow=100&idDevice=777",function(result){
    			$.each(result, function(i, data){
    				var c = `<tr class="w3-hover-blue" style="cursor:pointer">
					      <td class="w3-center">`+data.id_pengaduan+`</td>
					      <td>`+data.pengirim_pengaduan+`</td>
					      <td class="w3-center">`+data.isi_pengaduan+`</td>
					      <td class="w3-center">`+data.kategori+`</td>
					      <td class="w3-center"><img src="img/`+data.status_pengaduan+data.icon_kategori+`" height="50px"/></td>
					      <td class="w3-center"><button class="w3-button w3-circle w3-purple" style="width:48px;height:48px"><i class="fa fa-edit"></i></button></td>
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