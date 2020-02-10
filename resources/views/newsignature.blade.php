@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            $url = url()->current();
            $action = '';

            if(strpos($url, 'newsignature') !== false){
                $action = "/newsignature/$reportid";
            } else if (strpos($url, 'editsignature') !== false){
                $action = "/editsignature/$signatureid";
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
                <h5>お名前  <span class="required">[必須]</span></h5>
                <div class="col-md-12">
                    <input name="name" class="tagsinput tagsinput-typeahead input-lg"  placeholder="建設　太郎" value="{{old('name') ?? $signature->name}}" required />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>備考</h5>
                <div class="col-md-12">
                    <input name="remarks" class="tagsinput tagsinput-typeahead input-lg" value="{{old('remarks') ?? $signature->remarks}}" style="width:80%;"/>
                </div>
            </div>

            <div class="item-conteiner-top">
                <input type="submit" class="btn btn-primary" value="保存する" />
            </div>
        </form>

    </div>

    <script>
        // Enter無効
        $(document).ready(function () {
            $('input,textarea[readonly]').not($('input[type="button"],input[type="submit"]')).keypress(function (e) {
                if (!e) var e = window.event;
                if (e.keyCode == 13)
                    return false;
            });
        });
    </script>

@endsection
