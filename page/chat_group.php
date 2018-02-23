<!DOCTYPE html>
<html>
<title>One BIT</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="©Aditia_Wensen - One BIT (One Best Information System) menjadikan kota lebih baik dengan pemanfaatan teknologi informatika. #Pengaduan #Berita #Pariwisata #InfoKota #Obrolan #Belanja #Lainnya">
<meta name="keywords" content="onebit one bit smartcity smart city">
<meta name="author" content="Aditia Wensen">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="../css/w3.css">
<link rel="stylesheet" href="../css/w3-theme-blue.css">
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<body>

<?php
$group = '';
$select_group = '';
if(!empty($_POST['group'])){
	$group = $_POST['group'];

	include('config.php');

	$r = $con->query("SELECT nama_group FROM t_group WHERE id_group='$group'")->fetch_assoc();
	$select_group = $r['nama_group'];

	$con->close();
}
?>

<h1 class="w3-center">CHAT GROUP</h1>

<div class="w3-row w3-panel">
	<div class="w3-row">
		<div class="w3-col s12 m6 l4">
			<form action="" method="POST" enctype="multipart/form-data">
			<select class="w3-select" name="group">
				<?php
				include('config.php');

				$q = $con->query("SELECT * FROM t_pengguna_group pg, t_group g WHERE pg.id_group=g.id_group AND id_pengguna_group='4aa886c4a2002221'");

				while ($r = $q->fetch_assoc()) {
				?>
				<option value="<?php echo $r['id_group']; ?>"><?php echo $r['nama_group']; ?></option>
				<?php
				}

				$con->close();
				?>
			</select>
			<div class="w3-row w3-padding-4">
				<button class="w3-button w3-purple w3-round"><i class="fa fa-search"></i> LIHAT CHAT</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="w3-row w3-panel">
	<h3><?php echo $select_group; ?></h3>
	<table class="w3-table w3-border">
		<thead class="w3-blue">
			<th>Nama Pengguna</th>
			<th>Isi</th>
			<th>Waktu</th>
		</thead>
		<tbody>
			<?php
			include('config.php');

			$q = $con->query("SELECT * FROM t_chat_group cg, t_group g, pengguna p WHERE cg.id_group=g.id_group AND cg.id_pengirim_chat=p.id_pengguna AND cg.id_group='$group'");
			while ($r = $q->fetch_assoc()) {
			?>
			<tr>
				<td><?php echo $r['nama_pengguna']; ?></td>
				<td><?php echo $r['isi_chat']; ?></td>
				<td><?php echo $r['waktu_chat']; ?></td>
			</tr>
			<?php
			}

			$con->close();
			?>
		</tbody>
	</table>
</div>

</body>

</html>