<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Markdown\Markdown;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use YuanChao\Editor\EndaEditor;

class PostsController extends Controller
{
    protected $markdown;
    function __construct(Markdown $markdown)
    {
        $this->middleware('auth',['only' => ['create','store','update','edit']]);
        $this->markdown = $markdown;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discussions=Discussion::latest()->paginate(15);
        return view('forum.index',[
            'discussions' => $discussions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreBlogPostRequest $request)
    {
//        dd(Auth::user()->id);die();
        //request中只有title和body，需要将将登陆用户的id传递进来
        $data = [
            'user_id' => Auth::user()->id,
            'last_user_id' => Auth::user()->id
        ];
        $discussion=Discussion::create(array_merge($request->all(),$data));
        //重定向到帖子详情页
        return redirect()->action('PostsController@show',['id' => $discussion->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discussion = Discussion::findorfail($id);
        $html = $this->markdown->markdown($discussion->body);
        return view('forum.show',[
           'discussion' => $discussion,
            'html' => $html
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discussion = Discussion::findorfail($id);
        if (Auth::user()->id !== $discussion->user_id){
            return redirect('/');
        }

        return view('forum.edit',[
            'discussion' => $discussion
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreBlogPostRequest $request, $id)
    {
        $discussion = Discussion::findorfail($id);

        $discussion->update($request->all());

        return redirect()->action('PostsController@show',['id' => $discussion->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload()
    {
        // endaEdit 为你 public 下的目录 update 2015-05-19
        $data = EndaEditor::uploadImgFile('uploads');

        return json_encode($data);
    }
}
