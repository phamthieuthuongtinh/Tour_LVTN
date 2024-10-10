@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Tất Cả Thư</h3>
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
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Tiêu đề</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($contacts as $key => $contact)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$contact->name}}</td>
                        <td>{{$contact->email}}</td>
                       
                        <td>{{$contact->phone}}</td>
                        <td>{{$contact->title}}</td>
                        <td>{{$contact->created_at}}</td>
                        
                        <td>
                          <div class="btn-group">
                              <a href="{{ route('contacts.edit', [$contact->id]) }}" class="btn btn-info mr-1" title="Xem chi tiết">
                                  <i class="fas fa-eye"></i>
                              </a>
                              <a href="" class="btn btn-primary mr-1" title="Trả lời">
                                <i class="fas fa-reply"></i> 
                              </a>
                              <a href="" class="btn btn-secondary mr-1" title="Chuyển tiếp">
                                  <i class="fas fa-share"></i> 
                              </a>
                              <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');" action="{{ route('contacts.destroy', [$contact->id]) }}" style="display: inline;">
                                  @method('DELETE')
                                  @csrf
                                  <button type="submit" class="btn btn-danger" title="Xóa">
                                      <i class="fas fa-trash"></i> <!-- Biểu tượng "Times" -->
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