@extends('back.layouts.master')
@section('title', 'Silinen Makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><strong>@yield('title')</strong></h6>
            <h6 class="m-0 font-weight-bold text-primary float-right"><strong>{{count($articles)}}</strong> Makele Bulundu
                <a href="{{route('admin.makaleler.index')}}" class="btn btn-success btn-sm"><i class="fa fa-archive"></i> Tüm Makaleler</a>
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
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $key => $article)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            <img src="{{$article->image}}" width="30">
                        </td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->getCategory->name}}</td>
                        <td>{{$article->hit}}</td>
                        <td>{{$article->created_at->diffForHumans()}}</td>
                        <td>
                            <a href="{{route('admin.recycle.article', $article->id)}}" class="btn btn-sm btn-success" title="Düzenle"> <i class="fa  fa-recycle"></i> </a>
                            <a href="{{route('admin.hard.delete.article', $article->id)}}" class="btn btn-sm btn-danger" title="Sil"> <i class="fa fa-times"></i> </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection