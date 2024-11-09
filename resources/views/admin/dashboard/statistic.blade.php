@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                {{-- Biểu đồ cột lợi nhuận --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title" style="color: blue">Thống Kê Lợi Nhuận</h2>
                                <a href="javascript:void(0);">Xem báo cáo</a>
                            </div>
                            <br>
                            <form id="dateFilterForm" method="POST" action="{{ route('dashboard.filter_dashboard') }}">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="form-group mb-2 mr-3">
                                        <label for="startDate" class="mr-2">Ngày bắt đầu:</label>
                                        <input type="date" class="form-control" id="startDate" name="startDate" />
                                    </div>
                                    <div class="form-group mb-2 mr-3">
                                        <label for="endDate" class="mr-2">Ngày kết thúc:</label>
                                        <input type="date" class="form-control" id="endDate" name="endDate" />
                                    </div>
                                    @if (Auth::user()->id == 1)
                                        <div class="form-group mb-2 mr-3">
                                            <label for="business_id" class="mr-2">Công ty:</label>
                                            <br>
                                            <select class="form-control" name="business_id" id="business_id">
                                                <option value="">Chọn công ty</option>
                                                @foreach ($businesses as $key => $busi)
                                                    <option value="{{ $busi->id }}">{{ $busi->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    @endif
                                </div>
                                <!-- Đẩy các nút xuống dòng -->
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2" id="applyDateFilter">Lọc</button>
                                    <button type="button" class="btn btn-secondary" id="resetForm">Làm mới</button>
                                </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="">

                                <p class="text-bold text-lg d-flex justify-content-center">
                                    <span style="font-size: 25px; color: rgb(109, 5, 74);">Biểu đồ thống kê lợi nhuận</span>
                                </p>
                                {{-- <p class="d-flex flex-column">
                            <span class="text-bold text-lg">$18,230.00</span>
                            <span>Sales Over Time</span>
                        </p> --}}
                                {{-- <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> 33.1%
                            </span>
                            <span class="text-muted">Since last month</span>
                        </p> --}}
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="salesChart" height="350"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Tổng thu
                                </span>
                                <span>
                                    <i class="fas fa-square text-gray"></i> Lợi nhuận
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
                @if(Auth::user()->id==1)
                <div class="col-lg-6">
                    {{-- Biểu đồ đường người tham gia web --}}
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title" style="color: red"> Biểu đồ thống kê tài khoản đăng ký</h3>
                                <a href="javascript:void(0);">Xem báo cáo</a>
                            </div>
                            <br>
                            <form id="dateFilterForm_line" method="POST" action="{{ route('dashboard.filter_line_dashboard') }}">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="form-group mb-2 mr-3">
                                        <label for="startDate" class="mr-2">Ngày bắt đầu:</label>
                                        <input type="date" class="form-control" id="startDate_line" name="startDate_line" />
                                    </div>
                                    <div class="form-group mb-2 mr-3">
                                        <label for="endDate" class="mr-2">Ngày kết thúc:</label>
                                        <input type="date" class="form-control" id="endDate_line" name="endDate_line" />
                                    </div>
                                    {{-- @if (Auth::user()->id == 1)
                                        <div class="form-group mb-2 mr-3">
                                            <label for="business_id" class="mr-2">Công ty:</label>
                                            <br>
                                            <select class="form-control" name="business_id_line" id="business_id_line">
                                                <option value="">Chọn công ty</option>
                                                @foreach ($businesses as $key => $busi)
                                                    <option value="{{ $busi->id }}">{{ $busi->name }}</option>
                                                @endforeach
    
                                            </select>
                                        </div>
                                    @endif --}}
                                </div>
                                <!-- Đẩy các nút xuống dòng -->
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2" id="applyDateFilter_line">Lọc</button>
                                    <button type="button" class="btn btn-secondary" id="resetForm_line">Làm mới</button>
                                </div>
    
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </div>
                       
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    {{-- <span class="text-bold text-lg">820</span> --}}
                                    <span>Lượt đăng ký trong năm qua</span>
                                </p>
                                {{-- <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 12.5%
                                    </span>
                                    <span class="text-muted">Since last week</span>
                                </p> --}}
                            </div>
                            <!-- /.d-flex -->
                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="229"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Khách hàng
                                </span>
                                <span>
                                    <i class="fas fa-square text-gray"></i> Doanh nghiệp
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title" style="color: blue">Biểu đồ thống kê tour đã bán theo loại</h2>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                          
                            <form id="dateFilterForm_pie" method="POST" action="{{ route('dashboard.filter_pie_dashboard') }}">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="form-group mb-2 mr-3">
                                        <label for="startDate" class="mr-2">Ngày bắt đầu:</label>
                                        <input type="date" class="form-control" id="startDate_pie" name="startDate_pie" />
                                    </div>
                                    <div class="form-group mb-2 mr-3">
                                        <label for="endDate" class="mr-2">Ngày kết thúc:</label>
                                        <input type="date" class="form-control" id="endDate_pie" name="endDate_pie" />
                                    </div>
                                    @if (Auth::user()->id == 1)
                                        <div class="form-group mb-2 mr-3">
                                            <label for="business_id" class="mr-2">Công ty:</label>
                                            <br>
                                            <select class="form-control" name="business_id_pie" id="business_id_pie">
                                                <option value="">Chọn công ty</option>
                                                @foreach ($businesses as $key => $busi)
                                                    <option value="{{ $busi->id }}">{{ $busi->name }}</option>
                                                @endforeach
    
                                            </select>
                                        </div>
                                    @endif
                                </div>
                                <!-- Đẩy các nút xuống dòng -->
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2" id="applyDateFilter_pie">Lọc</button>
                                    <button type="button" class="btn btn-secondary" id="resetForm_pie">Làm mới</button>
                                </div>
    
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="chart-responsive">
                                        <canvas id="pieChart" height="160"></canvas>
                                    </div>
                                    <!-- ./chart-responsive -->
                                </div>
                                <!-- /.col -->
                                {{-- <div class="col-md-5">
                                    <h6>Tỉ lệ tăng tháng này</h6>
                                    
                                    <ul class="nav nav-pills flex-column">
                                        @foreach($piedatamonth as $item)
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                {{ $item['type_name'] }}
                                               
                                                    @if ($item['percent']>0)
                                                     <span class="float-right text-success">
                                                        <i class="fas fa-arrow-up text-sm"></i>
                                                        {{ $item['percent'] }}%</span>
                                                    @else
                                                    <span class="float-right text-warning">
                                                        <i class="fas fa-arrow-left text-sm"></i>
                                                        {{ $item['percent'] }}%</span>
                                                    @endif
                                                    
                                                    
                                            </a>
                                        </li>
                                    @endforeach
                                       
                                    </ul>
                                </div> --}}
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer p-0">
                            
                        </div>
                        <!-- /.footer -->
                    </div>
                </div>
                @if (Auth::user()->id!=1)
                <div class="col-lg-6">
                    {{-- Bảng sản phẩm --}}
                   
                        
                   
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Tour bán chạy gần đây</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </div>
                            
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Tên tour</th>
                                        <th>Địa điểm</th>
                                        {{-- @if(Auth::user()->id==1)
                                        <th>Doanh nghiệp</th>
                                        @endif --}}
                                        <th>Loại</th>
                                        <th>Khác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tour_sale_ganday as $ts )
                                        <tr>
                                            <td>
                                                <img src="{{ asset('upload/tours/' . $ts->image) }}" alt="" width=80 height=70>
                                            
                                            </td>
                                          
                                            <td>
                                                <a href="{{route('chi-tiet-tour',[$ts->slug])}}">{{$ts->title}}</a>
                                            
                                            </td>
                                            
                                            <td>
                                                {{$ts->category->title}}
                                            
                                            </td>
                                              
                                            <td>
                                                {{$ts->type->type_name}}
                                            
                                            </td>
                                            
                                            
                                            {{-- <td>
                                                <a href="#" class="text-muted">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td> --}}
                                            <td>
                                                
                                                {{-- Perfect Item --}}
                                                <span class="badge bg-danger">Hot</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                </div>
                @endif
                @if (Auth::user()->id==1)
                <div class="col-lg-12">
                    {{-- Bảng sản phẩm --}}
                   
                        
                   
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Tour bán chạy gần đây</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </div>
                            
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Tên tour</th>
                                        <th>Địa điểm</th>
                                       
                                       
                                      
                                        <th>Loại</th>
                                        <th>Doanh nghiệp</th>
                                        <th>Khác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tour_sale_ganday as $ts )
                                        <tr>
                                            <td>
                                                <img src="{{ asset('upload/tours/' . $ts->image) }}" alt="" width=80 height=70>
                                            
                                            </td>
                                          
                                            <td>
                                                <a href="{{route('chi-tiet-tour',[$ts->slug])}}">{{$ts->title}}</a>
                                            
                                            </td>
                                            
                                            <td>
                                                {{$ts->category->title}}
                                            
                                            </td>
                                              
                                        
                                            
                                            
                                            <td>
                                                 {{$ts->type->type_name}}
                                            </td>
                                            <td>
                                                {{$ts->user->name}}
                                            </td>
                                            <td>
                                                
                                                {{-- Perfect Item --}}
                                                <span class="badge bg-danger">Hot</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                </div>
                @endif
                {{-- <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Online Store Overview</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-sm btn-tool">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-tool">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="ion ion-android-arrow-up text-success"></i> 12%
                                    </span>
                                    <span class="text-muted">CONVERSION RATE</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                                    </span>
                                    <span class="text-muted">SALES RATE</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="ion ion-android-arrow-down text-danger"></i> 1%
                                    </span>
                                    <span class="text-muted">REGISTRATION RATE</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <!-- /.content -->
@endsection
