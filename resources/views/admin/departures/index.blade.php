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
                <table class="table table-striped table-valign-middle" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã tour</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Hình ảnh</th>
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
                                <td>{{ $tour->tour_code }}</td>
                                <td>{{ $tour->title }}</td>
                                <td>{{ $tour->category->title }}</td>



                                <td><img src="{{ asset('upload/tours/' . $tour->image) }}" alt="" width=150
                                        height=100></td>

                                <td>

                                    @if ($tour->status == 3)
                                        <a href="{{ route('departures.show', [$tour->id]) }}" class="btn btn-warning"
                                            title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
