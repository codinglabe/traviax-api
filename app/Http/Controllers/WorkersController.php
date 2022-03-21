<?php

namespace App\Http\Controllers;

use App\Models\Workers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WorkersController extends Controller
{
    public function WorkerlogIn(Request $request){
                $cr = $request->only('email','password');
                if(Auth::guard('worker')->attempt($cr))
                {
                    return Auth::guard('worker')->user();
                }else
                {
                    return "Email or Password not match";
                }
    }

    public function WorkerRegistration(Request $request)
    {           
                $request->validate([
                    "email" => 'required|email',
                    "name" => 'required',
                    "address" => 'required',
                ]);
                $worker_check = Workers::where('email',$request->email)->first();
                if(!$worker_check->email == $request->email){
                    $name = $request->first_name." ".$request->name;
                    $worker = new Workers;
                    $worker->name = $name;
                    $worker->email = $request->email;
                    $worker->password = Hash::make($request->password);
                    $worker->address = $request->address;
                    $worker->postal_code = $request->postal_code;
                    $worker->telephone = $request->telephone;
                    $worker->name_or_siret_num = $request->nameOrSiretNum;
                    $worker->architect = $request->architect;
                    $worker->distance_km = $request->distanceKm;
                    $worker_reg_result = $worker->save();
                    if($worker_reg_result == true){
                        return "Registration Success";
                    }else{
                        return "Something went wrong!";
                    }
                }else{
                    return "Email is already regestered";
                }
                
    }
}
