@extends('mahasiswas.layout')

@section('content')
    <div class="container">
        <form action="/articles" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" required="required" name="title"></br>
                <label for="content">Content</label>
                <textarea class="form-control" type="text" name="content" id="content"
                cols="30" rows="10" required="required"></textarea></br>
                <label for="image">Feature Image:</label>
                <input type="file" class="form-control" required="required" name="image"></br>
                <button type="submit" name="submit" class="btn btn-primary float-right">Simpan</button>
            </div>
        </form>
    </div>
@endsection
