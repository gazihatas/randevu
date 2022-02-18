<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    //Verilerimizin Veritabanına hepsinin gönderilmesine izin verdik.
    protected  $guarded = [];
}
