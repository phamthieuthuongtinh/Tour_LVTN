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
                <div class="col-lg-6">
                    {{-- Biểu đồ đường người tham gia web --}}
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Luọng người đăng ký</h3>
                                <a href="javascript:void(0);">View Report</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">820</span>
                                    <span>Visitors Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 12.5%
                                    </span>
                                    <span class="text-muted">Since last week</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This Week
                                </span>
                                <span>
                                    <i class="fas fa-square text-gray"></i> Last Week
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Biểu đồ loại tour</h3>

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
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <canvas id="pieChart" height="150"></canvas>
                                    </div>
                                    <!-- ./chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        <li><i class="far fa-circle text-danger"></i> Chrome</li>
                                        <li><i class="far fa-circle text-success"></i> IE</li>
                                        <li><i class="far fa-circle text-warning"></i> FireFox</li>
                                        <li><i class="far fa-circle text-info"></i> Safari</li>
                                        <li><i class="far fa-circle text-primary"></i> Opera</li>
                                        <li><i class="far fa-circle text-secondary"></i> Navigator</li>
                                    </ul>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        United States of America
                                        <span class="float-right text-danger">
                                            <i class="fas fa-arrow-down text-sm"></i>
                                            12%</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        India
                                        <span class="float-right text-success">
                                            <i class="fas fa-arrow-up text-sm"></i> 4%
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        China
                                        <span class="float-right text-warning">
                                            <i class="fas fa-arrow-left text-sm"></i> 0% 
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.footer -->
                    </div>
                </div>
                <div class="col-lg-6">
                    {{-- Biểu đồ tròn --}}

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
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Sales</th>
                                        <th>More</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-150x150.png" alt="Product 1"
                                                class="img-circle img-size-32 mr-2">
                                            Some Product
                                        </td>
                                        <td>$13 USD</td>
                                        <td>
                                            <small class="text-success mr-1">
                                                <i class="fas fa-arrow-up"></i>
                                                12%
                                            </small>
                                            12,000 Sold
                                        </td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-150x150.png" alt="Product 1"
                                                class="img-circle img-size-32 mr-2">
                                            Another Product
                                        </td>
                                        <td>$29 USD</td>
                                        <td>
                                            <small class="text-warning mr-1">
                                                <i class="fas fa-arrow-down"></i>
                                                0.5%
                                            </small>
                                            123,234 Sold
                                        </td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-150x150.png" alt="Product 1"
                                                class="img-circle img-size-32 mr-2">
                                            Amazing Product
                                        </td>
                                        <td>$1,230 USD</td>
                                        <td>
                                            <small class="text-danger mr-1">
                                                <i class="fas fa-arrow-down"></i>
                                                3%
                                            </small>
                                            198 Sold
                                        </td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-150x150.png" alt="Product 1"
                                                class="img-circle img-size-32 mr-2">
                                            Perfect Item
                                            <span class="badge bg-danger">NEW</span>
                                        </td>
                                        <td>$199 USD</td>
                                        <td>
                                            <small class="text-success mr-1">
                                                <i class="fas fa-arrow-up"></i>
                                                63%
                                            </small>
                                            87 Sold
                                        </td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-150x150.png" alt="Product 1"
                                                class="img-circle img-size-32 mr-2">
                                            Perfect Item
                                            <span class="badge bg-danger">NEW</span>
                                        </td>
                                        <td>$199 USD</td>
                                        <td>
                                            <small class="text-success mr-1">
                                                <i class="fas fa-arrow-up"></i>
                                                63%
                                            </small>
                                            87 Sold
                                        </td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-150x150.png" alt="Product 1"
                                                class="img-circle img-size-32 mr-2">
                                            Perfect Item
                                            <span class="badge bg-danger">NEW</span>
                                        </td>
                                        <td>$199 USD</td>
                                        <td>
                                            <small class="text-success mr-1">
                                                <i class="fas fa-arrow-up"></i>
                                                63%
                                            </small>
                                            87 Sold
                                        </td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
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
                </div>
            </div>

            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <!-- /.content -->
@endsection
