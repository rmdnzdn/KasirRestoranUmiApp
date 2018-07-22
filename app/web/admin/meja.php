<?php    
    if(!isset($_GET['menu'])){
        header("location:index.php?menu=meja");
    }
    @$meja = $_POST['tjenis'];
    @$table = "tbl_meja";
    @$alamat = "?menu=meja";
    @$where = "id = $_GET[id]";
    @$field = array('no_meja' => $meja,'status'=>'0');

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
        $aksi->ubah($table,$field,$where,$alamat);
    }

    if (isset($_POST['bcari'])) {
        @$text = $_POST['tcari'];
        @$cari = "WHERE no_meja LIKE '%$text%'";
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
    <title>MEJA</title>
</head>
<body>
<br><br><br><br>
<div class="container"> 
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2"></div>    
            <div class="col-md-8">
                <div class="panel panel-primary">       
                    <?php if(!isset($_GET['edit'])){ ?>
                        <div class="panel-heading">Tambah Meja
                    <?php }else{ ?>
                        <div class="panel-heading">Ubah Meja
                    <?php } ?>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="input-group">
                                <span class="input-group-addon"><div class="glyphicon glyphicon-tags"></div></span> 
                                <input type="text" name="tjenis"class="form-control" placeholder="Masukan Nama Meja" autofocus tabindex="0" autocomplete="off" required maxlength="25" value="<?php echo @$edit['no_meja']; ?>"> 
                                <span class="input-group-btn">
                                    <?php  
                                    if (@$_GET['id']=="") { ?>
                                        <button type="submit" name="bsimpan" class="btn btn-primary btn-block" tabindex="0">SIMPAN
                                    <?php }else{ ?>
                                        <button type="submit" name="bubah" class="btn btn-success btn-block" tabindex="0">UBAH
                                    <?php }?>
                                    </button>
                                </span>
                            </div>  
                        </form>
                    </div>  
                    <div class="panel-footer">&nbsp;</div>
                </div>
            </div>  
        </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">Daftar Meja</div>
                <div class="panel-body">
                <form method="post">
                    <div class="col-md-12"style="margin-bottom:10px;">
                        <div class="input-group">
                            <input type="text" name="tcari" value="<?php echo @$text; ?>" class="form-control" placeholder="Cari Meja "maxlength="25">
                            <span class="input-group-btn">
                                <button type="submit"  name="bcari" class="btn btn-primary"><div class="glyphicon glyphicon-search"></div></button>
                                <button type="submit" name="refresh" class="btn btn-success"><div class="glyphicon glyphicon-refresh">Refresh</div></button>
                            </span>
                        </div>
                    </div>
                <!--    <div class="col-md-12" style="margin-left:-10px;margin-top:10px;">
                        <label>Tampilkan Data Sebanyak :</label>
                        <select name="baris" onchange="submit()">
                            <option><?php if(isset($_POST['baris'])){echo $_POST['baris'];}else{echo "10";} ?></option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label>Baris</label>
                    </div> -->
                    <div class="table table-responsive" style="margin-top:10px;">   
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr id="pri">
                                    <td width="6%">No.</td>
                                    <td width="20%">ID Meja</td>
                                    <td>Nama Meja </td>
                                    <td>Status</td>
                                    <td width="10%"><center>Hapus</center></td>
                                    <td width="10%"><center>Edit</center></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php    
                                        $a = $aksi->tampil($table,$cari,"ORDER BY id DESC");
                                        @$no = 0;
                                        if ($a == "") {
                                            echo "<tr><td colspan='5' align='center'>Data Tidak Ada !!!</td></tr>";
                                        }else{
                                            foreach($a as $data){
                                                $idjenis = $data[0];
                                                $jns = $data[1];
                                                $no++;
                                                ?>

                                                <td><center><b><?php echo $no; ?></b></center></td>
                                                <td><?php echo $idjenis; ?></td>
                                                <td><?php echo $jns; ?></td>
                                                <td><?php echo $data[2] ?></td>
                                                <td><center><a href="?menu=meja&hapus&id=<?php echo $idjenis; ?>" onClick="return confirm('Yakin Akan Menghapus data <?php echo $jns; ?> ini ?')"><span class="glyphicon glyphicon-trash" id="red"></span></a></center></td>
                                                <td><center><a href="?menu=meja&edit&id=<?php echo $idjenis; ?>"><span class="glyphicon glyphicon-edit"></span></a></center></td>
                                </tr>
                                <?php   }} ?>
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