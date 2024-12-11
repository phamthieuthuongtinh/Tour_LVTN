@extends('layouts.app')
@section('content')
<div class="card card-primary">
   <div class="card-header">
      <h3 class="card-title">Chỉnh sửa Tour</h3>
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
   <form method="POST" action="{{route('tours.update',[$tour->id])}}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
      <div class="card-body">
        
     
         <input type="hidden" value=" {{Auth::user()->id}}" name="business_id" id="">
         <div class="form-group">
            <label for="exampleInputEmail1">Danh mục tour</label>
            <select class="form-control" name="category_id" id="categorySelect">
               @foreach ( $categories as $key => $category )
                  <option {{$category->id==$tour->category_id ?'selected':''}} value="{{$category->id}}">{{$category->title}}</option>
               @endforeach
            </select>
         </div>
         <div class="form-group">
            <label for="exampleInputEmail1">Loại tour</label>
            <select class="form-control" name="type_id" id="categorySelect">
               @foreach ( $types as $key => $type )
                  <option {{$type->id==$tour->type_id ?'selected':''}} value="{{$type->id}}">{{$type->type_name}}</option>
               @endforeach
            </select>
         </div>
         {{-- <div class="form-group">
            <label for="tourType">Loại hình du lịch</label>
            <select class="form-control" name="tour_type" id="tourType">
                <option value="">Chọn loại hình</option>
                @foreach ( $categories as $key => $category )
                @if($category->id<=6)
                  <option {{$category->id==$tour->category_id && ?'selected':''}} value="{{$category->id}}">{{$category->title}}</option>
               @endif
               @endforeach
               
            </select>
        </div> --}}
        
        {{-- <div class="form-group">
            <label for="category">Địa điểm du lịch</label>
            <select class="form-control" name="category_id" id="category">
                <option value="">Chọn địa điểm</option>
                <!-- Các lựa chọn sẽ được cập nhật dựa trên lựa chọn "tourType" -->
            </select>
        </div> --}}
        
         <div class="form-group">
            <label for="exampleInputEmail1">Tiêu đề tour</label>
            <input type="text" value="{{$tour->title}}" class="form-control" name="title" id="exampleInputEmail1" placeholder="...">
         </div>
         {{-- <div class="form-group">
            <label for="exampleInputPassword1">Số lượng tour</label>
            <input type="text" class="form-control" value="{{$tour->quantity}}" name="quantity" id="exampleInputPassword1" placeholder="...">
         </div> --}}
         <div class="form-group">
            <label for="exampleInputPassword1">Mô tả tour</label>
            <input type="text" class="form-control" value="{{$tour->description}}" name="description" id="exampleInputPassword1" placeholder="...">
         </div>
         {{-- <div class="form-group"> --}}
         <div class="form-group">
            <label for="exampleInputPassword1">Nơi xuất phát</label>
            <input type="text" class="form-control" value="{{$tour->tour_from}}" name="tour_from" id="exampleInputPassword1" placeholder="...">
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Nơi đến</label>
            <input type="text" class="form-control" value="{{$tour->tour_to}}" name="tour_to" id="exampleInputPassword1" placeholder="...">
         </div>
         {{-- <div class="form-group">
            <label for="adultPrice">Chi phí tour</label>
            <input type="text" class="form-control" name="tour_cost" id="tour_cost" value="{{$tour->tour_cost}}" placeholder="...">
         </div> --}}
         <div class="form-group">
            <label for="adultPrice">Giá người lớn</label>
            <input type="text" value="{{$tour->price}}" class="form-control" name="price" id="adultPrice" placeholder="...">
         </div>
         <div class="form-group">
            <label for="childPrice">Giá trẻ em (5-11 tuổi)</label>
            <input type="text" value="{{$tour->price_treem}}" class="form-control" name="price_treem" id="childPrice" placeholder="...">
         </div>
         <div class="form-group">
            <label for="toddlerPrice">Giá trẻ nhỏ (2-5 tuổi)</label>
            <input type="text" value="{{$tour->price_trenho}}" class="form-control" name="price_trenho" id="toddlerPrice" placeholder="...">
         </div>
         <div class="form-group">
            <label for="infantPrice">Giá sơ sinh (<2 tuổi)</label>
            <input type="text" value="{{$tour->price_sosinh}}" class="form-control" name="price_sosinh" id="infantPrice" placeholder="...">
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Phương tiện</label>
            <input type="text" class="form-control" value="{{$tour->vehicle}}" name="vehicle" id="exampleInputPassword1" placeholder="...">
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Số ngày</label>
            <input type="number" class="form-control" value="{{$tour->so_ngay}}" name="so_ngay" id="so_ngay" placeholder="...">
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Số đêm</label>
            <input type="number" class="form-control" value="{{$tour->so_dem}}" name="so_dem" id="so_dem" placeholder="...">
         </div>
         
         {{-- <div class="form-group">
            <label for="exampleInputPassword1">Tổng thời gian đi</label>
            <input type="text" class="form-control" value="{{$tour->tour_time}}" name="tour_time" id="tour_time" placeholder="...">
         </div> --}}
        
         
         <div class="form-group">
            <label for="exampleInputFile">Hình ảnh</label>
            <div class="input-group">
               <div class="custom-file">
                  <input type="file" name="image" class="form-control-file" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
               </div>
               <img width='120' height='120' src="{{asset('upload/tours/'.$tour->image)}}" alt="">
            </div>
         </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
         <button type="submit" class="btn btn-primary">Cập nhật</button>
      </div>
   </form>
</div>
{{-- 
<script>
   document.getElementById('tourType').addEventListener('change', function () {
    var tourType = this.value;
    var categorySelect = document.getElementById('category');

    // Xóa các tùy chọn hiện có trong danh sách chọn địa điểm
    categorySelect.innerHTML = '<option value="">Chọn địa điểm</option>';

    // Lấy danh sách các địa điểm tương ứng từ server hoặc từ biến dữ liệu
    var categories = @json($categories);

    // Lọc các danh mục theo category_parent_id
    var filteredCategories = categories.filter(function (category) {
        return category.category_parent== tourType;
    });

    // Tạo các tùy chọn cho danh sách chọn địa điểm
    filteredCategories.forEach(function (category) {
        var option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.title;
        if (category.id == {{ $tour->category_id ?? 'null' }}) {
            option.selected = true;
        }
        categorySelect.appendChild(option);
    });
});

</script> --}}
{{-- <script>
   $(document).ready(function() {
       $('#categorySelect').select2({
           placeholder: 'Chọn danh mục tour',
           allowClear: true
       });
   });
</script> --}}
   <style>
      .select2-container .select2-selection--single {
         height: calc(2.25rem + 2px) !important;
      }
   </style>
@endsection