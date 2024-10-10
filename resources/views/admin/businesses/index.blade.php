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
                            <th>Tên doanh nghiệp</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Ngày đăng ký</th>
                            <th>Thao tác</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registers as $key => $reg)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $reg->company_name }}</td>
                                <td>{{ $reg->email }}</td>
                                <td>{{ $reg->phone }}</td>
                                {{-- <td>
                            @if ($cate->status == 1)
                            <a href="#"><span style="color:blue; font-size:16px;" class="fa-thumb-styling fa fa-thumbs-up"></span> Hiển thị</a>
                            @else
                            <a href="#"><span style="color:red; font-size:16px;" class="fa-thumb-styling fa fa-thumbs-down"></span> Ẩn</a>
                            @endif
                        </td> --}}
                                <td>{{ $reg->address }}</td>
                                <td>
                                    @if ($reg->status == 1)
                                        Chờ duyệt
                                    @elseif($reg->status == 0)
                                        Đã từ chối
                                    @else
                                        Đã duyệt
                                    @endif
                                </td>
                                <td>{{ $reg->created_at }}</td>
                                <td>
                                    @if ($reg->status == 1)
                                        <!-- Duyệt -->
                                        <a href="{{ route('admin.accept_register', [$reg->id]) }}" class="btn btn-success"
                                            title="Duyệt">
                                            <i class="fas fa-check"></i> <!-- Biểu tượng "Check" -->
                                        </a>

                                        <form method="POST" onsubmit="return confirm('Bạn có chắc từ chối?');"
                                            action="{{ route('admin.refuse_register', [$reg->id]) }}"
                                            style="display: inline;">
                                            @method('PATCH')
                                            @csrf
                                            <!-- Từ chối -->
                                            <button type="submit" class="btn btn-danger" title="Từ chối">
                                                <i class="fas fa-times"></i> <!-- Biểu tượng "Times" -->
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            onsubmit="return confirm('Bạn có chắc bỏ duyệt, các tài khoản được tạo cho doanh nghiệp sẽ bị xóa?');"
                                            action="{{ route('admin.boduyet_register', [$reg->id]) }}"
                                            style="display: inline;">
                                            @method('PATCH')
                                            @csrf
                                            <!-- Bỏ duyệt -->
                                            <button type="submit" class="btn btn-warning" title="Bỏ duyệt">
                                                <i class="fas fa-undo"></i> <!-- Biểu tượng "Undo" -->
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
