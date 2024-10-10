<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class BusinessController extends Controller
{
    public function register_business()
    {
       return view('pages.register_business');
    }
    public function store_register(Request $request)
    {
        try {
            // Validate input data
            $data = $request->validate([
                'email' => 'required|unique:registers|max:255',
                'name' => 'required',
                'phone' => 'required|max:220',
                'address' => 'required|max:255',
             
            ], [
                'email.required' => 'Bạn chưa nhập Email',
                'email.unique' => 'Email này đã được sử dụng',
                'name.required' => 'Bạn chưa nhập tên',
                'phone.required' => 'Bạn chưa nhập số điện thoại',
                'address.required' => 'Bạn chưa nhập địa chỉ',
            ]);

            // Create new Customer instance
            $register = new Register();
            $register->email = $data['email'];
            $register->phone = $data['phone'];
            $register->company_name = $data['name'];
            $register->address = $data['address'];
            $register->status = 1;

            // Save customer to database
            $register->save();

            // Success message
            toastr()->success('Đăng ký thành công! Chúng tôi sẽ sớm liên hệ với quý công ty',['positionClass' => 'toast-bottom-right']);
            return redirect()->back();

        } catch (ValidationException $e) {
            toastr()->error('Đăng ký không thành công! Vui lòng kiểm tra lại thông tin đăng ký.',['positionClass' => 'toast-bottom-right']);
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            toastr()->error('Đăng ký không thành công!',['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        }
    }
}
