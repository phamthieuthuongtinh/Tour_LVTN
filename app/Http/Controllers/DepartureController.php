<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departure;

class DepartureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $data=$request->validate([
            'departure_date'=>'required',
            'quantity'=>'required',
            'tour_id'=>'required',
        ],[
            'departure_date.required'=>'Bạn chưa chọn ngày khởi hành',
            'quantity.required'=>'Bạn chưa nhập số lượng người'
        ]);
         // Kiểm tra xem ngày khởi hành đã tồn tại cho cùng tour_id hay chưa
        $departure_isset=Departure::where('tour_id',$data['tour_id'])->first();
        if($departure_isset){
             $existingDeparture = Departure::where('tour_id', $data['tour_id']) ->where('departure_date', $data['departure_date']) ->exists();
             if ($existingDeparture) {
                return redirect()->back()->withErrors(['departure_date' => 'Ngày khởi hành này đã có']);
            }
        }

        $departure= new Departure();
        $departure->tour_id=$data['tour_id'];
        $departure->departure_date=$data['departure_date'];
        $departure->quantity=$data['quantity'];
        $departure->status=1;
        $departure->save();
        toastr()->success('Thêm ngày khởi hành thành công!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $tour_id=$id;
        $departures= Departure::where('tour_id',$id)->orderby('departure_date','DESC')->get();
        return view('admin.departures.edit',compact('departures','tour_id'));
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

        $departure=Departure::find($id);
        if($departure->status==0 ){
            $departure->status=1;
        }
        else{
             $departure->status=0;
        }
        $departure->save();
        toastr()->success('Cập nhật thành công!');
        return redirect()->back();
    }
}
