@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Chi tiết</h3>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="">
            <div class="card-header border-0">
                <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Thông tin người gửi và ngày gửi cùng một hàng -->
                <div class="row mb-2">
                    <div class="col">
                        <p><strong>Người gửi:</strong> {{ $contact->name }}</p>
                    </div>
                    <div class="col text-right">
                        <p><strong>Ngày gửi:</strong> {{ $contact->created_at }}</p>
                    </div>
                </div>

                <!-- Chủ đề của email -->
                <div class="row mb-2">
                    <div class="col">
                        <p><strong>Chủ đề:</strong> {{ $contact->title }}</p>
                    </div>
                </div>

                <!-- Nội dung của email -->
                <div class="row mb-2">
                    <div class="col">
                        <h5><strong>Nội dung:</strong></h5>
                        <div class="content">
                            {!! nl2br(e($contact->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-2">
                <a href="" class="btn btn-primary" title="Trả lời">
                    <i class="fas fa-reply"></i> 
                </a>
                <a href="" class="btn btn-secondary" title="Chuyển tiếp">
                    <i class="fas fa-share"></i> 
                </a>
                <form action="{{route('contacts.destroy',[$contact->id])}}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');" class="btn btn-danger" title="Xóa">
                        <i class="fas fa-trash"></i> 
                    </button>
                </form>
            </div>
        </div>
    </div>
    
@endsection
