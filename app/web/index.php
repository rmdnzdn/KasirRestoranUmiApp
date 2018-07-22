<?php 	
	session_start();
	include "config/koneksi.php";
	include "library/fungsi.php";

	@$aksi = new oop();

	// @$username = mysql_real_escape_string($_POST['tuser']);
	// @$password = mysql_real_escape_string($_POST['tpass']);
	@$username = $_POST['tuser'];
	@$password = $_POST['tpass'];
	@$table = "tbl_user";

 	if (isset($_POST['blogin'])) {
 		if (empty($_POST['tuser']) OR empty($_POST['tpass'])) {
 			echo "<script>alert('Lengkapi data');document.location.href='index.php'</script>";
 		}else{
 			$aksi->login($table,$username,$password,"#");
 			if ($_SESSION['jabatan']=="admin") {
 				echo "<script>alert('Loginn berhasil');document.location.href='admin/index.php'</script>";
 			}elseif($_SESSION['jabatan']=="manager"){
 				echo "<script>alert('Login Berhasil');document.location.href='manager/index.php'</script>";
 			}
 		}
 		
 	}
 	if (isset($_POST['bpesan'])) {
 		echo "<script>document.location.href='pesanan/index.php'</script>";
 	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>FORM LOGIN</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<br><br>
<form method="post">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<table align="center" class="table">
			<tr>
				<td colspan="3" align="center">SILAHKAN LOGIN</td>
			</tr>
			<tr>
				<td>USERNAME</td>
				<td>:</td>
				<td><input type="text" name="tuser" placeholder="Masukan username Anda" class="form-control"></td>
			</tr>
			<tr>
				<td>PASSWORD</td>
				<td>:</td>
				<td><input type="password" name="tpass" placeholder="Masukan password Anda" class="form-control"></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<input type="submit" name="blogin" class="btn btn-lg btn-primary" value="LOGIN">
					<input type="submit" name="bpesan" class="btn btn-lg btn-primary" value="PESAN MAKANAN">
				</td>

			</tr>
		</table>
	</div>

</form>
</body>
</html>