<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\Itinerarydetail;
use App\Models\Tour;


class ItineraryController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'location' => 'required',
        'description' => 'required',
        'day_number' => 'required',
        'image'=>'required',
        'tour_id' => 'required',
        'details.*.descriptions.*' => 'required',
        'details.*.images.*' => 'nullable|image' // Thay đổi `nullable` nếu hình ảnh không bắt buộc
    ]);

    $itinerary = new Itinerary();
    $itinerary->tour_id = $data['tour_id'];
    $itinerary->day_number = $data['day_number'];
    $itinerary->location = $data['location'];
    $itinerary->description = $data['description'];
    if (isset($data['image'])) {
         
        $get_image = $data['image'];
        $path = 'upload/tours/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);

        $itinerary->image = $new_image;

    }
    $itinerary->save();

    // Lưu từng mô tả và hình ảnh cho ngày cụ thể
    if (isset($data['details'])) {
        foreach ($data['details'] as $details) {
            foreach ($details['descriptions'] as $index => $description) {
                $itineraryDetail = new ItineraryDetail();
                $itineraryDetail->ite_id = $itinerary->id;
                $itineraryDetail->day_number = $data['day_number'];
                $itineraryDetail->description = $description;

                if (isset($details['images'][$index])) {
                    $get_image = $details['images'][$index];
                    $path = 'upload/tours/';
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move($path,$new_image);

                    $itineraryDetail->image = $new_image;
                }

                $itineraryDetail->save(); // Đừng quên gọi save() để lưu dữ liệu
            }
        }
    }

    // Thông báo và chuyển hướng nếu cần
    toastr()->success('Cập nhật lịch trình thành công!');
    return redirect()->back();
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tour_id=$id;
        $tour=Tour::where('id',$tour_id)->first();
        $itineraries = Itinerary::where('tour_id', $tour_id)->get();
        $itineraryDetails = ItineraryDetail::whereIn('ite_id', $itineraries->pluck('id'))->get()->groupBy('day_number');
        return view('admin.itineraries.show', compact('itineraries', 'tour_id', 'tour','itineraryDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tour_id=$id;
        $tour=Tour::where('id',$tour_id)->first();
        $itineraries = Itinerary::where('tour_id', $tour_id)->get();
        return view('admin.itineraries.edit',compact('tour','tour_id','itineraries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
    
        $itineraryDetail = ItineraryDetail::findOrFail($id);
        $itineraryDetail->description = $request->description;
    
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            
            
            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('images', 'public');
            $itineraryDetail->image = $imagePath;
        }
    
        $itineraryDetail->save();
    
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function add( string $day_number,string $id)
    {
        $day_number=$day_number;
        $tour_id=$id;
        $tour=Tour::where('id',$id)->first();
        $itineraries = Itinerary::where('tour_id', $id)->get();
        return view('admin.itineraries.create',compact('tour','tour_id','itineraries','day_number'));
    }
    public function change( string $tour_id,string $day_number)
    {
        $day_number=$day_number;
       
        $tour=Tour::where('id',$tour_id)->first();
        $itineraries = Itinerary::where('tour_id', $tour_id)->where('day_number',$day_number)->first();
        $itineraryDetails = Itinerarydetail::where('ite_id', $itineraries->id)->where('day_number',$day_number)->get();
        return view('admin.itineraries.edit',compact('tour','tour_id','itineraries','day_number','itineraryDetails'));
    }
    public function update_itinerary(Request $request, string $tour_id,string $day_number){
        $itinerary = Itinerary::where('tour_id', $tour_id)->where('day_number',$day_number)->first();
        $data=$request->all();
        $itinerary->location=$data['location'];
        $itinerary->description=$data['description'];
       
        if (isset($data['image'])) {
         
            $get_image = $data['image'];
            $path = 'upload/tours/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);

            $itinerary->image = $new_image;

        }
         $itinerary->save();
        // if (isset($data['details'])) {
        //     foreach ($data['details'] as $details) {
        //         foreach ($details['descriptions'] as $index => $description) {
        //             $itineraryDetail = new ItineraryDetail();
        //             $itineraryDetail->ite_id = $itinerary->id;
        //             $itineraryDetail->day_number = $data['day_number'];
        //             $itineraryDetail->description = $description;
    
        //             if (isset($details['images'][$index])) {
        //                 $get_image = $details['images'][$index];
        //                 $path = 'upload/tours/';
        //                 $get_name_image = $get_image->getClientOriginalName();
        //                 $name_image = current(explode('.',$get_name_image));
        //                 $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        //                 $get_image->move($path,$new_image);
    
        //                 $itineraryDetail->image = $new_image;
        //             }
    
        //             $itineraryDetail->save(); // Đừng quên gọi save() để lưu dữ liệu
        //         }
        //     }
        // }
    
        // Thông báo và chuyển hướng nếu cần
        toastr()->success('Cập nhật lịch trình thành công!');
        return redirect()->back();
    }
    public function destroy_itinerarydetail(string $id){
        $itinerayDetail=Itinerarydetail::find($id);
        $itinerayDetail->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->back();
    }

    public function edit_itinerayDetail(Request $request, string $id){
        $itinerary = Itinerarydetail::where('id', $id)->first();
        $data=$request->all();
        $itinerary->description=$data['description'];
        $itinerary->image_name=$data['image_name'];

        if (isset($data['image'])) {
         
                        $get_image = $data['image'];
                        $path = 'upload/tours/';
                        $get_name_image = $get_image->getClientOriginalName();
                        $name_image = current(explode('.',$get_name_image));
                        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                        $get_image->move($path,$new_image);
    
                        $itinerary->image = $new_image;
           
        }
        $itinerary->save();
        // Thông báo và chuyển hướng nếu cần
        toastr()->success('Cập nhật lịch trình thành công!');
        return redirect()->back();
    }
    public function show_itinerayDetail(Request $request, string $id){
        $itinerayDetail=Itinerarydetail::where('id',$id)->first();
  
        return view('admin.itineraries.showdetail',compact('itinerayDetail'));
 
    }
   

}
