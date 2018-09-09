<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $users=User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles=Role::lists('name','id');
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {

       // $r=$request->validate();
        //dd($r);

        //
//        dd($request->all());
        $input=$request->all();
        if($file=$request->file('photo_id')){
            $name=time().$file->getClientOriginalName();
            $photo=Photo::create(['file'=>$name]);
            $file->move('images',$name);
            //dd($photo->id);
            $input['photo_id']=$photo->id;


        }
        $input['password']=bcrypt($request->password);

        User::create($input);

        return redirect('/admin/users');

//        $this->validate($request,
//            [
//                'name'=>'required',
//                'email'=>'required',
//                'password'=>'required',
//            ]);


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

        $user=User::findOrFail($id);
        $roles=Role::lists('name','id');
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {
        //
        $input=$request->all();
        $user=User::findOrFail($id);

        if($file=$request->file('photo_id')){
            $name=time().$file->getClientOriginalName();
            $photo=Photo::create(['file'=>$name]);
            $file->move('images',$name);
            //dd($photo->id);
            $input['photo_id']=$photo->id;


        }
        $input['password']=bcrypt($request->password);

        $user->update($input);

        return redirect('/admin/users');
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

        $user=User::findOrFail($id);

        unlink(public_path().$user->photo->file);

        Session::flash('deleted_user','user has been deleted');


        $user->delete();

        return redirect('/admin/users');
    }
}
