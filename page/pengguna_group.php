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
if (!empty($_POST['nama_group'])) {
	$nama_group = $_POST['nama_group'];
	$pengguna_group = $_POST['pengguna_group'];

	include('config.php');

	$q = $con->query("INSERT INTO t_pengguna_group(
			id_group,
			id_pengguna_group
		) VALUES(
			'$nama_group',
			'$pengguna_group'
		)");

	$con->close();
}
?>

<h1 class="w3-center">PENGGUNA GROUP</h1>
<div class="w3-row w3-panel">
	<div class="w3-col s12 m6 l4">
		<form action="" method="POST" enctype="multipart/form-data">
		<div class="w3-padding-4">
			<select class="w3-select" name="nama_group">
				<?php
				include('config.php');

				$q = $con->query("SELECT * FROM t_group ORDER BY nama_group");
				while ($r = $q->fetch_assoc()) {
				?>
				<option value="<?php echo $r['id_group']; ?>"><?php echo $r['nama_group']; ?></option>
				<?php
				}

				$con->close();
				?>
			</select>
		</div>
		<div class="w3-padding-4">
			<select class="w3-select" name="pengguna_group">
				<?php
				include('config.php');

				$q = $con->query("SELECT * FROM pengguna ORDER BY nama_pengguna");
				while ($r = $q->fetch_assoc()) {
				?>
				<option value="<?php echo $r['id_pengguna']; ?>"><?php echo $r['nama_pengguna']; ?></option>
				<?php
				}

				$con->close();
				?>
			</select>
		</div>
		<div class="w3-padding-4">
			<button class="w3-button w3-green w3-round"><i class="fa fa-plus"></i> TAMBAH PENGGUNA</button>
		</div>
		</form>
	</div>
</div>
<div class="w3-row w3-panel">
	<table class="w3-table w3-border">
		<thead class="w3-blue">
			<th>NAMA GROUP</th>
			<th>PENGGUNA</th>
		</thead>
		<tbody>
			<?php
			include('config.php');

			$q = $con->query("SELECT * FROM t_group g, t_pengguna_group pg, pengguna p WHERE g.id_group=pg.id_group AND pg.id_pengguna_group=p.id_pengguna");
			while ($r = $q->fetch_assoc()) {
			?>
			<tr>
				<td><?php echo $r['nama_group']; ?></td>
				<td><?php echo $r['nama_pengguna']; ?></td>
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