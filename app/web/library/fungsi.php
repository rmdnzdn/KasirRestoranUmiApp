<?php  
	class oop{
		

		function simpan($table,array $field, $alamat){
			$sql = "INSERT INTO $table SET";
			foreach ($field as $key => $value) {
			  	$sql.=" $key = '$value',";
			  }  
			$sql = rtrim($sql, ',');
			$jalan = mysql_query($sql);
			if($jalan){
				echo "<script>alert('Data Berhasil Disimpan !!!');document.location.href='$alamat'</script>";
			}else{
				echo mysql_error();
			}
		}

		function simpanlsg($table, array $field,$alamat){
			$sql="INSERT INTO $table SET";
			foreach($field as $key => $value){
				$sql.=" $key = '$value',";
			}
			$sql=rtrim($sql,',');
			$jalan=mysql_query($sql);
			if($jalan){
				echo "<script>document.location.href='$alamat'</script>";
			}else{
				echo "<script>alert('Data Gagal Disimpan');document.location.href='$alamat'</script>";
			}
		}

		function pesan($pesan){
			echo "<script>alert('$pesan');</script>";
		}

		function alamat($redirect){
			echo "<script>document.location.href='$redirect';</script>";
		}


		function tampil($table,$cari,$urut){
			$sql="SELECT * FROM $table $cari $urut";
			$tampil=mysql_query($sql);
			while($data=mysql_fetch_array($tampil))
				$isi[]=$data;
			return @$isi;
		}

		function hapus($table,$where,$alamat){
			$sql = "DELETE FROM $table WHERE $where";
			$jalan = mysql_query($sql);
			if($jalan){
				echo "<script>alert('Berhasil Dihapus !!!');document.location.href='$alamat'</script>";
			}else{
				echo mysql_error();
			}
		}

		function edit($table,$where){
			$sql = "SELECT * FROM $table WHERE $where";
			$jalan = mysql_fetch_array(mysql_query($sql));
			return $jalan;
		}

		function ubah($table, array $field,$where,$alamat){
			$sql = "UPDATE $table SET";
			foreach ($field as $key => $value) {
				$sql.=" $key = '$value',";
			}
			$sql = rtrim($sql,',');
			$sql.= "WHERE $where";
			$jalan = mysql_query($sql);
			if($jalan){
				echo "<script>alert('Berhasil Diubah !!!');document.location.href='$alamat'</script>";
			}else{
				echo mysql_error();
			}
		}

		function login($table, $username, $password, $nama_form){
			@session_start();
			$sql = "SELECT * FROM $table WHERE username = '$username' AND password ='$password'";
			$jalan = mysql_query($sql);
			$tampil = mysql_fetch_array($jalan);
			$cek = mysql_num_rows($jalan);
			if ($cek > 0) {
				$_SESSION['username'] = $tampil['username'];
				$_SESSION['nama'] = $tampil['nama'];
				$_SESSION['jabatan'] = $tampil['jabatan'];
				$_SESSION['id'] = $tampil['id'];
				echo "<script>alert('Login Berhasil');documet.location.href='$nama_form'</script>";
			}else{
				echo mysql_error();
			}
		}
	

		function logout(){
			session_destroy();
			echo "<script>alert('Log Out Berhasil');</script>";
		}
	}

?>