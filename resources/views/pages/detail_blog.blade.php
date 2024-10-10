@extends('layout')

@section('content')
<div class="container-xxl blog-detail">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="bg-white text-center text-primary px-3">Chi Tiết Bài Blog</h1>
        </div>
        <div class="row my-4">
            <div class="col-md-12">
                <div class="card">
                   
                    <div class="card-body">
                        <h2 class="card-title">{{ $blog->title }}</h2>
                        <p class="card-text text-muted">{{ $blog->created_at->format('d/m/Y') }}</p>
                        <div class="card-content">
                            {!! $blog->content !!}
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<style>

</style>
@endsection


