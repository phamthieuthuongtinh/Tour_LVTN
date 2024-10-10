@extends('layout')
@section('content')
<div class="container-xxl  destination">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="bg-white text-center text-primary px-3">Đăng nhập tài khoản</h1>
        </div>
        <div class="row g-5 justify-content-center">
            <div class="col-lg-5">
                <div>
                    <form action="{{route('customers.login')}}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                <h5 class="section-title bg-white text-center text-primary px-3">Đăng nhập</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu">
                                    <label for="password">Mật khẩu</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Đăng nhập</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-3"style="text-align: right;">
                     <a  href="{{route('register_customer')}}"><i class="fas fa-user-plus"></i> Bạn chưa có tài khoản?</a>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection
