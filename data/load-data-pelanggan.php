<?
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	
include('aw-config/config.php');

$q = $con->query("SELECT * FROM pelanggan WHERE lat >= 0 AND lng >= 0");

$outp = "";
if ($q->num_rows > 0) {
	while($r = $q->fetch_assoc()) {
	    if ($outp != "") {$outp .= ",";}
	    $outp .= '{"id_pelanggan":"' . $r["id_pelanggan"] . '",';
	    $outp .= '"pelanggan":"' . $r["pelanggan"] . '",';
	    $outp .= '"kelurahan":"' . $r["nama_kelurahan"] . '",';
	    $outp .= '"alamat":"' . $r["alamat"] . '",';
	    $outp .= '"golongan":"' . $r["jenis_golongan"] . '",';
	    $outp .= '"status":"' . $r["aktif"] . '",';
	    $outp .= '"gambar_rumah":"' . $r["gambarrumah"] . '",';
	    $outp .= '"gambar_meter":"' . $r["gambarmeter"] . '",';
		$outp .= '"lat":"' . $r["lat"] . '",';
	    $outp .= '"lng":"' . $r["lng"] . '"}'; 
	}
} else {

}

$outp ='['.$outp.']';
echo($outp);	

$con->close();

function escapeJsonString($value) {
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
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