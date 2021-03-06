@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/pagination.css') }}" rel="stylesheet">

    <div class="container main-container">

        <div class="btn-container col-md-12">
            <button class="btn btn-primary btn-new-pdf" onClick="location.href='/newreport'">日報作成</button>
            <button class="edit-construction-btn btn btn-primary btn-new-pdf" onClick="location.href='/construction'">工事番号</button>
            <button class="edit-construction-btn btn btn-primary btn-new-pdf" onClick="location.href='/edit_trader'">業者・重機</button>
            <button class="btn-dataexport btn btn-primary btn-new-pdf" onClick="location.href='/dataexport'">CSV出力</button>
        </div>

        <?php
            $userNames = array();
            foreach($allDailyreports as $dailyreport){
                $userNames[] = $dailyreport->userName;
            }
        ?>

        <div>
            <div class="refine">
                <form method="get" action="/" enctype="multipart/form-data">
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

                        <select name="department_id" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                            <option value="" label="default">部署を選択</option>

                            @foreach(array("住宅部", "土木部", "特殊建築部", "農業施設部") as $value)
                                @if($dailyreportsPalams['department_id'] == $loop->index+1)
                                    <option value="{{$loop->index+1}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$loop->index+1}}">{{$value}}</option>
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
                        <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
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
                    <button type="button" class="btn btn-primary btn-create-pdf" onClick="window.reset();">条件をリセット</button>
                    <button class="btn btn-primary btn-refine" onClick="location.href='/construction'">決定</button>
                </form>
            </div>
        </div>

        <div class="dailyreport-conteiner">

            <main class="dailyreport-wrapper">
                <table class="table table-striped table-condensed table-bordered table-nonfluid" border="1">
                    <thead class="header">
                        <tr><th>日報作者名</th><th>部署名</th><th>日付</th><th>工事番号</th><th>工事名</th><th>コピー</th><th>詳細</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($dailyreports as $dailyreport)
                            <tr>
                                <td>{{$dailyreport->userName}}</td>
                                @switch ($dailyreport->department_id)
                                    @case(1)
                                        <td>住宅部</td>
                                        @break
                                    @case(2)
                                        <td>土木部</td>
                                        @break
                                    @case(3)
                                        <td>特殊建築部</td>
                                        @break
                                    @case(4)
                                        <td>農業施設部</td>
                                        @break
                                    @default
                                        <td></td>
                                @endswitch
                                <td>{{$dailyreport->date->format('Y年m月d日')}}</td>
                                <td>{{$dailyreport->constructionNumber}}</td>
                                <td><div class="construction-name-form">{{$dailyreport->constructionName}}</div></td>
                                <td>
                                    <form method="get" action="/copyreport/{{$dailyreport->id}}">
                                        <input type="submit" class="btn btn-primary btn-create-pdf" value="コピーして作成" />
                                    </form>
                                </td>
                                <td>
                                    <form method="get" action="/{{$dailyreport->id}}">
                                        <input type="submit" class="btn btn-primary btn-create-pdf" value="詳細" />
                                    </form>
                                </td>
                            </tr>

                            <form method="POST" action="/delete/report/{{$dailyreport->id}}" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <button style="display: none;" type="submit" class="btn btn-primary btn-create-pdf delete-submit" id="{{$dailyreport->id}}"></button>
                            </form>
                        @endforeach
                    </tbody>
                </table>
              </main>
              <div class="pagination-container">
                {{ $dailyreports->links() }}
            </div>

        </div>
    </div>

    <script>
        // リセット処理
        function reset(){
            ['sort', 'userName', 'department_id', 'constructionNumber', 'constructionName'].forEach(name => {
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
            if($('select[name="department_id"]').val() != ""){
                $('select[name="department_id"]').addClass("select-choiced");
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
            $('select[name="department_id"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="department_id"]').removeClass("select-choiced");
                } else {
                    $('select[name="department_id"]').addClass("select-choiced");
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
