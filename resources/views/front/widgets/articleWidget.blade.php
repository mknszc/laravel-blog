@foreach($articles as $article)
    <div class="post-preview">
        <a href="{{route('single', [$article->getCategory->slug, $article->slug])}}">
            <h2 class="post-title">
                {{$article->title}}
            </h2>
            <img src="{{$article->image}}">
            <h3 class="post-subtitle">
                {{$article->content}}
            </h3>
        </a>
        <p class="post-meta"> Kategori :
            <a href="{{route('category', $article->getCategory->slug)}}">{{$article->getCategory->name}}</a>
            <span class="float-right"> {{$article->created_at->diffForHumans()}} </span>
        </p>
    </div>
    <hr>
@endforeach
{{$articles->links()}}