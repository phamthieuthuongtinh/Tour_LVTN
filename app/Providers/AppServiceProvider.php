<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Tour;
use App\Models\Customer;
use App\Models\Business;
use App\Models\Statistical;
use App\Models\Statisticalbusinesses;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function getCategoriesProduct()
    {
        $categories = Category::orderBy('title', 'ASC')->get();
        $listCategory = [];
        Category::recursive($categories, $parents = 0, $level = 1, $listCategory);
        return $listCategory;
    }
    public function getBanners()
    {
        $banners = Banner::orderBy('banner_id', 'DESC')->get();
        return $banners;
    }
    public function getStatistics()
    {

        if (isset(Auth::user()->id)) {

            if (Auth::user()->id == 1) {
                $statistics = Statistical::selectRaw('MONTH(order_date) as month, SUM(sales) as total_sales, SUM(profit) as total_profit')->groupByRaw('MONTH(order_date)')->get();
            } else {
                $statistics = Statisticalbusinesses::selectRaw('MONTH(order_date) as month, SUM(sales) as total_sales, SUM(profit) as total_profit')->where('business_id', Auth::user()->id)
                    ->groupByRaw('MONTH(order_date)')
                    ->get();
            }
            return  $statistics;
        }
    }

    public function getPieData()
    {
        $orders = Order::where('order_status', 2)->get();
        $orders_code = $orders->pluck('order_code')->toArray();
        $order_details = Orderdetail::whereIn('order_code', $orders_code)->get();

        $count = $order_details->groupBy('tour_id')->map(function ($group) {
            return $group->count(); // Đếm số bản ghi trong mỗi nhóm tour_id
        });
        if (isset(Auth::user()->id)) {
            if (Auth::user()->id == 1) {
                $tours = Tour::whereIn('id', $count->keys())->with('type')->get();
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

            return collect($tour_count_by_type)->map(function ($count, $type_name) {
                return [
                    'type_name' => $type_name,
                    'count' => $count,
                ];
            })->values()->all();
        }
    }
    public function getPieDataMonth()
    {

        
        $orders = Order::where('order_status', 2)->get();
        $orders_code = $orders->pluck('order_code')->toArray();
        $order_details = Orderdetail::whereIn('order_code', $orders_code)->get();
        $order_details_month = OrderDetail::whereIn('order_code', $orders_code)->where('created_at', '>=', Carbon::now()->subMonth())->get();
        $count = $order_details->groupBy('tour_id')->map(function ($group) {
            return $group->count(); // Đếm số bản ghi trong mỗi nhóm tour_id
        });
        $count_month = $order_details_month->groupBy('tour_id')->map(function ($group) {
            return $group->count(); // Đếm số bản ghi trong mỗi nhóm tour_id
        });


        $percentageIncrease = collect();

        $count->keys()->each(function ($tour_id) use ($count, $count_month, $percentageIncrease) {
            $totalCount = $count->get($tour_id); // Lấy tổng số lượng từ mảng count
            $totalCountMonth = $count_month->get($tour_id, 0); // Lấy số lượng cho tháng hiện tại (nếu không có, mặc định là 0)

            // Tính tỷ lệ phần trăm
            $percentage = 0; // Khởi tạo tỷ lệ phần trăm
            if ($totalCount > 0) { // Tránh chia cho 0
                if ($totalCountMonth == 0) {
                    $percentage = 0;
                } else {
                    if($totalCount - $totalCountMonth==0 ){
                        $percentage =100;
                    }
                    else{
                        $percentage = ($totalCountMonth   / ($totalCount - $totalCountMonth)) * 100;
                    }
                    
                }
            }

            // Thêm vào mảng kết quả với tour_id làm key
            $percentageIncrease[$tour_id] = abs($percentage);
        });

        if (isset(Auth::user()->id)) {

            if (Auth::user()->id == 1) {
                // if(session::get('business_id')){
                //     $tours = Tour::whereIn('id', $percentageIncrease->keys())->where('business_id',session::get('business_id'))->with('type')->get();
                // }
                // else{
                //     $tours = Tour::whereIn('id', $percentageIncrease->keys())->with('type')->get();
                // }
                $tours = Tour::whereIn('id', $percentageIncrease->keys())->with('type')->get();
        
            } else {
                $tours = Tour::whereIn('id', $percentageIncrease->keys())->where('business_id', Auth::user()->id)->with('type')->get();


            }
            $percent = [];
            foreach ($tours as $tour) {
                $type_name = $tour->type->type_name; // Lấy tên loại tour
                $tour_id = $tour->id; // Lấy tour_id để khớp với $count

                // Kiểm tra nếu type_name đã tồn tại trong mảng, thì cộng dồn số lượng
                if (isset($percent[$type_name])) {
                    $percent[$type_name] += $percentageIncrease[$tour_id]; // Cộng dồn
                } else {
                    // Nếu chưa tồn tại, thì gán giá trị
                    $percent[$type_name] = $percentageIncrease[$tour_id];
                }
            }

            return collect($percent)->map(function ($percentageIncrease, $type_name) {
                return [
                    'type_name' => $type_name,
                    'percent' => $percentageIncrease,
                ];
            })->all();
        }
    }
    public function getVisitor_1(){

        if(isset(Auth::user()->id)){
            $visitor = Customer::selectRaw('MONTH(created_at) as month, COUNT(customer_id) as total_visitors')
            ->groupByRaw('MONTH(created_at)')
            ->get()
            ->pluck('total_visitors', 'month'); // Lấy dữ liệu thành dạng key-value: ['month' => 'total_business']
        
        // Tạo một mảng từ tháng 1 đến tháng 12
        $months = collect(range(1, 12));
        
        // Gán giá trị 0 cho những tháng không có dữ liệu
        $fullVisitorData = $months->mapWithKeys(function ($month) use ($visitor) {
            return [$month => $visitor->get($month, 0)]; // Nếu không tồn tại trong $visitor, gán 0
        });
        
        // Kết quả trả về
        return $fullVisitorData;
        
        }  
    }
    public function getVisitor_2(){

        if(isset(Auth::user()->id)){
            $visitor = Business::selectRaw('MONTH(created_at) as month, COUNT(id) as total_business')
            ->groupByRaw('MONTH(created_at)')
            ->get()
            ->pluck('total_business', 'month'); // Lấy dữ liệu thành dạng key-value: ['month' => 'total_business']
        
        // Tạo một mảng từ tháng 1 đến tháng 12
        $months = collect(range(1, 12));
        
        // Gán giá trị 0 cho những tháng không có dữ liệu
        $fullVisitorData = $months->mapWithKeys(function ($month) use ($visitor) {
            return [$month => $visitor->get($month, 0)]; // Nếu không tồn tại trong $visitor, gán 0
        });
        
        // Kết quả trả về
        return $fullVisitorData;
        
        }  
    }
    public function getTourSale()
    {
        $now = Carbon::now();
        $discounts = Discount::where('status', '!=', 0)->where('end', '>=', $now)->with('cate')->orderBy('id', 'ASC')->get()->groupBy('category_id')->map(function ($group) {
            return $group->first(); // Lấy bản ghi đầu tiên trong mỗi nhóm
        });


        return $discounts;
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('*', function ($view) {
            $categories = $this->getCategoriesProduct();
            $banners = $this->getBanners();
            $statistics = $this->getStatistics();
            $piedata = $this->getPieData();
            $piedatamonth = $this->getPieDataMonth();
            $list_type_tour_sale = $this->getTourSale();
            $vistitor1 = $this->getVisitor_1();
            $vistitor2 = $this->getVisitor_2();
            $view->with('categories', $categories)->with('banners', $banners)->with('statistics', $statistics)->with('list_type_tour_sale', $list_type_tour_sale)
            ->with('piedata', $piedata)->with('piedatamonth', $piedatamonth)->with('visitor',$vistitor1)->with('business',$vistitor2);
        });
    }
}
