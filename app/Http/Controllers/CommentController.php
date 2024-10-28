<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * 1: đã duyệt
     *  * 2: đã xóa
     *  * 0: đã chưa duyệt
     */
    public function index()
    {
        $comments = Comment::with('tour')->where(function($query) {
            $query->where('status', 0)->orwhere('status',2);
        })
        ->whereNull('comment_parent_comment')
        ->orderBy('status', 'ASC')
        ->get();

        return view('admin.comments.index',compact('comments'));
    }
    public function business_index()
    {
        $comments = Comment::with('tour')->where(function($query) {
            $query->where('status', 0)
                  ->orWhere('status', 2);
        })
        ->whereNull('comment_parent_comment')
        ->orderBy('status', 'ASC')
        ->get();
        $comments_business = collect();
        if(Auth::user()->id!=1){
            $tours=Tour::with('category')->with('user')->where('business_id',Auth::user()->id)->Orderby('status','DESC')->get();
            $tourIds = $tours->pluck('id')->toArray();
            $comments_business = Comment::with('tour')
                ->whereIn('comment_tour_id', $tourIds)
                ->where(function($query) {
                    $query->where('status', 0)
                        ->orWhere('status', 2);
                })
                ->whereNull('comment_parent_comment')
                ->orderBy('status', 'ASC')
                ->get();
                    }
        return view('admin.comments.business_index',compact('comments_business'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $comments= Comment::where('status',1)->whereNull('comment_parent_comment')->orderby('comment_id','DESC')->get();
        $comment_reply = Comment::with('tour')->orderby('status', 'DESC')->get();
        return view('admin.comments.create',compact('comments','comment_reply'));
    }

    public function business_create(){
        $comments= Comment::where('status','!=',2)->whereNull('comment_parent_comment')->orderby('comment_id','DESC')->get();
        $comment_reply = Comment::with('tour')->orderby('status', 'DESC')->get();

        $comments_business = collect();
        if(Auth::user()->id!=1){
            $tours=Tour::with('category')->with('user')->where('business_id',Auth::user()->id)->Orderby('status','DESC')->get();
            $tourIds = $tours->pluck('id')->toArray();
            $comments_business = Comment::with('tour')->where('status','!=',2)->whereNull('comment_parent_comment')->whereIn('comment_tour_id', $tourIds)->orderBy('comment_id', 'ASC')->get();
            $commnent_reply_business = Comment::with('tour')->whereIn('comment_tour_id', $tourIds)->orderby('status', 'DESC')->get();
         }
        return view('admin.comments.business_create',compact('comments_business','commnent_reply_business'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data= $request->all();
        if($data['comment_content']){
            $comment = new Comment();
            $comment->comment_name = $data['comment_name'];
            $comment->comment_content = $data['comment_content'];
            $comment->comment_tour_id = $data['comment_tour_id'];
            $comment->customer_id = $data['customer_id'];
            $comment->status = 1;
            $comment->save();
            $commentId = $comment->comment_id;
        }
        
        if($data['star_rating']){
            $rating = new Rating();
            $rating->tour_id = $data['comment_tour_id'];
            $rating->rating = $data['star_rating'];
            $rating->comment_id = $commentId;
            $rating->save();
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
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::where('comment_id', $id)->first();
        if($comment->status==0){
            $comment->status=2;
            toastr()->success('Duyệt xóa thành công!');
        }else{
            $comment->status=1;
            toastr()->success('Bỏ duyệt thành công!');
        }
        
        $comment->save();
        
        return redirect()->route('comment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::where('comment_id', $id)->first();
        if($comment->comment_parent_comment!=null){
            $comment->delete();
            toastr()->success('Xoá thành công!');
           
        }else{
            $comment->status=1;
            toastr()->success('Xóa thành công!');
            $comment->save();
           
        }
        return redirect()->back();
       
    }
    public function recycle(string $id)
    {
        $comment = Comment::where('comment_id', $id)->first();
       
            $comment->status=0;
            toastr()->success('Khôi phục thành công!');
            $comment->save();
           
      
        return redirect()->back();
       
    }
    public function reply(Request $request)
    {
        $data = $request->all();
        $comment = new Comment();
        $comment->comment_content = $data['comment'];
        $comment->comment_tour_id = $data['comment_tour_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->status = 1;
        $comment->comment_name = Auth::user()->name;
        $comment->customer_id = Auth::user()->id;
        $comment->save();
    }
    public function request_destroy(Request $request)
    {
        $data = $request->all();
        $comment = Comment::where('comment_id',$data['comment_id'])->where('comment_tour_id',$data['comment_tour_id'])->first();
        $comment->status = 0;
        $comment->reason=$data['reason'];
        $comment->save();
    }
    public function huyyeucau(string $id)
    {
        $comment = Comment::where('comment_id', $id)->first();
      
            $comment->status=1;
            toastr()->success('Hủy yêu cầu thành công!');
            $comment->save();

        return redirect()->back();
       
    }
}
