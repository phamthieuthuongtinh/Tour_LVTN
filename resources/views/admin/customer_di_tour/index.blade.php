@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tất Cả Khách Hàng</h3>
   </div>
   @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
   @endif
   <!-- /.card-header -->
   <!-- form start -->
   <div class="card">
              <div class="card-header border-0">
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
                    <th>#</th>
                    <th>Tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Tên</th>
                    <th>CCCD</th>
                    <th>SDT</th>
                    <th>Ghi chú</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($member as $key => $mem)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$mem->tour_name}}</td>
                        <td>{{$mem->departure_date}}</td>
                       
                        <td>{{$mem->name}}</td>
                        
                        <td>{{$mem->cccd}}</td>
                        <td>{{$mem->phone}}</td>
                        <td>{{$mem->note}}</td>
                       
                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
</div>
@endsection