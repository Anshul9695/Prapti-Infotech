<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend/login/login')->with('bodyClass', 'authincation h-100');
    }

    public function register()
    {
        return view('Backend/login/register')->with('bodyClass', 'authincation h-100');
    }
    public function registerPost(request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/', 'unique:users,username'], // Add unique check
            'email' => 'required|email|unique:users,email', // Add unique check for email
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            //  return response()->json(['status' => 400, 'message' => $validator->getMessageBag()]);
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            if (Login::where('username', $request->username)->exists()) {
                return redirect()->back()->withErrors(['username' => 'Username is already taken.'])->withInput();
            }

            // Check if the email already exists manually
            if (Login::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors(['email' => 'Email is already taken.'])->withInput();
            }

            $user = new Login();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = 'user';
            $user->status = 1;
            $user->save();
            session()->flash('success', 'User registration successful');
            return redirect()->back();
        }
    }
    public function loginPost(request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/'],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            //  return response()->json(['status' => 400, 'message' => $validator->getMessageBag()]);
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = Login::where('username', $request->username)->first();
            if ($user) {
                if (password_verify($request->password, $user->password)) {
                    $request->session()->put('loggedinUser', $user->id);
                    return redirect()->route('dashboard');
                } else {
                    // return response()->json(['status' => 401, 'message' => 'Invalid password']);
                    session()->flash('error', 'Invalid password');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Invalid username Or Password');
                return redirect()->back();
            }
        }
    }


    public function logout()
    {
        session()->forget('loggedinUser');
        session()->flush();  // Optionally clear all session data
        Auth::logout(); // Logout the user from the Auth system
        return redirect()->route('login')->with('message', 'You have been logged out.');
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
    public function store(Request $request)
    {
        //
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
}
