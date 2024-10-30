<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Tour;
use App\Models\Type;
use App\Models\Category;
use App\Models\Stafftour;
use App\Models\Departure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class StaffController extends Controller
{
    /**
     * sex: 0:nam, 1: nữ
     * position: 0:hướng dẫn viên du lịch,
     */
    public function index()
    {
        if(Auth::user()->id==1){
             $staffs=Staff::where('status',1)->orderBy('id','DESC')->get();
        }else{
            $staffs=Staff::where('status',1)->where('business_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
       
        return view('admin.staffs.index',compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:staffs',
            'sex' => 'required',
            'position' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'required',
            'salary' => 'required',
            'hireday' => 'required',
            
            'birthday' => 'required',
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email này đã có',
            'sex.required' => 'Bạn chưa chọn giới tính',
            'position.required' => 'Bạn chưa chọn vị trí làm việc',
            'phone.required' => 'Bạn chưa nhập sdtc',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'image.required' => 'Bạn chưa chọn hình ảnh',
            'salary.required' => 'Bạn chưa nhập lương',
            'hireday.required' => 'Bạn chưa nhập ngày bắt đầu làm việc',
            'birthday.required' => 'Bạn chưa nhập ngày sinh',
        ]);
        $staff = new Staff();
        $staff->name = $data['name'];
        $staff->email = $data['email'];
        $staff->sex = $data['sex'];
        $staff->position = $data['position'];
        $staff->phone = $data['phone'];
        $staff->address = $data['address'];
        $staff->salary = $data['salary'];
        $staff->hireday = $data['hireday'];
        $staff->birthday = $data['birthday'];
        $staff->status = 1;
        $staff->business_id = Auth::user()->id;
        
        $get_image = $request->image;
        $path = 'upload/staffs/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $staff->image= $new_image;

        $staff->save();
        toastr()->success('Thêm danh nhân viên thành công!');
        return redirect()->route('staffs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $staff=Staff::find($id);
        return view('admin.staffs.show',compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staff=Staff::find($id);
        return view('admin.staffs.edit',compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:staffs',
            'sex' => 'required',
            'position' => 'required',
            'phone' => 'required',
            'address' => 'required',
           
            'salary' => 'required',
            'hireday' => 'required',
            
            'birthday' => 'required',
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email này đã có',
            'sex.required' => 'Bạn chưa chọn giới tính',
            'position.required' => 'Bạn chưa chọn vị trí làm việc',
            'phone.required' => 'Bạn chưa nhập sdtc',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'salary.required' => 'Bạn chưa nhập lương',
            'hireday.required' => 'Bạn chưa nhập ngày bắt đầu làm việc',
            'birthday.required' => 'Bạn chưa nhập ngày sinh',
        ]);
        $staff=Staff::find($id);
        $staff->name = $data['name'];
        $staff->email = $data['email'];
        $staff->sex = $data['sex'];
        $staff->position = $data['position'];
        $staff->phone = $data['phone'];
        $staff->address = $data['address'];
        $staff->salary = $data['salary'];
        $staff->hireday = $data['hireday'];
        $staff->birthday = $data['birthday'];
        $staff->status = 1;
        $staff->business_id = Auth::user()->id;
        if($request->image){
            $get_image = $request->image;
            $path = 'upload/staffs/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $staff->image= $new_image;
        }
        $staff->save();
        toastr()->success('Cập nhật nhân viên thành công!');
        return redirect()->route('staffs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff=Staff::find($id);
        $staff->status=0;
        $staff->save();
        toastr()->success('Xóa thành công!');
        return redirect()->route('staffs.index');
    }
    public function manage_task(string $id){
        $staff=Staff::find($id);
        $stafftours=Stafftour::where('staff_id',$id)->with('tour')->orderby('departure_date','ASC')->get();
        $tour=null;
        $type=null;
        $category=null;
        $departure=null;
        $now= Carbon::now();
        if(Auth::user()->id!=1){
            $tour=Tour::where('business_id',Auth::user()->id)->where('status',3)->orderBy('id',"DESC")->get();
            $type=Type::where('status',1)->get();
            $category=Category::where('status',1)->get();
            $tour_id=$tour->pluck('id')->toArray();
            $departure=Departure::whereIn('tour_id',$tour_id)->where('status',1)->where('departure_date','>',$now)->orderby('tour_id','ASC')->get();
        }
        return view('admin.staffs.manage_task',compact('tour','type','category','staff','departure','stafftours'));
    }

    public function add_task(Request $request){
        $data = $request->validate([
            'tour_id' => 'required',
            'staff_id' => 'required',
            'departure_date' => 'required',
           
        ],[
            'tour_id.required' => 'Bạn chưa chọn tour',
            'staff_id.required' => 'Bạn chưa có nhân viên',
            'departure_date.required' => 'Bạn chưa chọn ngày',
           
        ]);
        $exists = Stafftour::where('tour_id', $data['tour_id'])->where('staff_id', $data['staff_id'])->where('departure_date', $data['departure_date'])->exists();

        if ($exists) {
            return back()->withErrors(['departure_date' => 'Nhân viên đã có lịch làm việc vào ngày này cho tour này.']);
        }

        $stafftour = new Stafftour();
        $stafftour->tour_id = $data['tour_id'];
        $stafftour->staff_id = $data['staff_id'];
        $stafftour->departure_date = $data['departure_date'];
      
        $stafftour->status = 1;
        $stafftour->save();
        toastr()->success('Thêm lịch thành công!');
        return redirect()->back();
    }
    public function destroy_task(string $id)
    {
        $staff=Stafftour::find($id);
        if( $staff->status==0){
            $staff->status=1;
            $staff->save();
            toastr()->success('Khôi phục thành công!');
        }else{
            $staff->status=0;
            $staff->save();
            toastr()->success('Xóa thành công!');
        }
        return redirect()->back();
    }
}
