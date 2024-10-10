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
                            <th>Tên loại</th>
                            <th>Mô tả</th>
                            <th>Hình ảnh</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $key => $type)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->type_name }}</td>
                                <td>{{ $type->type_description }}</td>
                                <td><img width="150" height="100" src="{{asset('upload/types/'. $type->image)}}" alt=""></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('types.edit', [$type->id]) }}" class="btn btn-warning mr-2"
                                            title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');"
                                            action="{{ route('types.destroy', [$type->id]) }}">
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
@endsection
