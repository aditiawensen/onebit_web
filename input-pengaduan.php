<?php
	include('data/aw-config/config.php');
?>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>

<div class="w3-row">
    <div class="w3-col m1 w3-padding w3-center">
        <a href="?page=admin-respon"><i class="fa fa-arrow-left w3-xxlarge"></i></a>
    </div>
	<div class="w3-col m5 w3-padding">
    	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
    		<div class="w3-container" style="background:rgba(0,100,255,.1)">
				<h2>Input Pengaduan Facebook</h2>
			</div>
	    	<form class="w3-container w3-padding" action="" method="POST" enctype="multipart/form-data">
	    		<div class="w3-padding-8">
	    			<label class="w3-text-white">Id Pengguna</label>
	    			<input id="idpengguna" name="input_id_pengguna" class="w3-input w3-hover-light-blue" type="text" readonly>
	    		</div>
					<div class="w3-padding-8">
						<label class="w3-text-white">Nama Pengguna</label>
	    				<input id="namapengguna" name="input_nama_pengguna" class="w3-input w3-hover-light-blue" type="text" required>
	    			</div>
					<div class="w3-padding-8">
						<label class="w3-text-white">Isi Pengaduan</label>
	    				<textarea name="input_isi_pengaduan" class="w3-input w3-border w3-hover-light-blue w3-small" rows="7" required></textarea>
	    			</div>
	    			<div class="w3-padding-8">
						<label class="w3-text-white">Gambar Pengaduan</label>
						<input name="image" class="w3-input" type="file" required>
					</div>
					<div class="w3-padding-8">
						<select class="w3-select" name="kategori">
							<?php
							$select_kategori = $con->query("SELECT * FROM kategori");
							while ($rk = $select_kategori->fetch_assoc()) {
								?>
								<option value="<?php echo $rk['nama_kategori'] ?>"><?php echo $rk['nama_kategori'] ?></option>
								<?php
							}
							?>							
						</select>
					</div>
					<div class="w3-right-align">
						<button name="button_upload" class="w3-button w3-blue">Upload</button>
					</div>
			</form>
    	</div>
	</div>

    <div class="w3-col m6 w3-padding">
    	<div class="w3-card-2" style="background:rgba(0,100,255,.3)">
    		<div class="w3-container" style="background:rgba(0,100,255,.1)">
				<h2>Daftar Pengaduan</h2>
			</div>
    			<table class="w3-table w3-bordered">
				    <thead>
				      <tr>
				        <th class="w3-center">No</th>
				        <th>Pengguna</th>
				        <th>Isi Pengaduan</th>
				        <th class="w3-center">Waktu</th>
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
    		$.getJSON("http://onebit.asia/data/load-data-pengaduan.php?lastId=9999999&startRow=0&limitRow=20&idDevice=",function(result){
    			var no = 1;
    			$.each(result, function(i, field){
    				var c = `<tr class="w3-hover-blue" style="cursor:pointer">
					      <td class="w3-center">`+field.id_pengaduan+`</td>
					      <td>`+field.pengirim_pengaduan+`</td>
					      <td>`+field.isi_pengaduan+`</td>
					      <td class="w3-center">`+field.waktu_pengaduan+`</td>
					    </tr>`;
		            $('#body-table').append(c);
		        });
    		});
    	}

        $('#namapengguna').keyup(function(){
            var v = $('#namapengguna').val();
            $('#idpengguna').val(setId(v));
        });

        function setId(x) {
            var v = x.replace(/ /g, "-");
            v = "facebook-"+v.toLowerCase();
            return v;
        }
    	</script>

<?php
if(!empty($_POST['input_id_pengguna']) && !empty($_POST['input_isi_pengaduan'])) {

	$id = "p".date("YmdHis");

	$data_id_pengguna = $_POST['input_id_pengguna'];
	$data_nama_pengguna = $_POST['input_nama_pengguna'];
	$data_isi_pengaduan = $_POST['input_isi_pengaduan'];
	$data_kategori = $_POST['kategori'];

	$data_id_pengguna = str_replace('"', '``', $data_id_pengguna);
	$data_nama_pengguna = str_replace('"', '``', $data_nama_pengguna);
	$data_isi_pengaduan = str_replace('"', '``', $data_isi_pengaduan);
	
	include('data/aw-plugins/aw-image-compress.php');

	makeDirectory();
	if (!empty($_FILES['image']['name'])) {
		$periode = date('Ym');
        $img = $id.".jpg";
        $source = 'data/aw-uploads/images/'.$periode.'/';
        move_uploaded_file( $_FILES['image']['tmp_name'], $source.$img );

        $dest100 = 'data/aw-uploads/images/'.$periode.'/compress100/';
        thumbnail( $img, $source, $dest100, 100, 100 );

        $dest400 = 'data/aw-uploads/images/'.$periode.'/compress400/';
        thumbnail( $img, $source, $dest400, 400, 400 );

        $dest700 = 'data/aw-uploads/images/'.$periode.'/compress700/';
        thumbnail( $img, $source, $dest700, 700, 700 );
        $imgname = "http://onebit.asia/".$dest700.$img;
    } else {
        $imgname = 'empty';
    }

    $k = $con->query("SELECT * FROM kategori k WHERE k.`nama_kategori`='$data_kategori'")->fetch_assoc();
    $id_kategori = $k['id_kategori'];

    echo $data_id_pengguna.$data_nama_pengguna.$data_isi_pengaduan.$img.$data_kategori.$id_kategori;

    $icon_kategori = getIconCategory($data_kategori);

    $periode_folder = date('Ym');
    $link_gambar = 'images/'.$periode_folder.'/';

    $input1 = $con->query("INSERT INTO pengguna(id_pengguna,nama_pengguna,gambar_pengguna,telp_pengguna,waktu_daftar) VALUES(
    	'$data_id_pengguna',
    	'$data_nama_pengguna',
    	'user.png',
    	'0',
    	NOW()
   	)");

   	$input2 = $con->query("INSERT INTO `pengaduan`(`id_kategori`,`kategori`,`id_sub_kategori`,`sub_kategori`,`icon_kategori`,`icon_sub_kategori`,`isi_pengaduan`,`gambar_pengaduan`,`pengirim_pengaduan`,`gambar_pengirim_pengaduan`,`waktu_pengaduan`,`posisi_lat_pengaduan`,`posisi_lng_pengaduan`,`media_pengaduan`,`status_pengaduan`,`warna_pengaduan`,`sembunyikan`,`blokir`,`periode`,`link_gambar`,`kecamatan_posisi`,`kota_posisi`,`id_perangkat`) VALUES (
   		'$id_kategori',
   		'$data_kategori',
   		'',
   		'$data_kategori',
   		'$icon_kategori',
   		'',
   		'$data_isi_pengaduan',
   		'$img',
   		'$data_nama_pengguna',
   		'user.png',
   		NOW(),
   		'0',
   		'0',
   		'Website',
   		'N',
   		'red',
   		'N',
   		'N',
   		'$periode_folder',
   		'$link_gambar',
   		'',
   		'',
   		'$data_id_pengguna'
   		)");

   	if ($con->affected_rows > 0) {
   		$time = date('Y-m-d H:i:s');
		pushNotification($data_nama_pengguna,'Pengaduan Baru',$data_kategori,$time,2,'bitungsmartcity');
   	}

	$con->close();
}

function makeDirectory(){
    $periode = date('Ym');
    if (!file_exists('data/aw-uploads/images/'.$periode)) {
        mkdir('data/aw-uploads/images/'.$periode, 0777, true);
        if (!file_exists('data/aw-uploads/images/'.$periode.'/compress100')) {
            mkdir('data/aw-uploads/images/'.$periode.'/compress100', 0777, true);
        }
        if (!file_exists('data/aw-uploads/images/'.$periode.'/compress400')) {
            mkdir('data/aw-uploads/images/'.$periode.'/compress400', 0777, true);
        }
        if (!file_exists('data/aw-uploads/images/'.$periode.'/compress700')) {
            mkdir('data/aw-uploads/images/'.$periode.'/compress700', 0777, true);
        }
    }
}

function getIconCategory($x){
    switch ($x) {
        case 'Kebersihan':
            return 'kebersihan.png';
            break;
        case 'Kebakaran':
            return 'kebakaran.png';
            break;
        case 'Kemacetan':
            return 'kemacetan.png';
            break;
        case 'Kebanjiran':
            return 'kebanjiran.png';
            break;
        case 'Kerusakan':
            return 'kerusakan.png';
            break;
        case 'Kesehatan':
            return 'kesehatan.png';
            break;
        case 'Pelanggaran':
            return 'pelanggaran.png';
            break;
        case 'Potensi Teroris':
            return 'potensi-teroris.png';
            break;
        case 'Pohon Tumbang':
            return 'pohon-tumbang.png';
            break;
        case 'Kaki Lima Liar':
            return 'kaki-lima-liar.png';
            break;
        case 'PDAM (Pelayanan Air)':
            return 'pdam.png';
            break;
        case 'PLN (Pelayanan Listrik)':
            return 'pln.png';
            break;
        case 'Bank':
            return 'bank.png';
            break;
        case 'Hotel':
            return 'hotel.png';
            break;
        case 'Kuliner':
            return 'kuliner.png';
            break;
        case 'Pelabuhan':
            return 'pelabuhan.png';
            break;
        case 'Instansi':
            return 'instansi.png';
            break;
        case 'Sekolah':
            return 'sekolah.png';
            break;
        default:
            return 'empty';
            break;
    }
}

//PUSH NOTIFICATION
function pushNotification($header, $body, $footer, $time, $intent, $topic) {
	$gcm = new GCM();
    $push = new Push();

    $data = array();
    $data['header'] = $header;
    $data['body'] = $body;
    $data['footer'] = $footer;
    $data['time'] = $time;

    $push->setTitle("Notification");
    $push->setIsBackground(FALSE);
    $push->setFlag($intent);
    $push->setData($data);

    $gcm->sendToTopic($topic, $push->getPush());
}

class GCM {

    // constructor
    function __construct() {
        
    }

    // sending push message to single user by gcm registration id
    public function send($to, $message) {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // Sending message to a topic by topic id
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // sending push message to multiple users by gcm registration ids
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // function makes curl request to gcm servers
    private function sendPushNotification($fields) {

        // Set POST variables
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $headers = array(
            'Authorization: key=AIzaSyAI99zHr1gwToviddKU3x5BSl8AehKiWxg',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }

}

class Push{
    // push message title
    private $title;
    
    // push message payload
    private $data;
    
    // flag indicating background task on push received
    private $is_background;
    
    // flag to indicate the type of notification
    private $flag;
    
    function __construct() {
        
    }
    
    public function setTitle($title){
        $this->title = $title;
    }
    
    public function setData($data){
        $this->data = $data;
    }
    
    public function setIsBackground($is_background){
        $this->is_background = $is_background;
    }
    
    public function setFlag($flag){
        $this->flag = $flag;
    }
    
    public function getPush(){
        $res = array();
        $res['title'] = $this->title;
        $res['is_background'] = $this->is_background;
        $res['flag'] = $this->flag;
        $res['data'] = $this->data;
        
        return $res;
    }
}
?>
<br>
<br>
<br>