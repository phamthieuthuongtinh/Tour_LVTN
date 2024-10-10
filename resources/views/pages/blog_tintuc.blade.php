@extends('layout')

@section('content')
    <div class="container-xxl py-4">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="bg-white text-center text-primary px-3">Tin tức du lịch</h1>
            </div>
            <div class="container mt-4">
                <h1 class="my-4">Danh sách bài blog</h1>

                @foreach ($blogs as $blog)
                    <div class="card blog-card">
                        <div class="row">
                            @if ($blog->image)
                                <div class="col-md-4">
                                    <img  src="{{ asset('upload/blogs/' . $blog->image) }}" class="img-fluid rounded-start"
                                        alt="{{ $blog->title }}">
                                </div>
                            @endif
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">{{ $blog->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <p class="card-text">{{ $blog->description }}</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('chitiet', $blog->id) }}" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Phân trang -->
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-4px);
        }

        .card-footer {
            background: #f8f9fa ;
            border-top: 1px solid #ddd;
            padding: 12px;
            position: relative;
            display: flex;
            justify-content: flex-end;
            /* Đưa nút về phía bên phải */
        }

        .card-footer .btn-primary {
            font-size: 1rem;
            /* Kích thước chữ của nút */
            padding: 8px 16px;
            /* Padding để nút không bị quá rộng hoặc quá hẹp */
            border-radius: 4px;
            /* Bo góc của nút */
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .card-footer .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .card-body .mb-2 {
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

     

        .img-fluid {
            max-width: 100%;
            height: auto;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        @media (max-width: 767.98px) {
            .card-footer .btn-primary {
                position: static;
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection
