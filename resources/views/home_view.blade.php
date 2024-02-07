<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> SIALIR KABUPATEN MADIUN</title>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('template')}}/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('template')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="{{asset('template')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="{{asset('template')}}/plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('template')}}/dist/css/adminlte.min.css">


<link rel="stylesheet" href="{{asset('template')}}/plugins/select2/css/select2.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{asset('template')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{asset('template')}}/plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="{{asset('template')}}/plugins/summernote/summernote-bs4.min.css">
<link rel="shortcut icon" type="image/jpg" href="{{ asset('img').'/logo-kab-madiun.png' }}"/>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        {{-- <img href="{{ asset('img').'/logo-kab-madiun.png' }}" width="20px"> --}}
        
        <img style="width: 40px;" src="{{ asset('img').'/logo-kab-madiun.png' }}" alt="logo" class="m-1">
        <a class="ml-2 align-bottom navbar-brand" href="#">
            <h3 aria-sort="margin-bottom:-40px !important;">SIALIR <br>    
                <small class="text-sm">Sistem Analisa Penggunaan Air Dan Listrik</small>
            </h3> 
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                        @if (Auth::check())
                        <a class="nav-link" href="/dashboard">
                            <i class="fas fa-tachometer-alt mr-1"></i>
                                Dashboard
                            </a>
                        @else
                            <a class="nav-link" href="/login">
                                <i class="fas fa-sign-in-alt mr-1"></i>
                                Login
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
    </nav>      

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="{{ asset('img').'/slide1.jpg' }}" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{ asset('img').'/slide2.jpg' }}" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{ asset('img').'/slide3.jpg' }}" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>
    
    <div class="canvas p-5 bg-light">

        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-5">Data Penggunaan Energi</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 pl-5 pr-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                            <p class="text-center">
                              <strong>Index Penggunaan</strong>
                            </p>
        
                            <div class="chart">
                              <!-- Sales Chart Canvas -->
                              <canvas id="barChart" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                          </div> 
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                    <!-- /.card-body -->
                  </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 pl-5 pr-5"> 
                <div class="card">
                  <div class="card-body">
                    <h5 class=" text-primary"><b>Data Konsumsi Energi Lisktik Bulanan</b></h5>
                     <table class="table p-0">
                      <thead>
                          <tr>
                              <th class="p-1 border text-center bg-light align-middle" rowspan="2">OPD</th>
                              <th class="p-1 border text-center bg-light align-middle" rowspan="2">Gedung</th>
                              <th class="p-1 border text-center bg-light align-middle" rowspan="2">Poriode</th>
                              <th class="p-1 border text-center bg-light align-middle" colspan="3">Penggunaan Listrik</th>
                              <th class="p-1 border text-center bg-light align-middle" rowspan="2">Biaya</th>
                          </tr>
                          <tr>
                              <th class="p-1 border text-center bg-light align-middle">AC</th>
                              <th class="p-1 border text-center bg-light align-middle">Non AC</th>
                              <th class="p-1 border text-center bg-light align-middle">Total</th> 
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($result['laporan_listrik'] as $item)
                          <tr>

                              <td class="p-2 border">{{$item->nama_opd}}</td>
                              <td class="p-2 border">{{$item->nama_gedung}}</td>
                              <td class="p-2 border">{{ date('F Y',strtotime($item->poriode))}}</td>
                              <td class="p-2 border">{{ number_format($item->penggunaan_ac),2,',','.'}} KWh</td>
                              <td class="p-2 border">{{ number_format($item->penggunaan_non_ac),2,',','.'}} KWh</td>
                              <td class="p-2 border">{{ number_format($item->penggunaan_total),2,',','.'}} KWh</td>
                              <td class="p-2 border text-right">Rp. {{ number_format($item->biaya_listrik,2,',','.')}}</td>

                          </tr>
                          @endforeach
                      </tbody> 
                    </table> 

                    <h5 class="mt-5 text-primary"><b>Data Konsumsi Energi Air Bulanan</b></h5>
                    <table class="table p-0">
                     <thead>
                         <tr>
                             <th class="p-1 border text-center bg-light align-middle">OPD</th>
                             <th class="p-1 border text-center bg-light align-middle">Gedung</th>
                             <th class="p-1 border text-center bg-light align-middle">Poriode</th>
                             <th class="p-1 border text-center bg-light align-middle">Penggunaan Air</th>
                             <th class="p-1 border text-center bg-light align-middle">Biaya</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($result['laporan_air'] as $item)
                         <tr>

                             <td class="p-2 border">{{$item->nama_opd}}</td>
                             <td class="p-2 border">{{$item->nama_gedung}}</td>
                             <td class="p-2 border">{{ date('F Y',strtotime($item->poriode))}}</td>
                             <td class="p-2 border">{{ number_format($item->penggunaan_air),2,',','.'}} KWh</td>
                             <td class="p-2 border text-right">Rp. {{ number_format($item->biaya_air,2,',','.')}}</td>

                         </tr>
                         @endforeach
                     </tbody> 
                   </table>

                    <div class="float-right mt-3">
                      {{$result['laporan_listrik']->links()}} 
                    </div> 
                  </div>
                </div>  
              </div>
        </div>


    </div>

    <div class="canvas p-5 bg-dark text-white">
        <div class="row">
            <div class="col-md-12 pl-5 pr-5">
                <h2 class="text-center mb-5">Tentang SIALIR</h2>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi modi ad quidem. Minus aut quia neque suscipit non dolorem ducimus? Laborum hic ab labore possimus inventore laudantium quidem natus porro.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam nemo ipsa dolorem eius nostrum expedita magnam voluptatum molestias, totam, doloribus officiis repudiandae obcaecati recusandae ratione voluptas quae veniam. Molestiae, maxime. 
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum nulla, magni voluptatibus, ea vero repellat veritatis minima quasi aut unde incidunt ex iusto, atque id iure. Dolor id repellendus officia.
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et, sed, voluptas aliquid nisi non asperiores dolores voluptatibus porro quos sit adipisci libero explicabo odit! Placeat veritatis voluptates ullam enim voluptatem!

                </p>
            </div>
        </div>
    </div>

    <div class="canvas p-5 bg-light">
        <div class="row">
            <div class="col-md-12 pl-5 pr-5">
                <h2 class="text-center mb-5">Metode Penghitungan</h2>

                <div class="row d-flex justify-content-center ">
                    <div class="col-md-3 mr-4 border-primary border-right">
                        <img src="{{ asset('img').'/listrik.png' }}" class="mx-auto d-block mb-2" style="width:40%" >
                        <h5 class="border-bottom pb-1 border-primary text-primary ">    Listrik</h5>
                        <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates ipsum facilis, perspiciatis eum aut ut fugit maiores iure, dolorum veniam deserunt earum commodi alias adipisci soluta quis reiciendis facere enim!</p>
                    </div>
                    <div class="col-md-3 ml-4 border-primary border-left">
                        <img src="{{ asset('img').'/air.png' }}" class="mx-auto d-block mb-2" style="width:40%" >
                        <h5 class="border-bottom pb-1 border-primary text-primary ">    Air</h5>    
                        <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates ipsum facilis, perspiciatis eum aut ut fugit maiores iure, dolorum veniam deserunt earum commodi alias adipisci soluta quis reiciendis facere enim!</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="canvas p-5 bg-dark text-white">
      <div class="row border-light border-bottom">
        <div class="col-md-3 text-center">
          <img src="{{ asset('img').'/logo-kab-madiun.png' }}" style="width:50% !important;">
          <a class="align-bottom navbar-brand" href="#">
            <h3 class="text-center"><span class="text-white text-center">SIALIR</span> <br>    
                <small class="text-sm text-white text-center">Sistem Analisa Penggunaan Air Dan Listrik</small>
            </h3> 
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 pt-4">
          <strong>Copyright &copy; {{ date('Y')}} <a href="">Tim Prana Komputer</a>.</strong> All rights reserved.
          <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
          </div>
        </div>
      </div>
    </div>
      
      
      
</body>
<script src="{{asset('template')}}/plugins/jquery/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{asset('template')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('template')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('template')}}/plugins/chart.js/Chart.min.js"></script>

<!-- Sparkline -->
<script src="{{asset('template')}}/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{asset('template')}}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{asset('template')}}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('template')}}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{asset('template')}}/plugins/moment/moment.min.js"></script>
<script src="{{asset('template')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('template')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{asset('template')}}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('template')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('template')}}/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('template')}}/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('template')}}/dist/js/pages/dashboard.js"></script>
<script src="{{asset('template')}}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{asset('template')}}plugins/daterangepicker/daterangepicker.js"></script>


<script>
var areaChartData = {
    labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
    datasets: [
        {
        label               : 'Penggunaan Listrik Non AC {KWh)',
        backgroundColor     : 'rgba(97, 34, 224)',
        borderColor         : 'rgba(97, 34, 224',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(97, 34, 224',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(97, 34, 224)',
        data                : <?php echo json_encode(array_values($result['cart_penggunaan_non_ac'])); ?>

        },
    
        {
            label               : 'Penggunaan Listrik AC {KWh)',
            backgroundColor     : 'rgba(7, 217, 66)',
            borderColor         : 'rgba(7, 217, 66)',
            pointRadius         : false,
            pointColor          : 'rgba(7, 217, 66)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(7, 217, 66)',
            data                : <?php echo json_encode($result['cart_penggunaan_ac']); ?> 
          },
        {
            label               : 'Penggunaan Air (M^3)',
            backgroundColor     : 'rgba(237, 222, 5)',
            borderColor         : 'rgba(237, 222, 5)',
            pointRadius         : false,
            pointColor          : 'rgba(237, 222, 5)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(237, 222, 5)',
            data                : <?php echo json_encode($result['cart_penggunaan_air']); ?> 
          },
    ]
    }
    
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
    }

    new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
    })

    var donutData  = {
      labels: [
          'Sangat Efisien',
          'Efisien',
          'Cukup Efisien',
          'Boros'
      ],
      datasets: [
        {
          data: <?php echo json_encode($result['data_cart_pie']); ?>,
          backgroundColor : ['#008cff', '#00ff15', '#ffd500', '#ff0000'],
        }
      ]
    }

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }

    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

</script>