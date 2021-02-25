@extends('back.layouts.master')
@section('title', 'Tüm Sayfalar')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><strong>@yield('title')</strong></h6>
            <h6 class="m-0 font-weight-bold text-primary float-right"><strong>{{count($pages)}}</strong> Makele Bulundu
                <a href="{{route('admin.trashed')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i> Silinen Makaleler</a>
            </h6>
        </div>
        <div class="card-body">
            <div id="orderSuccess" class="alert alert-success" style="display: none;">
                Sıralama başarıyla güncellendi.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Fotoğraf</th>
                        <th>Sayfa Başlığı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody id="orders">
                    @foreach($pages as $key => $page)
                    <tr id="page_{{$page->id}}">
                        <td>{{$key+1}}</td>
                        <td>
                            <img src="{{asset($page->image)}}" width="30">
                        </td>
                        <td>{{$page->title}}</td>
                        <td>
                            <input class="statusArticle" data-id="{{$page->id}}" type="checkbox" data-on="Aktif" data-off = "Pasif" data-offstyle="danger" {{$page->status == 1 ? 'checked' : ''}} data-toggle="toggle" data-onstyle="success">
                        </td>
                        <td>
                            <a href="{{route('page', $page->slug)}}" target="_blank" href="" class="btn btn-sm btn-primary" title="Görüntüle"> <i class="fa fa-eye"></i> </a>
                            <a href="{{route('admin.page.edit', $page->id)}}" class="btn btn-sm btn-success" title="Düzenle"> <i class="fa fa-pen"></i> </a>
                            <a href="{{route('admin.page.delete', $page->id)}}" class="btn btn-sm btn-danger" title="Sil"> <i class="fa fa-times"></i> </a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $('.statusArticle').change(function() {
                id = $(this).data("id")
                status = $(this).prop('checked')
                $.get("{{route('admin.page.switch')}}", {id:id, status:status}, function(data, status) {

                });
            })
        })

        $('#orders').sortable({
            update:function () {
                var siralama = $('#orders').sortable('serialize');
                $.get("{{route('admin.page.orders')}}?"+siralama, function(data, status) {
                    $('#orderSuccess').show();
                    setTimeout(function() {
                        $('#orderSuccess').hide();
                    }, 1000);
                });
            }
        });
    </script>
@endsection