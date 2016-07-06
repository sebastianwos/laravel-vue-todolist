<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    /**
     * SettingsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        return view('settings.form', compact('user'));
    }

    public function changePassword(Request $request){

        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        $user->password = bcrypt($request->input('password'));
        $user->save();

        flash('Password was changed');

        return redirect()->back();

    }

}
