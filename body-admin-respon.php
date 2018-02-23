<?php

switch ($_SESSION['ses_username']) {
	case 'adminresponkebersihan':
		$id_kategori = "k01";
		break;
	case 'adminresponkebakaran':
		$id_kategori = "k02";
		break;
	case 'adminresponkemacetan':
		$id_kategori = "k03";
		break;
	case 'adminresponkebanjiran':
		$id_kategori = "k04";
		break;
	case 'adminresponkerusakan':
		$id_kategori = "k05";
		break;
	case 'adminresponpelanggaran':
		$id_kategori = "k06";
		break;
	case 'adminresponpohontumbang':
		$id_kategori = "k07";
		break;
	case 'adminresponkakilimaliar':
		$id_kategori = "k08";
		break;
	case 'adminresponpdam':
		$id_kategori = "k09";
		break;
	case 'adminresponkemacetan':
		$id_kategori = "k03";
		break;
	default:
		$id_kategori = "";
		break;
}

include ('data/aw-config/config.php');
$pN = $con->query("SELECT COUNT(*) jumlah FROM pengaduan where status_pengaduan ='N'")->fetch_assoc();
$pP = $con->query("SELECT COUNT(*) jumlah FROM pengaduan where status_pengaduan ='P'")->fetch_assoc();
$pY = $con->query("SELECT COUNT(*) jumlah FROM pengaduan where status_pengaduan ='Y'")->fetch_assoc();
$pT = $con->query("SELECT COUNT(*) jumlah FROM pengaduan ")->fetch_assoc();

$pctN = ($pN['jumlah']/$pT['jumlah'])*100;
$pctP = ($pP['jumlah']/$pT['jumlah'])*100;
$pctY = ($pY['jumlah']/$pT['jumlah'])*100;
?>	

		<div class="w3-row" style="background: url('img/smart.png'); background-size: 100% 100%; height: 240px">
			<div class="w3-col m4">
				<div class="w3-row w3-padding-64">
					<div class="w3-col m6 w3-right-align">
						<button class="w3-button w3-hover-green w3-xxlarge w3-circle w3-green w3-card-4" style="height: 77px; width: 77px"></button>
					</div>
					<div class="w3-col m6 w3-padding-8 w3-container">
						<span class="w3-xxlarge w3-text-white"><?php echo number_format($pctY, 2, ',', ''); ?>%</span>
					</div>
				</div>
			</div>
			<div class="w3-col m4 w3-padding-64">
				<div class="w3-row">
					<div class="w3-col m6 w3-right-align">
						<button class="w3-button w3-hover-orange w3-xxlarge w3-circle w3-orange w3-card-4" style="height: 77px; width: 77px"></button>
					</div>
					<div class="w3-col m6 w3-padding-8 w3-container">
						<span class="w3-xxlarge w3-text-white"><?php echo number_format($pctP, 2, ',', ''); ?>%</span>
					</div>
				</div>
			</div>
			<div class="w3-col m4 w3-padding-64">
				<div class="w3-row">
					<div class="w3-col m6 w3-right-align">
						<button class="w3-button w3-hover-red w3-xxlarge w3-circle w3-red w3-card-4" style="height: 77px; width: 77px"></button>
					</div>
					<div class="w3-col m6 w3-padding-8 w3-container">
						<span class="w3-xxlarge w3-text-white"><?php echo number_format($pctN, 2, ',', ''); ?>%</span>
					</div>
				</div>
			</div>
		</div>

		<div class="w3-row">
			<div class="w3-col m4">
				<h2 class="w3-lobster w3-center">Struktur Organisasi</h2>
				<ul class="w3-ul w3-card-2 w3-margin-left" style="background:rgba(0,100,255,.3)">
				  <li class="w3-padding-16">
				    <img src="img/avatar_male.png" class="w3-left w3-circle w3-margin-right" style="width:50px">
				    <span class="w3-large">...</span><br>
				    <span>Kepala Dinas</span>
				  </li>
				  <li class="w3-padding-16">
				    <img src="img/avatar_male.png" class="w3-left w3-circle w3-margin-right" style="width:50px">
				    <span class="w3-large">...</span><br>
				    <span>Sekretaris</span>
				  </li>  
				  <li class="w3-padding-16">
				    <img src="img/avatar_male.png" class="w3-left w3-circle w3-margin-right" style="width:50px">
				    <span class="w3-large">...</span><br>
				    <span>Kepala Bidang</span>
				  </li> 
				</ul>
			</div>
			<div class="w3-col m8 w3-container">
				<h2 class="w3-lobster w3-center">Pengaduan</h2>
				<form action="" method="GET">
				<table class="w3-table w3-card-2 w3-bordered w3-margin-bottom" style="background:rgba(0,100,255,.3)">
				    <thead>
				      <tr style="background:rgba(0,100,255,.3)">
				        <th>No</th>
				        <th width="120px">Kategori</th>
				        <th>Isi Pengaduan</th>
				        <th></th>
				      </tr>
				    </thead>

				    <?php
				    if (!empty($_GET['status'])) {
				    	switch ($_GET['status']) {
					    	case 'Y':
					    		$q = $con->query("SELECT * FROM pengaduan WHERE status_pengaduan='Y' ORDER BY id_pengaduan DESC");
					    		break;
					    	case 'P':
					    		$q = $con->query("SELECT * FROM pengaduan WHERE status_pengaduan='P' ORDER BY id_pengaduan DESC");
					    		break;
					    	default:
					    		$q = $con->query("SELECT * FROM pengaduan WHERE status_pengaduan='N' ORDER BY id_pengaduan DESC");
					    		break;
					    }
				    } else {
				    	$q = $con->query("SELECT * FROM pengaduan ORDER BY id_pengaduan DESC");
				    }
				    while ($r = $q->fetch_assoc()) {
				    ?>
				    	<tr>
					      <td><?php echo $r['id_pengaduan']; ?></td>
					      <td>
					      	<div>
					      		<?php echo tampilKategori($r['kategori']); ?>
							</div>
							<div>
								
							</div>
					      </td>
					      <td>
					      	<div class="w3-row w3-padding-tiny">
					      		<div>
					      			<span class="w3-tiny"><?php echo time_elapsed_string($r["waktu_pengaduan"]); ?></span>
					      			<span class="w3-right w3-small w3-text-light-blue"><i><?php echo $r['pengirim_pengaduan']; ?></i></span>
					      		</div>
					      		<div class="w3-row w3-leftbar <?php echo setWarnaPengaduan($r['status_pengaduan']); ?> w3-padding-tiny">
					      			<span class="">
					      				<?php echo $r['isi_pengaduan']; ?>
					      			</span>
					      		</div>
					      	</div>
					      </td>
					      <td>					   
					      	<a href="?page=admin-respon&act=edit&id=<?php echo $r['id_pengaduan']; ?>" class="w3-button w3-blue w3-round w3-center w3-hover-pink"><i class="fa fa-search w3-large"></i></a>
					      </td>
					    </tr>
				    <?php
				    }
				    ?>
				</table>
				</form>

				<a href="?page=admin-respon&act=daftar-pengaduan-all" class="w3-button w3-hover-pink w3-small w3-blue w3-hide">Lihat Selengkapnya</a>

				<br>
				<br>
				<br>
			</div>
		</div>
		<div style="height:55px"></div>

<?php
$con->close();
?>

<?php
function tampilKategori($x) {
	if (strlen($x) > 10) {
		return substr($x, 0, 10)."...";
	} else {
		return $x;
	}
}
function setWarnaPengaduan($x) {
	switch ($x) {
		case 'Y':
			$x = "w3-border-green";
			break;
		case 'P':
			$x = "w3-border-orange";
			break;
		default:
			$x = "w3-border-red";
			break;
	}
	return $x;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'tahun',
        'm' => 'bulan',
        'w' => 'minggu',
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' yang lalu' : 'beberapa detik yang lalu';
}
?>