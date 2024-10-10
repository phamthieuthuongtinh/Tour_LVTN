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
        <div class="card-header mb-1">
            <h3 class="card-title">Quản lý lịch trình</h3>
        </div>
      
            <div class="p-2">
                 
                <!-- Form 1 -->
                <form method="POST" action="{{route('itineraries.edit_itinerayDetail',[$itinerayDetail->id])}}" class="form-container" enctype="multipart/form-data">
                    @csrf
                   
                        <h5 class="">Nội dung ngày {{$itinerayDetail->day_number}}</h5>
                 
          
                   
                        <div class="form-group mb-3">
                                <label for="description">Mô tả chính:</label>
                                <textarea class="form-control" name="description" id="editor" rows="8" placeholder="Mô tả chính">{{$itinerayDetail->description}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image_name">Tên hình ảnh</label>
                            <input class="form-control" name="image_name" id="image_name"  placeholder="Tên hình ảnh" value="{{$itinerayDetail->image_name}}"></input>
                    </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Hình ảnh</label>
                            <div class="input-group">
                               <div class="custom-file">
                                  <input type="file" name="image" value="{{$itinerayDetail->image}}" class="form-control-file" id="exampleInputFile">
                                  <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
                               </div>
                            </div>
                         </div>
                        <img width="200" height="200" src="{{asset('upload/tours/'.$itinerayDetail->image)}}" alt="">
                    <input type="hidden" name="day_number" value="{{$itinerayDetail->day_number}}">
                    <div class="card-footer d-flex justify-content-center">

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
    
            
            </div>
    </div>
@endsection
