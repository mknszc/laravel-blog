@extends("front.layouts.master")
@section("title", "Blog Sitesi")
@section("content")
    <div class="col-md-9 mx-auto">
        @include('front.widgets.articleWidget')
    </div>
    @include('front.widgets.categoryWidget')
@endsection
