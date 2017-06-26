<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{

    public function register()
    {
        return view('user.register');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\UserRegisterRequest $request)
    {
//        dd($request->all());die;

        $data=[
          'confirm_code' => str_random(48),
            'avatar' => '/images/default-avatar.jpg',
        ];
        //保存数据
        $user=User::create(array_merge($request->all(),$data));
//        //发送邮件
//        //subject view confirm_code email
//        $subject='Confirm Your Email';
//        $view='email.register';
//
//        $this->sendTo($user,$subject,$view,$data);
        if ($user){
            echo "<script>alert('注册成功！');</script>";
            //重定向

            return redirect('/');
        }

    }

    /**处理点击激活链接后的逻辑
     * @param $confirm_code
     */
    public function confirmEmail($confirm_code)
    {
        $user = User::where('confirm_code',$confirm_code)->first();
        if (is_null($user)){
            return redirect('/');
        }
        //不为空就修改状态
        $user->is_confirmed = 1;
        //并确保链接只有在第一次点击时有效
        $user->confirm_code = str_random(48);
        //保存
        $user->save();

        return redirect('user/login');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    /**使用Mail类进行邮件发送
     * @param $user
     * @param $subject
     * @param $view
     * @param $data
     */
    private function sendTo($user, $subject, $view, $data)
    {
        Mail::queue($view,$data,function ($message) use($user,$subject){
             $message->to($user->email)->subject($subject);
        });
    }


    public function login()
    {
        return view('user.login');
    }

    /**用户登录方法
     * @param Requests\UserLoginRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signin(Requests\UserLoginRequest $request)
    {

//        dd($request->all());die;
        if (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
                //邮箱验证服务，逻辑暂时未处理
//            'is_confrimed' => 1
        ])){
            return redirect('/');
        }

        Session::flash('user_login_failed','邮箱未验证或者密码不正确');
        return redirect('user/login')->withInput();
    }

    /**退出登录的方法
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**用户编辑头像方法
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatar()
    {
        return view('user.avatar');
    }


    public function changeAvatar(Request $request)
    {
        //拿到请求中的头像文件
//        $file = $request->file('avatar');
        $file = Input::file('avatar');

        $input = array('image' => $file);
        $rules = array(
            'image' => 'image'
        );

        $validator = Validator::make($input, $rules);
        if ( $validator->fails() ) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);

        }

//        dd($request->all());die;
        //设置头像存储路径
        $destinationPath = 'uploads/';
        //设置头像的存储文件名
        $fileName = Auth::user()->id.'_'.time().$file->getClientOriginalName();
        //将请求中的头像移动到制定路径中
        $file->move($destinationPath,$fileName);
        Image::make($destinationPath.$fileName)->fit(400)->save();



        return \Response::json(
            [
                'success' => true,
                'avatar' => asset($destinationPath.$fileName),
                'image' => $destinationPath.$fileName,
            ]
        );
    }

    /**裁剪头像
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cropAvatar(Request $request)
    {
//        dd($request->all());

        $photo = $request->get('photo');
        $width = (int) $request->get('w');
        $height = (int) $request->get('h');
        $xAlign = (int) $request->get('x');
        $yAlign = (int) $request->get('y');


        Image::make($photo)->crop($width,$height,$xAlign,$yAlign)->save();


        $user = Auth::user();
        $user->avatar = asset($photo);
        $user->save();

        return redirect('user/avatar');
    }

    /**修改密码界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modifyPwd()
    {
        return view('user.editpwd');
    }

    /**修改密码
     * @param Request $request
     */
    public function updatePwd(Request $request)
    {

//        echo  json_encode(array('code' => '1'));
        $oldPwd = $request->oldPwd;
        $newPwd = $request->newPwd;
        $id = Auth::user()->id;
        $user = User::find($id);
        $pwd = $user->password;
        $oldPwd = bcrypt($oldPwd);
        if ($pwd == $oldPwd){
            $res = User::where('id',$id)->update(['password' => $newPwd]);
            if ($res){
                echo json_encode(array('success' => 2));
            }else{
                echo json_encode(array('success' => 3));
            }
        }else{
            echo json_encode(array('success' => 1));
        }


    }

}
