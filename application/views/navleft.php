<?php defined('BASEPATH') OR exit('No direct script access allowed');$this->load->model('alert_model');
  $alert=$this->alert_model->alert_on_loan()->row();?>
<?php if ($this->ion_auth->is_admin()): ?>
<ul class="sidebar-menu" data-widget="tree">
  <li class="header text-green">MENU NAVIGASI</li>
  <li class="<?php echo activate_dashboard('home');?>">
    <?php echo anchor('home', '<i class="fa fa-home"></i> <span>BERANDA</span>'); ?>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-database"></i><span>MASTER DATA</span>
      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
      <li class="<?php echo activate_dashboard('members');?>">
        <?php echo anchor('members','<i class="fa fa-circle-o"></i> ANGGOTA'); ?>
      </li>
      <li class="<?php echo activate_dashboard('product');?>">
        <?php echo anchor('product','<i class="fa fa-circle-o"></i> PRODUK'); ?>
      </li>
      <li class="<?php echo activate_dashboard('category');?>">
        <?php echo anchor('category','<i class="fa fa-circle-o"></i> KATEGORI PRODUK'); ?>
      </li>
      <li class="<?php echo activate_dashboard('users');?>">
        <?php echo anchor('users', '<i class="fa fa-circle-o"></i> USERS'); ?>
      </li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-file-text"></i><span>TRANSAKSI</span>
      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
      <li class="header text-green">KAS MASUK</li>
      <li class="<?php echo activate_dashboard('installment');?>">
        <?php echo anchor('installment', '<i class="fa fa-circle-o"></i> ANGSURAN'); ?>
      </li>
      <li class="<?php echo activate_dashboard('deposit');?>">
        <?php echo anchor('deposit', '<i class="fa fa-circle-o"></i> SIMPANAN'); ?>
      </li>
      <li class="<?php echo activate_dashboard('sales');?>">
        <?php echo anchor('sales', '<i class="fa fa-circle-o"></i> PENJUALAN'); ?>
      </li>
      <li class="header text-green">KAS KELUAR</li>
      <li class="<?php echo activate_dashboard('withdrawal');?>">
        <?php echo anchor('withdrawal', '<i class="fa fa-circle-o"></i> PENARIKAN SIMPANAN'); ?>
      </li>
      <li class="<?php echo activate_dashboard('loan_in');?>">
        <?php echo anchor('loan_in','<i class="fa fa-circle-o"></i> PINJAMAN KOPERASI'); ?>
      </li>
      <li class="<?php echo activate_dashboard('loan_out');?>">
        <?php echo anchor('loan_out', '<i class="fa fa-circle-o"></i> PINJAMAN BANK'); ?>
      </li>
    </ul>
  </li>
  <li class="<?php echo activate_dashboard('loan');?>">
    <a href="<?php echo site_url('loan') ?>">
      <i class="fa fa-clone"></i> <span>PERSETUJUAN</span>
      <span class="pull-right-container">
        <?php if ($alert->new_loan>(int)0) : ?>
          <label class="label pull-right bg-blue"><?php echo (int)$alert->new_loan;?></label>
        <?php endif ?>
      </span>
    </a>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-book"></i><span>REKAP</span>
      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
      <li class="<?php echo activate_dashboard('net_income');?>">
        <?php echo anchor('net_income', '<i class="fa fa-circle-o"></i> SISA HASIL USAHA'); ?>
      </li>
    </ul>
  </li>
  <li class="header text-green">LAPORAN</li>
  <li class="<?php echo activate_dashboard('report');?>">
    <?php echo anchor('report','<i class="fa fa-print"></i> <span>LAPORAN</span>'); ?>
  </li>
</ul>
<?php elseif ($this->ion_auth->in_group((int)2)): // Admin Koperasi?>
<ul class="sidebar-menu" data-widget="tree">
  <li class="header text-green">MENU NAVIGASI</li>
  <li class="<?php echo activate_dashboard('home');?>">
    <?php echo anchor('home', '<i class="fa fa-home"></i> <span>BERANDA</span>'); ?>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-database"></i><span>MASTER DATA</span>
      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
      <li class="<?php echo activate_dashboard('members');?>">
        <?php echo anchor('members','<i class="fa fa-circle-o"></i> ANGGOTA'); ?>
      </li>
      <li class="<?php echo activate_dashboard('product');?>">
        <?php echo anchor('product','<i class="fa fa-circle-o"></i> PRODUK'); ?>
      </li>
      <li class="<?php echo activate_dashboard('category');?>">
        <?php echo anchor('category','<i class="fa fa-circle-o"></i> KATEGORI PRODUK'); ?>
      </li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-file-text"></i><span>TRANSAKSI</span>
      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
      <li class="header text-green">KAS MASUK</li>
      <li class="<?php echo activate_dashboard('installment');?>">
        <?php echo anchor('installment', '<i class="fa fa-circle-o"></i> ANGSURAN'); ?>
      </li>
      <li class="<?php echo activate_dashboard('deposit');?>">
        <?php echo anchor('deposit', '<i class="fa fa-circle-o"></i> SIMPANAN'); ?>
      </li>
      <!--
      <li class="<?php echo activate_dashboard('sales');?>">
        <?php echo anchor('sales', '<i class="fa fa-circle-o"></i> PENJUALAN'); ?>
      </li>
      -->
      <li class="header text-green">KAS KELUAR</li>
      <li class="<?php echo activate_dashboard('withdrawal');?>">
        <?php echo anchor('withdrawal', '<i class="fa fa-circle-o"></i> PENARIKAN SIMPANAN'); ?>
      </li>
      <li class="<?php echo activate_dashboard('loan_in');?>">
        <?php echo anchor('loan_in','<i class="fa fa-circle-o"></i> PINJAMAN KOPERASI'); ?>
      </li>
      <li class="<?php echo activate_dashboard('loan_out');?>">
        <?php echo anchor('loan_out', '<i class="fa fa-circle-o"></i> PINJAMAN BANK'); ?>
      </li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-book"></i><span>REKAP</span>
      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
      <li class="<?php echo activate_dashboard('net_income');?>">
        <?php echo anchor('net_income', '<i class="fa fa-circle-o"></i> SISA HASIL USAHA'); ?>
      </li>
    </ul>
  </li>
  <li class="header text-green">LAPORAN</li>
  <li class="<?php echo activate_dashboard('report');?>">
    <?php echo anchor('report','<i class="fa fa-print"></i> <span>LAPORAN</span>'); ?>
  </li>
</ul>
<?php elseif($this->ion_auth->in_group((int)3)): //Advisor?>
<ul class="sidebar-menu" data-widget="tree">
  <li class="header text-green">MENU NAVIGASI</li>
  <li class="<?php echo activate_dashboard('home');?>">
    <?php echo anchor('home', '<i class="fa fa-home"></i> <span>BERANDA</span>'); ?>
  </li>
  <li class="<?php echo activate_dashboard('loan');?>">
    <a href="<?php echo site_url('loan') ?>">
      <i class="fa fa-clone"></i> <span>PERSETUJUAN</span>
      <span class="pull-right-container">
        <?php if ($alert->new_loan>(int)0) : ?>
          <label class="label pull-right bg-blue"><?php echo (int)$alert->new_loan;?></label>
        <?php endif ?>
      </span>
    </a>
  </li>
  <li class="header text-green">LAPORAN</li>
  <li class="<?php echo activate_dashboard('report');?>">
    <?php echo anchor('report','<i class="fa fa-print"></i> <span>LAPORAN</span>'); ?>
  </li>
</ul>
<?php elseif($this->ion_auth->in_group((int)6)): //Pesonalia?>
<ul class="sidebar-menu" data-widget="tree">
  <li class="header text-green">MENU NAVIGASI</li>
  <li class="<?php echo activate_dashboard('home');?>">
    <?php echo anchor('home', '<i class="fa fa-home"></i> <span>BERANDA</span>'); ?>
  </li>
  <li class="<?php echo activate_dashboard('loan');?>">
    <a href="<?php echo site_url('loan') ?>">
      <i class="fa fa-clone"></i> <span>PERSETUJUAN</span>
      <span class="pull-right-container">
        <?php if ($alert->new_loan>(int)0) : ?>
          <label class="label pull-right bg-blue"><?php echo (int)$alert->new_loan;?></label>
        <?php endif ?>
      </span>
    </a>
  </li>
</ul>
<?php endif ?>