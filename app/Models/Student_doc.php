<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_doc extends Model
{
    use HasFactory;
    //fillable -> ini boleh diisi
    protected $table='student_doc';
    protected $guarded=['id'];
    // guarded -> ini tidak boleh diisi
    //protected $guarded=['nim'];
    
    // public function student(){
    // return $this->belongsTo(Student::class);
    // }
    public function student()
    {
    	return $this->belongsTo('App\Models\student');
    }
}