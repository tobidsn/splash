<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class ProfileController extends Controller
{
    public function show($username)
    {	
    	$user = User::where('username', $username)->firstOrFail();

    	$is_edit_profile = false;
     	$is_following = false;

     	if (Auth::check()) {
	    	$me = Auth::user();
	    	$is_edit_profile = (Auth::id() == $user->id);
	    	$is_following = !$is_edit_profile && !$me->isFollowing($user);
	    }
	    
    	return view('profile', compact('username', 'user', 'is_edit_profile', 'is_following'));
    }
}
