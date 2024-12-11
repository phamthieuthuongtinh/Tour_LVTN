@extends('layout')
@section('content')
<div class="container-xxl destination">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="bg-white text-center text-primary px-3">Sửa Thông Tin Cá Nhân</h1>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('customers.update',[$customer->customer_id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="customer_name">Họ tên</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $customer->customer_name }}" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $customer->phone }}" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="age">Tuổi</label>
                                <input type="number" class="form-control" id="age" name="age" value="{{ $customer->age }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="job">Nghề nghiệp</label>
                                <input type="text" class="form-control" id="job" name="job" value="{{ $customer->job }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="hobby">Sở thích</label>
                                <input type="text" class="form-control" id="hobby" name="hobby" value="{{ $customer->hobby }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                            <a href="{{ route('customers.infor',[$customer->customer_id]) }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
