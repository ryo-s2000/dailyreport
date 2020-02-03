@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">

        <form method="post" action="/dataexport" enctype="multipart/form-data">
            @csrf

            <div class="item-conteiner-top">
                <h5>開始日付  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <input type="date" name="startDate" value="{{date('Y-m-d' , strtotime("-1 month"))}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>終了日付  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <input type="date" name="endDate" value="{{date('Y-m-d')}}" />
                </div>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>工事番号・工事名  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->number}}">{{$construction->number}}</option>
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
                        <option value="" label="default">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->name}}">{{$construction->name}}</option>
                        @endforeach
                    </select>
                </div>

                <select class="select-checker" name="constructionNumberChecker" required>
                    <option label="default" selected><option>
                        <option value="true">true</option>
                </select>
                <select class="select-checker" name="constructionNameChecker" required>
                    <option label="default" selected><option>
                        <option value="true">true</option>
                </select>
            </div>

            <div class="item-conteiner-top">
                <input type="submit" class="btn btn-primary" value="csvデータを作成する" />
            </div>

        </form>

    </div>

    <script>
        $(function() {
            // selectチェッカー
            $('select[name="department"]').change(function(e, data) {
                if($(this).prop("selectedIndex")){
                    $('select[name="departmentChecker"]').val("true");
                } else {
                    $('select[name="departmentChecker"]').prop("selectedIndex", 0);
                }
            });
            $('select[name="constructionNumber"]').change(function(e, data) {
                if($(this).prop("selectedIndex")){
                    $('select[name="constructionNumberChecker"]').val("true");
                } else {
                    $('select[name="constructionNumberChecker"]').prop("selectedIndex", 0);
                }
            });
            $('select[name="constructionName"]').change(function(e, data) {
                if($(this).prop("selectedIndex")){
                    $('select[name="constructionNameChecker"]').val("true");
                } else {
                    $('select[name="constructionNameChecker"]').prop("selectedIndex", 0);
                }
            });

            // 工事番号、工事名同期処理
            $('select[name="constructionNumber"]').change(function(e, data) {
                if(data !="exit"){
                    $('select[name="constructionName"]').prop("selectedIndex", $(this).prop("selectedIndex")).trigger('change', ['exit']);
                }
            });
            $('select[name="constructionName"]').change(function(e, data) {
                if(data !="exit"){
                    $('select[name="constructionNumber"]').prop("selectedIndex", $(this).prop("selectedIndex")).trigger('change', ['exit']);
                }
            });

        });
    </script>

@endsection
