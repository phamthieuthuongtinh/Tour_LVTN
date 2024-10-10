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
            <h3 class="card-title">Quản lý dịch vụ</h3>
         </div>
         @if ($service)
         <form method="POST" action="{{route('services.update',[$service->id])}}">
            @method('PATCH')
            @csrf
              <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Dịch vụ bao gồm</label>
                    <textarea class="form-control" name="include" id="editor" rows="8" placeholder="Dịch vụ bao gồm">{{$service->include}}</textarea>
                 </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                   <label for="exampleInputEmail1">Dịch vụ không bao gồm</label>
                   <textarea class="form-control" name="not_include" id="editor1" rows="8" placeholder="Dịch vụ không bao gồm">{{$service->not_include}}</textarea>
                </div>
             </div>
              <input type="hidden" name="tour_id" value="{{$tour->id}}">
              <!-- /.card-body -->
              <div class="card-footer">
                 <button type="submit" class="btn btn-primary">Cập nhật</button>
              </div>
           </form>
        @else 
        <form method="POST" action="{{route('services.store')}}">
            
            @csrf
              <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Dịch vụ bao gồm</label>
                    <textarea class="form-control" name="include" id="editor" rows="8" placeholder="Dịch vụ bao gồm"></textarea>
                 </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                   <label for="exampleInputEmail1">Dịch vụ không bao gồm</label>
                   <textarea class="form-control" name="not_include" id="editor1" rows="8" placeholder="Dịch vụ không bao gồm"></textarea>
                </div>
             </div>
              <input type="hidden" name="tour_id" value="{{$tour->id}}">
              <!-- /.card-body -->
              <div class="card-footer">
                 <button type="submit" class="btn btn-primary">Thêm</button>
              </div>
           </form>
         @endif
         
       
        
    </div>
@endsection
