@extends('back.layouts.master')
@section('title', 'Tüm kategoriler')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="{{route('admin.category.create')}}">
                            @csrf
                            <div class="form-group">
                                <label>Kategori Adı</label>
                                <input type="text" class="form-control" name="category" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"> Ekle </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tüm Kategoriler</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori Adı</th>
                            <th>Makale Sayısı </th>
                            <th>Durum </th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->articleCount()}}</td>
                                <td>
                                    <input class="statusArticle" data-id="{{$category->id}}" type="checkbox" data-on="Aktif" data-off = "Pasif" data-offstyle="danger" {{$category->status == 1 ? 'checked' : ''}} data-toggle="toggle" data-onstyle="success">
                                </td>
                                <td>
                                    <a data-id="{{$category->id}}" class="edit btn btn-sm btn-success" title="Düzenle"> <i class="fa fa-pen"></i> </a>
                                    <a data-id="{{$category->id}}" data-count="{{$category->articleCount()}}"  data-name="{{$category->name}}" class="remove btn btn-sm btn-danger" title="Sil"> <i class="fa fa-times"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title text-center">Kategoriyi Düzenle</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('admin.category.update')}}">
                            @csrf
                            <div class="form-group">
                                <label>Kategori Adı</label>
                                <input id="category-name" type="text" class="form-control" name="category" required>
                                <input id="id" type="hidden" class="form-control" name="id">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary"> Kaydet </button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="removeModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title text-center">Kategoriyi Sil</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div id="removeBody" class="modal-body">
                        <div id="categoryAlert">

                        </div>
                    </div>
                    <div id class="modal-footer">
                        <form method="post" action="{{route('admin.category.delete')}}">
                            <input id="removeId" type="hidden" class="form-control" name="id">
                            @csrf
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                            <button id="deleteButton" type="submit" class="btn btn-primary"> Sil </button>
                    </div>
                    </form>
                </div>

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
            $('.edit').click(function () {
                id = $(this).data("id")
                $.ajax({
                    type : 'GET',
                    url : '{{route("admin.category.getData")}}',
                    data : {id:id},
                    success : function (data) {
                        $('#id').val(data.id);
                        $('#category-name').val(data.name);
                        $('#editModal').modal();
                    }

                });
            });

            $('.remove').click(function () {
                id = $(this).data("id")
                count = $(this).data("count")
                name = $(this).data("name")

                $('#removeId').val(id);
                $('#removeBody').hide();

                if (id == 1) {
                    $('#categoryAlert').html(name + ' Kategorisi Silinemez');
                    $('#removeBody').show();
                    $('#deleteButton').hide();
                    $('#removeModal').modal();

                    return;
                }

                $('#deleteButton').show();

                if (count > 0) {
                    $('#categoryAlert').html('Bu kategoriye ait ' + count + ' makale var. Silmek istediğinize emin misiniz ?');
                    $('#removeBody').show();
                }

                $('#removeModal').modal();
            });

            $('.statusArticle').change(function() {
                id = $(this).data("id")
                status = $(this).prop('checked')
                $.get("{{route('admin.category.switch')}}", {id:id, status:status}, function(data, status){

                });
            })
        })
    </script>
@endsection