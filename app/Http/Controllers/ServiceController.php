<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Tour;
class ServiceController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'include' => 'required',
            'not_include' => 'required',
            
            'tour_id' => 'required',
           
        ],[
            'include.required' => 'Bạn chưa nhập dịch vụ bao gồm',
            'not_include.unique' => 'Tiêu đề này dịch vụ không bao gồm',
        ]);
        $service = new Service();
        $service->include = $data['include'];
        $service->not_include = $data['not_include'];
        $service->tour_id = $data['tour_id'];
        toastr()->success('Thêm thành công!');
        $service->save();
        return redirect()->back();
      
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
        $tour= Tour::find($id);
        $service= Service::where('tour_id',$tour->id)->Orderby('id','DESC')->first();
        return view('admin.services.edit',compact('tour','service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'include' => 'required',
            'not_include' => 'required',
            
            'tour_id' => 'required',
           
        ],[
            'include.required' => 'Bạn chưa nhập dịch vụ bao gồm',
            'not_include.unique' => 'Tiêu đề này dịch vụ không bao gồm',
        ]);
        $service = Service::find($id);
        $service->include = $data['include'];
        $service->not_include = $data['not_include'];
        toastr()->success('Cập nhật thành công!');
        $service->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
