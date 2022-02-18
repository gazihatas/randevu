<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\WorkingHours;
use Illuminate\Http\Request;



class indexController extends Controller
{
    public function  getWorkingHours()
    {
        //
        $date = date("Y-m-d");
        //geriye dönüş arrayi ekledik
        $returnArray = [];
        //VEri tabanındaki WorkingHouse tablosundaki tüm verileri aldık.
        $hours = WorkingHours::all();
        foreach($hours as $k => $v)
        {
            //Bu saat dolumu boşmu. Bunu Appoitmens tablosundan kontrol ediyoruz.
            $control = Appointment::where('date',$date)->where('workingHour',$v['id'])->count();
            $v['isActive'] = ($control == 0) ? true : false;
            $returnArray[] = $v;
        }

        return response()->json($returnArray);
    }
}
