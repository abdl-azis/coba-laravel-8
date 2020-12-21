<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_history extends Model
{
    use HasFactory;
    //fillable -> ini boleh diisi
    protected $table='students_history';
    protected $guarded=['id'];
    // guarded -> ini tidak boleh diisi
    //protected $guarded=['nim'];
    
}