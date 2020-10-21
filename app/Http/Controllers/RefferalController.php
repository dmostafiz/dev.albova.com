<?php

namespace App\Http\Controllers;

use App\AffiliateClick;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RefferalController extends Controller
{
    public function reffInit()
    {

        if(isset($_GET['ref_id']))
        {
            $ref_id = $_GET['ref_id'];
            Session::put('ref_id', $ref_id);

            $user = User::where('ref_id', $ref_id)->first();

            if($user)
            {
                $click = new AffiliateClick();
                $click->user_id =  $user->id;
                $click->click = 1;
                $click->save();
            }

        }

        return redirect()->to('/');
    }

    // public function generateRefId(Request $request)
    // {
    //     if($request->id != get_current_user_id())
    //     {
    //        abort(401);
    //     }

    //     $user = User::where('id',$request->id)->first();

    //     $newRefId = substr(time(), -4) . $user->id;

    //     $user->ref_id = $newRefId;
    //     $user->save();

    //     return redirect()->back();
       
    // }
}
