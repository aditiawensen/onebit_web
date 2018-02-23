<?
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	include('aw-config/config.php');

	$q = $con->query("SELECT * FROM kategori");

	$outp = "";
	while ($r = $q->fetch_assoc()) {
	    if ($outp != "") {$outp .= ",";}
	    $outp .= '{"id_kategori":"' . $r["id_kategori"] . '",';
	    $outp .= '"nama_kategori":"' . $r["nama_kategori"] . '",';
	    $outp .= '"urut_kategori":"' . $r["urut_kategori"] . '"}'; 
	}
	$outp ='['.$outp.']';

	echo($outp);

	$con->close();
?>