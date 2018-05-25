 <!DOCTYPE html>
 <html>
 <head>
 	<title>Belajar Codeigniter</title>
 	<!-- untuk memanggil bootstrap -->
 	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
 	<!-- untuk memanggil data table -->
 	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css');?>">
 </head>
 <body>

 <div class="container">
 	<h1>Membuat CRUD menggunakan Codeigniter dan Ajax</h1>
 	<button type="button" class="btn btn-success" onclick="add_book()">Tambah Data</i></button>
 	<br>
 	<br>

 	<table id="table_id" class="table table-stripped table-bordered">
 		<thead>
 			<tr>
	 			<th>Id</th>
	 			<th>No ISBN</th>
	 			<th>Judul Buku</th>
	 			<th>Penulis</th>
	 			<th>Kategori</th>
	 			<th>Aksi</th>
	 		</tr>

	 		<tbody>
	 			<?php 
	 			foreach($buku as $bk){

	 			?>
	 			<tr>
	 				<td><?php echo $bk->id_buku;?></td>
	 				<td><?php echo $bk->no_isbn;?></td>
	 				<td><?php echo $bk->judul_buku;?></td>
	 				<td><?php echo $bk->penulis;?></td>
	 				<td><?php echo $bk->kategori;?></td>
	 				<td>
	 					<button class="btn btn-warning" onclick="edit_book(<?php echo  $bk->id_buku;?>)"><i class="glyphicon glyphicon-pencil"></i>Edit
	 					</button>
	 					<button class="btn btn-danger" onclick="delete_book(<?php echo  $bk->id_buku;?>)"><i class="glyphicon glyphicon-remove"></i>Hapus
	 					</button>
	 				</td>
	 			</tr>

	 			<?php
	 			}
	 			?>
	 		</tbody>
 		</thead>
 		</table>
 </div>

 	<!-- Link ke JS -->
 	<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js');?>"></script>
 	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
 	<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js'); ?>"></script>
 	<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js'); ?>"></script>

 	<!-- JS -->
 	<script type="text/javascript">
 		//inisialisasi data tabel
 		$(document).ready(function() {
 			$('#table_id').DataTable();
 		});
 		var save_method;
 		var table;

 		//koding JS untuk menambah data buku
 		function add_book(){
 			save_method = 'add';
 			$('#form')[0].reset();
 			$('#modal_form').modal('show');
 		}

 		//untuk menyimpan ke database
 		function save(){
 			var url;

 			if(save_method == 'add'){
 				url = '<?php echo site_url('index.php/Book/tambah_data');?>';
 			} else {
 				url = '<?php echo site_url('index.php/Book/update_data');?>';
 			}
 			$.ajax({
 				url: url,
 				type: "POST",
 				data: $("#form").serialize(),
 				datatype: "JSON",
 				success: function(data){
 					$("#modal_form").modal('hide');
 					location.reload();
 				},
 				error: function(jqXHR, textStatus, errorThrown){
 					alert('Data gagal disimpan / diubah');
 				}
 			});
 		}

 		//untuk edit data buku berdasarkan id
 		function edit_book(id)
 		{
 			save_method = 'update';
 			$('#form')[0].reset();

 			//load data dari ajax
 			$.ajax({
 				url: "<?php echo site_url('index.php/book/ajax_edit/');?>/"+id,
 				type: "GET",
 				dataType: "JSON",
 				success: function(data){
 					$('[name="id_buku"]').val(data.id_buku);
 					$('[name="no_isbn"]').val(data.no_isbn);
 					$('[name="judul_buku"]').val(data.judul_buku);
 					$('[name="penulis"]').val(data.penulis);
 					$('[name="kategori"]').val(data.kategori);

 					$('#modal_form').modal('show');
 					$('.modal_title').text('Edit Buku');
 				},

 				error: function(jqXHR, textStatus, errorThrown){
 					alert('Gagal Update Data');
 				}
 			});
 		}

 		function delete_book(id)
 		{
 			if(confirm('apakah anda akan menghapus data ini')){
 			//ajax delete data dari database

 			$.ajax({
 				url: "<?php echo site_url('index.php/book/hapus_data');?>/"+id,
 				type:"POST",
 				dataType: "JSON",
 				success: function(data){
 					location.reload();
 				},
 				error: function(jqXHR, textStatus, errorThrown){
 					alert('Gagal Menghapus Data');
 				}
 			});
 		}
 	}

 	</script>

 	<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body form">
      	<form action="#" id="form" class="form-horizontal">
      		<!-- CREATE	 -->
      		<input type="hidden" value="" name="id_buku">

      		<div class="form-body">
      			<div class="form-group">
      				<label class="control-label col-md-3">No ISBN</label>
      				<div class="col-md-9">
      					<input type="text" name="no_isbn" placeholder="Masukan No ISBN" class="form-control">
      				</div>
      			</div>
      		</div>

      		<div class="form-body">
      			<div class="form-group">
      				<label class="control-label col-md-3">Judul Buku</label>
      				<div class="col-md-9">
      					<input type="text" name="judul_buku" placeholder="Masukan Judul Buku" class="form-control">
      				</div>
      			</div>
      		</div>

      		<div class="form-body">
      			<div class="form-group">
      				<label class="control-label col-md-3">Penulis</label>
      				<div class="col-md-9">
      					<input type="text" name="penulis" placeholder="Masukan Nama Penulis" class="form-control">
      				</div>
      			</div>
      		</div>

      		<div class="form-body">
      			<div class="form-group">
      				<label class="control-label col-md-3">Kategori Buku</label>
      				<div class="col-md-9">
      					<input type="text" name="kategori" placeholder="Masukan Kategori Buku" class="form-control">
      				</div>
      			</div>
      		</div>

      	</form>
      	<!-- END CREATE -->
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="save()" class="btn btn-primary">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>