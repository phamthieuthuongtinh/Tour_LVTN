@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tất Cả Tour</h3>
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
                <table class="table table-striped table-valign-middle table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thư viện</th>
                            <th>Tiêu đề</th>

                            <th>Danh mục</th>
                            <th>Loại</th>
                            @if (Auth::user()->id == 1)
                                <th>Doanh nghiệp</th>
                            @endif

                            {{-- <th>Giá tour</th> --}}

                            {{-- <th>Mô tả</th>
                    <th>Phương tiện</th> --}}
                            <th>Hình ảnh</th>
                            {{-- <th>Số ngày</th>
                            <th>Số đêm</th> --}}
                            {{-- <th>Nơi đi</th>
                    <th>Nơi đến</th> --}}
                            <th>Mã tour</th>
                            <th>Trạng thái</th>
                            {{-- <th>Slug</th>
                    <th>Ngày tạo</th> --}}
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
                        @foreach ($tours as $key => $tour)
                            <tr class="{{ $tour->status == 0 ? 'deleted-tour' : '' }}">
                                <td>{{ $key }}</td>
                                <td>
                                    @if ($tour->status == 0)
                                        <span class="disabled-link">Thêm ảnh</span>
                                    @else
                                        <a href="{{ route('galleries.edit', [$tour->id]) }}">Thêm ảnh</a>
                                    @endif
                                </td>
                                <td>{{ $tour->title }}</td>
                                <td>{{ $tour->category->title }}</td>
                                <td>{{ $tour->type->type_name }}</td>
                                @if (Auth::user()->id == 1)
                                    <td>{{ $tour->user->name }}</td>
                                @endif
{{-- 
                                <td>
                                    <p style="color: blue; padding:0px; margin: 0px;">>11 tuổi:</p>
                                    {{ number_format($tour->price) }}đ
                                    <p style="color: blue; padding:0px; margin: 0px;">5-11 tuổi:</p>
                                    {{ number_format($tour->price_treem) }}đ
                                    <p style="color: blue; padding:0px; margin: 0px;">2-5 tuổi:</p>
                                    {{ number_format($tour->price_trenho) }}đ
                                    <p style="color: blue; padding:0px; margin: 0px;">
                                        <2 tuổi:</p>
                                            {{ number_format($tour->price_sosinh) }}đ
                                </td> --}}

                                {{-- <td>{{ substr($tour->description, 0, 20) }}...</td>
                        <td>{{$tour->vehicle}}</td> --}}
                                <td><img src="{{ asset('upload/tours/' . $tour->image) }}" alt="" width=150
                                        height=120></td>
                                {{-- <td>{{ $tour->so_ngay }}</td>
                                <td>{{ $tour->so_dem }}</td> --}}
                                {{-- <td>{{$tour->tour_from}}</td>
                        <td>{{$tour->tour_to}}</td> --}}
                                <td>{{ $tour->tour_code }}</td>
                                <td>
                                    @if ($tour->status == 1)
                                        Chưa gửi duyệt
                                    @elseif($tour->status == 2)
                                        Chờ được duyệt
                                    @elseif($tour->status == 3)
                                        Đã được duyệt
                                    @elseif($tour->status == 4)
                                        Bị từ chối
                                    @else
                                        Đã bị xóa
                                    @endif

                                </td>
                                {{-- <td>{{ substr($tour->slug, 0, 20) }}...</td>
                      
                        <td>{{$tour->created_at}}</td> --}}
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('tours.xem', [$tour->id]) }}" class="btn btn-info mr-2"
                                            title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($tour->status == 1 || $tour->status == 4)
                                            <a href="{{ route('tours.edit', [$tour->id]) }}" class="btn btn-warning"
                                                title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                    
                                            <form method="POST" action="{{ route('tours.guiduyet', [$tour->id]) }}">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-success" title="Gửi duyệt">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                            <br>
                                            <form method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa tour này?');"
                                                action="{{ route('tours.destroy', [$tour->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger" title="Xóa">
                                                    <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                                </button>
                                            </form>
                                        @elseif($tour->status == 2)
                                            <form method="POST" action="{{ route('tours.guiduyet', [$tour->id]) }}">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-warning" title="Hủy gửi">
                                                    <i class="fas fa-undo"></i> <!-- Biểu tượng "Undo" -->
                                                </button>
                                            </form>
                                        @elseif($tour->status == 3)
                                            @if (Auth::user()->id == 1)
                                                <form method="POST" action="{{ route('tours.duyet', [$tour->id]) }}">
                                                    @method('PATCH')
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning" title="Bỏ duyệt">
                                                        <i class="fas fa-undo"></i> <!-- Biểu tượng "Undo" -->
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" onsubmit="return confirm('Bạn có chắc chuyển tour này về trạng thái chưa gửi duyệt?');"
                                                    action="{{ route('tours.xoa', [$tour->id]) }}">
                                                    @method('PATCH')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" title="Trở về chưa gửi duyệt">
                                                        <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form method="POST"
                                                onsubmit="return confirm('Bạn có chắc khôi phục tour này?');"
                                                action="{{ route('tours.destroy', [$tour->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-warning" title="Khôi phục">
                                                    <i class="fa fa-recycle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
      .btn-group .btn {
          margin-right: 5px;
          /* Điều chỉnh khoảng cách giữa các nút */
      }
  </style>
@endsection
