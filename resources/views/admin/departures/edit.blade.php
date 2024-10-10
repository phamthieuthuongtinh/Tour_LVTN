@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        
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
        <div class="card-header">
            <h3 class="card-title">Thêm Ngày Khởi Hành</h3>
         </div>
         <form method="POST" action="{{route('departures.store')}}">
            @csrf
              <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Ngày khởi hành</label>
                    <input type="date" class="form-control" name="departure_date" id="departure_date" placeholder="Ngày khởi hành">
                 </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                   <label for="exampleInputEmail1">Số lượng người</label>
                   <input type="number" class="form-control" name="quantity" id="quantity" value='10'>
                </div>
             </div>
              <input type="hidden" name="tour_id" value="{{$tour_id}}">
              <!-- /.card-body -->
              <div class="card-footer">
                 <button type="submit" class="btn btn-primary">Thêm</button>
              </div>
           </form>
         <div class="card-header" style="background-color: #c21aa6">
            <h3 class="card-title">Tất Cả Ngày Khởi Hành</h3>
        </div>
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
                            <th>Ngày khởi hành</th>
                            <th>Số lượng người</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <style>
                        .deleted-tour {
                            background-color: #4d4d4d !important;
                        }

                        .disabled-link {
                            color: gray;
                            pointer-events: none;
                            text-decoration: none;
                        }
                    </style>
                    <tbody>
                        @foreach ($departures as $key => $depart)
                            <tr class="{{ $depart->status == 0 ? 'deleted-tour' : '' }}">
                                <td>{{ $key }}</td>
                                <td>{{ $depart->departure_date }}</td>

                                <td>{{ $depart->quantity }}</td>


                                <td>

                                    @if ($depart->status == 1)
                                        {{-- <a href="{{ route('departures.edit', [$depart->id]) }}" class="btn btn-warning">
                                            Sửa
                                        </a>
                                        <br>
                                        <br> --}}
                                        <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');"
                                            action="{{ route('departures.destroy', [$depart->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger" title="Xóa">
                                                <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" onsubmit="return confirm('Bạn có chắc khôi phục?');"
                                            action="{{ route('departures.destroy', [$depart->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-warning" title="Khôi phục">
                                                <i class="fa fa-recycle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
        
    </div>
@endsection
