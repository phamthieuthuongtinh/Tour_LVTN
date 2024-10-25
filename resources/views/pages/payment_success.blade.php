@extends('layout')

@section('content')
    <style>
        .success-card {
            border: 1px solid #d4edda;
            border-radius: 0.25rem;
            background-color: #d4edda;
            color: #155724;
        }

        .success-card-header {
            background-color: #c3e6cb;
            color: #155724;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #c3e6cb;
        }

        .success-card-body {
            padding: 1.25rem;
        }

        .success-card-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .success-card-text {
            margin-bottom: 1rem;
        }

        .success-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
        }

        .success-button:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
    </style>

    <div class="success-card">
        <div class="success-card-header">
            Thanh Toán Thành Công
        </div>
        <div class="success-card-body">
            <h4 class="success-card-title">Cảm ơn bạn đã thanh toán!</h4>
            <p class="success-card-text">Giao dịch của bạn đã được xử lý thành công. Bạn sẽ nhận được một email thông tin về đơn hàng trong ít phút tới.</p>
            <p class="success-card-text">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hỗ trợ.</p>
            <a href="/" class="success-button">Quay lại trang chủ</a>
            <a href="{{ route('customers.ordered', Session::get('customer_id')) }}" class="success-button">Xem tour đã đặt</a>
        </div>
    </div>
@endsection
