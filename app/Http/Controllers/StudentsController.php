<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Student_history;
use App\Models\Student_doc;
use File;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ORM

        $students= Student::all();
        return view('students.index', compact('students'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student)
    {
        //
        
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //untuk nge-Save data ke database
      /**
        *Cara Pertama Insert data ke database
        *
        *$student->nama=$request->nama;
        *$student->nim=$request->nim;
        *$student->email=$request->email;
        *$student->jurusan=$request->jurusan;
        *
        *$student->save();
        */
        //$student = new Student;

      /** ini Cara ke 2 untuk insert harus menggunakan fillable or guarded pada model
        * tapi jika sudah pakai fillable ada cara mempersingkat lagi
        *
        *Student::create([
        *'nama' => $request->nama,
        *'nim' => $request->nim,
        *'email' => $request->email,
        *'jurusan' => $request->jurusan,
        *]);
        */

        $request->validate([
        'nama' => 'required',
        'nim' => 'required|size:10',
        'email' => 'required',
        'jurusan' => 'required',
        'filename' => 'required|mimes:pdf,xlx,csv,doc,docx',
    ]);
        
        if($request->file()){
        $filename = time().'.'.$request->filename->getClientOriginalName();  
        $tes=$request->filename->move(public_path('filename'), $filename);       
        //return $tes;
        $student= Student::create($request->all());
        Student_doc::create([
        'filename' => $filename,
        'student_id' => $student->id,
        ]);

       }
        return redirect('/students')->with('status', 'Success Add Data!');
       //return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $filename =Student_doc::all();
       return view('students.show', compact('student', 'filename'));
    //return $filename;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
        $students= Student::with('doc')->get();
        $filename =Student_doc::all();
        
        return view('students.edit', compact('student', 'filename'));
    }
    public function ammend(Student $student)
    {
        //
        $students= Student::with('doc')->get();
        $filename =Student_doc::all();
        
        return view('students.ammend', compact('student', 'filename'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
         $request->validate([
        'nama' => 'required',
        'nim' => 'required|size:10',
        'email' => 'required',
        'jurusan' => 'required',
        //'filename' => 'required',
    ]);
        Student::where('id', $student->id)
                ->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'email' => $request->email,
                'jurusan' => $request->jurusan,
                ]);
    //     $student->getOriginal();
    //     Student_history::updateOrCreate(['id' => $student->getOriginal('id')], [
    //         'nama'=> $student->getOriginal('nama'),
    //         'nim'=> $student->getOriginal('nim'),
    //         'email'=> $student->getOriginal('email'),
    //         'jurusan'=> $student->getOriginal('jurusan'),
    //         'student_id'=>$student->getOriginal('id'),
    //         'created_at'=>$student->getOriginal('created_at'),
    // ]);

        $docada = $request->file();
        $docs= Student_doc::all();
        $tes = $request->filename;
        //$students= Student::with('doc')->get();
         foreach($docs as $doc){
         if($doc->filename==$student->doc->filename){
         
          $student_id= $doc->student_id;
          $filename= $doc->filename;
         }
          }
         if($docada){
          File::delete(public_path('filename/'.$filename));
          $filename = time().'.'.$request->filename->getClientOriginalName();
          $request->filename->move(public_path('filename'), $filename);
           // dd('hai');
         }
        //return $docada;
        // // return $docada;
        //if(!$docada){
        
        // if(File::exists(public_path('filename/'.$filename))){
        //     File::delete(public_path('filename/'.$filename));
        //     //File::delete(public_path('filename/1608250179.Apps.pdf'));
           
        
        //  }
        //     $filenam = time().'.'.$request->filename->getClientOriginalName();
        //     //$filename = time().'.'.$request->filename->getClientOriginalName();
        //     $request->filename->move(public_path('filename'), $filenam);
        // // }

        //return $filename;

        $form_data = array(
        'filename' => $filename,
        'student_id' => $student->id,
        );

        Student_doc::where('student_id', $student->id)->update($form_data);
        return redirect('/students')->with('status', 'Data Success Change!');
    }

    public function tes(Request $request, Student $student)
    {
        //
         $request->validate([
        'nama' => 'required',
        'nim' => 'required|size:10',
        'email' => 'required',
        'jurusan' => 'required',
        //'filename' => 'required',
    ]);
        Student::where('id', $student->id)
                ->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'email' => $request->email,
                'jurusan' => $request->jurusan,
                ]);
        $student->getOriginal();
        Student_history::updateOrCreate(['student_id' => $student->getOriginal('id')], [
            'nama'=> $student->getOriginal('nama'),
            'nim'=> $student->getOriginal('nim'),
            'email'=> $student->getOriginal('email'),
            'jurusan'=> $student->getOriginal('jurusan'),
            'student_id'=>$student->getOriginal('id'),
            'created_at'=>$student->getOriginal('created_at'),
    ]);

       $docada = $request->file();
        $docs= Student_doc::all();
        $tes = $request->filename;
        //$students= Student::with('doc')->get();
         foreach($docs as $doc){
         if($doc->filename==$student->doc->filename){
         
          $student_id= $doc->student_id;
          $filename= $doc->filename;
         }
          }
         if($docada){
          File::delete(public_path('filename/'.$filename));
          $filename = time().'.'.$request->filename->getClientOriginalName();
          $request->filename->move(public_path('filename'), $filename);
           // dd('hai');
         }
        //return $docada;
        // // return $docada;
        //if(!$docada){
        
        // if(File::exists(public_path('filename/'.$filename))){
        //     File::delete(public_path('filename/'.$filename));
        //     //File::delete(public_path('filename/1608250179.Apps.pdf'));
           
        
        //  }
        //     $filenam = time().'.'.$request->filename->getClientOriginalName();
        //     //$filename = time().'.'.$request->filename->getClientOriginalName();
        //     $request->filename->move(public_path('filename'), $filenam);
        // // }

        //return $filename;

        $form_data = array(
        'filename' => $filename,
        'student_id' => $student->id,
        );

        Student_doc::where('student_id', $student->id)->update($form_data);
        return redirect('/students')->with('status', 'Data Success Change!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        
        //$id=Student::get($student->id);
        $docs= Student_doc::all();
        foreach($docs as $doc){
            $student_id= $doc->student_id;
            $filename= $doc->filename;
        }
        if($student->id==$student_id){
        if(File::exists(public_path('filename/'.$filename))){
            File::delete(public_path('filename/'.$filename));
            //File::delete(public_path('filename/1608250179.Apps.pdf'));
           
        }
        
        }
        Student::destroy($student->id);
        
        // $path = public_path('filename').$linkdata;
        // return $path;
        //return $linkdata;
        // Post::where('GroupID', $post->GroupID)->delete();
        
         

        
       return redirect('/students')->with('status', 'Success Deleting Data!');
        
    }
}