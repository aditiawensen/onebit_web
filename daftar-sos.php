<div class="w3-row w3-container w3-padding-8">
	<table class="w3-table w3-bordered" style="background:rgba(0,100,255,.3)">
		<thead style="background:rgba(0,100,255,.1)">
			<th>No</th>
			<th>Nama Pengirim</th>
			<th>Telp</th>
			<th class="w3-center">Waktu</th>
			<th class="w3-center">Posisi</th>
			<th></th>
		</thead>
		<tbody>
			<?php
			include ('data/aw-config/config.php');

			$q = $con->query("SELECT * FROM sos s, pengguna p WHERE s.id_pengirim=p.id_pengguna ORDER BY id_sos DESC");
			while ($r = $q->fetch_assoc()) {
			?>
			<tr>
				<td><?php echo $r['id_sos']; ?></td>
				<td><?php echo $r['nama_pengguna']; ?></td>
				<td><?php echo $r['telp_pengguna']; ?></td>
				<td class="w3-right-align"><?php echo date('d M Y H:i:s', strtotime($r['waktu_sos'])); ?></td>
				<td class="w3-center"><?php echo $r['lat'].",".$r['lng']; ?></td>
				<td>
					<div class="w3-row">
						<div class="w3-col s6">
							<button onclick="openLocation(<?php echo $r['lat']?>,<?php echo $r['lng']?>)" class="w3-button w3-green w3-round"><i class="fa fa-map-marker"></i></button>
						</div>
						<div class="w3-col s6">
							<a href="?page=daftar-sos" class="w3-button w3-blue w3-round"><i class="fa fa-search"></i></a>
						</div>
					</div>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>

<script>
		$(document).ready(function(){
          $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="logout.php" class="w3-hover-blue w3-tooltip"><i class="fa fa-sign-out"></i><span style="position:absolute;right:50px;bottom:17px" class="w3-border w3-border-blue w3-text w3-tag w3-small w3-round-large">Logout</span></a></li>`);
          $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="?page=daftar-sos" class="w3-hover-blue w3-tooltip"><i class="fa fa-list"></i><span class="w3-xlarge"> Daftar</span></a></li>`);
          $('#navbar').append(`<li class="w3-hide-small w3-right"><a href="?page=sos" class="w3-hover-blue w3-tooltip"><i class="fa fa-spinner w3-spin"></i><span class="w3-xlarge"> Standby</span></a></li>`);
        });

        function openLocation(lat,lng){
          window.open(`http://onebit.asia/index.php?page=show-location&lat=`+lat+`&lng=`+lng);
        }
</script>