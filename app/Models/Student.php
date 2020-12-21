<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    //use SoftDeletes;
    //fillable -> ini boleh diisi
    protected $fillable=['nama','nim','email','jurusan'];
    // guarded -> ini tidak boleh diisi
    //protected $guarded=['nim'];
     public function doc()
    {
    	return $this->hasOne('App\Models\student_doc');
    }
    
}