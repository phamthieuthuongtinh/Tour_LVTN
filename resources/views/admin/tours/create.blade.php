@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tạo Tour</h3>
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
        <form method="POST" action="{{ route('tours.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categorySelect">Danh mục tour</label>
                            <select class="form-control" name="category_id" id="categorySelect">
                                @foreach ($categories as $key => $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="typeSelect">Loại tour</label>
                            <select class="form-control" name="type_id" id="typeSelect">
                                @foreach ($types as $key => $type)
                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="titleInput">Tiêu đề tour</label>
                            <input type="text" class="form-control" name="title" id="titleInput" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="descriptionInput">Mô tả tour</label>
                            <input type="text" class="form-control" name="description" id="descriptionInput" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="tourFromInput">Nơi xuất phát</label>
                            <input type="text" class="form-control" name="tour_from" id="tourFromInput" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="tourToInput">Nơi đến</label>
                            <input type="text" class="form-control" name="tour_to" id="tourToInput" placeholder="...">
                        </div>
                    </div>

                    <div class="col-md-6">
                        {{-- <div class="form-group">
                            <label for="tourCostInput">Chi phí tour</label>
                            <input type="text" class="form-control" name="tour_cost" id="tourCostInput" placeholder="...">
                        </div> --}}
                        <div class="form-group">
                            <label for="adultPrice">Giá người lớn</label>
                            <input type="text" class="form-control" name="price" id="adultPrice" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="childPrice">Giá trẻ em (5-11 tuổi)</label>
                            <input type="text" class="form-control" name="price_treem" id="childPrice" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="toddlerPrice">Giá trẻ nhỏ (2-5 tuổi)</label>
                            <input type="text" class="form-control" name="price_trenho" id="toddlerPrice" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="infantPrice">Giá sơ sinh (&lt;2 tuổi)</label>
                            <input type="text" class="form-control" name="price_sosinh" id="infantPrice" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="vehicleInput">Phương tiện</label>
                            <input type="text" class="form-control" name="vehicle" id="vehicleInput" placeholder="...">
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="so_ngay">Số ngày</label>
                            <input type="number" class="form-control" name="so_ngay" id="so_ngay" placeholder="...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="so_dem">Số đêm</label>
                            <input type="number" class="form-control" name="so_dem" id="so_dem" placeholder="...">
                        </div>
                    </div>
                </div>

                <input type="hidden" value="{{ Auth::user()->id }}" name="business_id" id="">

                

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Tạo</button>
            </div>

        </form>
    </div>
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
    </style>
@endsection
