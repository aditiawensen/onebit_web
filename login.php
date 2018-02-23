<div class="w3-row w3-animate-zoom w3-text-white">
<h5 class="w3-center">Login</h5>
  <div class="w3-col l4 w3-padding w3-hide-small w3-hide-medium w3-center">
    &nbsp;
  </div>
  <div class="w3-col l4 w3-padding">
    <form role="form" action="#" method="post">
    <div class="w3-row w3-padding" style="background:rgba(0,100,255,.3)">
      <label>USERNAME</label><br>
      <input name="username" class="w3-input w3-text-black" type="text" required>
      <label>PASSWORD</label><br>
      <input name="password" class="w3-input w3-text-black" type="password" required>
      <br>
      <center><button type=submit class="w3-button w3-large w3-green w3-text-white"><b><i class="fa fa-check"></i></b></button></center>
    </div>
    </form>
  </div>
  <div class="w3-col l4 w3-padding w3-hide-small w3-hide-medium w3-center">
    &nbsp;
  </div>
</div>
<br>
<h1 class="w3-center">One BIT</h1>
<h5 class="w3-center">one best information technology</h5>

<?php
if(!empty($_POST['username']) && !empty($_POST['password'])){
	include "data/aw-config/config.php";

	function login_validate() {
		$timer=3600;
		$_SESSION["expires_by"] = time() + $timer;
	}

	function login_check() {
		$exp_time = $_SESSION["expires_by"];
		if (time() < $exp_time) {
			login_validate();
			return true; 
		}else{
			unset($_SESSION["expires_by"]);
			return false; 
		}
	}

	$username = $_POST['username'];
	$pass     = $_POST['password'];

	if (!ctype_alnum($username) OR !ctype_alnum($pass)){
		echo "Sekarang loginnya tidak bisa diinjeksi.";
		header('location:index.php?affect=warning');
	}else{
		$q=$con->query("SELECT * FROM login WHERE username='$username' AND password='$pass' AND status_user='aktif'");
		$ketemu=$q->num_rows;

		if($ketemu > 0){
			while ($r = $q->fetch_assoc()) {
				$_SESSION['ses_username'] = $r['username'];
				$_SESSION['ses_nama'] = $r['name'];
				$_SESSION['ses_level']  = $r['group_akses'];
			}

			login_validate();

			if($_SESSION['ses_level']=="polres") {
				header('location:index.php?page=sos');
			} elseif($_SESSION['ses_level']=="adminberita"){
				header('location:index.php?page=input-berita');
			} elseif($_SESSION['ses_level']=="adminpengaduan"){
				header('location:index.php?page=map');
			} elseif($_SESSION['ses_level']=="adminrespon"){
				header('location:index.php?page=admin-respon');
			} elseif($_SESSION['ses_level']=="adminpolres"){
				header('location:index.php?page=hak-akses-panic-button');
			} else {
				header('location:index.php?page=admin-respon');
			}
		}else{
			header('location:index.php?affect=gagal');
		}
	}
}
?>
