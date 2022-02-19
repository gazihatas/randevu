<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\WorkingHours;
use Illuminate\Http\Request;



class indexController extends Controller
{
    public function  getWorkingHours($date = '')
    {
        //
        $date = ($date=='') ? date("Y-m-d") : $date;
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

    public function appointmentStore(Request $request)
    {
        $returnArray = [];
        $returnArray['status'] = false;
        // Verilerimizi _token harici alıyoruz.
        $all = $request->except('_token');
        /* Appointmnet ten bir kontrol sağlıyoruz.
           Bu seçilen tarih ve seçilen çalışma saatinde herhangi
           bir randevu olup olmadığğının kontrolünü yapıyoruz.
        */
        $control = Appointment::where('date',$all['date'])->where('workingHour',$all['workingHour'])->count();
        //eğerr bir kontrol var ise radevu doludur diye return ettik
        if($control != 0)
        {
            $returnArray['message'] = "Bu randevu tarihi doludur.";
            return response()->json($returnArray);
        }

        $create = Appointment::create($all);
        if($create)
        {
            $returnArray['status'] = true;
            $returnArray['message']= "Randevunuz Başarı ile Alındı.";
        }
        else{
            $returnArray['message'] = "Veri eklenemedi bizimle iletişime geçin.";

        }
        return response()->json($returnArray);
    }
}
