@extends('layout')
@section('content')
    <div class="container box-list-tour">
        <div class="row">
            <div class="col-md-12 col-xs-12 bx-title-lst-tour text-center">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="bg-white text-center text-primary px-3">Các tour đã thích</h1>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($tours as $key => $tour)
                    <div class="col-lg-4 col-md-6 fadeInUp" data-wow-delay="0.1s">
                        <div class="package-item">
                            <div class="overflow-hidden">
                                <img style="width:456px; height:260px;" class="img-fluid"
                                    src="{{ asset('upload/tours/' . $tour->image) }}" alt="">
                            </div>
                             <div class="d-flex border-bottom flex-wrap">
                                <small class="flex-fill text-center border-end border-bottom py-2"><i class="fa fa-mountain text-primary me-2"></i>{{ $tour->type->type_name }}</small>
                                <small class="flex-fill text-center border-end border-bottom py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $tour->so_ngay }} Ngày - {{ $tour->so_ngay }}</small>
                                
                                <small class="flex-fill text-center border-end border-bottom py-2 w-100"><i class="fa fa-plane text-primary me-2"></i>{{ $tour->tour_from }}</small>
                            </div>
                         
                            <div class="text-center p-4">
                                @php
                                // Mặc định là giá ban đầu
                                    $hasDiscount = false; 
                                    $discountedPrice = $tour->price; 

                                    // Kiểm tra và tính giá giảm nếu có
                                    foreach ($tour_sales as $dis) {
                                        if ($tour->id == $dis->tour_id) {
                                            $discountedPrice = ($tour->price * (100 - $dis->rate)) / 100; // Tính giá sau giảm
                                            $hasDiscount = true; // Đánh dấu là có giảm giá
                                            break;
                                        }
                                    }
                                @endphp

                                <h6>Giá từ: @if($hasDiscount) <del class="text-muted">{{ number_format($tour->price) }} đ</del> @endif</h6>
                                <h4 class="mb-0">{{ number_format($discountedPrice) }} đ</h4>



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
                                    @if($hasDiscount) 
                                    <input type="hidden" id="wishlist_sale{{ $tour->id }}"
                                        value="{{ number_format($discountedPrice) }}đ">
                                    @else
                                    <input type="hidden" id="wishlist_sale{{ $tour->id }}"
                                        value="0">
                                    @endif
                                  

                                    <input type="hidden" id="wishlist_tourfrom{{ $tour->id }}"
                                        value="{{$tour->tour_from}} ">
                                    <input type="hidden" id="wishlist_songay{{ $tour->id }}"
                                        value="{{$tour->so_ngay}}N-">
                                    <input type="hidden" id="wishlist_sodem{{ $tour->id }}"
                                        value="{{$tour->so_dem}}Đ">
                                    <input type="hidden" id="wishlist_vehicle{{ $tour->id }}"
                                        value="{{$tour->vehicle }}">
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

    </div>
    <style>
        #favorite-button {
            border: none;
            background: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        #favorite-button i {
            color: #535152;
            /* Màu mặc định của trái tim */
        }

        #favorite-button:hover i {
            color: #ff6f61;
            /* Màu khi hover */
        }

        .heart-favorited {
            color: red;
            /* Màu đỏ cho trái tim khi đã yêu thích */
        }

        .package-item .text-center p {
            height: 50px;
            /* Điều chỉnh chiều cao này tùy theo yêu cầu */
            overflow: hidden;
            font-size: 15px;
        }

        .text-bray {
            color: #e4e5e9;
            /* Màu xám cho sao không được đánh giá */
        }
        
    </style>
@endsection
