<?php
include ('data/aw-config/config.php');
include('data/aw-plugins/aw-image-compress.php');

$id = $_GET['id'];
$r = $con->query("SELECT * FROM pengaduan,pengguna WHERE pengaduan.id_perangkat=pengguna.id_pengguna AND id_pengaduan='$id'")->fetch_assoc();

$imgname = $r['img_tindak_lanjut'];

if (!empty($_FILES['image']['tmp_name'])) {
	makeDirectory();

	$img = date("YmdHis").".jpg";

	$periode = date('Ym');  
    $source = 'data/aw-uploads/tindak-lanjut/'.$periode.'/';

    move_uploaded_file( $_FILES['image']['tmp_name'], $source.$img );

    $dest100 = 'data/aw-uploads/tindak-lanjut/'.$periode.'/compress100/';
    thumbnail( $img, $source, $dest100, 100, 100 );

    $dest400 = 'data/aw-uploads/tindak-lanjut/'.$periode.'/compress400/';
    thumbnail( $img, $source, $dest400, 400, 400 );

    $dest700 = 'data/aw-uploads/tindak-lanjut/'.$periode.'/compress700/';
    thumbnail( $img, $source, $dest700, 700, 700 );

    $imgname = "http://onebit.asia/".$dest700.$img;
    //$imgname = $dest700.$img;
    $con->query("UPDATE pengaduan SET img_tindak_lanjut='$imgname' WHERE id_pengaduan='$id'");
}

function makeDirectory(){
    $periode = date('Ym');
    if (!file_exists('data/aw-uploads/tindak-lanjut/'.$periode)) {
        mkdir('data/aw-uploads/tindak-lanjut/'.$periode, 0777, true);
        if (!file_exists('data/aw-uploads/tindak-lanjut/'.$periode.'/compress100')) {
            mkdir('data/aw-uploads/tindak-lanjut/'.$periode.'/compress100', 0777, true);
        }
        if (!file_exists('data/aw-uploads/tindak-lanjut/'.$periode.'/compress400')) {
            mkdir('data/aw-uploads/tindak-lanjut/'.$periode.'/compress400', 0777, true);
        }
        if (!file_exists('data/aw-uploads/tindak-lanjut/'.$periode.'/compress700')) {
            mkdir('data/aw-uploads/tindak-lanjut/'.$periode.'/compress700', 0777, true);
        }
    }
}
?>

<div class="w3-col m1 w3-padding w3-center">
	<a href="?page=admin-respon&act=edit&id=<?php echo $id; ?>" class="w3-xxlarge"><i class="fa fa-arrow-left"></i></a>
</div>

<div class="w3-col m5 w3-padding">
	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
		<div class="w3-container" style="background:rgba(0,100,255,.1)">
			<h3>Info Pengaduan</h3>
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

<div class="w3-col m5 w3-padding">
	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
		<div class="w3-container" style="background:rgba(0,100,255,.1)">
			<h3>Tindak Lanjut Pengaduan</h3>			
		</div>
		<div class="w3-row w3-padding">
			<div class="w3-padding-4">
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="w3-center">
						<input type="file" name="image" class="w3-input">
					</div>					
					<div class="w3-center w3-padding-8">
						<button class="w3-button w3-blue w3-round-large w3-small"><i class="fa fa-upload"></i> Upload</button>
					</div>					
				</form>
			</div>
			<img src="<?php echo $imgname; ?>" width="100%" alt="Tidak Ada Gambar">
		</div>
	</div>
</div>