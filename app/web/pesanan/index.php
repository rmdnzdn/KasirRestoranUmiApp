<?php  
	include '../config/koneksi.php';
	include '../library/fungsi.php';
	@$aksi = new oop();

	@$today = date("dmY");
	@$sql = mysql_query("SELECT * FROM tbl_pesanan WHERE kd_pesanan LIKE '$today%' ORDER BY kd_pesanan DESC");
	@$k = mysql_fetch_array($sql);

	if ($k == "") {
		@$urut = "0001"; 
	}else{
		@$urut = substr($k['kd_pesanan'], 8,4)+1;
		if (@$urut < 10) {
			@$urut = "000$urut";
		}elseif (@$urut < 100) {
			@$urut = "00$urut";
		}elseif (@$urut < 1000) {
			@$urut = "0$urut";
		}
	}

	@$kd_pesanan = "$today$urut";
	@$tgl_pesanan = date("Y-m-d");
	@$alamat="?menu=pesanan";

	@$kd_menu = $_POST['tmenu'];
	@$sql = mysql_query("SELECT * FROM tbl_menu WHERE kd_menu = '$kd_menu'");
	@$data_menu = mysql_fetch_array($sql);

	@$sql1 = mysql_query("SELECT * FROM tbl_pesanan_detail WHERE kd_pesanan='$kd_pesanan' AND kd_menu='$kd_menu'");
	@$tmp = mysql_fetch_array($sql1);

	@$jumlah = $_POST['tjumlah'];
	@$subtotal = $_POST['ttotal'];

	@$nama = $_POST['tnama'];
	@$hp = $_POST['thp'];
	@$no_meja = $_POST['tmeja'];

	@$s = mysql_query("SELECT SUM(subtotal) AS stl FROM tbl_pesanan_detail WHERE kd_pesanan = '$kd_pesanan'");
	@$l = mysql_fetch_array($sql);
	@$to = $l['stl'];

	@$field = array(
			'kd_pesanan'=>$kd_pesanan,
			'atas_nama'=>$nama,
			'no_hp'=>$hp,
			'no_meja'=>$no_meja,
			'total'=>$to,
			'tanggal_pesanan'=>$tgl_pesanan,
			'status'=>'0'
		);

	@$field_detail = array(
			'kd_pesanan'=>$kd_pesanan,
			'kd_menu'=>$kd_menu,
			'nama_menu'=>$data_menu['nama_menu'],
			'harga_menu'=>$data_menu['harga_menu'],
			'jumlah_beli'=>$jumlah,
			'subtotal'=>$subtotal
		);

	if (isset($_POST['simpan_detail'])) {
		if ($jumlah==0 || $jumlah=="") {
			$aksi->pesan("Jumlah tidak bisa kosong");
			$aksi->alamat($alamat);
		}else{
			if ($kd_menu==$tmp['kd_menu']) {
				mysql_query("UPDATE tbl_pesanan_detail SET jumlah_beli = jumlah_beli+$jumlah, subtotal=subtotal+$subtotal WHERE kd_pesanan='$kd_pesanan' AND kd_menu='$kd_menu'");
				$aksi->alamat($alamat);
			}else{
				$aksi->simpanlsg("tbl_pesanan_detail",$field_detail,$alamat);
			}
		}
	}

	if (isset($_GET['edit'])) {
		@$id = $_GET['id'];
		$edit = $aksi->edit("tbl_pesanan_detail"," id = '$id'");
	}
	@$slcid = $aksi->edit("tbl_menu","kd_menu = '$edit[2]'");

	if (isset($_GET['hapus'])) {
		@$id = $_GET['id'];
		$aksi->hapus("tbl_pesanan_detail","id = '$id'",$alamat);
	}

	if (isset($_POST['ubah_detail'])) {
		if ($jumlah==0 || $jumlah=="") {
			$aksi->pesan("Jumlah tidak bisa kosong");
		}else{
			@$id = $_GET['id'];
			
		}
	}

	if (isset($_POST['selesai'])) {	
			mysql_query("UPDATE tbl_meja SET status = 1 WHERE id='$kd_meja'");
			$aksi->simpan("tbl_pesanan",$field,$alamat);
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>FORM PEMESANAN</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<br><br>
<div class="container-fluid" style="margin:10px;">
	<div class="row">
	<form method="post">
		<div class="panel panel-primary">
			<div class="panel-heading"><center>FORM PEMESANAN - <?php echo $kd_pesanan; ?></center></div>
			<div class="panel-body">
				<div class="col-md-12">	
					<div class="col-md-4">
						<label>PILIH MEJA :</label>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><div class="glyphicon glyphicon-glass"></div></span>
								<select name="tmeja"  class="form-control">
									<?php  
										@$sql = mysql_query("SELECT * FROM tbl_meja WHERE status = '0'");
										while ($data = mysql_fetch_array($sql)) {?>
											<option value="<?php echo $data[0]; ?>"><?php echo $data[1]; ?></option>
										<?php } ?>
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<label>ATAS NAMA :</label>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><div class="glyphicon glyphicon-text-size"></div></span>
								<input type="text" name="tnama"  placeholder="Masukan Nama" class="form-control">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<label>No.HP :</label>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><div class="glyphicon glyphicon-phone"></div></span>
								<input type="text" name="thp" placeholder="Masukan No.HP Anda"  class="form-control"  maxlength="14" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-4">
						<div class="panel panel-primary">
							<div class="panel-heading">PILIH MENU</div>
							<div class="panel-body">
								<div class="col-md-12">
									<div class="form-group" >
										<label>JENIS MENU :</label>
										<select name="tjenis" class="form-control" onchange="submit()">
											<option selected disabled>Pilih Jenis Menu</option>
											<!-- <option value="<?php echo $slcid[3]; ?>" selected><?php echo $slcid[3]; ?></option> -->
											<?php @$a = mysql_query("SELECT * FROM tbl_menu GROUP BY jenis_menu"); 
											while ($data = mysql_fetch_array($a)) {?>
												<option value="<?php echo $data[3]; ?>" <?php if(@$_POST['tjenis']==$data[3]){echo "selected";} ?> ><?php echo $data[3]; ?></option>
											<?php } ?>
											
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group" >
										<label>PILIH MENU :</label>
										<select name="tmenu" class="form-control" onchange="submit()">
										<!-- <option <?php echo $edit[0]  ?> selected><?php echo $edit['nama_menu']." - ".$edit['harga_menu']; ?></option> -->
										<?php @$b = mysql_query("SELECT * FROM tbl_menu WHERE jenis_menu = '$_POST[tjenis]'");
											while ($data1 = mysql_fetch_array($b)) { ?>
												<option value="<?php echo $data1[0]; ?>" <?php if(@$_POST['tmenu']==$data1[0]){echo "selected";}elseif(@$_POST) ?>><?php echo $data1[1]." - ".$data1[2]; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group" >
										<label>HARGA MENU :</label>
										<?php $e = $aksi->edit("tbl_menu","kd_menu = '$_POST[tmenu]'"); ?>
										<input type="text" name="tharga" id="tharga" value="<?php if($_GET['id']){echo $edit['harga_menu'];}else{ echo $e[2];} ?>" placeholder="Harga Menu"  readonly class="form-control">
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>JUMLAH BELI :</label>
										<input type="text" name="tjumlah" id="tjumlah" value="<?php if($_GET['id']){echo $edit['jumlah_beli'];} ?>"  class="form-control"  placeholder="Banyak" maxlength="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' >	
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>TOTAL HARGA :</label>
											<input type="text" name="ttotal" id="ttotal" value="<?php echo @$edit['subtotal']; ?>" class="form-control"  placeholder="Total Harga" readonly onkeypress='return event.charCode >= 48 && event.charCode <= 57' >
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<?php if (@$_GET['id']=="") { ?>
											<button type="submit" name="simpan_detail" class="btn btn-block btn-lg btn-primary" tabindex="0">TAMBAH</button>			
										<?php }else{ ?>
											<button type="submit" name="ubah_detail" class="btn btn-block btn-lg btn-success" tabindex="0">UBAH</button>			
										<?php } ?>
									</div>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="panel panel-primary">
							<div class="panel-heading"><center>DAFTAR PESANAN</center></div>
							<div class="panel panel-body">
								<div class="table-responsive">
									<table class="table  table-striped table-hovered">
										<thead id="pri">
											<th><center>Menu</center></th>
											<th><center>Harga</center></th>
											<th><center>Jumlah</center></th>
											<th><center>Subtotal</center></th>
											<th width="10%"><center>AKSI</center></th>
										</thead>
										<tbody>
											<?php  
												$a = $aksi->tampil("tbl_pesanan_detail","WHERE kd_pesanan = '$kd_pesanan'","ORDER BY id ASC");
												if ($a == "") {
													echo "<tr><td colspan='6'><center>Belum Ada Menu yang dipesan</center></td></tr>";
												}else{
													foreach ($a as $r) {
												?>
												<tr>
													<td><center><?php echo $r['nama_menu']; ?></center></td>
													<td><center><?php echo  number_format($r['harga_menu'], 0,'','.') ; ?></center></td>
													<td><center><?php echo $r['jumlah_beli']; ?></center></td>
													<td align="right"><?php echo number_format($r['subtotal'],0,'','.'); ?></td>
													<!-- <td><a href="?menu=pesanan&edit&id=<?php echo $r[0]; ?>"><center><span class="btn btn-success btn-xs">EDIT</span></center></a></td> -->
													<td><a href="?menu=pesanan&hapus&id=<?php echo $r[0]; ?>"><center><span class="btn btn-danger btn-xs">HAPUS</span></center></a></td>
												<?php	} } ?>
												<?php 	
													@$sql = mysql_query("SELECT SUM(subtotal) AS stl FROM tbl_pesanan_detail WHERE kd_pesanan = '$kd_pesanan'");
													@$tl = mysql_fetch_array($sql);
													@$subtot = $tl['stl'];
												 ?>
												</tr>
										</tbody>
										<tr>
											<td colspan="3" align="right">Total :</td>
											<td align="right">Rp. <?php 	echo number_format(@$subtot, 0,'','.'); ?></td>
											<td colspan="2"></td>
										</tr>
									</table>
										<button type="submit" name="selesai" class="btn btn-primary btn-block" ><h4><b>SELESAI PEMESANAN</b></h4></button>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#tjumlah").keyup(function(){
				var harga = parseInt($("#tharga").val());
				var jumlah = parseInt($("#tjumlah").val());
				var total = harga * jumlah;
				$("#ttotal").val(total);
				
			})
		});
	</script>
</body>
</html>