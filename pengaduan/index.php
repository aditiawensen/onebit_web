<!DOCTYPE html>
<html>
<?php
error_reporting(0);
$id = $_GET['id'];
include('../data/aw-config/config.php');
$r = $con->query("SELECT * FROM pengaduan,pengguna WHERE pengaduan.id_perangkat=pengguna.id_pengguna AND id_pengaduan='$id'")->fetch_assoc();
?>
<title><?php echo $r['nama_pengguna'] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Description" content="<?php echo $r['isi_pengaduan'] ?>">
<meta property="og:image" content="http://onebit.asia/data/aw-uploads/<?php echo $r['link_gambar'] ?>compress400/<?php echo $r['gambar_pengaduan'] ?>">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="700">
<meta property="og:image:height" content="700">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body>

<div class="w3-row w3-blue w3-center w3-padding">
  <span class="w3-medium">Pengaduan One BIT</span>
</div>

<br>

<div class="w3-row">
	<div class="w3-col m3 l4 w3-hide-small">
		&nbsp;
	</div>
	<div class="w3-col s12 m6 l4">
		<div class="w3-container">

		  <img src="http://onebit.asia/data/aw-uploads/<?php echo $r['link_gambar'] ?>compress700/<?php echo $r['gambar_pengaduan'] ?>" class="w3-round-small" style="width:100%">

		  <h4><?php echo $r['nama_pengguna'] ?></h4>
		  <span class="w3-tiny w3-text-grey"><?php echo time_elapsed_string($r['waktu_pengaduan']) ?></span>
		  <p class="w3-small"><?php echo make_links_clickable($r['isi_pengaduan']) ?></p>

		</div>
	</div>
	<div class="w3-col m3 l4 w3-hide-small">
		&nbsp;
	</div>
</div>

<?php
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

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
}
?>

</body>
</html>
