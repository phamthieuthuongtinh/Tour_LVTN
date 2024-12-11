<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistical;
use App\Models\Tour;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\User;
use App\Models\Customer;
use App\Models\Business;
use Carbon\Carbon;
// use App\Providers\AppServiceProvider;
use App\Models\Statisticalbusinesses;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
*/
    public function index()
    {
        //
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
        //
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
        //
    }
    public function show_dashboard(){
        $now=Carbon::now();
        $twoMonthsAgo = $now->copy()->subMonths(2);
        $orders = Order::where('order_status', 2)->wherebetween('order_date',[$twoMonthsAgo, $now])->get();
        $orders_code = $orders->pluck('order_code')->toArray();

        $order_details = Orderdetail::whereIn('order_code', $orders_code)->get();
        $tour_id = $order_details->pluck('tour_id')->unique()->values();
        if(Auth::user()->id==1){
            $tour_sale_ganday=Tour::whereIn('id',$tour_id)->with('category')->with('type')->with('user')->limit(5)->get();
        }else{
            $tour_sale_ganday=Tour::whereIn('id',$tour_id)->with('category')->with('type')->where('business_id',Auth::user()->id)->limit(5)->get();
        }
       $businesses= User::where('role','business')->where('status',1)->get();
        return view('admin.dashboard.statistic',compact('businesses','tour_sale_ganday'));
    }
    public function filterStatistics(Request $request)
    {
        // Xác định ngày bắt đầu và ngày kết thúc từ yêu cầu
        
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $business_id=$request->input('business_id');
        
        // Chuyển đổi định dạng ngày để dễ so sánh
        if ($startDate) {
            $startDate = date('Y-m-d', strtotime($startDate));
        }
        if ($endDate) {
            $endDate = date('Y-m-d', strtotime($endDate));
        }
        

        // Truy vấn dữ liệu từ cơ sở dữ liệu theo ngày bắt đầu và kết thúc
        if(Auth::user()->id==1){
            if($business_id ){
               if($startDate && $endDate) {
                    $statistics = Statisticalbusinesses::whereBetween('order_date', [$startDate, $endDate])
                    ->selectRaw('DATE_FORMAT(order_date, "%d/%m/%Y") as date, SUM(sales) as total_sales, SUM(profit) as total_profit') ->where('business_id', $business_id)
                    ->groupBy('date') ->orderBy('order_date', 'asc')
                    ->get();
               }
               else{
                    $statistics = Statisticalbusinesses::selectRaw('DATE_FORMAT(order_date, "%d/%m/%Y") as date, SUM(sales) as total_sales, SUM(profit) as total_profit') 
                    ->where('business_id', $business_id)
                    ->groupBy('date') ->orderBy('order_date', 'asc')
                    ->get();
               }
            }  
            else{
                 $statistics = Statistical::whereBetween('order_date', [$startDate, $endDate])
                ->selectRaw('DATE_FORMAT(order_date, "%d/%m/%Y") as date, SUM(sales) as total_sales, SUM(profit) as total_profit')
                ->groupBy('date')
                ->get();
            } 
        }
        else{
            $statistics = Statisticalbusinesses::whereBetween('order_date', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(order_date, "%d/%m/%Y") as date, SUM(sales) as total_sales, SUM(profit) as total_profit') ->where('business_id', Auth::user()->id)
            ->groupBy('date')
            ->get();
        }
        

        // Tạo dữ liệu cho biểu đồ
        $labels = [];
        $salesData = [];
        $profitData = [];

        foreach ($statistics as $item) {
            $labels[] = $item->date;
            $salesData[] = $item->total_sales;
            $profitData[] = $item->total_profit;
        }

        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'labels' => $labels,
            'salesData' => $salesData,
            'profitData' => $profitData
        ]);
    }

    // Biểu đồ đường
    public function filter_line_dashboard(Request $request)
    {
        // Xác định ngày bắt đầu và ngày kết thúc từ yêu cầu
        
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        // $business_id=$request->input('business_id_line');
        
        // Chuyển đổi định dạng ngày để dễ so sánh
        if ($startDate) {
            $startDate = date('Y-m-d', strtotime($startDate));
        }
        if ($endDate) {
            $endDate = date('Y-m-d', strtotime($endDate));
        }
        
        // Tạo dữ liệu cho biểu đồ
        $datavisitor = [];
        $databusiness = [];
        $labels = [];
        // Truy vấn dữ liệu từ cơ sở dữ liệu theo ngày bắt đầu và kết thúc
   
        if($startDate && $endDate) {
            $business=Business::whereBetween('created_at', [$startDate, $endDate])->selectRaw('DATE(created_at) as month, COUNT(id) as total_business')
            ->groupByRaw('DATE(created_at)')
            ->get()
            ->pluck('total_business', 'month');
            $customer=Customer::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->selectRaw('DATE(created_at) as month, COUNT(customer_id) as total_visitors')
            ->groupByRaw('DATE(created_at)')
            ->get()
            ->pluck('total_visitors', 'month');
        }
       
        $period = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval('P1D'),
            (new \DateTime($endDate))->modify('+1 day')
        );
        
        $months = collect(iterator_to_array($period))->map(function ($date) {
            return $date->format('Y-m-d'); // Định dạng từng ngày thành 'Y-m-d'
        }); //là các ngày nhưng để tên mà months
        $fullcustomerdata = $months->mapWithKeys(function ($month) use ($customer) {
            return [$month => $customer->get($month, 0)]; // Nếu không tồn tại trong , gán 0
        });
        $fullbusinessdata = $months->mapWithKeys(function ($month) use ($business) {
            return [$month => $business->get($month, 0)]; // Nếu không tồn tại trong , gán 0
        });
        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'labels' => $months,
            'datavisitor' => $fullcustomerdata,
            'databusiness' => $fullbusinessdata
        ]);
    }
    
    //Biểu đồ tròn
    // public function filter_pie_before_month(string $business_id){
    //     $orders = Order::where('order_status', 2)->get();
    //     $orders_code = $orders->pluck('order_code')->toArray();
    //     $order_details = Orderdetail::whereIn('order_code', $orders_code)->get();
    //     $order_details_month = OrderDetail::whereIn('order_code', $orders_code)->where('created_at', '>=', Carbon::now()->subMonth())->get();
    //     $count = $order_details->groupBy('tour_id')->map(function ($group) {
    //         return $group->count(); // Đếm số bản ghi trong mỗi nhóm tour_id
    //     });
    //     $count_month = $order_details_month->groupBy('tour_id')->map(function ($group) {
    //         return $group->count(); // Đếm số bản ghi trong mỗi nhóm tour_id
    //     });


    //     $percentageIncrease = collect();

    //     $count->keys()->each(function ($tour_id) use ($count, $count_month, $percentageIncrease) {
    //         $totalCount = $count->get($tour_id); // Lấy tổng số lượng từ mảng count
    //         $totalCountMonth = $count_month->get($tour_id, 0); // Lấy số lượng cho tháng hiện tại (nếu không có, mặc định là 0)

    //         // Tính tỷ lệ phần trăm
    //         $percentage = 0; // Khởi tạo tỷ lệ phần trăm
    //         if ($totalCount > 0) { // Tránh chia cho 0
    //             if ($totalCountMonth == 0) {
    //                 $percentage = 0;
    //             } else {
    //                 if($totalCount - $totalCountMonth==0 ){
    //                     $percentage =100;
    //                 }
    //                 else{
    //                     $percentage = ($totalCountMonth   / ($totalCount - $totalCountMonth)) * 100;
    //                 }
                    
    //             }
    //         }

    //         // Thêm vào mảng kết quả với tour_id làm key
    //         $percentageIncrease[$tour_id] = abs($percentage);
    //     });

    //     if (isset(Auth::user()->id)) {

    //         if (Auth::user()->id == 1) {
    //             $tours = Tour::whereIn('id', $percentageIncrease->keys())->where('business_id',$business_id)->with('type')->get();
    //             // $tour_count_by_type = $tours->groupBy('type.type_name')->map(function ($group) {
    //             //     return $group->count(); 
    //             // });
    //         } else {
    //             $tours = Tour::whereIn('id', $percentageIncrease->keys())->where('business_id', Auth::user()->id)->with('type')->get();
    //             // $tour_count_by_type = $tours->groupBy('type.type_name')->map(function ($group) {
    //             //     return $group->count(); 
    //             // });

    //         }
    //         $percent = [];
    //         foreach ($tours as $tour) {
    //             $type_name = $tour->type->type_name; // Lấy tên loại tour
    //             $tour_id = $tour->id; // Lấy tour_id để khớp với $count

    //             // Kiểm tra nếu type_name đã tồn tại trong mảng, thì cộng dồn số lượng
    //             if (isset($percent[$type_name])) {
    //                 $percent[$type_name] += $percentageIncrease[$tour_id]; // Cộng dồn
    //             } else {
    //                 // Nếu chưa tồn tại, thì gán giá trị
    //                 $percent[$type_name] = $percentageIncrease[$tour_id];
    //             }
    //         }

    //         return collect($percent)->map(function ($percentageIncrease, $type_name) {
    //             return [
    //                 'type_name' => $type_name,
    //                 'percent' => $percentageIncrease,
    //             ];
    //         })->all();
    //     }
    // }
    public function filter_pie_dashboard(Request $request){
        // session()->forget('business_id');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $business_id=$request->input('business_id');
        
        // Chuyển đổi định dạng ngày để dễ so sánh
        if ($startDate) {
            $startDate = date('Y-m-d', strtotime($startDate));
        }
        if ($endDate) {
            $endDate = date('Y-m-d', strtotime($endDate));
        }
        
        $orders = Order::where('order_status', 2)->whereBetween('created_at', [$startDate, $endDate])->get();
        $orders_code = $orders->pluck('order_code')->toArray();
        $order_details = Orderdetail::whereIn('order_code', $orders_code)->get();

        $count = $order_details->groupBy('tour_id')->map(function ($group) {
            return $group->count(); // Đếm số bản ghi trong mỗi nhóm tour_id
        });
        if (isset(Auth::user()->id)) {
            if (Auth::user()->id == 1) {
                if($business_id){
                    // if ($business_id) {
                    //     session(['business_id' => $business_id]);
                    // }
                    if($startDate && $endDate) {
                        $tours = Tour::whereIn('id', $count->keys())->where('business_id',$business_id)->with('type')->get();

                        // $piedata = $this->appService->getPieDataMonth();
                       
                    }
                    else{
                        $tours = Tour::whereIn('id', $count->keys())->where('business_id',$business_id)->with('type')->get();

                        // $piedata = $this->appService->getPieDataMonth();
                    }
                }
               else{
                    $tours = Tour::whereIn('id', $count->keys())->with('type')->get();
               }
            } else {
                $tours = Tour::whereIn('id', $count->keys())->where('business_id', Auth::user()->id)->with('type')->get();
            }
            $tour_count_by_type = [];
            foreach ($tours as $tour) {
                $type_name = $tour->type->type_name; // Lấy tên loại tour
                $tour_id = $tour->id; // Lấy tour_id để khớp với $count

                // Kiểm tra nếu type_name đã tồn tại trong mảng, thì cộng dồn số lượng
                if (isset($tour_count_by_type[$type_name])) {
                    $tour_count_by_type[$type_name] += $count[$tour_id];
                } else {
                    // Nếu chưa tồn tại, thì gán giá trị
                    $tour_count_by_type[$type_name] = $count[$tour_id];
                }
            }
            // dd($tour_count_by_type);

            $response_data = collect($tour_count_by_type)->map(fn($count, $type_name) => [
                'type_name' => $type_name,
                'count' => $count,
            ])->values()->all();
    
            // Trả về dữ liệu phù hợp cho biểu đồ
            return response()->json($response_data);
            
        }
    }
}
