@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            $action = "";

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
                    <input name="number" class="tagsinput tagsinput-typeahead input-lg" value="{{old('number') ?? $construction->number}}" required />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事名  <span class="required">[必須]</span></h5>
                <div class="col-md-12">
                    <textarea class="patrol-textarea" name="name" rows="2" cols="40" wrap="hard" placeholder="2行以内" required>{{old('name') ?? $construction->name}}</textarea>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>発注者</h5>
                <div class="col-md-12">
                    <input name="orderer" class="tagsinput tagsinput-typeahead input-lg" value="{{old('orderer') ?? $construction->orderer}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>値段</h5>
                <div class="col-md-12">
                    <input type="number" name="price" class="tagsinput tagsinput-typeahead input-lg" value="{{old('price') ?? $construction->price}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工期自</h5>
                <div class="col-md-12">
                    @if($construction->start)
                        <input type="date" name="start" value="{{old('start') ?? date('Y-m-d', strtotime( $construction->start ))}}" />
                    @else
                        <input type="date" name="start" value="{{old('start')}}"/>
                    @endif
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工期至</h5>
                <div class="col-md-12">
                    @if($construction->end)
                        <input type="date" name="end" value="{{old('end') ?? date('Y-m-d', strtotime( $construction->end ))}}" />
                    @else
                        <input type="date" name="end" value="{{old('end')}}"/>
                    @endif
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事箇所</h5>
                <div class="col-md-12">
                    <input type="text" name="place" class="tagsinput tagsinput-typeahead input-lg" value="{{old('place') ?? $construction->place}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>営業担当</h5>
                <div class="col-md-12">
                    <input type="text" name="sales" class="tagsinput tagsinput-typeahead input-lg" value="{{old('sales') ?? $construction->sales}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事担当</h5>
                <div class="col-md-12">
                    <input type="text" name="supervisor" class="tagsinput tagsinput-typeahead input-lg" value="{{old('supervisor') ?? $construction->supervisor}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事内容・備考</h5>
                <div class="col-md-12">
                    <input type="text" name="remarks" class="tagsinput tagsinput-typeahead input-lg" style="width: 500px;" value="{{old('remarks') ?? $construction->remarks}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <input type="submit" class="btn btn-primary" value="工事情報を登録する" />
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
