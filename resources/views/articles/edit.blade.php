@extends('mahasiswas.layout')

@section('content')
    <div class="container">
        <form action="/articles/{{ $article->id }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" required="required" name="title" value="{{ $article->title }}"></br>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <input type="text" class="form-control" required="required" name="content" value={{ $article->content }}></br>
            </div>
            <div class="form-group">
                <label for="image">Feature Image</label>
                <input type="file" class="form-control" required="required" name="image" value="{{ $article->featured_image }}"></br>
                <img src="{{ asset('storage/'.$article->featured_image) }}" alt="featured-image" width="150px">
            </div>
            <button type="submit" class="btn btn-primary float-right">Ubah Data</button>
        </form>
    </div>
@endsection
