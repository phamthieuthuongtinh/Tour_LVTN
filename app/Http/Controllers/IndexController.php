<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Statistical;
use App\Models\Statisticalbusinesses;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\Type;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Orderdetail;
use App\Models\Departure;
use App\Models\Discount;
use App\Models\Customer;
use App\Models\Recommend;
use App\Models\Like;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class IndexController extends Controller
{
    public function index(){
        // list tour sale
        $list_tour_sales=Discount::where('status',1)->get();
        $sortedCateCounts = $list_tour_sales->groupBy('tour.category_id')->map(function ($group) {
            return $group->count();
        })->sortDesc();

        $top4CateIds = $sortedCateCounts->keys()->take(4);
        $types = Category::whereIn('id', $top4CateIds)->get();
      
        $types->transform(function ($type) {
            // Tìm giá trị nhỏ nhất và lớn nhất của rate trong bảng Discount cho từng type_id
            $discounts = Discount::where('category_id', $type->id)->get();
            // Thêm thuộc tính min và max vào đối tượng type
            $type->min = $discounts->isNotEmpty() ? $discounts->min('rate') : 0;
            $type->max = $discounts->isNotEmpty() ? $discounts->max('rate') : 0;
            
            return $type;
        });
        if(Session::get('customer_id')){
            $recommends= collect();
            $customer_id=Session::get('customer_id');
            $customer= Customer::where( 'customer_id',$customer_id)->first();

            $likes=Like::where('customer_id',$customer_id)->get();
            $like_tour_id=$likes->pluck ('tour_id')->toArray();
            $tour=Tour::wherein('id',$like_tour_id)->get();
            $cate_id=$tour->pluck ('category_id')->toArray();

            $recommends_1=Tour::whereIn('category_id',$cate_id)->whereNotIn('id',$like_tour_id)->get();

            //Lấy recommend theo loại tour đã đặt
            $ordered_list=Order::where('customer_id',$customer_id)->get();
            $ordered_ordercode=$ordered_list->pluck('order_code')->toArray();
            $orderdetails=Orderdetail::whereIn('order_code',$ordered_ordercode)->get();
            $tourId_list=$orderdetails->pluck('tour_id')->toArray();
            $tour_list=Tour::wherein('id',$tourId_list)->get();
            $type_id=$tour_list->pluck('type_id')->toArray();
           
            // dd($customer_id);
            $recommends_2=Tour::whereIn('type_id',$type_id)->whereNotIn('id',$tourId_list)->get();
        
            $recommends = $recommends_1->merge($recommends_2)->unique('id');
           
           
                $recommend = Recommend::where('customer_id', $customer_id)->first();
                // $customerPreference = $customer->hobby;
                // $result = $this->analyzePreferences($customerPreference);
                // $typeIds = Type::whereIn('type_name', $result)->pluck('id');
                if ($recommend) {
                    // Convert the comma-separated string back to an array
                    $recommendTourIdsArray = explode(',', $recommend->recommend);
                
                    // Now you have the array of tour IDs
                    $recommends_3 = Tour::whereIn('type_id', $recommendTourIdsArray)->get();
                    $recommends = $recommends->merge($recommends_3)->unique('id');
                }
               
               
                $recommends = $recommends->shuffle();
                $recommends = $recommends->take(20);
                //sale tour
                $tour_id_sale=$recommends->pluck('id')->toArray();
                $tour_sales=Discount::whereIn('tour_id',$tour_id_sale)->get();
               
                //rating
               
                $rating=Rating::whereIn('tour_id',$tour_id_sale)->get();
                $groupedRatings = $rating->groupBy('tour_id');
                $avg_rating = $groupedRatings->map(function ($group) {
                    return $group->avg('rating');
                });
                

                foreach ($recommends as $tour) {
                    // Nếu tour_id có trong danh sách tính trung bình đánh giá, gán avg_rating cho tour
                    $tourId = $tour->id; // Hoặc $tour->tour_id nếu cần
                    // Nếu tour_id có trong danh sách tính trung bình đánh giá, gán avg_rating cho tour
                    $tour->avg_rating = isset($avg_rating[$tourId]) ? $avg_rating[$tourId] : 0;
                
                }
            return view('pages.home',compact('recommends','likes','tour_sales','types'));
        }  
        else{
            return view('pages.home',compact('types'));
        }      
    }
    // Xử lý ngôn ngữ tự nhiên NLP
    public function analyzePreferences($text)
    {
        $scriptPath = base_path('public/python/nlp_analysis.py');
        $command = "python $scriptPath " . escapeshellarg($text);
        $output = shell_exec($command);
        $result = json_decode($output, true);
        return $result;
    }    

    public function login_customer()
    {
        return view('pages.login'); 
    }
    public function register_customer()
    {
        return view('pages.register_customer'); 
    }
    public function payment_success_momo(Request $request)
    {
        $resultCode = $request->input('resultCode');

        if ($resultCode == 0) {
            $order_id = Session::get('order_id');
            $order_code = Session::get('order_code');
            $order = Order::where('order_id', $order_id)->first();
            $orderdetail = Orderdetail::where('order_code', $order_code)->first();
            $order->order_status=2;
            $order->save();
            $departure = Departure::where('tour_id', $orderdetail->tour_id)->where('departure_date', $orderdetail->departure_date)->first();
            $tour = Tour::where('id', $orderdetail->tour_id)->first();
            // Lưu lợi nhuận
            $statistic = Statistical::where('order_date', $order->order_date)->get();
            if ($statistic) {
                $statistic_count = $statistic->count();
            } else {
                $statistic_count = 0;
            }
            //tìm lợi nhuận của doanh nghiệm
            $statistic_business = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id', $tour->business_id)->get();
            if ($statistic_business) {
                $statistic_businessc_count = $statistic_business->count();
            } else {
                $statistic_businessc_count = 0;
            }
            $price_adult = $tour->price;
            $price_child = $tour->price_treem;
            $price_infant = $tour->price_trenho;
            $price_newborn = $tour->price_sosinh;
            $voucher = null;
            if($orderdetail->voucher !== null){
                $voucher=Voucher::where('voucher_code',$orderdetail->voucher)->first();
            }

            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            //cập nhật số lượng người trong bảng Lịch trình
            $update_quantity= $orderdetail->nguoi_lon + $orderdetail->tre_em + $orderdetail->tre_nho + $orderdetail->so_sinh;
            $departure->quantity= $departure->quantity-$update_quantity;
            $departure->save();
            //tính toán lợi nhuận
            $total_order += 1;
            // Tính doanh thu từ từng loại khách hàng
            $revenue_adult = $orderdetail->nguoi_lon * $price_adult;
            $revenue_child = $orderdetail->tre_em * $price_child;
            $revenue_infant = $orderdetail->tre_nho * $price_infant;
            $revenue_newborn = $orderdetail->so_sinh * $price_newborn;
            $sales= $revenue_adult + $revenue_child + $revenue_infant + $revenue_newborn;
            if ($voucher) {
                if ($voucher->voucher_condition == 1) {
                    $sales = $sales - $voucher->voucher_number;
                } else {
                    $sales = $sales - ($sales * $voucher->voucher_number / 100);
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
                $statistic_business_update = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id', $tour->business_id)->first();
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

            // Xử lý thành công
            return view('pages.payment_success'); 
        } else {
            // Chuyển hướng đến trang lỗi và xóa thôgn tin đơn hàng nếu có lỗi thanh toán momo
            $order_id = Session::get('order_id');
            $order_code = Session::get('order_code');
            $order = Order::where('order_id', $order_id)->first();
            $orderdetail = Orderdetail::where('order_code', $order_code)->first();
            $order->delete();
            $orderdetail->delete();
            Session::forget('order_id');
            Session::forget('order_code');
            Session::forget('tour_id');
            $message='Giao dịch đã bị hủy!';
            return redirect()->route('payment-error')->with('error_message', $message);
        }
        
    }
    public function payment_error()
    {
        return view('pages.payment_error'); 
    }
    public function payment_success()
    {
        return view('pages.payment_success'); 
    }
    public function search(Request $request){
        $query = Tour::query(); // Khởi tạo một query builder cho model Tour
     
        if ($request->has('tour_to') && $request->tour_to != null) {
            $query->where('title', 'like', '%' . $request->tour_to . '%');
        }
    
        if ($request->has('price') && $request->price != null) {
            switch ($request->price) {
                case 'under5':
                    $query->where('price', '<', 5000000);
                    break;
                case '5to10':
                    $query->whereBetween('price', [5000000, 10000000]);
                    break;
                case '10to20':
                    $query->whereBetween('price', [10000000, 20000000]);
                    break;
                case 'over20':
                    $query->where('price', '>', 20000000);
                    break;
            }
        }
        $tours_get = $query->get();
        // Kiểm tra nếu người dùng chọn ngày khởi hành
        if ($request->has('departure_date') && $request->departure_date != null) {
            $departure_date = Carbon::createFromFormat('d/m/Y', $request->departure_date)->format('Y-m-d');
            $tour_ids=$tours_get->pluck('id')->toArray();
           
            $tour_get_2=Departure::whereIn('tour_id',$tour_ids)->where('departure_date',$departure_date)->get();
            $tour_get_2=$tour_get_2->pluck('tour_id')->toArray();
            $tours_get=Tour::whereIn('id',$tour_get_2)->get();
            // dd($request->departure_date);
        }
        $tours=$tours_get;
        // Thực hiện truy vấn và lấy kết quả
       
        if(Session::get('customer_id')){
            $customer_id=Session::get('customer_id');
            $likes=Like::where('customer_id',$customer_id)->get();
            return view('pages.search',compact('tours','likes'));
           
        }
       else{
            return view('pages.search',compact('tours'));
       }
    }

//     public function filterTours(Request $request)
// {
//     $category = Category::where('slug', $request->slug)->first();
//     $query = Tour::where('category_id', $category->id)
//                  ->where('status', 3)
//                  ->with('category')
//                  ->with(['departures' => function ($query) {
//                      $query->where('status', 1)
//                            ->where('departure_date', '>=', Carbon::today())
//                            ->orderBy('departure_date', 'ASC');
//                  }]);

//     // Lọc theo giá
//     if ($request->price) {
//         switch ($request->price) {
//             case 'under5':
//                 $query->where('price', '<', 5000000);
//                 break;
//             case '5to10':
//                 $query->whereBetween('price', [5000000, 10000000]);
//                 break;
//             case '10to20':
//                 $query->whereBetween('price', [10000000, 20000000]);
//                 break;
//             case 'over20':
//                 $query->where('price', '>', 20000000);
//                 break;
//         }
//     }

//     // Lọc theo loại tour
//     if ($request->tour_type) {
//         $query->where('type_id', $request->tour_type);
//     }

//     // Lọc theo phương tiện
//     if ($request->tour_from) {
//         $query->where('tour_from', $request->tour_from);
//     }

//     // Paginate
//     $tours = $query->paginate(2);

//     return response()->json(['tours' => $tours]);
// }

    
    public function about_us(){
        return view('pages.about');
    }
    public function contact(){
        return view('pages.contact');
    }
    public function secure(){
        return view('pages.secure');
    }
    public function clause(){
        return view('pages.clause');
    }
    public function suport(){
        return view('pages.suport');
    }
}
