@extends('layouts.app')

@section('content')
    <div class="p-1">
        <div class="row">
            <div class="col-md-6">
                <!-- Tour Image -->
                <h4 class="mb-3 text-primary">{{ $tour->title }}</h4>
                <div class="mb-4">
                    <img src="{{ asset('upload/tours/' . $tour->image) }}" class="img-fluid rounded shadow-sm">
                </div>

                <!-- Tour Details -->
                <div class="mb-3">
                    <p><i class="fa fa-info-circle"></i> Mô tả: {{ $tour->description }}</p>
                    <div class="container my-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted"><i class="fa fa-globe"></i> {{ $tour->category->title }}</p>
                                <p><i class="fa fa-spa"></i> {{ $tour->type->type_name }}</p>
                                <p><i class="fa fa-users"></i> {{ $tour->vehicle }}</p>
                                <p><i class="fa fa-sun"></i> Số ngày: {{ $tour->so_ngay }}</p>
                                <p><i class="fa fa-moon"></i> Số đêm: {{ $tour->so_dem }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fa fa-plane"></i> Điểm đi: {{ $tour->tour_from }}</p>
                                <p><i class="fa fa-plane-arrival"></i> Điểm đến: {{ $tour->tour_to }}</p>
                                <div class="price-details">
                                    <p><i class="fa fa-tag"></i> Giá:</p>
                                    <ul>
                                        <li>Người lớn: {{ number_format($tour->price) }} đ</li>
                                        <li>Trẻ em: {{ number_format($tour->price_treem) }} đ</li>
                                        <li>Trẻ nhỏ: {{ number_format($tour->price_trenho) }} đ</li>
                                        <li>Sơ sinh: {{ number_format($tour->price_sosinh) }} đ</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Tour Itinerary -->
                <h3 class="mt-4 mb-3 text-success">Ngày khởi hành còn khả dụng</h3>
                <ul class="list-group">
                    @if ($departures->isEmpty())
                        <li class="list-group-item">
                            <strong>Chưa có ngày khởi hành</strong>
                        </li>
                    @else
                        @foreach ($departures as $key => $day)
                            <li class="list-group-item">
                                <strong>Ngày {{ $day->departure_date }}</strong><br>
                            </li>
                        @endforeach
                    @endif
                </ul>
                @if ($tour->status == 3)
                    <a href="{{ route('departures.show', [$tour->id]) }}" class="btn btn-primary mt-3">Thêm ngày khởi hành</a>             
                @endif

                <h3 class="mt-4 mb-3 text-success">Thông tin dịch vụ</h3>
                @if ($service)
                    <div class="row">
                        <div class="col-6">
                            {!! $service->include !!}
                        </div>
                        <div class="col-6">
                            {!! $service->not_include !!}
                        </div>
                    </div>
                @else
                <div>
                    <strong>Chưa có thông tin dịch vụ</strong>
                </div>
                    
                @endif
                @if ($tour->status == 3)
                    <a href="{{route('services.edit',[$tour->id])}}" class="btn btn-primary mt-3">Quản lý dịch vụ</a>
                @endif
                
                <br>
                @if (Auth::user()->id == 1)
                    @if ($tour->status == 3)
                        <form method="POST" action="{{ route('tours.duyet', [$tour->id]) }}">
                            @method('PATCH')
                            @csrf
                            <button type="submit" class="btn btn-warning" title="Bỏ duyệt">
                                <i class="fas fa-undo"></i> <!-- Biểu tượng "Undo" -->
                            </button>
                        </form>
                    @else
                        <div class="btn-group">
                            <form method="POST" action="{{ route('tours.duyet', [$tour->id]) }}" title="Duyệt">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-success" title="Duyệt">
                                    <i class="fas fa-check"></i> <!-- Biểu tượng "Check" -->
                                </button>
                            </form>

                            <form method="POST" action="{{ route('tours.tuchoi_duyet', [$tour->id]) }}">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-danger" title="Từ chối">
                                    <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <div>
                        <h3 class="mt-4 mb-3 text-success">Thao tác</h3>
                    </div>
                    <div class="btn-group">
                        @if ($tour->status == 1 || $tour->status == 4)
                            <a href="{{ route('tours.edit', [$tour->id]) }}" class="btn btn-warning" title="Chỉnh sửa">
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
                            <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tour này?');"
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
                                <form method="POST"
                                    onsubmit="return confirm('Bạn có chắc chuyển tour này về trạng thái chưa gửi duyệt?');"
                                    action="{{ route('tours.xoa', [$tour->id]) }}">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" class="btn btn-danger" title="Trở về chưa gửi duyệt">
                                        <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                    </button>
                                </form>
                            @endif
                        @else
                            <form method="POST" onsubmit="return confirm('Bạn có chắc khôi phục tour này?');"
                                action="{{ route('tours.destroy', [$tour->id]) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-warning" title="Khôi phục">
                                    <i class="fa fa-recycle"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endif


            </div>

            <div class="col-md-6">
                <!-- Lịch trình -->
                <h3 class="mt-4 mb-3 text-success">Lịch trình</h3>
                <ul class="list-group">
                    @if($itineraries->isEmpty())
                    <strong>Chưa có thông tin lịch trình</strong>
                    @else
                        @foreach ($itineraries as $key => $ite)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>Ngày {{ $ite->day_number }}: {{ $ite->location }}</strong><br>
                                        <p>{!! $ite->description !!}</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img width="200px" height="200px" src="{{ asset('upload/tours/' . $ite->image) }}"
                                            alt="" class="img-fluid rounded">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                    
                </ul>
                @if ($tour->status == 3)
                    <a href="{{route('itineraries.show',[$tour->id])}}" class="btn btn-primary mt-3">Quản lý lịch trình</a>
                @endif
                
            </div>

        </div>
    </div>

    <style>
        /* Tùy chỉnh cho trang chi tiết tour */
        .img-fluid {
            max-height: 400px;
            object-fit: cover;
            border-radius: .5rem;
        }

        .text-primary {
            color: #007bff;
        }

        .text-success {
            color: #28a745;
        }

        .list-group-item {
            border: 1px solid #ddd;
            border-radius: .25rem;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-warning:hover,
        .btn-primary:hover {
            opacity: 0.8;
        }

        .btn-group .btn {
            margin-right: 5px;
            /* Điều chỉnh khoảng cách giữa các nút */
        }
    </style>
@endsection
