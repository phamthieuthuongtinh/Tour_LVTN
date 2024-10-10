@extends('layout')
@section('content')
<div class="container-xxl py-5">
   <div class="container">
       <div class="row g-5">
           <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="bg-white text-center text-primary px-3">Liên hệ</h1>
            </div>
               <h3 class="mb-4">Liên Hệ Trực Tiếp Với <span class="text-primary">Chúng Tôi</span></h3>
               <p class="mb-4">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn trong mọi vấn đề liên quan đến chuyến đi. Hãy liên hệ với chúng tôi để được tư vấn và giải đáp nhanh chóng.</p>
               <div class="d-flex align-items-center mb-4">
                   <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                       <i class="fa fa-map-marker-alt text-white"></i>
                   </div>
                   <div class="ms-3">
                       <p class="mb-2">Địa chỉ</p>
                       <h5 class="mb-0">3/2, Cần Thơ University, Cần Thơ</h5>
                   </div>
               </div>
               <div class="d-flex align-items-center mb-4">
                   <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                       <i class="fa fa-phone-alt text-white"></i>
                   </div>
                   <div class="ms-3">
                       <p class="mb-2">Số điện thoại</p>
                       <h5 class="mb-0">(+84) 123 456 789</h5>
                   </div>
               </div>
               <div class="d-flex align-items-center">
                   <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                       <i class="fa fa-envelope-open text-white"></i>
                   </div>
                   <div class="ms-3">
                       <p class="mb-2">Email</p>
                       <h5 class="mb-0">info@dulichviet.com</h5>
                   </div>
               </div>
           </div>
           <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
               <form action="{{route('contacts.store')}}" method="POST">
                    @csrf
                   <div class="row g-3">
                       <div class="col-md-6">
                           <div class="form-floating">
                               <input type="text" class="form-control" id="name" placeholder="Tên của bạn" name="name">
                               <label for="name">Tên của bạn</label>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-floating">
                               <input type="email" class="form-control" id="email" name="email" placeholder="Email của bạn">
                               <label for="email">Email của bạn</label>
                           </div>
                       </div>
                       <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Tiêu đề">
                            <label for="phone">Số điện thoại</label>
                        </div>
                    </div>
                       <div class="col-12">
                           <div class="form-floating">
                               <input type="text" class="form-control" name="title" id="title" placeholder="Tiêu đề">
                               <label for="title">Tiêu đề</label>
                           </div>
                       </div>
                       <div class="col-12">
                           <div class="form-floating">
                               <textarea class="form-control" placeholder="Nội dung" name="content" id="content" style="height: 150px"></textarea>
                               <label for="content">Nội dung</label>
                           </div>
                       </div>
                       <div class="col-12">
                           <button class="btn btn-primary py-3 px-5" type="submit">Gửi</button>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div>
@endsection
