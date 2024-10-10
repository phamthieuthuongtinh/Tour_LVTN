@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tất Cả Danh Mục</h3>
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
                            <th>Tiêu đề</th>
                            <th>Mã voucher</th>

                            <th>Giá trị giảm</th>
                            <th>Số lượt dùng còn</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $key => $vou)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $vou->voucher_name }}</td>
                                <td>{{ $vou->voucher_code }}</td>


                                <td>
                                    @if ($vou->voucher_condition == 1)
                                        <p>{{ number_format($vou->voucher_number) }} đ</p>
                                    @else
                                        <p> {{ $vou->voucher_number }}%</p>
                                    @endif
                                </td>
                                <td>{{ $vou->voucher_time }}</td>
                                <td>{{ $vou->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('vouchers.edit', [$vou->id]) }}" class="btn btn-warning"
                                            title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa voucher này?');"
                                            action="{{ route('vouchers.destroy', [$vou->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger" title="Xóa">
                                                <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                            </button>
                                        </form>
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
