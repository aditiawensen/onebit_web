<?php
include ('data/aw-config/config.php');

if(!empty($_POST['id_pengguna'])) {

	$id = $_POST['id_pengguna'];

	$q = $con->query("INSERT INTO akses_panic_button(id_perangkat,blokir) VALUES('$id','N')");

	if ($con->affected_rows > 0 ) {
		echo "Berhasil Ditambahkan";
	} else {
		echo "Gagal Ditambahkan";
	}

}

if(!empty($_GET['delete'])) {
	$delete = $_GET['delete'];
	switch ($delete) {
		case 'Y':
			if(!empty($_GET['id'])) {
				$id_delete = $_GET['id'];
				$con->query("DELETE FROM akses_panic_button WHERE id_perangkat='$id_delete'");
			}
			break;
	}
}
?>

<div class="w3-row">
	<div class="w3-col m4 w3-container w3-padding-8">
		<div style="background:rgba(0,100,255,.3)">
			<div class="w3-row w3-padding w3-container w3-padding-8" style="background:rgba(0,100,255,.1)">
				<h3>Input Hak Akses Panic Button</h3>
			</div>
			<div class="w3-row w3-padding w3-container w3-padding-8">
				<form action="" method="POST">
				<div class="w3-col s9">
					<input class="w3-input" type="text" name="id_pengguna" placeholder="ID Pengguna">
				</div>
				<div class="w3-col s3 w3-right-align">
					<button class="w3-button w3-blue w3-round">INPUT</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="w3-col m8">
		<div class="w3-row w3-container w3-padding-8">
			<table class="w3-table w3-bordered" style="background:rgba(0,100,255,.3)">
				<thead style="background:rgba(0,100,255,.1)">
					<th>No</th>
					<th>ID Pengguna</th>
					<th>Nama Pengguna</th>
					<th>Telp</th>
					<th></th>
				</thead>
				<tbody>
					<?php
					$q = $con->query("SELECT * FROM akses_panic_button a, pengguna p WHERE a.id_perangkat=p.id_pengguna ORDER BY id DESC");
					while ($r = $q->fetch_assoc()) {
					?>
					<tr>
						<td><?php echo $r['id']; ?></td>
						<td><?php echo $r['id_perangkat']; ?></td>
						<td><?php echo $r['nama_pengguna']; ?></td>
						<td><?php echo $r['telp_pengguna']; ?></td>
						<td>
							<div class="w3-row">
								<div class="w3-col s12">
									<a href="?page=hak-akses-panic-button&delete=Y&id=<?php echo $r['id_perangkat']; ?>" class="w3-button w3-red w3-round"><i class="fa fa-trash"></i></a>
								</div>
							</div>
						</td>
					</tr>
					<?php
					}
					$con->close();
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
		$(document).ready(function(){
          $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="logout.php" class="w3-hover-blue w3-tooltip"><i class="fa fa-sign-out"></i><span style="position:absolute;right:50px;bottom:17px" class="w3-border w3-border-blue w3-text w3-tag w3-small w3-round-large">Logout</span></a></li>`);
        });

        function openLocation(lat,lng){
          window.open(`http://onebit.asia/index.php?page=show-location&lat=`+lat+`&lng=`+lng);
        }
</script>