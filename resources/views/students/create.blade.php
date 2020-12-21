@extends('layout.main')

@section('title', 'Form Add Data Student')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-8">

            <h1 class="mt-3">Form Add Data Student</h1>

            <form method="post" action="/students" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        placeholder="Masukkan Nama" name="nama" value="{{old('nama')}}">
                    @error('nama')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                        placeholder="Masukkan NIM" name="nim" value="{{old('nim')}}">
                    @error('nim')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                        placeholder="Masukkan email" name="email" value="{{old('email')}}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan"
                        placeholder="Masukkan jurusan" name="jurusan" value="{{old('jurusan')}}">
                    @error('jurusan')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="filename">Upload doc</label>
                    <input type="file" class="form-control @error('filename') is-invalid @enderror" id="filename"
                        name="filename" value="{{old('filename')}}">
                    @error('filename')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Data!</button>
            </form>

        </div>
    </div>

</div>
@endsection