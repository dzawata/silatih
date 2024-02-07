

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


@if (session('insert')=="failed")
  <script>$('#modalTambah').modal('show');</script>  
@endif

@if (session('update') == "failed")
  {{-- <script>$("modalEdit1").modal('show');</script>   --}}
  
@endif

<script>
  @if (Request::is('penggunaan/listrik/tambah*'))
  $("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = "Rp " + left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = "Rp " + input_val;
    
    // final formatting
    if (blur === "blur") {
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}

@endif

    $('#input_tahun').keyup(function (e) {
      
      
      $.ajax({
        url   : '{{ route('dashboard.ajax')}}',
        type  : "POST",
        datatype : "html",
        data  : {
                _token : "<?php echo csrf_token(); ?>",
                tahun : $('#input_tahun').val(),
        },
        success: function(dataresult){
          if(dataresult == false){

              $("#biaya_air").html(""); 
              $("#biaya_listrik").html(""); 
              $("#penggunaan_listrik").html(""); 
              $("#penggunaan_air").html(""); 
              $("#tahun").html(""); 
              $("#tahun1").html(""); 
              $("#tahun2").html(""); 
              $("#tahun3").html(""); 
          } else {
            console.log(new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(dataresult.biaya_air));

              $("#biaya_air").html((dataresult.biaya_air/1000).toFixed(3)); 
              $("#biaya_listrik").html((dataresult.biaya_listrik/1000).toFixed(3)); 
              $("#penggunaan_listrik").html((dataresult.penggunaan_listrik/1000).toFixed(3)); 
              $("#penggunaan_air").html((dataresult.penggunaan_air/1000).toFixed(3)); 
              $("#tahun").html(dataresult.tahun);
              $("#tahun1").html(dataresult.tahun);
              $("#tahun2").html(dataresult.tahun);
              $("#tahun3").html(dataresult.tahun);
          }
        }
      });
    });


  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

  })
  $(function () {
    //Initialize Select2 Elements
    $('.select3').select2()

  })
  $('#reservation').daterangepicker()
  
  $("#field-poriode").hide();
  
  $('#selectby').change(function(){
    var terpilih =  $('#selectby').val();

    if(terpilih == "semua"){
      $("#field-semua").show();
      $("#field-poriode").hide();
    } else if(terpilih == "range"){
      $("#field-poriode").show();
      $("#field-semua").hide();
    }
});
</script>

@if (Request::is('penggunaan/listrik/display') OR Request::is('penggunaan/air/display') OR Request::is('kwh_meter/display') )
  <script>


    $('#select_the_opd').on('select2:select', function (e) {
      
      var kdx = e.params.data.text;
      
      $.ajax({
        url   : '{{ route('penggunaan.ajax_get_akun')}}',
        type  : "POST",
        datatype : "html",
        data  : {
                _token : "<?php echo csrf_token(); ?>",
                kdx : kdx,
        },
        success: function(dataresult){
          if(dataresult['gedung'] == false){
             $('#akun_field').html("<div class='form-control is-invalid'> OPD belum memiliki data gedung</div>");

          } else {
            $('#akun_field').html(dataresult['gedung']);
            
          }
        
        
        }
      });
    });
  </script> 
@endif


@if (Request::is('laporan/listrik/display')  OR Request::is('laporan/air/display') OR Request::is('laporan/penghematan/listrik/display') OR Request::is('laporan/penghematan/air/display') )
  <script>


    $('#select_the_opd').on('select2:select', function (e) {
      
      var kdx = e.params.data.text;
      
      $.ajax({
        url   : '{{ route('penggunaan.ajax_get_akun2')}}',
        type  : "POST",
        datatype : "html",
        data  : {
                _token : "<?php echo csrf_token(); ?>",
                kdx : kdx,
        },
        success: function(dataresult){
          if(dataresult['gedung'] == false){
             $('#akun_field').html("<div class='form-control is-invalid'> OPD belum memiliki data gedung</div>");

          } else {
            $('#akun_field').html(dataresult['gedung']);
            
          }
        
        
        }
      });
    });
  </script> 
@endif


@if (Request::is('record/air/detail/*'))
  <script>
    $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($bulan)); ?> ,
      datasets: [
        {
          label               : 'Intensitas Konsumsi Air (L/Orang/8 jam)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($cart_air)); ?> 
        }, 
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
      


    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif

@if (Request::is('record/listrik/detail/*'))
  <script>
    $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($bulan)); ?> ,
      datasets: [
        {
          label               : 'Intensitas Konsumsi Non AC {KWh)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($cart_non_ac)); ?> 
        },
        {
          label               : 'Intensitas Konsumsi AC {KWh)',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',lineTension: 0,  
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : <?php echo json_encode(array_values($cart_ac)); ?> 
        },
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
      


    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif

@if (!empty($result['cart_penggunaan_ac'])  AND !empty($result['cart_penggunaan_non_ac']))
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
            data                : <?php echo json_encode($result['cart_penggunaan_non_ac']); ?> 

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
            label               : 'Penggunaan Air (M2)',
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

  </script>
@endif
@if(!empty($result['data_cart_pie']))

  <script>
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
@endif


<script>
  var is_school = $("#is_school_edit").val();
  if(is_school == 0){
    $("#attr_sekolah").hide();
  } else {
    $("#attr_sekolah").show();
  }

  $("#is_school_edit").change(function(){
    var is_school = $("#is_school_edit").val();
    if( is_school == 0){
      $("#attr_sekolah").hide();
    } else {
      $("#attr_sekolah").show();
    }
});      
</script>


@if (Request::is('chart/energi/listrik'))
<script>
    $(function () { 
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
      datasets: [
        {
          label               : 'Penggunaan Energi Listrik (KWH)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($result['chart_penggunaan_listrik'])); ?> 
        }
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
      


    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif

@if (Request::is('chart/energi/air'))
<script>
    $(function () { 
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
      datasets: [
        {
          label               : 'Intensitas Konsumsi Air  (M^3)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($result['chart_penggunaan_air'])); ?> 
        }
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
      


    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif

@if (Request::is('chart/biaya/air'))
<script>
    $(function () { 
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
      datasets: [
        {
          label               : 'Biaya Energi Air M^3',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($result['chart_penggunaan_air'])); ?> 
        }
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
       
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif

@if (Request::is('chart/penghematan_energi/listrik'))
<script>
    $(function () { 
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
      datasets: [
        {
          label               : 'Penghematan Energi Air  (%)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($result['perbandingan_listrik'])); ?> 
        }
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
       
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif

@if (Request::is('chart/penghematan_energi/air'))
<script>
    $(function () { 
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
      datasets: [
        {
          label               : 'Penghematan Penggunaan Energi Air (%)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($result['perbandingan_air'])); ?> 
        }
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
       
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif

@if (Request::is('chart/penghematan_biaya/listrik'))
<script>
    $(function () { 
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
      datasets: [
        {
          label               : 'Penghematan Biaya Energi Listrik (%)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($result['perbandingan_biaya_listrik'])); ?> 
        }
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
       
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif


@if (Request::is('chart/penghematan_biaya/air'))
<script>
    $(function () { 
    var areaChartCanvas = $('#line').get(0).getContext('2d')

    var areaChartData = {
      labels  : <?php echo json_encode(array_values($result['bulan'])); ?> ,
      datasets: [
        {
          label               : 'Penghematan Biaya Energi Air (%)',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',lineTension: 0,  
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?php echo json_encode(array_values($result['perbandingan_biaya_air'])); ?> 
        }
      ]
    }

    var areaChartOptions = { 
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      },
      hover: {
         mode: 'index',
         intersect: false
      },
      tooltips: {
         mode: 'index',
         intersect: false
      },
       
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,        
      lineTension: 0,           
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#line').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,       
      options: lineChartOptions,
    })
  });
  </script>
@endif