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

        return view('home');
    }
}
