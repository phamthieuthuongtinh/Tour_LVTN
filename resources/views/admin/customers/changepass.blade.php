@extends('layout')
@section('content')
<div class="container-xxl destination">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="bg-white text-center text-primary px-3">Đổi Mật Khẩu</h1>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('customers.changePassword',[$customer->customer_id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="current_password">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_password">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập Nhật Mật Khẩu</button>
                            <a href="{{ route('customers.infor',[$customer->customer_id]) }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
