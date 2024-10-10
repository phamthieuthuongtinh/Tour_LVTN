@extends('layout')
@section('content')
<div class="container box-list-tour">
    <div class="row">
        <div class="col-md-12 col-xs-12 bx-title-lst-tour text-center">
            <div class="w100 fl title-tour1 wow fadeInUp">
                <h1 style="color: #86B817;font-size: 30px;"> Kết quả tìm kiếm </h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($tours as $key => $tour)
                    @if ($tour->departures->isNotEmpty())
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="package-item">
                                <div class="overflow-hidden">
                                    <img style="width:456px; height:280px;" class="img-fluid"
                                        src="{{ asset('upload/tours/' . $tour->image) }}" alt="">
                                </div>
                                <div class="d-flex border-bottom">
                                    <small class="flex-fill text-center border-end py-2"><i
                                            class="fa fa-map-marker-alt text-primary me-2"></i>{{ $tour->category->title }}</small>
                                    <small class="flex-fill text-center border-end py-2"><i
                                            class="fa fa-calendar-alt text-primary me-2"></i>{{ $tour->tour_time }}</small>
                                    <small class="flex-fill text-center py-2"><i
                                            class="fa fa-users text-primary me-2"></i>{{ $tour->quantity }}</small>
                                </div>
                                <div class="d-flex border-bottom">
                                    <small class="flex-fill text-center border-end py-2"><i
                                            class="fa fa-plane text-primary me-2"></i>Địa điểm xuất phát:
                                        {{ $tour->tour_from }}</small>
                                </div>
                                <div class="text-center p-4">
                                    <h3 class="mb-0">{{ number_format($tour->price) }} đ</h3>
                                    <div class="mb-3">
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                    </div>
                                    <p>{{ $tour->title }}</p>
                                    @php
                                        if(Session::get('customer_id')){
                                            $isLiked = $likes->contains('tour_id', $tour->id);
                                        }
                                    @endphp
                                    <div class="d-flex justify-content-center mb-2">
                                        <a href="{{ route('chi-tiet-tour', ['slug' => $tour->slug]) }}"
                                            class="btn btn-sm btn-primary px-3 border-end"
                                            style="border-radius: 30px;">Chi tiết</a>
                                        <form action="{{ route('tour.like') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="customer_id" class="customer_id" value="{{ Session::get('customer_id') }}" id="customer_id">
                                            @if (Session::get('customer_id'))
                                                <button class="favorite-button btn btn-sm ms-2" data-tour-id="{{ $tour->id }}">
                                                    <i style="font-size: 18px; color: {{ $isLiked ? 'red' : 'black' }};" class="fa fa-heart"></i>
                                                </button>
                                            @else
                                                <button  class="favorite-button btn btn-sm ms-2" data-tour-id="{{ $tour->id }}">
                                                    <i style="font-size: 18px" class="fa fa-heart"></i>
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- Hiển thị liên kết phân trang -->
           
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
        color: #535152; /* Màu mặc định của trái tim */
    }

    #favorite-button:hover i {
        color: #ff6f61; /* Màu khi hover */
    }
    .heart-favorited {
        color: red; /* Màu đỏ cho trái tim khi đã yêu thích */
    }
    
    .package-item .text-center p {
        height: 60px; /* Điều chỉnh chiều cao này tùy theo yêu cầu */
        overflow: hidden;
        font-size: 15px;
    }
</style>
@endsection
