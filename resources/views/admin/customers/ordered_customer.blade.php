@extends('layout')

@section('content')
<div class="container">
    <h2 class="my-4">Các tour bạn đã đặt</h2>
    @if($orderdetails->isEmpty())
        <p>Bạn chưa đặt tour nào.</p>
    @else
        <div class="table-responsive">
            @foreach ($orderdetails as $order)
            <table class="table table-bordered" style="border-color: #86B817;">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên Tour</th>
                        <th>Thời gian</th>
                        <th>Địa điểm xuất phát</th>
                        <th>Số lượng</th>
                        <th>Tổng Giá</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                   
                        <tr>
                            <td><img style="width:100px; height:67px;" src="{{ asset('upload/tours/' . $order->tour->image) }}" alt=""></td>
                            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                               <a href="{{route('chi-tiet-tour', ['slug' => $order->tour->slug])}}">{{ $order->tour->title }}</a> 
                            </td>
                            <td>
                               
                                
                                <span class="current-departure-date-{{ $order->order_code }}">
                                    {{ $order->departure_date }}
                                    @if($order->departure_date>$now && $order->order->order_status!=4)
                                    <button class="btn btn-link btn-edit-date" data-id="{{ $order->order_code }}"> <!-- Sử dụng 'data-id' -->
                                        <i class="fa fa-retweet" title="Đổi ngày"></i>
                                    </button>
                                    @endif
                                </span>
                                
                                <!-- Dropdown chọn ngày -->
                                
                                <select class="form-control select-departure-date " data-id="{{ $order->order_code}}" style="display: none;">
                                    <option value="" disabled selected>Chọn ngày khởi hành</option> <!-- Tùy chọn rỗng -->
                                    @foreach($order->departure as $date)
                                        <option value="{{ $date->departure_date }}">{{ $date->departure_date }}</option>
                                    @endforeach
                                </select>

                            </td>

                            
                            <td>{{ $order->tour->tour_from }}</td>
                            
                            <td style="max-width: 200px;">
                                @if($order->sale==0)
                                    @if( $order->nguoi_lon>0)
                                        Người lớn: {{ $order->nguoi_lon }} x {{ number_format($order->tour->price)}}đ
                                    @endif
                                    @if( $order->tre_em>0)
                                    <br>Trẻ em: {{ $order->tre_em }} x {{ number_format($order->tour->price_treem)}}đ
                                    @endif
                                    @if( $order->tre_nho>0)
                                    <br>Trẻ nhỏ: {{ $order->tre_nho }} x {{ number_format($order->tour->price_trenho)}}đ
                                    @endif
                                    @if( $order->so_sinh>0)
                                    <br>Sơ sinh: {{ $order->so_sinh }} x {{ number_format($order->tour->price_sosinh)}}đ
                                    @endif
                                @else
                                    @if( $order->nguoi_lon>0)
                                        Người lớn: {{$order->nguoi_lon}} x  {{number_format($order->tour->price*(100-$order->sale)/100)}}đ 
                                    @endif
                                    @if( $order->tre_em>0)
                                    <br>Trẻ em: {{ $order->tre_em }} x {{number_format($order->tour->price_treem*(100-$order->sale)/100)}}đ
                                    @endif
                                    @if( $order->tre_nho>0)
                                    <br>Trẻ nhỏ: {{ $order->tre_nho }} x {{number_format($order->tour->price_trenho*(100-$order->sale)/100)}}đ
                                    @endif
                                    @if( $order->so_sinh>0)
                                    <br>Sơ sinh: {{ $order->so_sinh }} x {{number_format($order->tour->price_sosinh*(100-$order->sale)/100)}}đ
                                    @endif
                                @endif
                               
                               
                               
                            </td>
                            <td>
                                @if($order->sale)
                                 Sale: {{$order->sale}}% <br>
                                @endif
                                @if($order->voucher)
                                voucher:
                                    @if ($order->coupon->voucher_condition==0)
                                    {{$order->coupon->voucher_number}}%
                                    @else
                                    {{number_format($order->coupon->voucher_number)}}đ<br>
                                    @endif
                                @endif
                                Thành tiền:
                                @php
                                // Tính tổng giá trị trước khi áp dụng voucher
                                    $total = $order->nguoi_lon * $order->tour->price 
                                            + $order->tre_em * $order->tour->price_treem
                                            + $order->tre_nho * $order->tour->price_trenho
                                            + $order->so_sinh * $order->tour->price_sosinh;
                                    if ($order->sale!=0) {
                                        $total= $total*(100-$order->sale)/100;
                                    }
                                    // Áp dụng voucher
                                    $discountAmount = 0;
                                    if ($order->voucher) {
                                        if ($order->coupon->voucher_condition == 0) {
                                            // Giảm giá theo phần trăm
                                            $discountAmount = $total * $order->coupon->voucher_number / 100;
                                        } else if ($order->coupon->voucher_condition == 1) {
                                            // Giảm giá theo số tiền cụ thể
                                            $discountAmount = $order->coupon->voucher_number;
                                        }
                                    }
                            
                                    // Tổng giá sau giảm giá
                                    $finalTotal = $total - $discountAmount;
                            
                                    echo number_format($finalTotal);
                                @endphp
                                 đ
                            </td>
                            <td style="max-width: 100px;">{{ $order->order->payment_method}}</td>
                            <td>
                                @if($order->order->order_status==2)
                                 Đã thanh toán
                                @elseif($order->order->order_status==1)
                                 Chưa thanh toán
                                @elseif($order->order->order_status==3)
                                Đang xử lý hoàn tiền
                                @else
                                Đã hoàn tiền
                                @endif
                                
                            </td>
                            <td>
                                @if($order->order->order_status==1 && $order->departure_date>$now)
                                    <form method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy tour này?');" action="{{route('orders.destroy',[$order->order->order_id])}}">
                                        @method('DELETE')
                                        @csrf
                                    <input type="submit" class="btn btn-danger" value="Hủy">
                                    </form>
                                @elseif($order->order->order_status==2 && $order->departure_date>$now)
                                    <form method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy tour này? Chúng tôi sẽ liên hệ qua Email để hoàn trả phần tiền đã thanh toán trong vòng 7 ngày!');" action="{{route('orders.destroy_has_paid',[$order->order->order_id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-danger" value="Hủy">
                                    </form>
                                 @else
                                    <input type="submit" class="btn btn-default" value="Hủy" style="background-color: #d3d3d3; cursor: not-allowed;" disabled>
                                @endif
                            </td>
                        </tr>
                        {{-- Danh sách thành viên --}}
                        <tr>
                            <td colspan="9" class="text-center" style="">
                                <p style="color: #FF5733;font-size:20px;"><b>Danh sách thành viên</b></p>
                               
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Loại </th>
                                            <th>Tên</th>
                                           
                                            <th>CCCD</th>
                                            
                                            <th>Số điện thoại</th>
                                            <th>Ghi chú</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Người lớn (Người đặt tour)</td>
                                            <td>{{$customer->customer_name}}</td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$order->note}}</td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        @foreach($order->members as $key=> $member)
                                            <tr>
                                                <td>{{$key+2}}</td>
                                                <td>
                                                    @if($member->loai==1)
                                                        Người lớn
                                                    @elseif ($member->loai==2)
                                                        Trẻ em
                                                    @elseif ($member->loai==3)
                                                        Trẻ nhỏ
                                                    @else
                                                        Sơ sinh
                                                    @endif
                                                </td>
                                                <td>{{$member->name}}</td>
                                                <td>{{$member->cccd}}</td>
                                                <td>{{$member->phone}}</td>
                                                <td>{{$member->note}}</td>
                                               
                                            </tr>
                                        
                                       @endforeach
                                    </tbody>
                                </table>
                                
                            </td>
                            
                        </tr>
                        
                        <br>
                  
                </tbody>
            </table>
            @endforeach
        </div>
    @endif
</div>

@endsection
