<?php
include "models/m_barang.php";
$brg = new Barang($connection );

if(@$_GET['act'] == ''){

?>

        <div class="row">
          <div class="col-lg-12">
            <h1>Barang <small>Data Barang</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="icon-dashboard"></i> Barang</a></li>    
            </ol>
          </div>
        </div><!-- /.row -->

        <div class="row">
            <div clas="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="datatables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga Barang</th>
                                <th>Stok Barang</th>
                                <th>Gambar barang</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $tampil = $brg->tampil();
                                while($data = $tampil->fetch_object()){
                            ?>
                            <tr>
                                <td align="center"><?php echo $no++."."; ?></td>
                                <td><?php echo $data->nama_brg;   ?></td>
                                <td><?php echo $data->harga_brg;   ?></td>
                                <td><?php echo $data->stok_brg;  ?></td>
                                <td align="center">
                                    <img src="assets/img/barang/<?php echo $data->gbr_brg;   ?>" width="70px">
                                    
                                    </td>
                                
                                <td align="center">
                                    <a id="edit_brg" data-toggle="modal" data-target="#edit" data-id="<?php  echo $data->id_brg; ?>" data-nama="<?php  echo $data->nama_brg; ?>" data-harga="<?php  echo $data->harga_brg; ?>" data-stok="<?php  echo $data->stok_brg; ?>" data-gbr="<?php  echo $data->gbr_brg; ?> ">
                                        <button class="btn btn-info btn-xs"><i class="fa fa-edit"> </i> Edit</button></a>
                                    <a href="?page=barang&act=del&id=<?php echo $data->id_brg ?>" onclick="return confirm('Yakin ingin Menghapus data ?')">
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"> </i> Delete </button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                         } ?>
                         </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"> </i> Tambah Data </button>
                <a href="./report/export_excel.php" target="_blank">
                    <button class="btn btn-default" ><i class="fa fa-print"> </i> Export Data excel </button>
                </a>

               <!-- modal tambah --> 
                <div id="tambah" class="modal fade" role="dialog">
                         <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h1 class="modal-title">Tambah Data barang</h1>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label" for="nm_brg">Nama barang</label>
                                            <input type="text" name="nm_brg" class="form-control" id="nm_brg"required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="hrg_brg">Harga barang</label>
                                            <input type="number" name="hrg_brg" class="form-control" id="hrg_brg"required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="stok_brg">Stock barang</label>
                                            <input type="number" name="stok_brg" class="form-control" id="stok_brg"required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="gbr_brg">Gambar barang</label>
                                            <input type="file" name="gbr_brg" class="form-control" id="gbr_brg"required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <input type="submit" name="tambah" class="btn btn-success" value="Simpan">
                                    </div> 
                                </form>
                                <?php 
                                if(@$_POST['tambah']){
                                    $nm_brg = $connection->conn->real_escape_string($_POST['nm_brg']);
                                    $harga_brg = $connection->conn->real_escape_string($_POST['hrg_brg']);
                                    $stok_brg = $connection->conn->real_escape_string($_POST['stok_brg']);
                               
                                    $extensi = explode(".", $_FILES['gbr_brg']['name']);
                                    $gbr_brg = "brg-".round(microtime(true)).".".end($extensi);
                                    $sumber = $_FILES['gbr_brg']['tmp_name'];

                                    $upload = move_uploaded_file($sumber, "assets/img/barang/".$gbr_brg);
                                    if($upload){
                                        $brg->tambah($nm_brg, $harga_brg, $stok_brg, $gbr_brg);
                                        header("location: ?page=barang");
                                    }else{
                                        echo "<script>alert('Upload gambar gagal.!')</script>";
                                    }
                                }
                                ?>
                            </div>
                         </div>
                      </div>
                        <!--modal edit -->
                        <div id="edit" class="modal fade" role="dialog">
                         <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h1 class="modal-title">Edit Data barang</h1>
                                </div>
                                <form id="form" enctype="multipart/form-data">
                                    <div class="modal-body" id="modal-edit">
                                        <div class="form-group">
                                            <label class="control-label" for="nm_brg">Nama barang</label>
                                            <input type="hidden" name="id_brg" id="id_brg">
                                            <input type="text" name="nm_brg" class="form-control" id="nm_brg"required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="hrg_brg">Harga barang</label>
                                            <input type="number" name="hrg_brg" class="form-control" id="hrg_brg"required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="stok_brg">Stock barang</label>
                                            <input type="number" name="stok_brg" class="form-control" id="stok_brg"required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="gbr_brg">Gambar barang</label>
                                            <div style="padding-bottom:5px;">
                                                <img src="" width="80px" id="pict">
                                            </div>
                                            <input type="file" name="gbr_brg" class="form-control" id="gbr_brg">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" name="edit" class="btn btn-success" value="Simpan">
                                    </div> 
                                </form>
                            </div>
                         </div>
                      </div>
                      <script src="assets/js/jquery-1.10.2.js"></script>
                      <script type="text/javascript">
                      $(document).on("click","#edit_brg", function(){
                          var idbrg = $(this).data('id');
                          var nmbrg = $(this).data('nama');
                          var hrgbrg = $(this).data('harga');
                          var stokbrg = $(this).data('stok');
                          var gbrbrg = $(this).data('gbr');
                          $(".modal-body #id_brg").val(idbrg);
                            $(".modal-body #nm_brg").val(nmbrg);
                            $(".modal-body #hrg_brg").val(hrgbrg);
                            $(".modal-body #stok_brg").val(stokbrg);
                            $(".modal-body #pict").attr("src", "assets/img/barang/"+gbrbrg);
                      });
                      $(document).ready(function(e){
                            $("#form").on("submit", (function(e){
                                e.preventDefault();
                                $.ajax({
                                    url: 'models/proses_edit_barang.php', //call models
                                    type: 'POST',
                                    data: new FormData(this),
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(msg){
                                        $('.table').html(msg);
                                    }
                                
                                });
                            }));
                      })
                      
                      </script>

            </div>
        </div>
<?php
} else if(@$_GET['act'] == 'del'){
    $gbr_awal = $brg->tampil($_GET['id'])->fetch_object()->gbr_brg;
    unlink("assets/img/barang/".$gbr_awal);//menghapus gambar pda direktori

    $brg->hapus($_GET['id']);
    header("location: ?page=barang ");
}
?>