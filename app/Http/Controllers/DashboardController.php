<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistical;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Departure;
use App\Models\User;
use App\Models\Business;
use App\Models\Statisticalbusinesses;
use Illuminate\Support\Facades\Auth;

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
       $businesses= User::where('role','business')->where('status',1)->get();
        return view('admin.dashboard.statistic',compact('businesses'));
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
}
