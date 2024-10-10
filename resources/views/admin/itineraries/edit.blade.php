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
      
            <div class="">
                @php
                    $i=$day_number
                 @endphp
                <!-- Form 1 -->
                <form method="POST" action="{{ route('itineraries.updated', ['tour_id' => $tour_id, 'day_number' => $i]) }}" class="form-container" enctype="multipart/form-data">
                    @csrf
                  
                    <h5 class="">Nội dung ngày {{$i}}</h5>
                    <div id="day{{$i}}" class="day-container">
                        <div class="form-group mb-3">
                            <label for="location{{$i}}">Địa điểm di chuyển:</label>
                            <input type="text" class="form-control" value="{{$itineraries->location}}" name="location" id="location{{$i}}" placeholder="Địa điểm" >
                        </div>
                        <div class="form-group mb-3">
                            <label for="description{{$i}}">Các hoạt động chính:</label>
                            <textarea class="form-control" name="description" id="editor" placeholder="Mô tả chính">{{$itineraries->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Hình ảnh</label>
                            <div class="input-group">
                               <div class="custom-file">
                                  <input type="file" name="image" value="{{$itineraries->image}}" class="form-control-file" id="exampleInputFile">
                                  <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
                               </div>
                            </div>
                         </div>
                        <img width="200" height="200" src="{{asset('upload/tours/'.$itineraries->image)}}" alt="">
                        {{-- <div class="form-group mb-3">
                            <label for="details{{$i}}">Chi tiết hoạt động:</label>
                        </div> --}}
                        <!-- Nút thêm mô tả và hình ảnh -->
                    </div>
                    <input type="hidden" name="day_number" value="{{$i}}">
                    <input type="hidden" name="tour_id" value="{{$tour_id}}">
                    <div class="card-footer d-flex justify-content-center">
                        {{-- <button type="button" class="btn btn-secondary add-detail-item mr-2" data-day="{{$i}}">Thêm chi tiết hoạt động</button> --}}
                        <button type="submit" class="btn btn-primary">
                            Cập nhật</button>
                    </div>
                </form>
    
            
            </div>

            {{-- <div class="card-header mb-1">
                <h3 class="card-title">Danh sách chi tiết lịch trình</h3>
            </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mô tả</th>
                        <th>Hình ảnh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itineraryDetails as $key => $itine)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $itine->description }}</td>
                            <td><img width="100" height="100" src="{{ asset('upload/tours/' . $itine->image) }}" alt=""></td>
                            <td>
                                <a class="btn btn-warning" href="{{route('itineraries.show_itinerayDetail',[$itine->id])}}">Sửa</a>
                                <br><br>
                                <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');"
                                    action="{{ route('itineraries.destroy_itinerarydetail', [$itine->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" class="btn btn-danger" value="Xóa">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
    </div>
   
    <!-- Template cho mục mô tả và hình ảnh -->
    {{-- <script type="text/template" id="item-template">
        <div class="item-container mb-3">
            <div class="form-group mb-3">
                <label for="description{day}_new">Nội dung:</label>
                <input type="text" class="form-control" name="details[{day}][descriptions][]" id="description{day}_new" placeholder="Nội dung" required>
            </div>
            <div class="form-group mb-3">
                <label for="image{day}_new">Hình ảnh:</label>
                <input type="file" name="details[{day}][images][]" class="form-control-file" id="image{day}_new" accept="image/*">
            </div>
            <button type="button" class="btn btn-danger remove-item">Xóa</button>
        </div>
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.add-detail-item').forEach(button => {
                button.addEventListener('click', function () {
                    const day = this.getAttribute('data-day');
                    const template = document.querySelector('#item-template').innerHTML.replace(/{day}/g, day);
                    document.querySelector(`#day${day}`).insertAdjacentHTML('beforeend', template);
                });
            });
    
            document.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-item')) {
                    e.target.closest('.item-container').remove();
                }
            });
        });
    </script> --}}

    <style>
       
        .form-container {
            border: 1px solid #01203f; /* Đặt viền cho form */
            padding: 1rem; /* Thêm khoảng cách bên trong form */
            margin-bottom: 1rem; /* Thêm khoảng cách giữa các form */
            border-radius: 0.375rem; /* Tạo các góc bo tròn cho form */
            box-shadow: 0 0 0.125rem rgba(0, 0, 0, 0.075); /* Thêm bóng nhẹ cho form */
        }
        .form-group {
            margin-bottom: 1rem; /* Khoảng cách giữa các nhóm trường trong form */
        }
        .card-footer {
            margin-top: 1rem; /* Khoảng cách trên footer */
        }
        .border-end {
            border-right: 1px solid #f40468; /* Đặt viền bên phải cho cột */
        } 
    </style>
@endsection
