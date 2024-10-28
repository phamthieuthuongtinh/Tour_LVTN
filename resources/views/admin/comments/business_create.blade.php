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
                        @foreach ($comments_business as $key => $com)
                            <tr class="{{ $com->status == 2 ? 'deleted-com' : '' }}">
                                <td>{{ $key }}</td>
                                <td style="width: 250px;">{{ $com->tour->title }}</td>
                                <td>{{ $com->comment_name }}</td>
                                <td style="width: 500px;">{{ $com->comment_content }}
                                    <br>
                                    <p style="color: blue">Các phản hồi cũ:</p>
                                    <ul class="list_rep">
                                        @foreach ($commnent_reply_business as $key => $comm_reply)
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
                                @if($com->status==1)
                                <td>
                                    <textarea class="reply_comment_{{ $com->comment_id }}" placeholder="Nội dung phản hồi" rows="3" cols="30"></textarea>
                                    <div style="display: flex; gap: 10px; margin-top: 5px;">
                                        <button class="btn btn-info btn-sm btn-reply-comment"
                                        data-comment_id="{{ $com->comment_id }}"
                                        data-tour_id="{{ $com->comment_tour_id }}"
                                        style="text-align:left;display: block; width: fit-content; margin-top: 5px;">Phản
                                        hồi</button>
                                        <button class="btn btn-danger btn-sm btn-request-destroy-comment"
                                        data-comment_id="{{ $com->comment_id }}"
                                        data-tour_id="{{ $com->comment_tour_id }}"
                                        style="text-align:left;display: block; width: fit-content; margin-top: 5px;">Yêu cầu xóa</button>
                                    </div>
                                    
                                </td>
                                @else
                                <td>
                                    <form method="POST" action="{{ route('comment.huyyeucau', [$com->comment_id]) }}">
                                        @method('PATCH')
                                        @csrf
                                        <button type="submit" class="btn btn-warning" title="Hủy gửi">
                                            <i class="fas fa-undo"></i> <!-- Biểu tượng "Undo" -->
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal nhập lý do -->
        <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reasonModalLabel">Nhập lý do yêu cầu xóa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" id="deleteReason" placeholder="Nhập lý do..." rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-danger" id="submitDeleteRequest">Gửi yêu cầu</button>
                    </div>
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
