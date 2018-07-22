<?php  
	include "../config/koneksi.php";
	include "../library/fungsi.php";
	date_default_timezone_set("Asia/Jakarta");

	@$aksi = new oop();
	session_start();
	
	@$home = "../index.php";

	if (isset($_GET['logout'])) {
		$aksi->logout();
		$aksi->alamat($home);
	}	


?>
<!DOCTYPE html>
<html>
<head>
    <title>ADMIN</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style type="text/css">
    	body{
    		background-color: rgba(0, 0, 0, 0.05);
    	}
    	#hov:hover{
    		display: block;
    		background-color: rgba(0, 0, 0, 0.4);
    		border-radius: 5px 5px;
    		color: #1a242f;
    		transition: 0.3s ease-in-out;
    	}
    </style>
    <script type="text/javascript">
    	window.setTimeout("waktu()",1000);
    	function waktu(){
    		var tanggal = new Date();
    		setTimeout("waktu()",1000);
    		document.getElementById("output").innerHTML = 
    		tanggal.getHours()+":"+tanggal.getMinutes()+":"+tanggal.getSeconds();
    	}
    </script>
    <script language="Javascript">
    	var tanggallengkap = new String();
    	var namahari = ("Minggu Senin Selasa Rabu Kamis Jum'at Sabtu");
    	namahari = namahari.split(" ");
    	var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
    	namabulan = namabulan.split(" ");
    	var tgl = new Date();
    	var hari = tgl.getDay();
    	var tanggal = tgl.getDate();
    	var bulan = tgl.getMonth();
    	var tahun= tgl.getFullYear();
    	tanggallengkap =namahari[hari] + ", " + tanggal + " " + namabulan[bulan] + " " + tahun;

    		var popupWindow = null;
    		function centerredPopup(url,winName,w,h,scroll){
    			LeftPosition = (screen.width) ?(screen.width-w)/2 : 0;
    			TopPosition = (screen.height) ?(screen.height-h)/2 : 0;
    			settings
    			='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
    			popupWindow = window.open(url,winName,settings)
    		}
    </script>
    
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toogle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>	
			<a class="navbar-brand" href="index.php">ADMIN</a>
		</div>
		<!-- akhir dari navbar atas -->
		<div class="navbar-collapse collaspse">
			<ul class="nav navbar-nav" id="hov">
				<li>
					<a href="?menu=menu"><div class="glyphicon glyphicon-tasks"></div>&nbsp;&nbsp;KELOLA MENU</a>
				</li>
			</ul>
			<ul class="nav navbar-nav" id="hov">
				<li>
					<a href="?menu=meja"><div class="glyphicon glyphicon-glass"></div>&nbsp;&nbsp;KELOLA MEJA</a>
				</li>
			</ul>
			<ul class="nav navbar-nav" id="hov">
				<li>
					<a href="?menu=user"><div class="glyphicon glyphicon-user"></div>&nbsp;&nbsp;KELOLA USER</a>
				</li>
			</ul>
			<ul class="nav navbar-nav" id="hov">
				<li>
					<a href="?logout" onclick="return confirm('Apakah Anda yakin akan keluar dari akun ?');"><div class="glyphicon glyphicon-circle-arrow-right"></div>&nbsp;&nbsp;Keluar</a>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li>
					<h4><a style="text-decoration:none;color:white;margin-right:30px;margin-top:10px;" class="nav navbar-nav navbar-right">
						<script language="javascript">document.write(tanggallengkap);</script>
					</h4></a>
				</li>
			</ul>
		</div>
	</nav>
	<?php  
		switch (@$_GET['menu']){
			case 'meja':include 'meja.php'; break;	
			case 'menu':include 'menu.php'; break;	
			case 'user':include 'user.php'; break;	
			case 'haladmin':include 'hal_admin.php'; break;	
			default:$aksi->alamat("index.php?menu=haladmin");break;
		}
	?>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../js/show-password.js"></script>
	<script>
		 $(function () {
	        $('#password').password().on('show.bs.password', function (e) {
	            $('#methods').prop('checked', true);
	        }).on('hide.bs.password', function (e) {
	            $('#methods').prop('checked', false);
	        });
	        $('#methods').click(function () {
	            $('#password').password('toggle');
	        });
	    });
	 </script>
</body>	
</html>