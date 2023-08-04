<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nette\Utils\Random;
use Faker\Factory;

class AttendanceController extends Controller
{
    public function action(Request $request, $function =0, $userId=0, $info=0)
    {
        dump($function);
        dump($userId);
        dump($info);
        dd('done');
    }

    public function home()
    {
        $member = Member::take(5)->orderBy('id', 'desc')->get();
        return view ('home',compact('member'));
    }

    public function createRandom()
    {
        $faker = Factory::create();
        $member = Member::create([
            'name' => $faker->name,
            'token' => Str::random('5'),
            'departmentId' => $faker->unique()->numberBetween(0,9)
        ]);
        $member->save;

        return redirect()->route('home');
    }

    public function checkIn(Request $request, $departmentName =0, $userID=0, $token=0, $status=0)
    {
        $data = Member::find($userID);
        if($data){
            if ($departmentName == 'gateway'){
                $data =['messenger'=>'Allow access Gateway!',
                    'status'=>'true',];
                return response()->json($data,200);
            }else {
                $departmentId = $data['departmentId'];
                if ($departmentId%2==0 && $departmentName=='exhibition') {
                    $data =['messenger'=>'Allow access Exhibition!',
                        'status'=>'true',];
                    return response()->json($data,200);
                }elseif(($departmentId%2!=0 && $departmentName=='warehouse')){
                    $data =['messenger'=>'Allow access Warehouse!',
                        'status'=>'true',];
                    return response()->json($data,200);
                }else {
                    $data =['messenger'=>'Deny access '.$departmentName.'!',
                        'status'=>'false',];
                    return response()->json($data,403);
                }
            }
        }else{
            $data =['messenger'=>"Deny access! Stop right there.",
                'status'=>'false',];
            return response()->json($data,403);
        }
    }
}
