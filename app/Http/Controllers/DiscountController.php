<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;
use App\Models\Tour;
use App\Models\Type;
use App\Models\Category;
use App\Models\Like;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discount=Discount::where('status','!=',0)->with('tour')->orderBy('id','DESC')->get();

        return view('admin.discounts.index',compact('discount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tour=null;
        $type=null;
        $category=null;
        if(Auth::user()->id!=1){
            $tour=Tour::where('business_id',Auth::user()->id)->where('status',3)->orderBy('id',"DESC")->get();
            $type=Type::where('status',1)->get();
            $category=Category::where('status',1)->get();
        }
 
        return view('admin.discounts.create',compact('tour','type','category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tour_id' => 'required',
            'type_id' => 'required',
            'cate_id' => 'required',
            'rate' => 'required',
            'start' => 'required',
            'end' => 'required',
        ],[
            'tour_id.required' => 'Bạn chưa chọn tour',
            'type_id.required' => 'Bạn chưa chọn loại tour',
            'cate_id.required' => 'Bạn chưa chọn loại tour',
            'rate.required' => 'Bạn chưa nhập % giảm giá',
            'start.required' => 'Bạn chưa nhập ngày bắt đầu',
            'end.required' => 'Bạn chưa nhập ngày kết thúc',
            
        ]);
        $discount = new Discount();
        $discount->tour_id = $data['tour_id'];
        $discount->type_id = $data['type_id'];
        $discount->category_id = $data['cate_id'];
        $discount->rate = $data['rate'];
        $discount->start = $data['start'];
        $discount->end = $data['end'];
        $discount->status = 1;

        $discount->save();
        toastr()->success('Thêm thành công!');
        return redirect()->route('discounts.index');
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
        $types = Type::all();
        $tours = Tour::all(); 
        $category=Category::all();
        $discount=Discount::where('id',$id)->with('cate')->first();
        if(Auth::user()->id!=1){
            $tour=Tour::where('business_id',Auth::user()->id)->where('status',3)->orderBy('id',"DESC")->get();
            $type=Type::where('status',1)->get();
            $category=Category::where('status',1)->get();
        }
        return view('admin.discounts.edit',compact('discount','tour','type','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'type_id' => 'required',
            'rate' => 'required',
            'start' => 'required',
            'end' => 'required',
        ],[
            'type_id.required' => 'Bạn chưa chọn loại tour',
            'rate.required' => 'Bạn chưa nhập % giảm giá',
            'start.required' => 'Bạn chưa nhập ngày bắt đầu',
            'end.required' => 'Bạn chưa nhập ngày kết thúc',
            
        ]);
        $discount =  Discount::find($id);
        if ($request->has('tour_id')) {
            $discount->tour_id = $request->input('tour_id');
        }
        if ($request->has('cate_id')) {
            $discount->category_id = $request->input('cate_id');
        }
        $discount->type_id = $data['type_id'];
        $discount->rate = $data['rate'];
        $discount->start = $data['start'];
        $discount->end = $data['end'];
        $discount->status = 1;

        $discount->save();
        toastr()->success('Cập nhật thành công!');
        return redirect()->route('discounts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount =  Discount::find($id);
        $discount->status=0;
        $discount->save();
        toastr()->success('Xóa thành công!');
        return redirect()->route('discounts.index');
    }
    public function tour_sale($slug){
        $category= Category::where('slug',$slug)->first();
        $discountIds = Discount::pluck('tour_id')->toArray();
        // $type= Type::where('id',$id)->first();
        $tours= Tour::where('category_id',$category->id) ->whereIn('id', $discountIds)->where('status',3)->with('category')->with(['departures' => function($query) {
            $query->where('status',1)->where('departure_date', '>=', Carbon::today())
                  ->orderBy('departure_date', 'ASC');
        }])->get();
        $nearestDeparture = null;
        foreach ($tours as $tour) {
            if ($tour->departures->isNotEmpty()) {
                $nearestDeparture = $tour->departures->first(); // Lấy ngày khởi hành gần nhất của tour đầu tiên
                break; // Nếu đã tìm thấy ngày khởi hành gần nhất, thoát vòng lặp
            } 
        }
        $tourfroms = $tours->unique('tour_from');
        $type_tour_id=$tours->pluck('type_id')->toArray();

        //tour-sale
        $tour_id=$tours->pluck('id')->toArray();
        $tour_sales=Discount::whereIn('tour_id',$tour_id)->get();

        //rating
        $rating_tour_id=$tours->pluck('id')->toArray();
        $rating=Rating::whereIn('tour_id',$rating_tour_id)->get();
        $groupedRatings = $rating->groupBy('tour_id');
        $avg_rating = $groupedRatings->map(function ($group) {
            return $group->avg('rating');
        });
    
        foreach ($tours as $tour) {
            // Nếu tour_id có trong danh sách tính trung bình đánh giá, gán avg_rating cho tour
            $tourId = $tour->id; // Hoặc $tour->tour_id nếu cần
            // Nếu tour_id có trong danh sách tính trung bình đánh giá, gán avg_rating cho tour
            $tour->avg_rating = isset($avg_rating[$tourId]) ? $avg_rating[$tourId] : 0;
           
        }
        // dd($tours);
        $typetours=Type::whereIn('id',$type_tour_id)->get();
        $tour_to=Category::whereNotIn('id', [5, 6])->orderBy('title', 'asc')->get();
        if(Session::get('customer_id')){
            $likes=Like::where('customer_id',Session::get('customer_id'))->get();
            return view('pages.tour_sale',compact('tours','nearestDeparture','category','likes','tourfroms','typetours','tour_to','tour_sales'));
        }
        else{
             return view('pages.tour_sale',compact('tours','nearestDeparture','category','tourfroms','typetours','tour_to','tour_sales'));
        } 
    }
}
