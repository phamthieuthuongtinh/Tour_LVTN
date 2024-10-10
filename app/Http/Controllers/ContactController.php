<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Validation\ValidationException;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts=Contact::orderby('id','DESC')->where('status','!=',0)->get();
        return view('admin.contacts.index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate input data
            $data = $request->validate([
                'email' => 'required',
                'name' => 'required',
                'phone' => 'required|max:10',
                'title' => 'required',
                'content' => 'required',
            ], [
                'email.required' => 'Bạn chưa nhập Email',
                'name.required' => 'Bạn chưa nhập tên',
                'phone.required' => 'Bạn chưa nhập số điện thoại',
                'title.required' => 'Bạn chưa nhập tiêu đề',
                'content.required' => 'Bạn chưa nhập nội dung',
               
            ]);

            // Create new Customer instance
            $contact = new Contact();
            $contact->email = $data['email'];
            $contact->phone = $data['phone'];
            $contact->name = $data['name'];
            $contact->title = $data['title'];
            $contact->content = $data['content'];
           

            $contact->status = 1;
           
            $contact->save();
            
            
            toastr()->success('Gửi thành công, chúng tôi sẽ sớm liên hệ với bạn!',['positionClass' => 'toast-bottom-right']);
            return redirect()->back();

        } catch (ValidationException $e) {
            toastr()->error('Gửi không thành công! Vui lòng kiểm tra lại thông tin.',['positionClass' => 'toast-bottom-right']);
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } 
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
        $contact= Contact::find($id);
        return view('admin.contacts.edit',compact('contact'));
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
        $contact=Contact::find($id);
        $contact->status=0;
        $contact->save();
        toastr()->success('Xóa thành công!');
        return redirect()->route('contacts.index');
    }
}
