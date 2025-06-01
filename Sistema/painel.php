<?php 
  session_start();
  include('backend/funcoes.php');

  // Calcular os valores para os gráficos
  /*$entradas [
      (int)qtdEntradas()
  ];

  $saidas = [
      (int)qtdSaidas()
  ];*/
  /*var_dump($entradas);
  var_dump($saidas);
  die();*/
  //var_dump(descrTipoUsuarioBarras());
  //die();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ParkWay - Dashboard</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>
<body class="hold-transition sidebar-mini layout-fixed dados-diarios">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('partes/navbar.php'); ?>
  <!-- Fim Navbar -->

  <!-- Sidebar -->
  <?php 
    if ($_SESSION['idTipoUsuario'] == 1 || $_SESSION['idTipoUsuario'] == 3) {
        $_SESSION['menu-n1'] = 'administrador';
    } else if ($_SESSION['idTipoUsuario'] == 2) {
        $_SESSION['menu-n1'] = 'funcionario';
    } else {
        $_SESSION['menu-n1'] = ''; // ou outro valor padrão
    }
    $_SESSION['menu-n2'] = 'painel'; // submenu que quer ativar
    include('partes/sidebar.php'); 
  ?>
  <!-- Fim Sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <!-- Espaço -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner" style="background-color: #263c52 !important;">
                <h3><?php echo qtdVagasAtivasDiario();?></h3>

                <p>Vagas Ativas</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner" style="background-color: #1a331f !important;">
                <h3><?php echo qtdEntradasDiario();?></h3>

                <p>Entradas Diárias</p>
              </div>
              <div class="icon">
                <i class="fas fa-sign-in-alt"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner" style="background-color: #360a0a !important;">
                <h3><?php echo qtdSaidasDiario();?></h3>

                <p>Saídas Diárias</p>
              </div>
              <div class="icon">
                <i class="fas fa-sign-out-alt"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner" style="background-color: #323b3f !important;">
                <h3><?php echo TempoMedioDiario();?></h3>

                <p>Tempo Médio de </p>
                <p>Permanência Diário</p>
              </div>
              <div class="icon">
                <i class="fas fa-parking"></i>
              </div>
            </div>
          </div>
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
              
            <!-- BAR CHART -->
            <div class="card text-success">
              <div class="card-header">
                <h3 class="card-title">Entradas e Saídas Diarias</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool text-verde-escuro" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool text-vermelho-escuro" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </section>

          <section class="col-lg-6 connectedSortable">
              
            <!-- BAR CHART -->
            <div class="card text-success">
              <div class="card-header">
                <h3 class="card-title">Permanências por Hora Diária</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool text-verde-escuro" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool text-vermelho-escuro" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- JS -->
<?php include('partes/js.php'); ?>
<!-- Fim JS -->

<script>
    var areaChartData = {
      //labels  : ['Administrador','Empresa','Comum'],
      labels  : ['Movimentações'],
      datasets: [
        
        {
          label               : 'Entradas',
          backgroundColor     : '#1a331f',
          borderColor         : '#1a331f',
          borderWidth         : 0,
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : '#1a331f',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: '#1a331f',
          data                : [<?php echo qtdEntradasDiario(); ?>]
        },
        
        {
          label               : 'Saídas',
          backgroundColor     : '#360a0a',
          borderColor         : '#360a0a',
          borderWidth         : 0,
          pointRadius         : false,
          pointColor          : '#360a0a',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: '#360a0a',
          data                : [<?php echo qtdSaidasDiario(); ?>]
        },
        
      ]
    }
    
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      // Scales para o gráfico começar no valor '0 (zero)'
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
     // GRÁFICO DE PIZZA
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
      labels: ['Acima de 1 Hora', 'Abaixo de 1 Hora'],
      datasets: [{
        data: [<?php echo intval(qtdAcimaHoraDiario()); ?>, <?php echo intval(qtdAbaixoHoraDiario()); ?>],
        backgroundColor: ['#1a331f', '#360a0a'],
        borderColor: ['#1a331f', '#360a0a'],
        borderWidth: 1
      }]
    }

    var pieOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }

    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })
</script>

</body>
</html>
