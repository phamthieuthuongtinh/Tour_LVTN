<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Type;
use App\Models\Departure;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Rating;
use App\Models\Itinerary;
use App\Models\Service;
use App\Models\Like;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Orderdetail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class ToursController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if(Auth::user()->id!=1){
            $tours=Tour::with('category')->with('user')->with('type')->where('business_id',Auth::user()->id)->Orderby('status','ASC')->get();
        }
        else{
            $tours=Tour::with('category')->with('user')->with('type')->Orderby('status','ASC')->get();
        }
        return view('admin.tours.index',compact('tours'));
    }
    public function admin_index_tour()
    {   
  
        $tours=Tour::with('category')->with('user')->with('type')->where('status',2)->orwhere('status',3)->Orderby('status','ASC')->get();
    
        return view('admin.tours.admin_index',compact('tours'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('category_parent', '!=', 0)
    ->where('status', 1)
    ->orderBy('id', 'ASC')
    ->get();

        $types= Type::Orderby('id','ASC')->where('status',1)->get();
        return view('admin.tours.create',compact('categories','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:tours|max:255',
            'description' => 'required',
           
            'category_id' => 'required',
            'type_id' => 'required',
            'price' => 'required',
            'price_treem' => 'required',
            'price_trenho' => 'required',
            'price_sosinh' => 'required',
            'vehicle' => 'required',
            'tour_from' => 'required',
            'tour_to' => 'required',
            'image' => 'required',
           
            'business_id' => 'required',
            'so_ngay' => 'required',
            'so_dem' => 'required',
        ],[
            'title.required' => 'Bạn chưa nhập tiêu đề',
            'title.unique' => 'Tiêu đề này đã có',
            'description.required' => 'Bạn chưa nhập mô tả',
            'tour_cost.required' => 'Bạn chưa nhập chi phí tour',
            'price.required' => 'Bạn chưa nhập giá',
            'vehicle.required' => 'Bạn chưa nhập phương tiện',
            'tour_from.required' => 'Bạn chưa nhập nơi xuất phát',
            'tour_to.required' => 'Bạn chưa nhập nơi đến',
            'image.required' => 'Bạn chưa chọn hình ảnh',
    

            'so_ngay.required' => 'Bạn chưa nhập số ngày',
            'so_dem.required' => 'Bạn chưa nhập số đêm',
            
        ]);
        $tour = new Tour();
        $tour->title = $data['title'];
        $tour->description = $data['description'];
        $tour->status = 1;
      
        $tour->category_id = $data['category_id'];
        $tour->type_id = $data['type_id'];
        $tour->price = $data['price'];
        $tour->price_treem = $data['price_treem'];
        $tour->price_trenho = $data['price_trenho'];
        $tour->price_sosinh = $data['price_sosinh'];
        $tour->vehicle = $data['vehicle'];
        $tour->so_ngay = $data['so_ngay'];
        $tour->so_dem = $data['so_dem'];
        $tour->tour_from = $data['tour_from'];
        $tour->tour_to = $data['tour_to'];
        $tour->business_id = $data['business_id'];
        $tour->slug =  Str::slug($data['title']);
        $tour->tour_code =  rand(0000,9999);
        
        $get_image = $request->image;
        $path = 'upload/tours/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $tour->image= $new_image;
        toastr()->success('Tạo tour thành công!');
        $tour->save();
        return redirect()->route('tours.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function xem(string $id)
    {

        $tour= Tour::where('id',$id)->with('category')->with('type')->first();
        $departures=Departure::where('tour_id',$id)->where('status',1)->where('departure_date', '>=', Carbon::today())->orderBy('departure_date', 'ASC')->get();
        $service = Service::where('tour_id', $tour->id)->first();
        $itineraries = Itinerary::where('tour_id', $tour->id)->orderby('day_number', 'ASC') ->get();

        return view('admin.tours.info_tour_admin',compact('tour','departures','itineraries','service')); 
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories= Category::Orderby('id','DESC')->get();
        $types= Type::Orderby('id','ASC')->where('status',1)->get();
        $tour= Tour::find($id);
        return view('admin.tours.edit',compact('tour','categories','types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
         
            'category_id' => 'required',
            'type_id' => 'required',
            'price' => 'required',
            'price_treem' => 'required',
            'price_trenho' => 'required',
            'price_sosinh' => 'required',
            'vehicle' => 'required',
            'so_ngay' => 'required',
            'so_dem' => 'required',
            'tour_from' => 'required',
            'tour_to' => 'required',
            'business_id' => 'required',
            
            
        ],[
            'title.required' => 'Bạn chưa nhập tiêu đề',
            'title.unique' => 'Tiêu đề này đã có',
            'description.required' => 'Bạn chưa nhập mô tả',
           'tour_cost.required' => 'Bạn chưa nhập chi phí tour',
            'price.required' => 'Bạn chưa nhập giá',
            'vehicle.required' => 'Bạn chưa nhập phương tiện',
            'so_ngay.required' => 'Bạn chưa nhập số ngày',
            'so_dem.required' => 'Bạn chưa nhập số đêm',
            'tour_from.required' => 'Bạn chưa nhập nơi xuất phát',
            'tour_to.required' => 'Bạn chưa nhập nơi đến',
       
            
        ]);
        $tour = Tour::find($id);
        $tour->title = $data['title'];
        $tour->description = $data['description'];
        $tour->status = 1;

        $tour->category_id = $data['category_id'];
        $tour->type_id = $data['type_id'];
        $tour->price = $data['price'];
        $tour->price_treem = $data['price_treem'];
        $tour->price_trenho = $data['price_trenho'];
        $tour->price_sosinh = $data['price_sosinh'];
        $tour->vehicle = $data['vehicle'];
        $tour->so_ngay = $data['so_ngay'];
        $tour->so_dem = $data['so_dem'];
        $tour->tour_from = $data['tour_from'];
        $tour->tour_to = $data['tour_to'];
        $tour->business_id = $data['business_id'];
        $tour->slug =  Str::slug($data['title']);
        $tour->tour_code = $tour->tour_code;
        
        $get_image = $request->image;
        if($get_image){
            $path = 'upload/tours/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $tour->image= $new_image;
        }
        
        toastr()->success('Cập nhật tour thành công!');
        $tour->save();
        return redirect()->route('tours.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour= Tour::find($id);
        if($tour->status==0){
            $tour->status=1;
            toastr()->success('Khôi phục tour thành công!');
        }else{
            $tour->status=0;
            toastr()->success('Xoá tour thành công!');
        }
        
        $tour->save();
        
        return redirect()->route('tours.index');
    }
    public function tour($slug){
        $category= Category::where('slug',$slug)->first();
        $tours= Tour::where('category_id',$category->id)->where('status',3)->with('category')->with(['departures' => function($query) {
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
            return view('pages.tour',compact('tours','nearestDeparture','category','likes','tourfroms','typetours','tour_to','tour_sales'));
        }
        else{
             return view('pages.tour',compact('tours','nearestDeparture','category','tourfroms','typetours','tour_to','tour_sales'));
        } 
    }
    public function detail_tour($slug){
        
        $tour = Tour::where('slug', $slug)->with('category')->with('type')->first();
        $sale=Discount::where('tour_id',$tour->id)->first();
        // dd($tour);
        //thông tin dịch vụ, comment, reply, đánh giá, danh sách ngày khởi hành, ngày khởi hành gần nhất của tour
        $service = Service::where('tour_id', $tour->id)->first();
        $comments = Comment::where('comment_tour_id', $tour->id)->where('status','!=',2)->whereNull('comment_parent_comment')->get();
        $reply=Comment::where('comment_tour_id',$tour->id)->where('status',1)->whereNotNull('comment_parent_comment')->get();
        $ratings=Rating::where('tour_id',$tour->id)->get();
        $departures=Departure::where('tour_id',$tour->id)->where('departure_date', '>=', Carbon::today())->orderby('departure_date','ASC')->get();
        $nearestDeparture = $departures->filter(function($depart) {
            return Carbon::parse($depart->departure_date) >= Carbon::today();
        })->sortBy('departure_date')->first();


         // Lấy thông tin lịch trình
         $itineraries = Itinerary::where('tour_id', $tour->id)->orderby('day_number', 'ASC') ->get();

         // Các tour liên quan      
        $relate= Tour::where('category_id',$tour->category_id)->where('id', '!=', $tour->id)->with('category')->with(['departures' => function($query) {
            $query->where('status',1)->where('departure_date', '>=', Carbon::today())
                  ->orderBy('departure_date', 'ASC');
        }])->take(3)->get();
        //Ngày gần nhất cho tour liên quan
        $rating_tour_id=$relate->pluck('id')->toArray();
        //rating
        $rating=Rating::whereIn('tour_id',$rating_tour_id)->get();
        $groupedRatings = $rating->groupBy('tour_id');
        $avg_rating = $groupedRatings->map(function ($group) {
            return $group->avg('rating');
        });
       
        foreach ($relate as $to) {
            // Nếu tour_id có trong danh sách tính trung bình đánh giá, gán avg_rating cho tour
            $tourId = $to->id; // Hoặc $tour->tour_id nếu cần
            // Nếu tour_id có trong danh sách tính trung bình đánh giá, gán avg_rating cho tour
            $to->avg_rating = isset($avg_rating[$tourId]) ? $avg_rating[$tourId] : 0;
           
        }
        foreach ($relate as $relatedTour) {
            $nearestRelatedDeparture = $relatedTour->departures->filter(function($depart) {
                return Carbon::parse($depart->departure_date) >= Carbon::today();
            })->sortBy('departure_date')->first();
        
            // Gán ngày khởi hành gần nhất vào một thuộc tính mới
            $relatedTour->nearest_departure = $nearestRelatedDeparture;
        }
       

            // Lấy chi tiết từng hoạt động
            // $itineraryDetails = ItineraryDetail::whereIn('ite_id', $itineraries->pluck('id'))
            //             ->get()
            //             ->groupBy('ite_id');

            // // Nhóm dữ liệu lịch trình theo ngày
            // $itinerariesByDay = $itineraries->groupBy('day_number')->map(function ($items) use ($itineraryDetails) {
            // return $items->map(function ($itinerary) use ($itineraryDetails) {
            // $details = isset($itineraryDetails[$itinerary->id]) ? $itineraryDetails[$itinerary->id] : collect();
            // return [
            // 'location' => $itinerary->location,
            // 'description' => $itinerary->description,
            // 'details' => $details
            // ];
            // });
            // });
            //  dd( $relate);
        $tour_sales=Discount::whereIn('tour_id',$rating_tour_id)->get();
        $ordered=[];
        $customer_id=Session::get('customer_id');
        $ordered=Order::where('customer_id',$customer_id)->where('order_status',2)->get();
        $order_codes = $ordered->pluck('order_code')->toArray();
        $orderedetails = OrderDetail::whereIn('order_code', $order_codes)->with('tour')->with('order')->with('coupon')->get();
        $likes=Like::where('customer_id',$customer_id)->get();
        $gallery=Gallery::orderBy('id','DESC')->where('tour_id',$tour->id)->get();
        return view('pages.detailtour',compact('tour','departures','nearestDeparture','comments','reply','ratings','itineraries','service','relate','likes','gallery','tour_sales','sale','orderedetails'));
    }
    
    public function gui_duyet(String $id){
        $tour=Tour::find($id);
        if( $tour->status==1 || $tour->status==4){
            $tour->status=2;
             $tour->save();
            toastr()->success('Gửi duyệt thành công!');
            return redirect()->back();
        }
        else{
            $tour->status=1;
            $tour->save();
            toastr()->success('Hủy gửi duyệt thành công!');
            return redirect()->back();
        }
       
        
       
    }
    public function duyet(String $id){
        $tour=Tour::find($id);
        if($tour->status==2){
            $tour->status=3;
            $tour->save();
            toastr()->success('Duyệt thành công!');
            return redirect()->back();
        }
        else{
            $tour->status=2;
            $tour->save();
            toastr()->success('Bỏ duyệt thành công!');
            return redirect()->back();
        }
       
    }
    public function tuchoi_duyet(String $id){
        $tour=Tour::find($id);
        $tour->status=4;
        $tour->save();
        toastr()->success('Duyệt thành công!');
        return redirect()->back();
    }
    public function xoa(String $id){
        $tour=Tour::find($id);
        $tour->status=1;
        $tour->save();
        toastr()->success('Tour trở về trạng thái chưa gửi duyệt!');
        return redirect()->back();
    }

    public function manage_departure(){
        if(Auth::user()->id!=1){
            $tours=Tour::where('status',3)->where('business_id',Auth::user()->id)->orderby('id','desc')->get();
        }
        else{
            $tours=Tour::where('status',1)->orderby('id','desc')->get();
        }
       
        
        return view('admin.departures.index',compact('tours'));
    }
    public function manage_itinerary(){
        if(Auth::user()->id!=1){
            $tours=Tour::where('status',3)->where('business_id',Auth::user()->id)->orderby('id','desc')->get();
        }
        else{
            $tours=Tour::where('status',3)->orderby('id','desc')->get();
        }
        return view('admin.itineraries.index',compact('tours'));
    }
    public function manage_service(){
        if(Auth::user()->id!=1){
            $tours=Tour::where('status',3)->where('business_id',Auth::user()->id)->orderby('id','desc')->get();
        }
        else{
            $tours=Tour::where('status',3)->orderby('id','desc')->get();
        }
        
        
        return view('admin.services.index',compact('tours'));
    }
    public function tour_like(Request $request){
        $data=$request->all();
        $find_like=Like::where('customer_id',$data['customer_id'])->where('tour_id',$data['tour_id'])->first();
        if($find_like){
            $find_like->delete();
            return response()->json(['status' => 'removed', 'message' => 'Đã bỏ yêu thích!']);
        }else{
            $like=new Like();
            $like->customer_id=$data['customer_id'];
            $like->tour_id=$data['tour_id'];
            $like->save();  
            return response()->json(['status' => 'added', 'message' => 'Đã thêm vào yêu thích!']);
        }
           
       
    }
}
