<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $title; ?></h3>
    <small class="pull-right"><?php echo anchor('product/add','TAMBAH DATA',array('class'=>'btn btn-success btn-sm')); ?></small>
  </div>
  <div class="box-body">
  	<table class="table table-striped table-hover" id="table-data">
  		<thead>
        <tr>
          <th width="3%">NO</th>
          <th>KODE</th>
          <th>NAMA PRODUK</th>
          <th>KATEGORI</th>
          <th style="text-align:center">STOK</th>
          <th style="text-align:center">TERJUAL</th>
          <th style="text-align:center">KELUAR</th>
          <th style="text-align:center">SISA</th>
          <th style="text-align:center">SATUAN</th>
          <th>HARGA BELI</th>
          <th>HARGA JUAL</th>
          <th width="2%">#</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=(int)1; foreach ($product as $rows): ?>
          <tr>
            <td><?php echo $no++;?></td>
            <td><?php echo $rows->kd_prod;?></td>
            <td><?php echo $rows->nm_prod;?></td>
            <td><?php echo $rows->nm_kategori;?></td>
            <td style="text-align:center"><?php echo $rows->stok;?></td>
            <td style="text-align:center"><?php echo $rows->dijual;?></td>
            <td style="text-align:center"><?php echo $rows->keluar;?></td>
            <td style="text-align:center"><?php echo $rows->sisa;?></td>
            <td style="text-align:center"><?php echo $rows->satuan;?></td>
            <td><?php echo number_format($rows->harga_beli,0,',','.');?></td>
            <td><?php echo number_format($rows->harga_jual,0,',','.');?></td>
            <td>
              <?php echo anchor('product/edit/'.$rows->kd_prod, '<i class="fa fa-pencil"></i>',array('class'=>'btn btn-success btn-xs'));?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
  	</table>
  </div>
</div>
<script type="text/javascript">
  $('#table-data').DataTable({
    "processing": true,
    "lengthMenu": [[15,50,100,500, -1], [15,50,100,500, "All"]],
    //"order":[[0,"asc" ]],
    "columnDefs": [
      {"targets": [0,8],orderable: false},
      {className: 'text-center', targets: [4,5,6,7]},
    ]
  });
</script>