@extends('layout')
@section('content')
<div class="container-xxl destination">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="bg-white text-center text-primary px-3">Thông Tin Cá Nhân</h1>
        </div>
        
        <!-- Personal Information Section -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin cá nhân</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Họ tên:</strong> {{ $customer->customer_name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $customer->email }}</li>
                            <li class="list-group-item"><strong>Số điện thoại:</strong> {{ $customer->phone }}</li>
                            <li class="list-group-item"><strong>Tuổi:</strong> {{ $customer->age }}</li>
                            <li class="list-group-item"><strong>Nghề nghiệp:</strong> {{ $customer->job }}</li>
                            <li class="list-group-item"><strong>Sở thích:</strong> {{ $customer->hobby }}</li>
                            <li class="list-group-item"><strong>Ngày tạo tài khoản:</strong> {{ $customer->created_at->format('d/m/Y') }}</li>
                        </ul>
                        <!-- Buttons for Edit and Change Password -->
                        <div class="mt-4">
                            <a href="" class="btn btn-primary">Sửa thông tin</a>
                            <a href="" class="btn btn-secondary">Đổi mật khẩu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
