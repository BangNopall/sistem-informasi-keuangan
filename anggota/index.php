<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>


  <section class="content">

    <div class="row">

      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php
            $tanggal = date('Y-m-d');
            $pemasukan = mysqli_query($koneksi, "SELECT sum(transaksi_nominal) as total_pemasukan FROM transaksi WHERE transaksi_jenis='Pemasukan' and transaksi_tanggal='$tanggal'");
            $p = mysqli_fetch_assoc($pemasukan);
            $total_pemasukan = $p['total_pemasukan'] !== null ? $p['total_pemasukan'] : 0;
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. " . number_format($total_pemasukan) . " ,-" ?></h4>
            <p>Pemasukan Hari Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php
            $bulan = date('m');
            $pemasukan = mysqli_query($koneksi, "SELECT sum(transaksi_nominal) as total_pemasukan FROM transaksi WHERE transaksi_jenis='Pemasukan' and month(transaksi_tanggal)='$bulan'");
            $p = mysqli_fetch_assoc($pemasukan);
            $total_pemasukan = $p['total_pemasukan'] !== null ? $p['total_pemasukan'] : 0;
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. " . number_format($total_pemasukan) . " ,-" ?></h4>
            <p>Pemasukan Bulan Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php
            $pemasukan = mysqli_query($koneksi, "SELECT sum(transaksi_nominal) as total_pemasukan FROM transaksi WHERE transaksi_jenis='Pemasukan'");
            $p = mysqli_fetch_assoc($pemasukan);
            $total_pemasukan = $p['total_pemasukan'] !== null ? $p['total_pemasukan'] : 0;
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. " . number_format($total_pemasukan) . " ,-" ?></h4>
            <p>Seluruh Pemasukan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>



      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <?php
            $tanggal = date('Y-m-d');
            $pengeluaran = mysqli_query($koneksi, "SELECT sum(transaksi_nominal) as total_pengeluaran FROM transaksi WHERE transaksi_jenis='pengeluaran' and transaksi_tanggal='$tanggal'");
            $p = mysqli_fetch_assoc($pengeluaran);
            $total_pengeluaran = $p['total_pengeluaran'] !== null ? $p['total_pengeluaran'] : 0;
            ?>

            <h4 style="font-weight: bolder"><?php echo "Rp. " . number_format($total_pengeluaran) . " ,-" ?></h4>
            <p>Pengeluaran Hari Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <?php
            $bulan = date('m');
            $pengeluaran = mysqli_query($koneksi, "SELECT sum(transaksi_nominal) as total_pengeluaran FROM transaksi WHERE transaksi_jenis='pengeluaran' and month(transaksi_tanggal)='$bulan'");
            $p = mysqli_fetch_assoc($pengeluaran);
            $total_pengeluaran = $p['total_pengeluaran'] !== null ? $p['total_pengeluaran'] : 0;
            ?>

            <h4 style="font-weight: bolder"><?php echo "Rp. " . number_format($total_pengeluaran) . " ,-" ?></h4>
            <p>Pengeluaran Bulan Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <?php
            $pengeluaran = mysqli_query($koneksi, "SELECT sum(transaksi_nominal) as total_pengeluaran FROM transaksi WHERE transaksi_jenis='pengeluaran'");
            $p = mysqli_fetch_assoc($pengeluaran);
            $total_pengeluaran = $p['total_pengeluaran'] !== null ? $p['total_pengeluaran'] : 0;
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. " . number_format($total_pengeluaran) . " ,-" ?></h4>
            <p>Seluruh Pengeluaran</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

    </div>























    <!-- /.row -->
    <!-- Main row -->
    <div class="row">

      <!-- Left col -->
      <section class="col-lg-8">

        <div class="nav-tabs-custom">

          <ul class="nav nav-tabs pull-right">
            <!-- <li><a href="#tab2" data-toggle="tab">Pemasukan</a></li> -->
            <li class="active"><a href="#tab1" data-toggle="tab">Pemasukan & Pengeluaran</a></li>
            <li class="pull-left header">Grafik</li>
          </ul>

          <div class="tab-content" style="padding: 20px">

            <div class="chart tab-pane active" id="tab1">


              <h4 class="text-center">Grafik Data Pemasukan & Pengeluaran Per <b>Bulan</b></h4>
              <canvas id="grafik1" style="position: relative; height: 300px;"></canvas>

              <br />
              <br />
              <br />
            </div>
            <div class="chart tab-pane" id="tab2" style="position: relative; height: 300px;">
              b
            </div>
          </div>

        </div>

      </section>
      <!-- /.Left col -->


      <section class="col-lg-4">


        <!-- Calendar -->
        <div class="box box-solid bg-green-gradient">
          <div class="box-header">
            <i class="fa fa-calendar"></i>
            <h3 class="box-title">Kalender</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <!--The calendar -->
            <div id="calendar" style="width: 100%"></div>
          </div>
          <!-- /.box-body -->
        </div>


      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->










  </section>

</div>







<?php include 'footer.php'; ?>