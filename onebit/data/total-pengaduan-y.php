<?
date_default_timezone_set("Asia/Makassar");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	
include('aw-config/config.php');

$q = $con->query("SELECT COUNT(*) jumlah FROM pengaduan where status_pengaduan ='Y'");

$outp = "";
if ($q->num_rows > 0) {
	while ($r = $q->fetch_assoc()) {
		if ($outp != "") {$outp .= ",";}
	    $outp .= '{"jumlah":"' . $r["jumlah"] . '"}';
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
?>