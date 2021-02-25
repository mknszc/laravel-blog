@extends('back.layouts.master')
@section('title', 'Tüm makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><strong>@yield('title')</strong></h6>
            <h6 class="m-0 font-weight-bold text-primary float-right"><strong>{{count($articles)}}</strong> Makele Bulundu
                <a href="{{route('admin.trashed')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i> Silinen Makaleler</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Görüntülenme</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $key => $article)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            <img src="{{asset($article->image)}}" width="30">
                        </td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->getCategory->name}}</td>
                        <td>{{$article->hit}}</td>
                        <td>{{$article->created_at->diffForHumans()}}</td>
                        <td>
                            <input class="statusArticle" data-id="{{$article->id}}" type="checkbox" data-on="Aktif" data-off = "Pasif" data-offstyle="danger" {{$article->status == 1 ? 'checked' : ''}} data-toggle="toggle" data-onstyle="success">
                        </td>
                        <td>
                            <a target="_blank" href="{{route('single', [$article->getCategory->slug, $article->slug])}}" class="btn btn-sm btn-primary" title="Görüntüle"> <i class="fa fa-eye"></i> </a>
                            <a href="{{route('admin.makaleler.edit', $article->id)}}" class="btn btn-sm btn-success" title="Düzenle"> <i class="fa fa-pen"></i> </a>
                            <a href="{{route('admin.delete.article', $article->id)}}" class="btn btn-sm btn-danger" title="Sil"> <i class="fa fa-times"></i> </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
            $('.statusArticle').change(function() {
                id = $(this).data("id")
                status = $(this).prop('checked')
                $.get("{{route('admin.switch')}}", {id:id, status:status}, function(data, status){

                });
            })
        })
    </script>
@endsection