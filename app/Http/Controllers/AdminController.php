<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Business;
use App\Models\Departure;
use App\Models\Customer;
use App\Models\Rating;
use App\Models\Itinerary;
use App\Models\Service;
use App\Models\Itinerarydetail;
use App\Models\Register;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function business_manage(){
        $registers=Register::where('status','!=',0)->orderby('status','ASC')->get();
        return view('admin.businesses.index',compact('registers'));
    }
    public function customer_manage(){
        $customers=Customer::where('status','!=',0)->orderby('status','ASC')->get();
        return view('admin.customers.admin_index',compact('customers'));
    }
    public function destroy_customer(String $id){
        $customer= Customer::where('customer_id',$id)->first();
        if($customer->status==1){
            $customer->status=0;
            $customer->save();
            toastr()->success('Xóa tài khoản thành công!');
        }else{
            $customer->status=1;
            $customer->save();
            toastr()->success('Khôi phục tài khoản thành công!');
        }
        return redirect()->back();
    }
    public function edit_register(String $id)
    {
        $register=Register::where('id',$id)->first();
        return view('admin.businesses.edit',compact('register'));
    }
    public function create_account_business(Request $request)
    {
        try {
            // Validate input data
            $data = $request->validate([
                'email' => 'required|unique:users|max:255',
                'company_name' => 'required',
                'register_id' => 'required',
                'password1' => 'required',
                
                'password2' => 'required|same:password1',
            ], [
                'email.required' => 'Bạn chưa nhập Email',
                'email.unique' => 'Email này đã được sử dụng',
                'company_name.required' => 'Bạn chưa nhập tên',
                'password1.required' => 'Bạn chưa nhập mật khẩu',
                'password2.required' => 'Bạn chưa nhập lại mật khẩu',
                'password2.same' => 'Mật khẩu nhập lại không khớp',
            ]);

            // Create new Customer instance
            $user = new User();
            $user->email = $data['email'];
            $user->name = $data['company_name'];
            $user->password = $data['password1'];
            $user->role = 'business';
            $user->status = 1;
            // Save customer to database
            $user->save();


            $register=Register::where('id',$data['register_id'])->first();
            $register->status=2;
            $register->save();
            $business= new Business();
            $business->user_id=$user->id;
            $business->address=$register->address;
            $business->phone=$register->phone;
            $business->save();
            // Success message
            toastr()->success('Tạo tài khoản thành công!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('admin.business_manage');

        } catch (ValidationException $e) {
            toastr()->error('Tạo tài khoản không thành công! Vui lòng kiểm tra lại thông tin.',['positionClass' => 'toast-bottom-right']);
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            toastr()->error('Tạo tài khoản không thành công!',['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        }

    }
    // public function accept_register(String $id)
    // {
    //     $register=Register::where('id',$id)->first();
    //    $register->status=2;
    //    $register->save();
    //    toastr()->success('Duyệt thành công!');
    //     return redirect()->back();
    // }
    public function boduyet_register(String $id)
    {
        $register=Register::find($id);
        $register->status=1;
        $register->save();
        $user=User::where('email',$register->email)->first();
        $business=Business::where('user_id',$user->id)->first();
        $business->delete();
        $user->delete();
        toastr()->success('Đã bỏ duyệt thành công!');
        return redirect()->back();
    }
    public function refuse_register(String $id)
    {
        $register=Register::find($id);
        $register->status=0;
        $register->save();
        toastr()->success('Đã từ chối thành công!');
        return redirect()->back();
    }
}
