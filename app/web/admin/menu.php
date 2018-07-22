<?php  
if (!isset($_GET['menu'])) {
	header("location:index.php?menu=menu");
}

	@$i = mysql_query("SELECT * FROM tbl_menu ORDER BY kd_menu DESC");
	@$j = mysql_fetch_array($i);

	if (@$j == "") {
		@$kd = "MN0001";
	}else{
		@$kode = substr($j['kd_menu'], 2,4)+1;
		if ($kode < 10) { @$kd = "MN000".$kode;}
		elseif ($kode < 100 ) {@$kd = "MN00".$kode;}
		elseif ($kode < 1000 ) {@$kd = "MNG000".$kode;}
		elseif ($kode < 10000 ) {@$kd = "MN0".$kode;}
		else{@$kd = "MN".$kode;}
	}

	@$kd_menu = $_POST['tkode'];
	@$nama_menu = $_POST['tnama'];
	@$jenis = $_POST['tjenis'];
	@$harga = $_POST['tharga'];

	@$table = "tbl_menu";
	@$alamat = "?menu=menu";
	@$where = "kd_menu = '$_GET[id]'";

	@$field = array(
			'kd_menu' => $kd_menu,
			'nama_menu' => $nama_menu,
			'harga_menu' => $harga,
			'jenis_menu' => $jenis
		);

	@$field2 = array(
			'nama_menu' => $nama_menu,
			'harga_menu' => $harga,
			'jenis_menu' => $jenis
		);

	if (isset($_POST['bsimpan'])) {
		$aksi->simpan($table,$field,$alamat);
	}
	if (isset($_GET['edit'])) {
		$edit = $aksi->edit($table,$where);
	}
	if (isset($_GET['hapus'])) {
		$aksi->hapus($table,$where,$alamat);
	}
	if (isset($_POST['bubah'])) {
		$aksi->ubah($table,$field2,$where,$alamat);
	}
	if (isset($_POST['bcari'])) {
		@$text = $_POST['tcari'];
		@$cari = "WHERE nama_barang LIKE '%$text%'";
	}else{
		@$cari = "";
	}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Barang </title>
</head>
<body>
<br><br>
<br><br>
	<div class="container-fluid" id="mrg">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-primary">
					<?php if(!isset($_GET['edit'])){ ?>
						<div class="panel-heading">Tambah Menu
					<?php }else { ?>
						<div class="panel-heading">Ubah Menu
					<?php } ?>
						</div>
					<div class="panel-body">
						<form method="post">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><div class="glyphicon glyphicon-lock"></div></span>
									<input type="text" name="tkode" value="<?php if(@$_GET['id']==""){echo @$kd;}else{echo @$edit['kd_menu'];} ?>" placeholder="Masukan Kode" class="form-control" required readonly>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><div class="glyphicon glyphicon-text-size"></div></span>
									<input type="text" name="tnama" value="<?php echo @$edit['nama_menu']; ?>" placeholder="Nama Menu" class="form-control" maxlength="50" required autocomplete="off" tabindex="0" autofocus>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><div class="glyphicon glyphicon-tags"></div></span>
									<select name="tjenis" class="form-control">
										<option selected disabled>Pilih Jenis Menu</option>
										<!-- <option value="<?php echo $slcid[3]; ?>" selected><?php echo $slcid[3]; ?></option> -->
										<?php @$a = mysql_query("SELECT * FROM tbl_menu GROUP BY jenis_menu"); 
										while ($data = mysql_fetch_array($a)) {?>
											<option value="<?php echo $data[3]; ?>" <?php if(@$_POST['tjenis']==$data[3]){echo "selected";} ?> ><?php echo $data[3]; ?></option>
										<?php } ?>
										
									</select>
									
								</div>
							</div>

							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><div class="glyphicon glyphicon-usd"></div></span>
									<input type="text" name="tharga"  value="<?php echo @$edit['harga_menu']; ?>" placeholder="Harga Menu" class="form-control" maxlength="11" required autocomplete="off" tabindex="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
								</div>
							</div>

							

							<div class="form-group">
								<?php if (@$_GET['id']=="") { ?>
									<button type="submit" name="bsimpan" class="btn btn-primary btn-block" tabindex="0">SIMPAN</button>
								<?php }else{ ?>
									<button type="submit" name="bubah" class="btn btn-success btn-block" tabindex="0">UBAH</button>
								<?php } ?>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="panel panel-primary">
					<div class="panel-heading">Daftar Menu</div>
					<div class="panel-body">
						<form method="post">
							<div class="table-responsive">
								<table class="table table-hover table-bordered table-striped">
									<div class="col-md-12" style="margin-bottom:10px;">
										<div class="input-group">
											<input type="text" name="tcari" value="<?php echo @$text; ?>" class="form-control" placeholder="Cari Menu" maxlength="50">
											<span class="input-group-btn">
												<button type="submit"  name="bcari" class="btn btn-primary"><div class="glyphicon glyphicon-search"></div></button>
												<button type="submit" name="refresh" class="btn btn-success"><div class="glyphicon glyphicon-refresh">Refresh</div></button>
											</span>
										</div>
									</div>
									<!-- <div class="col-md-12" style="margin-left:-10px;margin-top:10px;">
										<br>
										<label>Tampilkan Data Sebanyak :</label>
										<select>
											<option>10</option>
											<option>25</option>
											<option>50</option>
											<option>100</option>
										<label>Baris</label>
										</select>
									</div> -->
									<tr id="pri">
										<th>No.</th>
										<th>Kode Menu</th>
										<th>Nama Menu</th>
										<th>Jenis Menu</th>
										<th>Harga Menu</th>
										<th width="7%">Hapus</th>
										<th width="7%">Edit</th>
										
									</tr>
									<tbody>
										<tr>
											<?php  
												$a = $aksi->tampil("tbl_menu",$cari," ORDER BY kd_menu DESC");
												@$no = 0;
												if ($a=="") {
													echo "<tr><td colspan='11' align='center'><b>Data Tidak Ada</b></td></tr>";
												}else{
													foreach ($a as $data) {
														$no++;
														?>
												
														<td><center><b><?php echo $no; ?>.</b></center></td>
														<td><?php echo $data[0] ?></td>
														<td><?php echo $data[1]; ?></td>
														<td><?php echo $data[3]; ?></td>

														<td align="right"><?php echo number_format($data[2],0,'','.'); ?></td>
														<td><a href="?menu=menu&hapus&id=<?php echo $data[0];?>" onClick="return confirm('Anda Yakin Akan Menghapus Menu <?php echo $data[1] ?> ini ?')"><center><span class="glyphicon glyphicon-trash" id="red"></span></center></a></td>
														<td><a href="?menu=menu&edit&id=<?php echo $data[0]; ?>"><center><span class="glyphicon glyphicon-edit"></span></center></a></td>
													</tr>
										<?php	} } ?>
									</tbody>
								</table>
							</div>
							</form>
					</div>
					<div class="panel-footer">&nbsp;</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>