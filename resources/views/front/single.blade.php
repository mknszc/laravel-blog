@extends("front.layouts.master")
@section("title", $article->title)
@section("bg", asset($article->image))
@section("content")
    <div class="col-md-9 mx-auto">
        <h2 class="section-heading">{{$article->title}}</h2>
        {{$article->content}}
        <hr>
        <span class="text-right">Okunma Sayısı {{$article->hit}}</span>
    </div>
    @include('front.widgets.categoryWidget')
@endsection

