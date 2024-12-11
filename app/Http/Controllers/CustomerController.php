<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Departure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Recommend;
use App\Models\Like;
use App\Models\Tour;
use App\Models\Type;
use App\Models\Member;
use App\Models\Discount;
use Carbon\Carbon;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        
        $email = $request->email;
        $password =$request->password;
        $customer = Customer::where('email', $email)->first();
        

        if ($customer && Hash::check($password, $customer->password)) {
            Session::put('customer_id', $customer->customer_id);
            Session::put('customer_name', $customer->customer_name);
            Session::put('customer_phone', $customer->phone);
            Session::put('customer_email', $customer->email);
            if( $customer->hobby!=null){
                $recommend= Recommend::where('customer_id',$customer->customer_id)->first();
               
                if($recommend!=null && $recommend->created_at){
                    $currentDate = now();
                    $createdAt = $recommend->updated_at;
                 
                    if ($createdAt->diffInWeeks($currentDate) >= 2) {
                        
                        $customerPreference=$customer->hobby;
                        
                        $result = $this->analyzePreferences($customerPreference);
                     
                       
                        $typeIds = Type::whereIn('type_name', $result)->pluck('id');
                        $recommends = Tour::whereIn('type_id', $typeIds)->get();
                        $recommendTourIds = $recommends->pluck('id')->toArray(); // Get array of tour IDs
                        // Convert the array to a comma-separated string
                        $recommendTourIdsString = implode(',', $recommendTourIds);
                        $recommend->recommend = $recommendTourIdsString;
                        $recommend->updated_at = now();
                        $recommend->save();
                    }
                }
                if($recommend==null){
                    $customerPreference=$customer->hobby;
                    $result = $this->analyzePreferences($customerPreference);
                 
                   
                    $typeIds = Type::whereIn('type_name', $result)->pluck('id');
                    $recommends = Tour::whereIn('type_id', $typeIds)->get();
                    $recommendTourIds = $recommends->pluck('id')->toArray(); // Get array of tour IDs
                    // Convert the array to a comma-separated string
                    $recommendTourIdsString = implode(',', $recommendTourIds);
                    $recommend2=new Recommend();
                    $recommend2->customer_id= $customer->customer_id;
                    
                    $recommend2->recommend = $recommendTourIdsString;
                    $recommend2->save();
                }
            }

            toastr()->success('Đăng nhập thành công!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('homeweb');
        } else {
            toastr()->error('Tài khoản hoặc mật khẩu không chính xác!',['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        }
    }
    public function logout(){
        Session::invalidate(); 
        return redirect()->route('login_customer'); // Chuyển hướng về trang chủ
    }
    public function infor(string $id){
        $customer=Customer::where('customer_id',$id)->first();
        return view('admin.customers.infor_customer',compact('customer'));
    }
    public function ordered(string $id){
        $customer=Customer::where('customer_id',$id)->first();
        $ordereds=Order::where('customer_id',$id)->where('order_status','!=',0)->get();
        $order_codes = $ordereds->pluck('order_code')->toArray();
        $orderdetails = OrderDetail::whereIn('order_code', $order_codes)->with('tour')->with('order')->with('coupon')->get();
        $now = Carbon::now();
        // Danh sách thành viên cho các đơn
        foreach($orderdetails as $ord){
           
            $quantity= $ord->nguoi_lon + $ord->tre_em + $ord->tre_nho + $ord->so_sinh;
            $members = Member::where('order_code', $ord->order_code)->where('status',1)->get();
            $departure = Departure::where('tour_id', $ord->tour_id)->where('status',1)->where('quantity','>=',$quantity)->where('departure_date','>',$now)->orderby('departure_date','ASC')->get();
            $ord->members = $members;
            $ord->departure = $departure;

        }
       
        return view('admin.customers.ordered_customer',compact('ordereds','orderdetails','customer','now'));
    }
    public function update_order_date(Request $request,string $id){
        $order = Orderdetail::where('order_code',$id)->first();
        $departure=Departure::where('tour_id',$order->tour_id)->where('departure_date', $order->departure_date)->first();
        $quantity_order=$order->nguoi_lon+$order->tre_em+$order->tre_nho+$order->so_sinh;
        $departure->quantity+=$quantity_order;
        // Cập nhật ngày khởi hành
        $order->departure_date = $request->input('departure_date');
        $order->save();
        $departure->save();
        //update so luong
        $departure=Departure::where('tour_id',$order->tour_id)->where('departure_date', $order->departure_date)->first();
        $departure->quantity-=$quantity_order;
        $departure->save();
        return response()->json(['success' => true]);
       
       
    }
    public function liked(string $id){
        $likes=Like::where('customer_id',$id)->with('tour')->get();
        $tour_id=$likes->pluck('tour_id')->toArray();
        $tours=Tour::whereIn('id',$tour_id)->get();
        $tour_sales=Discount::whereIn('tour_id',$tour_id)->get();
        return view('admin.customers.liked_customer',compact('likes','tour_sales','tours'));
    }
    public function index()
    {
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
        try {
            // Validate input data
            $data = $request->validate([
                'email' => 'required|unique:customers|max:255',
                'name' => 'required',
                'phone' => 'required|max:220',
              
                'password1' => 'required',
                'password2' => 'required|same:password1',
            ], [
                'email.required' => 'Bạn chưa nhập Email',
                'email.unique' => 'Email này đã được sử dụng',
                'name.required' => 'Bạn chưa nhập tên',
                'phone.required' => 'Bạn chưa nhập số điện thoại',
                'password1.required' => 'Bạn chưa nhập mật khẩu',
                'password2.required' => 'Bạn chưa nhập lại mật khẩu',
                'password2.same' => 'Mật khẩu nhập lại không khớp',
            ]);

            // Create new Customer instance
            $customer = new Customer();
            $customer->email = $data['email'];
            $customer->phone = $data['phone'];
            $customer->age = $request->input('age', null);
            $customer->job = $request->input('job', null);
            $customer->hobby = $request->input('hobby', null);

            $customer->status = 1;
            $customer->customer_name = $data['name'];
            $customer->password = Hash::make($data['password1']);

            // Save customer to database
            $customer->save();
            if( !empty($request->input('hobby'))){
                $customerPreference = $request->input('hobby', null);
                $result = $this->analyzePreferences($customerPreference);
                $typeIds = Type::whereIn('type_name', $result)->pluck('id');
                $recommends = Tour::whereIn('type_id', $typeIds)->get();
                $recommendTourIds = $recommends->pluck('id')->toArray(); // Get array of tour IDs

                // Convert the array to a comma-separated string
                $recommendTourIdsString = implode(',', $recommendTourIds);
                $recommend=new Recommend();
                $recommend->customer_id= $customer->customer_id;
                
                $recommend->recommend = $recommendTourIdsString;
                $recommend->save();
            }
            // Success message
            toastr()->success('Đăng ký tài khoản thành công!',['positionClass' => 'toast-bottom-right']);
            return redirect()->back();

        } catch (ValidationException $e) {
            toastr()->error('Đăng ký không thành công! Vui lòng kiểm tra lại thông tin đăng ký.',['positionClass' => 'toast-bottom-right']);
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } 

    }
    public function analyzePreferences($text)
    {
        $scriptPath = base_path('public/python/nlp_analysis.py');
        $command = "python $scriptPath " . escapeshellarg($text);
        $output = shell_exec($command);
        $result = json_decode($output, true);
        return $result;
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
        $customer=Customer::where('customer_id',$id)->first();
        return view('admin.customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer=Customer::find($id);
        $data = $request->all();
        $customer->customer_name=$data['customer_name'];
        $customer->email=$data['email'];
        $customer->phone=$data['phone'];
        $customer->job=$data['job'];
        $customer->age=$data['age'];
        $customer->hobby=$data['hobby'];
        $customer->save();
        toastr()->success('Cập nhật thông tin thành công!');
        return view('admin.customers.infor_customer',compact('customer'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
    }
    public function showChangePasswordForm( string $id)
    {
        $customer=Customer::find($id);
        return view('admin.customers.changepass', compact('customer'));
    }
    
    public function changePassword(Request $request, string $id)
    {
        $data= $request->all();
        $customer=Customer::find($id);
        $current_password = Hash::make($data['current_password']);
        if (!Hash::check($data['current_password'], $customer->password)) {
            toastr()->error('Mật khẩu cũ không đúng!');
            return back();
        }
        else if($data['new_password_confirmation']==$data['new_password']){
            $customer->password= Hash::make($data['new_password']);
            $customer->save();
            toastr()->success('Thay đổi mật khẩu thành công!');
            return view('admin.customers.infor_customer',compact('customer'));
        }
        else{
            toastr()->error('Xác nhận mật khẩu mới không đúng!');
            return back();
        }
    }
    
}
