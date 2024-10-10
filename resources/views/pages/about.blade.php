@extends('layout')
@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('frontend/img/about.jpg') }}"
                            alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h1 class="bg-white text-center text-primary px-3">Về chúng tôi</h1>
                    </div>
                    <h2 class="mb-4">Chào Mừng Bạn Đến Với <span class="text-primary">Du Lịch Việt</span></h2>
                    <p class="mb-4">Chúng tôi tự hào là một trong những đơn vị hàng đầu trong lĩnh vực du lịch tại Việt
                        Nam. Với kinh nghiệm nhiều năm trong việc tổ chức các tour du lịch trong và ngoài nước, chúng tôi
                        cam kết mang đến cho bạn những trải nghiệm du lịch tuyệt vời nhất.</p>
                    <p class="mb-4">Tại Du Lịch Việt, mỗi chuyến đi không chỉ là một hành trình khám phá, mà còn là một cơ
                        hội để bạn tận hưởng những giây phút thư giãn và khám phá nét đẹp văn hóa, con người Việt Nam và thế
                        giới.</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Chuyến bay hạng sang</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Khách sạn chọn lọc</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Lưu trú 5 sao</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Phương tiện hiện đại</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>150+ Tour cao cấp</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Dịch vụ 24/7</p>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">Xem Thêm</a>
                </div>
            </div>
        </div>
    </div>
@endsection
