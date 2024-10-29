@extends('layout')
@section('content')
    <!--Recommend-->
    <div class="container-xxl py-3 ">
        @if (Session::get('customer_id') || Session::get('viewedTours')!=[])
            <div class="row">
                <div class="col-md-12 col-xs-12 bx-title-lst-tour text-center">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title bg-white text-center text-primary px-3">Phù hợp với bạn</h6>
                        <h1 class="mb-5">Các Tour Gợi Ý</h1>
                       
                    </div>
                    <div class="owl-carousel owl-theme">
                        @foreach ($recommends as $key => $recom)
                            <div style="padding: 10px" class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="package-item">
                                    <div class="overflow-hidden">
                                        <img style="width:456px !important; height:280px;" class="img-fluid"
                                            src="{{ asset('upload/tours/' . $recom->image) }}" alt="">
                                    </div>
                                    <div class="d-flex border-bottom flex-wrap">
                                        <small class="flex-fill text-center border-end border-bottom py-2"><i class="fa fa-mountain text-primary me-2"></i>{{ $recom->type->type_name }}</small>
                                        <small class="flex-fill text-center border-end border-bottom py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $recom->so_ngay }} Ngày - {{ $recom->so_ngay }}</small>
                                        
                                        <small class="flex-fill text-center py-2 w-100"><i class="fa fa-plane text-primary me-2"></i>{{ $recom->tour_from }}</small>
                                    </div>
                                    <div class="text-center p-4">
                                        @php
                                        // Mặc định là giá ban đầu
                                            $hasDiscount = false; 
                                            $discountedPrice = $recom->price; 

                                            // Kiểm tra và tính giá giảm nếu có
                                            foreach ($tour_sales as $dis) {
                                                if ($recom->id == $dis->tour_id) {
                                                    $discountedPrice = ($recom->price * (100 - $dis->rate)) / 100; // Tính giá sau giảm
                                                    $hasDiscount = true; // Đánh dấu là có giảm giá
                                                    break;
                                                }
                                            }
                                        @endphp

                                        <h6>Giá từ: @if($hasDiscount) <del class="text-muted">{{ number_format($recom->price) }} đ</del> @endif</h6>
                                        <h4 class="mb-0">{{ number_format($discountedPrice) }} đ</h4>

                                        <div class="mb-3">
                                            @php
                                                $fullStars = floor($recom->avg_rating); // Số ngôi sao đầy đủ
                                                $halfStar = $recom->avg_rating - $fullStars >= 0.5 ? true : false; // Kiểm tra có nửa sao không
                                            @endphp
                                            {{-- Vẽ các ngôi sao đầy đủ --}}
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <small class="fa fa-star text-primary"></small>
                                            @endfor

                                            {{-- Vẽ nửa ngôi sao nếu có --}}
                                            @if ($halfStar)
                                                <small class="fa fa-star-half-alt text-primary"></small>
                                            @endif

                                            {{-- Các ngôi sao còn lại (rỗng) --}}
                                            @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                                <small class="fa fa-star text-bray"></small>
                                            @endfor
                                        </div>
                                        <p>{{mb_substr($recom->title, 0, 60).'...'}}</p>
                                        @php
                                            if (Session::get('customer_id')) {
                                                $isLiked = $likes->contains('tour_id', $recom->id);
                                            }
                                        @endphp
                                        <form>
                                            @csrf
                                            <input type="hidden" id="wishlist_title{{ $recom->id }}"
                                                value="{{ $recom->title }}">
                                            <input type="hidden" id="wishlist_price{{ $recom->id }}"
                                                value="{{ number_format($recom->price) }} đ">
        
                                                @if($hasDiscount) 
                                                <input type="hidden" id="wishlist_sale{{ $recom->id }}"
                                                    value="{{ number_format($discountedPrice) }}đ">
                                                @else
                                                <input type="hidden" id="wishlist_sale{{ $recom->id }}"
                                                    value="0">
                                                @endif
                                            <input type="hidden" id="wishlist_tourfrom{{ $recom->id }}"
                                                value="{{$recom->tour_from }} ">
                                            <input type="hidden" id="wishlist_songay{{ $recom->id }}"
                                                value="{{$recom->so_ngay}}N-">
                                            <input type="hidden" id="wishlist_sodem{{ $recom->id }}"
                                                value="{{$recom->so_dem}}Đ">
                                            <input type="hidden" id="wishlist_vehicle{{ $recom->id }}"
                                                value="{{$recom->vehicle }}">
                                             @if ($recom->avg_rating>0)
                                                <input type="hidden" id="wishlist_rate{{ $recom->id }}"
                                                        value="{{ $recom->avg_rating }}">
                                                
                                            @else
                                                <input type="hidden" id="wishlist_rate{{ $recom->id }}"
                                                    value="Chưa có">
                                            @endif
        
                                            <input type="hidden" id="wishlist_image{{ $recom->id }}"
                                                src="{{ URL::to('upload/tours/' . $recom->image) }}"
                                                value="{{ asset('upload/tours/' . $recom->image) }}">
                                            <input type="hidden" id="wishlist_url{{ $recom->id }}"
                                                value="{{ route('chi-tiet-tour', ['slug' => $recom->slug]) }}">
                                        </form>
                                        <div class="d-flex justify-content-center mb-2">
                                            <a href="{{ route('chi-tiet-tour', ['slug' => $recom->slug]) }}"
                                                class="btn btn-sm btn-primary px-3 border-end mx-2"
                                                style="border-radius: 30px;">Chi tiết</a>
                                                <a href="#" onclick="add_compare({{ $recom->id }})"
                                                    class="btn btn-sm btn-primary px-3 border-end mx-2"
                                                    style="border-radius: 30px;"><i class="fa fa-plus"></i> So sánh
            
                                                </a>
                                            <form action="{{ route('tour.like') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="customer_id" class="customer_id"
                                                    value="{{ Session::get('customer_id') }}" id="customer_id">
                                                @if (Session::get('customer_id'))
                                                    <button class="favorite-button btn btn-sm ms-2"
                                                        data-tour-id="{{ $recom->id }}">
                                                        <i style="font-size: 18px; color: {{ $isLiked ? 'red' : 'black' }};"
                                                            class="fa fa-heart"></i>
                                                    </button>
                                                @else
                                                    <button class="favorite-button btn btn-sm ms-2"
                                                        data-tour-id="{{ $recom->id }}">
                                                        <i style="font-size: 18px" class="fa fa-heart"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Destination Start -->
    <div class="container-xxl py-0 destination">
        <div class="container">



            <!-- Thêm các tour khác tương tự -->


            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Điểm Đến Ưu Đãi</h6>
                <h1 class="mb-5">Các Điểm Đến Được Ưu Đãi</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="{{route('discounts.tour_sale',[$types[0]->slug])}}">
                                <img class="img-fluid" src="{{ asset('frontend/img/destination-1.jpg') }}" alt="">
                                <div class="bg-white text-danger fw-bold position-absolute top-0 start-0 m-3 py-1 px-2">
                                    @if($types[0]->max==$types[0]->min)
                                        Giảm
                                        {{$types[0]->max}}%
                                    @else
                                        Giảm từ
                                        {{$types[0]->min}} - {{$types[0]->max}}%
                                    @endif
                                </div>
                                <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">
                                    {{$types[0]->title}} </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                            <a class="position-relative d-block overflow-hidden" href="{{route('discounts.tour_sale',[$types[1]->slug])}}">
                                <img class="img-fluid" src="{{ asset('frontend/img/destination-2.jpg') }}" alt="">
                                <div class="bg-white text-danger fw-bold position-absolute top-0 start-0 m-3 py-1 px-2">
                                    @if($types[1]->max==$types[1]->min)
                                        Giảm
                                        {{$types[1]->max}}%
                                    @else
                                        Giảm từ
                                        {{$types[1]->min}} - {{$types[1]->max}}%
                                    @endif
                                </div>
                                <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">
                                    {{$types[1]->title}}</div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                            <a class="position-relative d-block overflow-hidden" href="{{route('discounts.tour_sale',[$types[2]->slug])}}">
                                <img class="img-fluid" src="{{ asset('frontend/img/destination-3.jpg') }}" alt="">
                                <div class="bg-white text-danger fw-bold position-absolute top-0 start-0 m-3 py-1 px-2">
                                    @if($types[2]->max==$types[2]->min)
                                        Giảm
                                        {{$types[2]->max}}%
                                    @else
                                        Giảm từ
                                        {{$types[2]->min}} - {{$types[2]->max}}%
                                    @endif
                                </div>
                                <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">
                                    {{$types[2]->title}}</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                    <a class="position-relative d-block h-100 overflow-hidden" href="{{route('discounts.tour_sale',[$types[3]->slug])}}">
                        <img class="img-fluid position-absolute w-100 h-100"
                            src="{{ asset('frontend/img/destination-4.jpg') }}" alt="" style="object-fit: cover;">
                        <div class="bg-white text-danger fw-bold position-absolute top-0 start-0 m-3 py-1 px-2">
                            @if($types[3]->max==$types[3]->min)
                                Giảm
                                {{$types[3]->max}}%
                            @else
                                Giảm từ
                                {{$types[3]->min}} - {{$types[3]->max}}%
                            @endif
                        </div>
                        <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2"> {{$types[3]->title}}
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Destination Start -->

    <!-- Package Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Gói Tour</h6>
                <h1 class="mb-5">Các Tour Mới</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($tour_hot as $key=>$tour )
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="package-item">
                            <div class="overflow-hidden">
                                <img style="width:456px; height:260px;" class="img-fluid"
                                    src="{{ asset('upload/tours/' . $tour->image) }}" alt="">
                            </div>
                            <div class="d-flex border-bottom flex-wrap">
                                <small class="flex-fill text-center border-end border-bottom py-2"><i class="fa fa-mountain text-primary me-2"></i>{{ $tour->type->type_name }}</small>
                                <small class="flex-fill text-center border-end border-bottom py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $tour->so_ngay }} Ngày - {{ $tour->so_ngay }}</small>
                                
                                <small class="flex-fill text-center py-2 w-100"><i class="fa fa-plane text-primary me-2"></i>{{ $tour->tour_from }}</small>
                            </div>
                            <div class="text-center p-4">
                                @php
                                // Mặc định là giá ban đầu
                                    $hasDiscount_2 = false; 
                                    $discountedPrice_2 = $tour->price; 

                                    // Kiểm tra và tính giá giảm nếu có
                                    foreach ($tour_hot_sales as $dis) {
                                        if ($tour->id == $dis->tour_id) {
                                            $discountedPrice_2 = ($tour->price * (100 - $dis->rate)) / 100; // Tính giá sau giảm
                                            $hasDiscount_2 = true; // Đánh dấu là có giảm giá
                                            break;
                                        }
                                    }
                                @endphp

                                <h6>Giá từ: @if($hasDiscount_2) <del class="text-muted">{{ number_format($tour->price) }} đ</del> @endif</h6>
                                <h4 class="mb-0">{{ number_format($discountedPrice_2) }} đ</h4>



                                <div class="">
                                    @php
                                        $fullStars = floor($tour->avg_rating); // Số ngôi sao đầy đủ
                                        $halfStar = $tour->avg_rating - $fullStars >= 0.5 ? true : false; // Kiểm tra có nửa sao không
                                    @endphp
                                    {{-- Vẽ các ngôi sao đầy đủ --}}
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <small class="fa fa-star text-primary"></small>
                                    @endfor

                                    {{-- Vẽ nửa ngôi sao nếu có --}}
                                    @if ($halfStar)
                                        <small class="fa fa-star-half-alt text-primary"></small>
                                    @endif

                                    {{-- Các ngôi sao còn lại (rỗng) --}}
                                    @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                        <small class="fa fa-star text-bray"></small>
                                    @endfor
                                </div>

                                <p style="">{{ mb_substr($tour->title, 0, 60) . '...' }}</p>
                                @php
                                    if (Session::get('customer_id')) {
                                        $isLiked = $likes->contains('tour_id', $tour->id);
                                    }
                                @endphp
                                <div class="row">

                                </div>
                                <form>
                                    @csrf
                                    <input type="hidden" id="wishlist_title{{ $tour->id }}"
                                        value="{{ $tour->title }}">
                                    <input type="hidden" id="wishlist_price{{ $tour->id }}"
                                        value="{{ number_format($tour->price) }} đ">
                                    @if($hasDiscount_2) 
                                        <input type="hidden" id="wishlist_sale{{ $tour->id }}"
                                            value="{{ number_format($discountedPrice_2) }}đ">
                                        @else
                                        <input type="hidden" id="wishlist_sale{{ $tour->id }}"
                                            value="0">
                                        @endif
                                    <input type="hidden" id="wishlist_tourfrom{{ $tour->id }}"
                                        value="{{$tour->tour_from }} ">
                                    <input type="hidden" id="wishlist_songay{{ $tour->id }}"
                                        value="{{$tour->so_ngay}}N-">
                                    <input type="hidden" id="wishlist_sodem{{ $tour->id }}"
                                        value="{{$tour->so_dem}}Đ">
                                    <input type="hidden" id="wishlist_vehicle{{ $tour->id }}"
                                        value="{{$tour->vehicle}}">
                                     @if ($tour->avg_rating>0)
                                        <input type="hidden" id="wishlist_rate{{ $tour->id }}"
                                                value="{{ $tour->avg_rating }}">
                                        
                                    @else
                                        <input type="hidden" id="wishlist_rate{{ $tour->id }}"
                                            value="Chưa có">
                                    @endif

                                    <input type="hidden" id="wishlist_image{{ $tour->id }}"
                                        src="{{ URL::to('upload/tours/' . $tour->image) }}"
                                        value="{{ asset('upload/tours/' . $tour->image) }}">
                                    <input type="hidden" id="wishlist_url{{ $tour->id }}"
                                        value="{{ route('chi-tiet-tour', ['slug' => $tour->slug]) }}">
                                </form>
                                <div class="d-flex justify-content-center mb-2">

                                    <a href="{{ route('chi-tiet-tour', ['slug' => $tour->slug]) }}"
                                        class="btn btn-sm btn-primary px-3 border-end mx-2"
                                        style="border-radius: 30px;">Chi tiết
                                    </a>
                                    <a href="#" onclick="add_compare({{ $tour->id }})"
                                        class="btn btn-sm btn-primary px-3 border-end "
                                        style="border-radius: 30px;"><i class="fa fa-plus"></i> So sánh

                                    </a>

                                    <form action="{{ route('tour.like') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="customer_id" class="customer_id"
                                            value="{{ Session::get('customer_id') }}" id="customer_id">
                                        @if (Session::get('customer_id'))
                                            <button class="favorite-button btn btn-sm ms-2"
                                                data-tour-id="{{ $tour->id }}">
                                                <i style="font-size: 18px; color: {{ $isLiked ? 'red' : 'black' }};"
                                                    class="fa fa-heart"></i>
                                            </button>
                                        @else
                                            <button class="favorite-button btn btn-sm ms-2"
                                                data-tour-id="{{ $tour->id }}">
                                                <i style="font-size: 18px" class="fa fa-heart"></i>
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Package End -->

    <!-- Process Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center pb-4 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Đặt Tour</h6>
                <h1 class="mb-5">Đặt Tour Chỉ Với 3 Bước </h1>
            </div>
            <div class="row gy-5 gx-4 justify-content-center">
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-globe fa-3x text-white" ></i>

                        </div>
                        <h5 class="mt-4">Chọn điểm đến</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Chọn điểm đến hoặc tour bạn muốn</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-dollar-sign fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Thanh toán</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Thanh toán hóa đơn đặt tour</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative border border-primary pt-5 pb-4 px-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-plane fa-3x text-white"></i>
                        </div>
                        <h5 class="mt-4">Khởi hành</h5>
                        <hr class="w-25 mx-auto bg-primary mb-1">
                        <hr class="w-50 mx-auto bg-primary mt-0">
                        <p class="mb-0">Tận hưởng kỳ nghỉ của bạn tại điểm đến</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Process Start -->
    <style>
        .owl-item .col-lg-4,
        .owl-item .col-md-6 {
            width: 100%;
            /* Chiếm toàn bộ chiều rộng của item */
            max-width: 100%;
            /* Đảm bảo không vượt quá chiều rộng */
            flex: none;
            /* Ngăn việc các phần tử này tự động điều chỉnh kích thước */
        }

        .owl-item .package-item {
            width: 100%;
            /* Chiếm toàn bộ chiều rộng */
        }

        .package-item .text-center p {
            height: 60px;
            /* Điều chỉnh chiều cao này tùy theo yêu cầu */
            overflow: hidden;
            font-size: 15px;
        }

        .owl-prev,
        .owl-next {
            background-color: #86B817 !important;
            /* Áp dụng màu nền */
            color: white !important;
            /* Màu của biểu tượng mũi tên */
            padding: 7px !important;
            /* Thêm khoảng cách bên trong nút */
        }

        .owl-prev i,
        .owl-next i {
            font-size: 20px;
            /* Điều chỉnh kích thước mũi tên */
        }
    </style>
@endsection
