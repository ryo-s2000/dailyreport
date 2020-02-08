@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/photo.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            $userNames = array();
            foreach($allDailyreports as $dailyreport){
                $userNames[] = $dailyreport->userName;
            }
        ?>

        <div>
            <div class="refine">
                <form method="get" action="/photo" enctype="multipart/form-data">
                    <div><span class="refine-title">順番</span></div>
                    <select name="sort" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                        <option value="" label="default">選択</option>

                        @foreach(array("日付が早い順", "日付が遅い順") as $value)
                            @if($dailyreportsPalams['sort'] == $value)
                                <option value="{{$value}}" selected>{{$value}}</option>
                            @else
                                <option value="{{$value}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>

                    <div><span class="refine-title">絞り込み</span></div>
                    <div>
                        <select name="userName" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                            <option value="" label="default">名前を選択</option>

                            @foreach(array_unique($userNames) as $value)
                                @if($dailyreportsPalams['userName'] == $value)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>

                        <select name="department" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                            <option value="" label="default">部署を選択</option>

                            @foreach(array("住宅部", "土木部", "特殊建築部", "農業施設部") as $value)
                                @if($dailyreportsPalams['department'] == $value)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                            <option value="" label="default">工事番号を選択</option>
                            @foreach ($constructions as $construction)
                                @if($dailyreportsPalams['constructionNumber'] == $construction->number)
                                    <option value="{{$construction->number}}" selected>{{$construction->number}}</option>
                                @else
                                    <option value="{{$construction->number}}">{{$construction->number}}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="constructionName" data-toggle="select" class="construction-form-name form-control select select-default mrs mbm">
                            <option value="" label="default">工事名を選択</option>
                            @foreach ($constructions as $construction)
                                @if($dailyreportsPalams['constructionName'] == $construction->name)
                                    <option value="{{$construction->name}}" selected>{{$construction->name}}</option>
                                @else
                                    <option value="{{$construction->name}}">{{$construction->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary btn-reset" onClick="window.reset();">条件をリセット</button>
                    <button class="btn btn-primary btn-refine" onClick="location.href='/construction'">決定</button>
                </form>
            </div>
        </div>


        <?php $beforReportDate = "" ?>

        @foreach($dailyreports as $dailyreport)
            @foreach(array("imagepath1", "imagepath2", "imagepath3", "imagepath4", "imagepath5") as $path)
                @if($dailyreport->$path)
                    @if($beforReportDate == "")
                        <h6>
                            {{date( 'Y年m月d日', strtotime( $dailyreport->date ))}}
                        </h6>

                        <div class="photo-container">
                            <div class="photo-cell">
                                <div>
                                    <img class="photo" src={{$dailyreport->$path}}>
                                </div>
                                <div class="photo-info">
                                    {{$dailyreport->constructionNumber}}<br />
                                    <p class="construction-name">{{$dailyreport->constructionName}}</p>
                                </div>
                            </div>
                        {{-- もしこの場所で繰り返しが途切れても自動で補正してくれる --}}
                    @elseif($dailyreport->date != $beforReportDate)
                        </div>
                            <h6>
                                {{date( 'Y年m月d日', strtotime( $dailyreport->date ))}}
                            </h6>

                            <div class="photo-container">
                                <div class="photo-cell">
                                    <div>
                                        <img class="photo" src={{$dailyreport->$path}}>
                                    </div>
                                    <div class="photo-info">
                                        {{$dailyreport->constructionNumber}}<br />
                                        <p class="construction-name">{{$dailyreport->constructionName}}</p>
                                    </div>
                                </div>
                    @else
                        <div class="photo-cell">
                            <div>
                                <img class="photo" src={{$dailyreport->$path}}>
                            </div>
                            <div class="photo-info">
                                {{$dailyreport->constructionNumber}}<br />
                                <p class="construction-name">{{$dailyreport->constructionName}}</p>
                            </div>
                        </div>
                    @endif
                <?php $beforReportDate = $dailyreport->date ?>
                @endif
            @endforeach
        @endforeach

        <script>
            // リセット処理
            function reset(){
                ['sort', 'userName', 'department', 'constructionNumber', 'constructionName'].forEach(name => {
                    selectName = 'select[name="' + name + '"]';
                    $(selectName).prop("selectedIndex", 0).trigger('change', ['exit']);
                });
            }

            // 選択時カラー機能
            $(document).ready(function(){
                if($('select[name="sort"]').val() != ""){
                    $('select[name="sort"]').addClass("select-choiced");
                }
                if($('select[name="userName"]').val() != ""){
                    $('select[name="userName"]').addClass("select-choiced");
                }
                if($('select[name="department"]').val() != ""){
                    $('select[name="department"]').addClass("select-choiced");
                }
                if($('select[name="constructionNumber"]').val() != ""){
                    $('select[name="constructionNumber"]').addClass("select-choiced");
                }
                if($('select[name="constructionName"]').val() != ""){
                    $('select[name="constructionName"]').addClass("select-choiced");
                }
            });

            $(function() {
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

                // 選択時カラー機能
                $('select[name="sort"]').change(function(e, data) {
                    if($(this).prop("selectedIndex") == 0){
                        $('select[name="sort"]').removeClass("select-choiced");
                    } else {
                        $('select[name="sort"]').addClass("select-choiced");
                    }
                });
                $('select[name="userName"]').change(function(e, data) {
                    if($(this).prop("selectedIndex") == 0){
                        $('select[name="userName"]').removeClass("select-choiced");
                    } else {
                        $('select[name="userName"]').addClass("select-choiced");
                    }
                });
                $('select[name="department"]').change(function(e, data) {
                    if($(this).prop("selectedIndex") == 0){
                        $('select[name="department"]').removeClass("select-choiced");
                    } else {
                        $('select[name="department"]').addClass("select-choiced");
                    }
                });
                $('select[name="constructionNumber"]').change(function(e, data) {
                    if($(this).prop("selectedIndex") == 0){
                        $('select[name="constructionNumber"]').removeClass("select-choiced");
                    } else {
                        $('select[name="constructionNumber"]').addClass("select-choiced");
                    }
                });
                $('select[name="constructionName"]').change(function(e, data) {
                    if($(this).prop("selectedIndex") == 0){
                        $('select[name="constructionName"]').removeClass("select-choiced");
                    } else {
                        $('select[name="constructionName"]').addClass("select-choiced");
                    }
                });

            });
        </script>

@endsection
