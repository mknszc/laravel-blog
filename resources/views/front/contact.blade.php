@extends("front.layouts.master")
@section("title", 'İletişim')
@section("content")
    <div class="col-md-8">
        <p> İletişime Geçebilirsiniz</p>
        @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{route('contact.post')}}">
            @csrf
            <div class="control-group">
                <div class="form-group controls">
                    <label>Ad Soyad</label>
                    <input type="text" class="form-control" value="{{old('name')}}" placeholder="Name" name="name" required data-validation-required-message="Please enter your name.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group controls">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{old('email')}}" placeholder="Email Address" name="email" required data-validation-required-message="Please enter your email address.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group col-xs-12 controls">
                    <label>Konu</label>
                    <select class="form-control" name="topic">
                        <option @if(old('topic') == 'Bilgi') selected @endif>Bilgi</option>
                        <option @if(old('topic') == 'İstek') selected @endif>İstek</option>
                        <option @if(old('topic') == 'İstek') selected @endif>Genel</option>
                    </select>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group  controls">
                    <label>Mesaj</label>
                    <textarea rows="5" class="form-control"placeholder="Mesaj" name="message" required data-validation-required-message="Please enter a message.">{{old('message')}}</textarea>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <br>
            <div id="success"></div>
            <button type="submit" class="btn btn-primary" id="sendMessageButton">Gönder</button>
        </form>
    </div>
    <div class="col-md-4">
        <div class="panel">
        </div>
    </div>
    </div>
@endsection

