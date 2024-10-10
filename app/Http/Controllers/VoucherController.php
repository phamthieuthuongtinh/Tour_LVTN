<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers=Voucher::Orderby('id',"DESC")->where('status',1)->get();
        return view('admin.vouchers.index',compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'voucher_name'=>'required',
            'voucher_code'=>'required|unique:vouchers|max:20',
            'voucher_time'=>'required',
            'voucher_condition'=>'required',
            'voucher_number'=>'required',
        ],[
            'voucher_name.required'=>'Bạn chưa nhập tên cho voucher',
            'voucher_code.required'=>'Bạn chưa nhập mã cho voucher',
            'voucher_code.unique'=>'Mã voucher đã có',
            'voucher_time.required'=>'Bạn chưa nhập số lượt dùng cho voucher',
            'voucher_condition.required'=>'Bạn chưa chọn loại cho voucher',
            'voucher_number.required'=>'Bạn chưa nhập giá trị giảm cho voucher',
        ]);
        $voucher= new Voucher();
        $voucher->voucher_name=$data['voucher_name'];
        $voucher->voucher_code=$data['voucher_code'];
        $voucher->voucher_time=$data['voucher_time'];
        $voucher->voucher_condition=$data['voucher_condition'];
        $voucher->voucher_number=$data['voucher_number'];
        $voucher->status=1;
        $voucher->save();
        toastr()->success('Tạo voucher thành công');
        return redirect()->route('vouchers.index');
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
        $voucher=Voucher::where('id',$id)->first();
        return view('admin.vouchers.edit',compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'voucher_name'=>'required',
            'voucher_code'=>'required|max:20',
            'voucher_time'=>'required',
            'voucher_condition'=>'required',
            'voucher_number'=>'required',
        ],[
            'voucher_name.required'=>'Bạn chưa nhập tên cho voucher',
            'voucher_code.required'=>'Bạn chưa nhập mã cho voucher',
            'voucher_time.required'=>'Bạn chưa nhập số lượt dùng cho voucher',
            'voucher_condition.required'=>'Bạn chưa chọn loại cho voucher',
            'voucher_number.required'=>'Bạn chưa nhập giá trị giảm cho voucher',
        ]);
        $voucher= Voucher::find($id);
        $voucher->voucher_name=$data['voucher_name'];
        $voucher->voucher_code=$data['voucher_code'];
        $voucher->voucher_time=$data['voucher_time'];
        $voucher->voucher_condition=$data['voucher_condition'];
        $voucher->voucher_number=$data['voucher_number'];
        $voucher->save();
        toastr()->success('Cập nhật voucher thành công');
        return redirect()->route('vouchers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher=Voucher::find($id);
        $voucher->status=0;
        $voucher->save();
        toastr()->success('Xóa voucher thành công!');
        return redirect()->back();
    }
    public function check_voucher(Request $request){
        $vouchercode = $request->input('voucher_code');
        $voucher = Voucher::where('voucher_code', $vouchercode)->first();
        if ($voucher) {
            Session::put('voucher', $voucher);
            return response()->json([
                'voucher' => $voucher,
                'message' => 'Thêm mã giảm giá thành công!'
            ]);
        } else {
            return response()->json(['message' => 'Mã giảm giá không đúng!'], 400);
        }
    }
}
