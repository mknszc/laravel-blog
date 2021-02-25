@extends('back.layouts.master')
@section('title', $article->title . ' makalesini güncelle')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><strong>@yield('title')</strong></h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </div>
            @endif
            <form method="post" action="{{route("admin.makaleler.update", $article->id)}}" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label> Makale Başlığı </label>
                    <input type="text" name="title" class="form-control" required value="{{$article->title}}">
                </div>
                <div class="form-group">
                    <label> Makale Kategori </label>
                    <select class="form-control" name="category" required>
                        <option value="-1">Seçim Yapınız</option>
                        @foreach($categories as $category)
                            <option @if ($article->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label> Makale Fotoğrafı </label>
                    <img src="{{asset($article->image)}}" width="100" class="img-thumbnail rounded">
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label> Makale İçeriği </label>
                    <textarea id="editor" name="content" class="form-control" rows="4">{{$article->content}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Makaleyi Kaydet</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote(
                {
                    height:300
                }
            );
        });
    </script>
@endsection