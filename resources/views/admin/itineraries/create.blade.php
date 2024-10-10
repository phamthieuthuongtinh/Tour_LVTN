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
            <div class="">
             
                <!-- Form 1 -->
                <form method="POST" action="{{ route('itineraries.store') }}" class="form-container" enctype="multipart/form-data">
                    @csrf
                    @php
                        $i=$day_number
                    @endphp
                    <h5 class="">Nội dung ngày {{$i}}</h5>
                    <div id="day{{$i}}" class="day-container">
                        <div class="form-group mb-3">
                            <label for="location{{$i}}">Địa điểm di chuyển:</label>
                            <input type="text" class="form-control" name="location" id="location{{$i}}" placeholder="Địa điểm" value="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description{{$i}}">Các hoạt động chính:</label>
                            <textarea class="form-control" name="description" id="editor" placeholder="Mô tả chính"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Hình ảnh</label>
                            <div class="input-group">
                               <div class="custom-file">
                                  <input type="file" name="image" class="form-control-file" id="exampleInputFile">
                                  <label class="custom-file-label" for="exampleInputFile">Chọn hình ảnh</label>
                               </div>
                            </div>
                         </div>
                        {{-- <div class="form-group mb-3">
                            <label for="details{{$i}}">Chi tiết hoạt động:</label>
                            <div class="details-container">
                                <!-- Phần này sẽ được sử dụng JavaScript để thêm các chi tiết hoạt động -->
                            </div>
                        </div> --}}
                
                        <!-- Nút thêm mô tả và hình ảnh -->
                    </div>
                    <input type="hidden" name="day_number" value="{{$i}}">
                    <input type="hidden" name="tour_id" value="{{$tour_id}}">
                    <div class="card-footer d-flex justify-content-center">
                        {{-- <button type="button" class="btn btn-secondary add-detail-item pd-3 mr-3" data-day="{{$i}}">Thêm chi tiết</button> --}}
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
           
            
            </div>
            
            
          
        </div>
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
