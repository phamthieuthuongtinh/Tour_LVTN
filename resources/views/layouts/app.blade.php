<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>AdminLTE 3 | Dashboard 3</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.2.6/css/froala_editor.pkgd.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/froala-editor@3.2.6/js/froala_editor.pkgd.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      
    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('layouts.include.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper p-1">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024-2025 <a href="home">AdminTravel</a>.</strong>
Đăng ký bản quyền.
    <div class="float-right d-none d-sm-inline-block">
      <b>Phiên bản</b> 3.2.0
    </div>
    
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('backend/dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('backend/plugins/chart.js/Chart.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('backend/dist/js/demo.js')}}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('backend/dist/js/pages/dashboard3.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js"></script>
{{-- <script src="{{ asset('ckeditor/ckeditor.js') }}"></script> --}}
{{-- TnyMCE --}}
<script>
  tinymce.init({
      selector: '#content',
      plugins: 'image link media code lists',
      toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | image media link code',
      height: 500,
      images_upload_handler: function (blobInfo, success, failure) {
          var xhr, formData;

          xhr = new XMLHttpRequest();
          xhr.open('POST', '/admin/blogs/upload-image'); // Đường dẫn xử lý upload hình ảnh
          xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
          xhr.onload = function() {
              var json;
              
              if (xhr.status != 200) {
                  failure('HTTP Error: ' + xhr.status);
                  return;
              }

              json = JSON.parse(xhr.responseText);

              if (!json || typeof json.location != 'string') {
                  failure('Invalid JSON: ' + xhr.responseText);
                  return;
              }

              success(json.location);
          };

          formData = new FormData();
          formData.append('file', blobInfo.blob(), blobInfo.filename());

          xhr.send(formData);
      }
  });
</script>


{{-- FroalEditor --}}
<script>
  new FroalaEditor('#editor', { quickInsertEnabled: false });
  new FroalaEditor('#editor1', { quickInsertEnabled: false });
  new FroalaEditor('#editor2', { quickInsertEnabled: false });
  new FroalaEditor('#editor3', { quickInsertEnabled: false });
</script>




{{-- <script>
  CKEDITOR.replace('ckeditor1', {
      filebrowserUploadUrl: "{{ route('upload.image') }}",
      filebrowserUploadMethod: 'form',
      extraPlugins: 'uploadimage'
  });
</script> --}}
<script>
  $(document).ready(function() {
      $('#categorySelect').select2({
          placeholder: 'Chọn danh mục tour',
          allowClear: true
      });
  });
</script>
<script>
    $(document).ready(function() {
      
      $('#myTable').DataTable({
          "language": {
              
              "info": "Hiển thị từ _START_ đến _END_ của _TOTAL_ mục",
              "infoEmpty": "Hiển thị từ 0 đến 0 của 0 mục",
              "infoFiltered": "(được lọc từ _MAX_ tổng số mục)",
              "lengthMenu": "Hiển thị _MENU_ mục",
              "search": "Tìm kiếm:",
              "zeroRecords": "Không tìm thấy dữ liệu phù hợp"
          }
      });
      // let table = new DataTable('#myTable');
  });

 
</script>

<script>
    function roundDownToThousands(value) {
            return Math.floor(value / 1000) * 1000;
        }

    document.getElementById('adultPrice').addEventListener('input', function() {
        var adultPrice = parseFloat(this.value) || 0;
        document.getElementById('childPrice').value = roundDownToThousands(adultPrice * 0.9);
        document.getElementById('toddlerPrice').value = roundDownToThousands(adultPrice * 0.9);
        document.getElementById('infantPrice').value = roundDownToThousands(adultPrice * 0.3);
    });
</script>
{{-- tính ngày --}}
{{-- <script>
  $( function() {
    $( "#departure_date" ).datepicker({
      format: 'dd-mm-yyyy', // Định dạng ngày
    });
    $( "#return_date" ).datepicker({
      format: 'dd-mm-yyyy', // Định dạng ngày
    });
  } );
</script> --}}
<script>
  function calculateDays() {
      var departureDateStr = document.getElementById('departure_date').value.trim();
      var returnDateStr = document.getElementById('return_date').value.trim();

      if (departureDateStr && returnDateStr) {
          // Chuyển đổi chuỗi thành đối tượng Date
          var departureDate = new Date(departureDateStr);
          var returnDate = new Date(returnDateStr);

          if (departureDate <= returnDate) {
              // Tính toán số ngày giữa hai ngày
              var timeDifference = returnDate.getTime() - departureDate.getTime();
              var dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));

              // Cập nhật giá trị của trường tour_time
              document.getElementById('tour_time').value = dayDifference + ' ngày ' + (dayDifference-1) + ' đêm';
          } else {
              // Hiển thị thông báo lỗi nếu ngày không hợp lệ
              document.getElementById('tour_time').value = 'Ngày đi phải trước ngày về';
          }
      } else {
          // Xóa giá trị nếu một trong hai ngày chưa được nhập
          document.getElementById('tour_time').value = '';
      }
  }

  // Gọi hàm calculateDays khi ngày thay đổi
  document.getElementById('departure_date').addEventListener('change', calculateDays);
  document.getElementById('return_date').addEventListener('change', calculateDays);

  // Gọi hàm calculateDays khi trang được tải
  window.onload = calculateDays;
</script>
{{-- Phàn hổi cmt --}}
<script>
 
  $('.btn-reply-comment').click(function() {
    
      var comment_id = $(this).data('comment_id');
      var comment = $('.reply_comment_' + comment_id).val();

      var comment_tour_id = $(this).data('tour_id');

 

      $.ajax({
        url: "{{route('comment.reply')}}",
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          comment: comment,
          comment_id: comment_id,
          comment_tour_id: comment_tour_id
        },
        success: function(data) {
          $('.reply_comment_' + comment_id).val('');
          
          alert('Phản hồi thành công!');
          window.location.reload();
        }
      });

    })
</script>
{{-- Yêu cầu cmt --}}
<script>
 
  $('.btn-request-destroy-comment').click(function() {

    
      var comment_id = $(this).data('comment_id');

      var comment_tour_id = $(this).data('tour_id');

      // Hiển thị modal nhập lý do
      $('#reasonModal').modal('show');

      // Xử lý khi nhấn nút "Gửi yêu cầu" trong modal
      $('#submitDeleteRequest').off('click').on('click', function() {
          // Lấy lý do từ ô nhập
          var reason = $('#deleteReason').val();

          // Kiểm tra nếu lý do trống
          if(reason.trim() === "") {
              alert('Vui lòng nhập lý do!');
              return;
          }

      $.ajax({
        url: "{{route('comment.request_destroy')}}",
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          comment_id: comment_id,
          reason: reason,
          comment_tour_id: comment_tour_id
        },
        success: function(data) {
          $('.reply_comment_' + comment_id).val('');
          
          alert('Đã gửi yêu cầu thành công!');
          window.location.reload();
        }
      });
    });
    })
</script>

{{-- Chuyển đổi trạng thái đã thanh toán <> chưa thanh toán và cập nhật số lượng người còn của tour --}}
<script type="text/javascript">
  $(document).ready(function() {
      $('.order_details').change(function() {
          var order_status = $(this).val();
          var form = $(this).closest('form');
          var order_id = form.find('input[name="order_id"]').val();
          var orderdetails_id = form.find('input[name="orderdetail_id"]').val();
          var _token = $('input[name="_token"]').val();

          $.ajax({
              url: "{{ route('orders.update_quantity') }}",
              method: 'POST',
              data: {
                  _token: _token,
                  order_status: order_status,
                  orderdetails_id: orderdetails_id,
                  order_id: order_id
              },
              success: function(data) {
                  alert("Cập nhật trạng thái thành công!");
                  location.reload();
              }
          });
      });
  });
</script>

{{-- Dashboard --}}
{{-- Biểu đồ doanh thu --}}
<script>
  $(document).ready(function() {
      // Dữ liệu từ controller
      var statistics = @json($statistics);

      var labels = [];
      var salesData = [];
      var profitData = [];

      statistics.forEach(function(item) {
          labels.push(item.month);
          salesData.push(item.total_sales);
          profitData.push(item.total_profit);
      });

      var salesChart = new Chart($('#salesChart'), {
          type: 'bar',
          data: {
              labels: labels,
              datasets: [
                  {
                      label: 'Tổng thu',
                      backgroundColor: '#007bff',
                      borderColor: '#007bff',
                      data: salesData
                  },
                  {
                      label: 'Lợi nhuận',
                      backgroundColor: '#ced4da',
                      borderColor: '#ced4da',
                      data: profitData
                  }
              ]
          },
          options: {
              maintainAspectRatio: false,
              tooltips: {
                  mode: 'index',
                  intersect: false
              },
              hover: {
                  mode: 'nearest',
                  intersect: true
              },
              legend: {
                  display: true
              },
              scales: {
                  yAxes: [{
                      gridLines: {
                          display: true,
                          lineWidth: '4px',
                          color: 'rgba(0, 0, 0, .2)',
                          zeroLineColor: 'transparent'
                      },
                      ticks: {
                          beginAtZero: true,
                          callback: function(value) {
                              if (value >= 1000) {
                                  value /= 1000;
                                  value += 'k';
                              }

                              return 'vnđ ' + value;
                          }
                      }
                  }],
                  xAxes: [{
                      display: true,
                      gridLines: {
                          display: false
                      },
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
      });


      function updateChartData(labels, salesData, profitData) {
          salesChart.data.labels = labels;
          salesChart.data.datasets[0].data = salesData;
          salesChart.data.datasets[1].data = profitData;
          salesChart.update();
      }

      function resetChart() {
            var defaultLabels = [];
            var defaultSalesData = [];
            var defaultProfitData = [];

            statistics.forEach(function(item) {
                defaultLabels.push(item.month);
                defaultSalesData.push(item.total_sales);
                defaultProfitData.push(item.total_profit);
            });

            updateChartData(defaultLabels, defaultSalesData, defaultProfitData);
        }

        // Xử lý sự kiện nhấn nút "Làm mới"
        $('#resetForm').on('click', function() {
            $('#dateFilterForm')[0].reset(); // Xóa dữ liệu trong form
            resetChart(); // Làm mới biểu đồ với dữ liệu mặc định
        });
      // Xử lý sự kiện thay đổi bộ lọc
      $('#dateFilterForm').on('submit', function(event) {
          event.preventDefault(); // Ngăn chặn gửi form theo cách truyền thống

          var startDate = $('#startDate').val();
          var business_id = $('#business_id').val();
          var endDate = $('#endDate').val();
          var _token = $('input[name="_token"]').val();

          if (startDate && endDate || business_id) {
              $.ajax({
                  url: "{{ route('dashboard.filter_dashboard') }}",
                  method: "POST",
                  dataType: "JSON",
                  data: {
                      startDate: startDate,
                      endDate: endDate,
                      business_id:business_id,
                      _token: _token
                  },
                  success: function(data) {
                      // Kiểm tra dữ liệu nhận được từ AJAX
                      console.log('Dữ liệu nhận được:', data);

                      // Cập nhật dữ liệu cho biểu đồ
                      updateChartData(data.labels, data.salesData, data.profitData);
                  },
                  error: function(xhr, status, error) {
                      console.error('Lỗi khi lấy dữ liệu:', status, error);
                  }
              });
          } else {
              alert('Vui lòng nhập thông tin cần lọc.');
          }
      });
      
  });
</script>
{{-- Biểu đồ tròn --}}
<script>
  $(document).ready(function(){
    var piedata = @json($piedata);

    var labels = [];
    var data = [];


    piedata.forEach(function(item) {
        labels.push(item.type_name);
        data.push(item.count);
    });
    console.log('labels-pie',labels);
    console.log('data-pie',data);
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
        labels: labels,
        datasets: [
          {
            data: data,
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
          }
        ]
    }
    var pieOptions = {
        legend: {
        display: true
      }
    }
    var pieChart = new Chart(pieChartCanvas, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions
    })

    function updateChartData(dataPie) {
      pieChart.data.labels = [];
        pieChart.data.datasets[0].data = [];

        // Thêm dữ liệu mới
        dataPie.forEach(function(item) {
            pieChart.data.labels.push(item.type_name);
            pieChart.data.datasets[0].data.push(item.count);
        });

        // Cập nhật lại biểu đồ
        // pieChart.update();
        // dataPie.forEach(function(item) {
        //     labels.push(item.type_name);
        //     data.push(item.count);
        // });
        pieChart.update();
      }

      function resetChart() {
        updateChartData(piedata);
      }

        // Xử lý sự kiện nhấn nút "Làm mới"
        $('#resetForm_pie').on('click', function() {
            $('#dateFilterForm_pie')[0].reset(); // Xóa dữ liệu trong form
            resetChart(); // Làm mới biểu đồ với dữ liệu mặc định
        });
      // Xử lý sự kiện thay đổi bộ lọc
      $('#dateFilterForm_pie').on('submit', function(event) {
          event.preventDefault(); // Ngăn chặn gửi form theo cách truyền thống

          var startDate = $('#startDate_pie').val();
          var business_id = $('#business_id_pie').val();
          var endDate = $('#endDate_pie').val();
          var _token = $('input[name="_token"]').val();

          if (startDate && endDate || business_id) {
              $.ajax({
                  url: "{{ route('dashboard.filter_pie_dashboard') }}",
                  method: "POST",
                  dataType: "JSON",
                  data: {
                      startDate: startDate,
                      endDate: endDate,
                      business_id:business_id,
                      _token: _token
                  },
                  success: function(data) {
                      // Kiểm tra dữ liệu nhận được từ AJAX
                      console.log('Dữ liệu nhận được:', data);

                      // Cập nhật dữ liệu cho biểu đồ
                      updateChartData(data);
                  },
                  error: function(xhr, status, error) {
                      console.error('Lỗi khi lấy dữ liệu:', status, error);
                  }
              });
          } else {
              alert('Vui lòng nhập thông tin cần lọc.');
          }
      });
  });
</script>
{{-- Biểu đồ đường --}}
<script>
  $(document).ready(function(){
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }
    var visitor = @json($visitor);
    var business = @json($business);
    var labels = [];
    var datavisitor = [];
    var databusiness = [];
    var max=1;

    Object.keys(visitor).forEach(function(month) {
        labels.push(month); // Đưa tháng vào labels
        datavisitor.push(visitor[month]); // Đưa tổng visitor của tháng vào datavisitor
    });
   
    Object.keys(business).forEach(function(month) {
         // Đưa tháng vào labels
         databusiness.push(business[month]); // Đưa tổng visitor của tháng vào datavisitor
    });
    var combinedData = [...datavisitor, ...databusiness]; // Kết hợp 2 mảng

    if (combinedData.length > 0) {
        max = Math.max(...combinedData); // Lấy giá trị lớn nhất từ mảng kết hợp
    }

    console.log(max);
    var mode = 'index'
    var intersect = true
    console.log('cần',visitor);
    console.log(databusiness);
      var $visitorsChart = $('#visitors-chart')
    // eslint-disable-next-line no-unused-vars
    var visitorsChart = new Chart($visitorsChart, {
      data: {
        // labels:[1, 2, 3, 4, 5, 6, 7,8,9,10,11,12],
        labels:labels,
        datasets: [{
          type: 'line',
          data: datavisitor,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          pointBorderColor: '#007bff',
          pointBackgroundColor: '#007bff',
          fill: false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        },
        {
          type: 'line',
          data: databusiness,
          backgroundColor: 'tansparent',
          borderColor: '#ced4da',
          pointBorderColor: '#ced4da',
          pointBackgroundColor: '#ced4da',
          fill: false
          // pointHoverBackgroundColor: '#ced4da',
          // pointHoverBorderColor    : '#ced4da'
        }
      ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: max,
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
    function resetChart() {
            var defaultlabel=[]
            Object.keys(visitor).forEach(function(month) {
              defaultlabel.push(month); // Đưa tháng vào label
          });

            updateChartData( defaultlabel,visitor, business);
        }

        // Xử lý sự kiện nhấn nút "Làm mới"
        $('#resetForm_line').on('click', function() {
            $('#dateFilterForm_line')[0].reset(); // Xóa dữ liệu trong form
            resetChart(); // Làm mới biểu đồ với dữ liệu mặc định
        });
    function updateChartData(labels, datavisitor, databusiness) {
      visitorsChart.data.labels = labels;
      const visitorArray = Object.values(datavisitor);
      const businessrArray = Object.values(databusiness);
      visitorsChart.data.datasets[0].data = visitorArray;
      visitorsChart.data.datasets[1].data = businessrArray;
      visitorsChart.update();
    }
    $('#dateFilterForm_line').on('submit', function(event) {
          event.preventDefault(); // Ngăn chặn gửi form theo cách truyền thống

          var startDate = $('#startDate_line').val();
          // var business_id = $('#business_id').val();
          var endDate = $('#endDate_line').val();
          var _token = $('input[name="_token"]').val();

          if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            // Tính số ngày giữa hai ngày
            const timeDiff = end - start; // tính ra mili giây
            const dayDiff = timeDiff / (1000 * 3600 * 24); // chuyển mili giây thành ngày

            // Kiểm tra xem khoảng cách có lớn hơn hoặc bằng 0 và nhỏ hơn hoặc bằng 30 không
            if (dayDiff >= 0 && dayDiff <= 30) {

              $.ajax({
                  url: "{{ route('dashboard.filter_line_dashboard') }}",
                  method: "POST",
                  dataType: "JSON",
                  data: {
                      startDate: startDate,
                      endDate: endDate,
                    
                      _token: _token
                  },
                  success: function(data) {
                      // Kiểm tra dữ liệu nhận được từ AJAX
                      console.log('Dữ liệu nhận được:', data);

                      // Cập nhật dữ liệu cho biểu đồ
                      updateChartData(data.labels, data.datavisitor, data.databusiness);
                  },
                  error: function(xhr, status, error) {
                      console.error('Lỗi khi lấy dữ liệu:', status, error);
                  }
              });
            } else {
                alert('Khoảng thời gian phải nằm trong khoảng 30 ngày.');
            }
          } else {
              alert('Vui lòng nhập thông tin cần lọc.');
          }
      });
  });
   

  

  
  
</script>
{{-- iput min=0 --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
  const inputs = document.querySelectorAll('input[type="number"]');
  
  inputs.forEach(input => {
      input.addEventListener('input', function() {
          if (this.value <script 0) {
              this.value = 0;
          }
      });
  });
  });
</script>


{{-- Sidebar --}}
<script>
    $(document).ready(function() {
    // Lấy đường dẫn hiện tại của trang
    var currentUrl = window.location.href;

    // Kiểm tra nếu đường dẫn chứa từ khóa 'tours'
    if (currentUrl.includes('/dashboard')) {
        // ở menu 'dashboard'
        $('.menu-dash').addClass('menu-is-opening menu-open');

        // Kiểm tra nếu URL là trang thống kê
        if (currentUrl.match(/\/dashboard\/statistic\/?$/)) {
            $('.dashboard').addClass('active');
        }
        // Bạn có thể thêm các điều kiện khác cho các trang khác của dashboard nếu cần
    }
    if (currentUrl.includes('/users')) {
        // Mở menu 'dashboard'
        $('.menu-user').addClass('menu-is-opening menu-open');

        // Kiểm tra nếu URL là trang thống kê
        if (currentUrl.match(/\/users\/manage-doanh-nghiep\/?$/)) {
            $('.business').addClass('active');
        }
        else if (currentUrl.match(/\/users\/manage-khach-hang\/?$/)) {
            $('.customer').addClass('active');
        }
        // Bạn có thể thêm các điều kiện khác cho các trang khác của dashboard nếu cần
    }
    if (currentUrl.includes('/categories')) {
            // Mở menu 'categories'
            $('.menu-cate').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/categories\/create$/)) {
                $('.create-cate').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/categories\/?$/)) {
                $('.all-cate').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/categories\/\d+\/edit$/)) {
                $('.all-cate').addClass('active');
            }
        }
        if (currentUrl.includes('/types')) {
            // Mở menu 'categories'
            $('.menu-type').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/types\/create$/)) {
                $('.create-type').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/types\/?$/)) {
                $('.all-type').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/types\/\d+\/edit$/)) {
                $('.all-type').addClass('active');
            }
        }
        if (currentUrl.includes('/tours')) {
            // Mở menu 'categories'
            $('.menu-tour').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/tours\/admin-manage-tour\/?$/)) {
                $('.admin-manage-tour').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/?$/)) {
                $('.all-tour').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/create$/)) {
                $('.create-tour').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/departure$/)) {
                $('.create-depart').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/departures\/\d+$/)) {
                $('.create-depart').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/itinerary$/)) {
                $('.create-iti').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/itineraries\/\d+$/)) {
                $('.create-iti').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/service$/)) {
                $('.manage-service').addClass('active');
            }
            else if (currentUrl.match(/\/tours\/services\/\d+\/edit$/)) {
                $('.manage-service').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/tours\/xem\/\d+$/)) {
              $('.admin-manage-tour').addClass('active');
              $('.all-tour').addClass('active');
          }

          
        }
        if (currentUrl.includes('/banners')) {
            // Mở menu 'categories'
            $('.menu-banner').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/banners\/create$/)) {
                $('.create-banner').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/banners\/?$/)) {
                $('.all-banner').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/banners\/\d+\/edit$/)) {
                $('.all-banner').addClass('active');
            }
        }
        if (currentUrl.includes('/comment')) {
            // Mở menu 'categories'
            $('.menu-cmt').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/comment\/create$/)) {
                $('.create-cmt').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/comment\/?$/)) {
                $('.all-cmt').addClass('active');
            }
            else if (currentUrl.match(/\/comment\/bussiness\/index\/?$/)) {
                $('.all-cmt').addClass('active');
            }
            else if (currentUrl.match(/\/comment\/bussiness\/reply\/?$/)) {
                $('.create-cmt').addClass('active');
            }
           
        }
        if (currentUrl.includes('/orders')) {
            // Mở menu 'categories'
            $('.menu-order').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/orders\/?$/)) {
                $('.all-order').addClass('active');
            }
            else if (currentUrl.match(/\/orders\/business\/order\/?$/)) {
                $('.all-order').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/orders\/\d+$/)) {
                $('.all-order').addClass('active');
            }
            else if (currentUrl.match(/\/orders-refund\/refund\/?$/)) {
                $('.all-order-refund').addClass('active');
            }
        }
        if (currentUrl.includes('/vouchers')) {
            // Mở menu 'categories'
            $('.menu-vou').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/vouchers\/create$/)) {
                $('.create-vou').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/vouchers\/?$/)) {
                $('.all-vou').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/vouchers\/\d+\/edit$/)) {
                $('.all-vou').addClass('active');
            }
        }
        if (currentUrl.includes('/blogs')) {
            // Mở menu 'categories'
            $('.menu-blog').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/blogs\/create$/)) {
                $('.create-blog').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/blogs\/?$/)) {
                $('.all-blog').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/blogs\/\d+\/edit$/)) {
                $('.all-blog').addClass('active');
            }
        }
        if (currentUrl.includes('/contacts')) {
            // Mở menu 'categories'
            $('.menu-cont').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/contacts\/create$/)) {
                $('.send-cont').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/contacts\/?$/)) {
                $('.all-cont').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/contacts\/\d+\/edit$/)) {
                $('.all-cont').addClass('active');
            }
        }
        if (currentUrl.includes('/discounts')) {
            // Mở menu 'categories'
            $('.menu-discount').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/discounts\/create$/)) {
                $('.create-discount').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/discounts\/?$/)) {
                $('.all-discount').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/discounts\/\d+\/edit$/)) {
                $('.edit-discount').addClass('active');
            }
        }
        if (currentUrl.includes('/customer-tour')) {
            // Mở menu 'categories'
            $('.menu-customer-tour').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/customer-tour\/create$/)) {
                $('.create-customer-tour').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/customer-tour\/?$/)) {
                $('.all-customer-tour').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/customer-tour\/\d+\/edit$/)) {
                $('.edit-customer-tour').addClass('active');
            }
        }
        if (currentUrl.includes('/staffs')) {
            // Mở menu 'categories'
            $('.menu-staff').addClass('menu-is-opening menu-open');

            // Phân biệt các trang cụ thể:
            // Trang tạo mới (/categories/create)
            if (currentUrl.match(/\/staffs\/create$/)) {
                $('.create-staff').addClass('active');
            }
            // Trang danh sách (/categories) và không có thêm phần đuôi như /create hay /edit
            else if (currentUrl.match(/\/staffs\/?$/)) {
                $('.all-staff').addClass('active');
            }
            // Trang chỉnh sửa (/categories/{id}/edit)
            else if (currentUrl.match(/\/staffs\/\d+\/edit$/)) {
                $('.all-staff').addClass('active');
            }
            else if (currentUrl.match(/\/staffs\/\d+?$/)) {
                $('.all-staff').addClass('active');
            }
            else if (currentUrl.match(/\/staffs\/manage\/\d+?$/)) {
                $('.all-staff').addClass('active');
            }
        }
  });

</script>
</body>
</html>
