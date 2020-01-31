@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            if($construction->name != ""){
                $action = "/editconstruction/".$construction->id;
            } else {
                $action = "/newconstruction";
            }
        ?>

        @if (count($errors) > 0)
        <!-- Form Error List -->
            <div class="alert alert-danger">
                <strong>エラーが発生しています！</strong>

                <br><br>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{$action}}" enctype="multipart/form-data">
            @csrf

            <div class="item-conteiner">
                <h5>工事番号  <span class="required">[必須]</span><span class="required">[被りなし]</span></h5>
                <div class="col-md-12">
                    <input name="number" class="tagsinput tagsinput-typeahead input-lg" value="{{$construction->number}}" required />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事名  <span class="required">[必須]</span></h5>
                <div class="col-md-12">
                    <textarea class="patrol-textarea" name="name" rows="2" cols="40" wrap="hard" placeholder="2行以内" required>{{$construction->name}}</textarea>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>発注者</h5>
                <div class="col-md-12">
                    <input name="orderer" class="tagsinput tagsinput-typeahead input-lg" value="{{$construction->orderer}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>値段  </h5>
                <div class="col-md-12">
                    <input type="number" name="price" class="tagsinput tagsinput-typeahead input-lg" value="{{$construction->price}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <input type="submit" class="btn btn-primary" value="工事情報を登録する" />
            </div>

        </form>
    </div>

@endsection
