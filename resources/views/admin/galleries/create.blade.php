@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Thêm Thư Viện Ảnh</h3>
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
   <form method="POST" action="{{route('galleries.store')}}" enctype="multipart/form-data">
    @csrf
        
      <div class="card-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Tour</label>
            <select class="form-control" name="tour_id" id="">
            
                <option value="{{$tour->id}}">{{$tour->title}}</option>
     
            </select>
        </div>
         {{-- <div class="form-group">
            <label for="exampleInputEmail1">Tiêu đề</label>
            <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="...">
         </div> --}}
       
         <div class="form-group">
            <label for="exampleInputFile">Hình ảnh</label>
            <div class="input-group">
               <div class="custom-file">
                  <input type="file" name="image[]" multiple class="form-control-file" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
               </div>
            </div>
         </div>
        
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
         <button type="submit" class="btn btn-primary">Thêm</button>
      </div>
   </form>
   <table class="table table-striped table-valign-middle" id="myTable">
    <thead>
    <tr>
      <th>#</th>
      {{-- <th>Tiêu đề</th> --}}
      <th>Hình ảnh</th>
      <th>Ngày thêm</th>
      <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
      @foreach($galleries as $key => $gal)
      <tr>
          <td>{{$key}}</td>
          {{-- <td>{{$gal->title}}</td> --}}
          <td><img src="{{asset('upload/galleries/'.$gal->image)}}" alt="" width=150 height=120></td>
          <td>{{$gal->created_at}}</td>
          <td>
              <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa ảnh này?');" action="{{route('galleries.destroy',[$gal->id])}}">
                  @method('DELETE')
                  @csrf
                 <input type="submit" class="btn btn-danger" value="Xóa">
              </form>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection