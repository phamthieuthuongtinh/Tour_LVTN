<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Departure;
use App\Models\Orderdetail;
use App\Models\Voucher;
use App\Models\Member;
use App\Models\Statistical;
use App\Models\Statisticalbusinesses;
use App\Models\Tour;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders=Order::with('customer')->where('order_status','>',0)->where('order_status','<',3)->Orderby('order_status','ASC')->get();   
        return view('admin.orders.index',compact('orders'));
    }
    public function business_index()
    {
        $orders_all=Order::with('customer')->where('order_status','>',0)->where('order_status','<',3)->Orderby('order_status','ASC')->get();

        $orderCodes = $orders_all->pluck('order_code')->toArray();
        $tourIds = OrderDetail::whereIn('order_code', $orderCodes)->pluck('tour_id')->toArray();
        $businessTourIds = Tour::whereIn('id', $tourIds)->where('business_id', Auth::user()->id)->pluck('id')->toArray();
        $orders = $orders_all->filter(function($order) use ($businessTourIds) {
            return OrderDetail::where('order_code', $order->order_code)
                ->whereIn('tour_id', $businessTourIds)
                ->exists();
        });
        $orders = $orders->values();
        return view('admin.orders.business_index',compact('orders'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $voucher= 'no';
        $order=Order::where('order_id',$id)->first();
        $members=Member::where('order_code',$order->order_code)->where('status',1)->get();
        $orderdetails=Orderdetail::where('order_code',$order->order_code)->with('tour')->first();
        $tour=Tour::where('id',$orderdetails->tour_id)->first();
        if($orderdetails->voucher){
            $voucher=Voucher::where('voucher_code',$orderdetails->voucher)->first();
        }
        $customer=Customer::where('customer_id',$order->customer_id)->first();
        return view('admin.orders.show', compact('orderdetails','order','customer','voucher','tour','members'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order=Order::find($id);

        $order->order_status=0;
        $members=Member::where('order_code',$order->order_code)->get();
        if($members!=null){
            foreach($members as $mem){
                $mem->status=0;
                $mem->save();
            }
        }
        $order->save();
        
        toastr()->success('Xóa đơn thành công!');
        return redirect()->back();
    }
    public function destroy_has_paid(string $id)
    {
        $order=Order::find($id);

        $order->order_status=3;
        $members=Member::where('order_code',$order->order_code)->get();
        if($members!=null){
            foreach($members as $mem){
                $mem->status=0;
                $mem->save();
            }
        }
        $order->save();
        // Cập nhật lại số lượng và lợi nhuận
        $order_detail = Orderdetail::where('order_code',$order->order_code)->first();
        $departure = Departure::where('tour_id',$order_detail->tour_id)->where('departure_date',$order_detail->departure_date)->first();
        $tour = Tour::where('id',$order_detail->tour_id)->first();
        //tìm bên bảng lợi nhuận chung
        $statistic = Statistical::where('order_date', $order->order_date)->get();
        if ($statistic) {
            $statistic_count = $statistic->count();
        } else {
            $statistic_count = 0;
        }
        //tìm bên bảng lợi nhuận của doanh nghiệm dành cho trang admin của doanh nghiệp vì chỉ doanh nghiệp mới xác nhận thanh toán
        $business_id= $tour->business_id;
        $statistic_business = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id',$business_id)->get();
        
        if ($statistic_business) {
            $statistic_businessc_count = $statistic_business->count();
        } else {
            $statistic_businessc_count = 0;
        }
        // Tính giá
        $price_adult = $tour->price;
        $price_child = $tour->price_treem;
        $price_infant = $tour->price_trenho;
        $price_newborn = $tour->price_sosinh;
        $voucher = null;
        if($order_detail->voucher !== null){
            $voucher=Voucher::where('voucher_code',$order_detail->voucher)->first();
        }
            //cập nhật số lượng người
        $update_quantity= $order_detail->nguoi_lon + $order_detail->tre_em + $order_detail->tre_nho + $order_detail->so_sinh;
        $departure->quantity= $departure->quantity +$update_quantity;
        $departure->save();
        $total_order = 0;
        $sales = 0;
        $profit = 0;
         
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

           //tính toán lợi nhuận
        $total_order +=1;

           // Tính doanh thu từ từng loại khách hàng
        $revenue_adult = $order_detail->nguoi_lon * $price_adult;
        $revenue_child = $order_detail->tre_em * $price_child;
        $revenue_infant = $order_detail->tre_nho * $price_infant;
        $revenue_newborn = $order_detail->so_sinh * $price_newborn;
        $sales= $revenue_adult + $revenue_child + $revenue_infant + $revenue_newborn;
        if($voucher){
            if($voucher->voucher_condition==1){
                $sales=$sales-$voucher->voucher_number;
            }
            else{
                $sales=$sales-($sales*$voucher->voucher_number/100);
            }
        }

        //Tính chi phí
        $desired_profit_margin = 0.30; // 30% lợi nhuận
        $total_cost = $sales - ($sales * $desired_profit_margin);
        //Tính lợi nhuận
        $profit = $sales - $total_cost;
        //Lưu lợi nhuận
        if ($statistic_count > 0) {
            $statistic_update = Statistical::where('order_date', $order->order_date)->first();
            $statistic_update->sales = $statistic_update->sales - $sales;
            $statistic_update->profit = $statistic_update->profit - $profit;
            $statistic_update->quantity = $statistic_update->quantity - $update_quantity;
            $statistic_update->total_order = $statistic_update->total_order - $total_order;
            $statistic_update->save();

            if ($statistic_update->sales == 0) {
                 $statistic_update->delete();
            }
        }

           //Lưu lợi nhuận cho doanh nghiệp
        if ($statistic_businessc_count > 0) {
            $statistic_business_update = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id',$tour->business_id)->first();
            $statistic_business_update->sales = $statistic_business_update->sales - $sales;
            $statistic_business_update->profit = $statistic_business_update->profit - $profit;
            $statistic_business_update->quantity = $statistic_business_update->quantity - $update_quantity;
            $statistic_business_update->total_order = $statistic_business_update->total_order - $total_order;
            $statistic_business_update->save();

            if ($statistic_business_update->sales == 0) {
                $statistic_business_update->delete();
            }
        }
    
        toastr()->success('Xóa đơn thành công!');
        return redirect()->back();
    }
    public function confirm_order(Request $request)
    {
        $customer_id = Session::get('customer_id');
        // $customer = Customer::where('customer_id', $customer_id)->get();
        $data = $request->all();
        $checkout_code = substr(md5(microtime()), rand(0, 26), 5);
        

        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->order_date = $order_date;
        $order->payment_method = $data['payment_method'];
        $order->save();
       
        


        $order_details = new Orderdetail();
        
        $order_details->order_code = $checkout_code;
        $order_details->note = $data['note'];
        $order_details->tour_id = $data['tour_id'];
        $order_details->voucher = $data['voucher'];
        $order_details->nguoi_lon = $data['nguoi_lon'];
        $order_details->tre_em = $data['tre_em'];
        $order_details->tre_nho = $data['tre_nho'];
        $order_details->so_sinh = $data['so_sinh'];
        $order_details->departure_date=$data['departure_date'];
        $order_details->sale=$data['sale'];
        $order_details->save();

        //Lưu thhông tin thành viên
        $adultMembers = $request->input('adult_members');
       
        $childMembers = $request->input('child_members');
        $toddlerMembers = $request->input('toddler_members');
        $infantMembers = $request->input('infant_members'); 
       
        $departure_id=Departure::where('tour_id',$data['tour_id'])->where('departure_date',$data['departure_date'])->first();
        if($data['payment_method']=='COD'|| $data['payment_method']=='BANK'){
            $update_quantity= $data['nguoi_lon'] + $data['tre_em'] + $data['tre_nho'] + $data['so_sinh'];
            $departure_id->quantity= $departure_id->quantity -$update_quantity;
            $departure_id->save();
        }
        if (!empty($adultMembers)) {
            foreach ($adultMembers as $adult) {
               $member= new Member();
               $member->departure_id=$departure_id->id;
               $member->order_code=$checkout_code;
               $member->tour_id=$data['tour_id'];
               $member->name=$adult['name'];
               $member->cccd=$adult['cccd'];
               $member->phone=$adult['phone'];
               $member->note=$adult['note'];
               $member->loai=1;
               $member->status=1;
               $member->save();
            }
        }
       
        // Lưu thông tin trẻ em vào cơ sở dữ liệu
        if (!empty($childMembers)) {
            foreach ($childMembers as $child) {
                $member_child= new Member();
               $member_child->departure_id= $departure_id->id;
               $member_child->order_code=$checkout_code;
               $member_child->tour_id=$data['tour_id'];
               $member_child->name=$child['name'];
               $member_child->note=$child['note'];
               $member_child->loai=2;
               $member_child->status=1;
               $member_child->save();
            }
        }
    
        // Lưu thông tin trẻ nhỏ vào cơ sở dữ liệu
        if (!empty($toddlerMembers)) {
            foreach ($toddlerMembers as $toddler) {
                $member_toddler= new Member();
                $member_toddler->departure_id=$departure_id->id;
                $member_toddler->order_code=$checkout_code;
                $member_toddler->tour_id=$data['tour_id'];
                $member_toddler->name=$toddler['name'];
                $member_toddler->note=$toddler['note'];
                $member_toddler->loai=3;
                $member_toddler->status=1;
                $member_toddler->save();
            }
        }
    
        // Lưu thông tin sơ sinh vào cơ sở dữ liệu
        if (!empty($infantMembers)) {
            foreach ($infantMembers as $infant) {
                $member_infant= new Member();
                $member_infant->departure_id=$departure_id->id;
                $member_infant->order_code=$checkout_code;
                $member_infant->tour_id=$data['tour_id'];
                $member_infant->name=$infant['name'];
                $member_infant->note=$infant['note'];
                $member_infant->loai=4;
                $member_infant->status=1;
                $member_infant->save();
            }
        }

        Session::forget('voucher');
    }
    public function update_quantity(Request $request)
    {
        $order=Order::find($request->order_id);
        $order_status = $request->order_status;
        $order->order_status = $order_status;
        $order->save();


        //lấy thông tin cần
        $order_detail = Orderdetail::where('orderdetails_id',$request->orderdetails_id)->first();
        $departure = Departure::where('tour_id',$order_detail->tour_id)->where('departure_date',$order_detail->departure_date)->first();
        $tour = Tour::where('id',$order_detail->tour_id)->first();
        
        //tìm bên bảng lợi nhuận chung
        $statistic = Statistical::where('order_date', $order->order_date)->get();
        if ($statistic) {
            $statistic_count = $statistic->count();
        } else {
            $statistic_count = 0;
        }
        //tìm bên bảng lợi nhuận của doanh nghiệm dành cho trang admin của doanh nghiệp vì chỉ doanh nghiệp mới xác nhận thanh toán
        if(Auth::user()->id!=1){
            $statistic_business = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id',Auth::user()->id)->get();
        }
        else{
            $business_id= $tour->business_id;
            $statistic_business = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id',$business_id)->get();
        }
        if ($statistic_business) {
            $statistic_businessc_count = $statistic_business->count();
        } else {
            $statistic_businessc_count = 0;
        }

        // Giá tour cho từng loại khách hàng
        $price_adult = $tour->price;
        $price_child = $tour->price_treem;
        $price_infant = $tour->price_trenho;
        $price_newborn = $tour->price_sosinh;
        $voucher = null;
        if($order_detail->voucher !== null){
            $voucher=Voucher::where('voucher_code',$order_detail->voucher)->first();
        }
        if($order_status==2){
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            //cập nhật số lượng người
            $update_quantity= $order_detail->nguoi_lon + $order_detail->tre_em + $order_detail->tre_nho + $order_detail->so_sinh;
            // $departure->quantity= $departure->quantity-$update_quantity;
            // $departure->save();
            //tính toán lợi nhuận
            $total_order +=1;
            // Tính doanh thu từ từng loại khách hàng
            $revenue_adult = $order_detail->nguoi_lon * $price_adult;
            $revenue_child = $order_detail->tre_em * $price_child;
            $revenue_infant = $order_detail->tre_nho * $price_infant;
            $revenue_newborn = $order_detail->so_sinh * $price_newborn;
            $sales= $revenue_adult + $revenue_child + $revenue_infant + $revenue_newborn;
            if($voucher){
                if($voucher->voucher_condition==1){
                    $sales=$sales-$voucher->voucher_number;
                }
                else{
                    $sales=$sales-($sales*$voucher->voucher_number/100);
                }
            }
            //Tính chi phí
            $desired_profit_margin = 0.30; // 30% lợi nhuận
            $total_cost = $sales - ($sales * $desired_profit_margin);
            //Tính lợi nhuận
            $profit = $sales - $total_cost;

            //Lưu statistical
            if ($statistic_count > 0) {
                $statistic_update = Statistical::where('order_date', $order->order_date)->first();
                $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit = $statistic_update->profit + $profit;
                $statistic_update->quantity = $statistic_update->quantity + $update_quantity;
                $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();
            } else {
                $statistic_new = new Statistical();
                $statistic_new->order_date = $order->order_date;
                $statistic_new->sales = $sales;
                $statistic_new->profit = $profit;
                $statistic_new->quantity = $update_quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();
            }

            //Lưu statistical cho từng doanh nghiệp
            if ($statistic_businessc_count > 0) {
                $statistic_business_update = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id',$tour->business_id)->first();
                $statistic_business_update->sales = $statistic_business_update->sales + $sales;
                $statistic_business_update->profit = $statistic_business_update->profit + $profit;
                $statistic_business_update->quantity = $statistic_business_update->quantity + $update_quantity;
                $statistic_business_update->total_order = $statistic_business_update->total_order + $total_order;
                $statistic_business_update->save();
            } else {
                $statistic_business_new = new Statisticalbusinesses();
                $statistic_business_new->order_date = $order->order_date;
                $statistic_business_new->sales = $sales;
                $statistic_business_new->profit = $profit;
                $statistic_business_new->quantity = $update_quantity;
                $statistic_business_new->total_order = $total_order;
                $statistic_business_new->business_id = $tour->business_id;
                $statistic_business_new->save();
            }
            
        }
        elseif($order_status==1){
             //cập nhật số lượng người
            $update_quantity= $order_detail->nguoi_lon + $order_detail->tre_em + $order_detail->tre_nho + $order_detail->so_sinh;
            // $departure->quantity= $departure->quantity +$update_quantity;
            // $departure->save();

            $total_order = 0;
            $sales = 0;
            $profit = 0;
          
            $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

            //tính toán lợi nhuận
            $total_order +=1;

            // Tính doanh thu từ từng loại khách hàng
            $revenue_adult = $order_detail->nguoi_lon * $price_adult;
            $revenue_child = $order_detail->tre_em * $price_child;
            $revenue_infant = $order_detail->tre_nho * $price_infant;
            $revenue_newborn = $order_detail->so_sinh * $price_newborn;
            $sales= $revenue_adult + $revenue_child + $revenue_infant + $revenue_newborn;
            if($voucher){
                if($voucher->voucher_condition==1){
                    $sales=$sales-$voucher->voucher_number;
                }
                else{
                    $sales=$sales-($sales*$voucher->voucher_number/100);
                }
            }

            //Tính chi phí
            $desired_profit_margin = 0.30; // 30% lợi nhuận
            $total_cost = $sales - ($sales * $desired_profit_margin);
            //Tính lợi nhuận
            $profit = $sales - $total_cost;
            //Lưu lợi nhuận
            if ($statistic_count > 0) {
                $statistic_update = Statistical::where('order_date', $order->order_date)->first();
                $statistic_update->sales = $statistic_update->sales - $sales;
                $statistic_update->profit = $statistic_update->profit - $profit;
                $statistic_update->quantity = $statistic_update->quantity - $update_quantity;
                $statistic_update->total_order = $statistic_update->total_order - $total_order;
                $statistic_update->save();

                if ($statistic_update->sales == 0) {
                    $statistic_update->delete();
                }
            }

            //Lưu lợi nhuận cho doanh nghiệp
            if ($statistic_businessc_count > 0) {
                $statistic_business_update = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id',$tour->business_id)->first();
                $statistic_business_update->sales = $statistic_business_update->sales - $sales;
                $statistic_business_update->profit = $statistic_business_update->profit - $profit;
                $statistic_business_update->quantity = $statistic_business_update->quantity - $update_quantity;
                $statistic_business_update->total_order = $statistic_business_update->total_order - $total_order;
                $statistic_business_update->save();

                if ($statistic_business_update->sales == 0) {
                    $statistic_business_update->delete();
                }
            }
        }
        
       

        
    
        return response()->json(['success' => 'Cập nhật trạng thái thành công!']);
    }
    
}
