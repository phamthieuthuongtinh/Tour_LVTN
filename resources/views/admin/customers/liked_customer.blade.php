@extends('layout')
@section('content')
    <div class="container box-list-tour">
        <div class="row">
            <div class="col-md-12 col-xs-12 bx-title-lst-tour text-center">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="bg-white text-center text-primary px-3">Các tour đã thích</h1>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($likes as $key => $tour)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="package-item">
                                <div class="overflow-hidden">
                                    <img style="width:456px; height:300px;" class="img-fluid"
                                        src="{{ asset('upload/tours/' . $tour->tour->image) }}" alt="">
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-6 text-center border-end py-2">
                                        <small><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $tour->tour->category->title }}</small>
                                    </div>
                                    <div class="col-6 text-center py-2">
                                        <small><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $tour->tour->type->type_name }}</small>
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-6 text-center border-end py-2">
                                        <small><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $tour->tour->vehicle }}</small>
                                    </div>
                                    <div class="col-6 text-center py-2">
                                        <small><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $tour->tour->so_ngay }}Ngày - {{ $tour->tour->so_ngay }}Đêm</small>
                                    </div>
                                </div>  
                                <div class="d-flex border-bottom">
                                    <small class="flex-fill text-center border-end py-2"><i
                                            class="fa fa-plane text-primary me-2"></i>
                                        {{ $tour->tour->tour_from }}</small>

                                </div>
                                <div class="text-center p-4">
                                    <h3 class="mb-0">{{ number_format($tour->tour->price) }} đ</h3>
                                    <div class="mb-3">
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                    </div>
                                    <p>{{mb_substr($tour->tour->title, 0, 60).'...'}}</p>
                                    @php
                                        if (Session::get('customer_id')) {
                                            $isLiked = $likes->contains('tour_id', $tour->tour->id);
                                        }

                                    @endphp
                                    <div class="d-flex justify-content-center mb-2">
                                        <a href="{{ route('chi-tiet-tour', ['slug' => $tour->tour->slug]) }}"
                                            class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px;">Chi
                                            tiết</a>

                                        <form action="{{ route('tour.like') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="customer_id" class="customer_id"
                                                value="{{ Session::get('customer_id') }}" id="customer_id">

                                            @if (Session::get('customer_id'))
                                                <button class="favorite-button btn btn-sm ms-2"
                                                    data-tour-id="{{ $tour->tour->id }}">
                                                    <i style="font-size: 18px; color: {{ $isLiked ? 'red' : 'black' }};"
                                                        class="fa fa-heart"></i>
                                                </button>
                                            @else
                                                <button class="favorite-button btn btn-sm ms-2"
                                                    data-tour-id="{{ $tour->tour->id }}">
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
@endsection
