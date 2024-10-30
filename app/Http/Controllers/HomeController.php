<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Customer;
use App\Models\Type;
use App\Models\Departure;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Itinerary;
use App\Models\Service;
use App\Models\Like;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Register;
use App\Models\Statisticalbusinesses;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Auth::user()->id==1){
             $order_new=Order::where('order_status',1)->count();
        }
        else{
            
            $order_new_all=Order::where('order_status',1)->get();
            $orderCodes = $order_new_all->pluck('order_code')->toArray();
            $tourIds = OrderDetail::whereIn('order_code', $orderCodes)->pluck('tour_id')->toArray();
            $businessTourIds = Tour::whereIn('id', $tourIds)->where('business_id', Auth::user()->id)->pluck('id')->toArray();
            $orders = $order_new_all->filter(function($order) use ($businessTourIds) {
                return OrderDetail::where('order_code', $order->order_code)
                    ->whereIn('tour_id', $businessTourIds)
                    ->exists();
            });
            $order_new = $orders->count();

        }
        $comments_business = collect();
        if(Auth::user()->id!=1){
            $tours=Tour::with('category')->with('user')->where('business_id',Auth::user()->id)->Orderby('status','DESC')->get();
            $tourIds = $tours->pluck('id')->toArray();
            $comments_business = Comment::with('tour')
                ->whereIn('comment_tour_id', $tourIds)
                ->where(function($query) {
                    $query->where('status', 0);
                })
                ->whereNull('comment_parent_comment')
                ->get();
        }
        $comment_new=$comments_business->count();
        if(Auth::user()->id!=1){
            $tour_new=Tour::where('business_id',Auth::user()->id)->where('status',2)->count();
        }
        else{
            $tour_new=Tour::where('status',2)->count();
        }


        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $customer_new = Customer::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->where('status','!=',0)->count();
        $business_new = Register::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->where('status',1)->count();
        $rate_statistical=0;
        $statistical_prev=0;
        $statistical_now=0;
        if(Auth::user()->id!=1){
            $previousMonthDate = Carbon::now()->subMonth();
            $statistical_prev=Statisticalbusinesses::where('business_id',Auth::user()->id)->whereMonth('order_date', $previousMonthDate)->whereYear('order_date', $currentYear)->sum('profit');
            $statistical_now=Statisticalbusinesses::where('business_id',Auth::user()->id)->whereMonth('order_date', $currentMonth)->whereYear('order_date', $currentYear)->sum('profit');
            if($statistical_prev >$statistical_now){
                $rate_statistical=($statistical_prev-($statistical_now));
            }else{
                $rate_statistical=($statistical_now-($statistical_prev));
            }
            $rate_statistical = round($rate_statistical, 1);
        }
       
        return view('home',compact('order_new','customer_new','business_new','comment_new','tour_new','statistical_prev','statistical_now','rate_statistical'));
    }
}
