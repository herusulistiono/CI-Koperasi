<div class="row">
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo $members->member_active; ?></h3>
        <p>Anggota Aktif</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-people-outline"></i>
      </div>
      <span class="small-box-footer">&nbsp;<i class="fa fa-arrow-circle-right"></i></span>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $loan->new_loan; ?></h3>
        <p>Pinjaman Baru</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-copy-outline"></i>
      </div>
      <span class="small-box-footer">&nbsp;<i class="fa fa-arrow-circle-right"></i></span>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $loan_acc->acc; ?></h3>
        <p>Pinjaman Disetujui</p>
      </div>
      <div class="icon">
        <i class="ion ion-checkmark"></i>
      </div>
      <span class="small-box-footer">&nbsp;<i class="fa fa-arrow-circle-right"></i></span>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?php echo $loan_den->acc; ?></h3>
        <p>Pinjaman Ditolak</p>
      </div>
      <div class="icon">
        <i class="ion ion-backspace-outline"></i>
      </div>
      <span class="small-box-footer">&nbsp;<i class="fa fa-arrow-circle-right"></i></span>
    </div>
  </div>
</div>
<!-- <div class="row">
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo number_format($amount_savings->total_simpanan,0,',',','); ?></h3>
        <p>Total Simpanan Per <?php echo date('Y') ?></p>
      </div>
      <div class="icon">
        <i class="ion ion-cash"></i>
      </div>
      <span class="small-box-footer">&nbsp;<i class="fa fa-arrow-circle-right"></i></span>
    </div>
  </div>
</div> -->