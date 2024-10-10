@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tất Cả Comment Chưa Duyệt</h3>
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
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card">
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
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tour</th>
                            <th>Tên</th>
                            <th>Nội dung</th>
                            <th>Ngày đánh giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <style>
                        .deleted-com {
                            background-color: #4d4d4d !important;
                        }
                    </style>
                    <tbody>
                        @foreach ($comments as $key => $com)
                            <tr class="{{ $com->status == 2 ? 'deleted-com' : '' }}">
                                <td>{{ $key }}</td>
                                <td style="width: 250px;">{{ $com->tour->title }}</td>
                                <td>{{ $com->comment_name }}</td>
                                <td style="width: 500px;">{{ $com->comment_content }}
                                    <br>
                                    <p style="color: blue">Các phản hồi cũ:</p>
                                    <ul class="list_rep">
                                        @foreach ($comment_reply as $key => $comm_reply)
                                            @if ($comm_reply->comment_parent_comment == $com->comment_id && $comm_reply->status != 2)
                                                <li>
                                                    <div class="btn-group">
                                                        <p style="display: inline; margin-right: 10px;">
                                                            {{ $comm_reply->comment_content }}</p>
                                                        <form method="POST"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa?');"
                                                            action="{{ route('comment.destroy', [$comm_reply->comment_id]) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button style="font-size: 3px;" type="submit"
                                                                class="btn btn-danger" title="Xóa">
                                                                <i style="font-size: 8px;" class="fas fa-times"></i>
                                                                <!-- Biểu tượng "Times" -->
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>

                                <td style="width: 200px;">{{ $com->created_at }}</td>
                                <td>
                                    <textarea class="reply_comment_{{ $com->comment_id }}" placeholder="Nội dung phản hồi" rows="3" cols="30"></textarea>
                                    <button class="btn btn-info btn-sm btn-reply-comment"
                                        data-comment_id="{{ $com->comment_id }}"
                                        data-tour_id="{{ $com->comment_tour_id }}"
                                        style="text-align:left;display: block; width: fit-content; margin-top: 5px;">Phản
                                        hồi</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        .btn-group {
            display: flex;

            gap: 10px;
            /* Khoảng cách giữa các nút */
        }
    </style>
@endsection
