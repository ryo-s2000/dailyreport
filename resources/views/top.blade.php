@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">

    <div class="container main-container">

        <div class="btn-container col-md-12">
            <button class="btn btn-primary btn-new-pdf" onClick="location.href='/newreport'">日報を作成する</button>
            <button class="photo-btn btn btn-primary btn-new-pdf" onClick="location.href='/photo'">画像一覧</button>
            <button class="edit-construction-btn btn btn-primary btn-new-pdf" onClick="location.href='/construction'">工事番号</button>
            <button class="btn-dataexport btn btn-primary btn-new-pdf" onClick="location.href='/dataexport'">CSVを出力する</button>
        </div>

        <?php
            $userNames = array();
            foreach($allDailyreports as $dailyreport){
                $userNames[] = $dailyreport->userName;
            }
        ?>

        <div>
            <div class="refine">
                <div><span class="refine-title">絞り込み</span></div>
                <form method="get" action="/" enctype="multipart/form-data">
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


                    <button class="btn btn-primary btn-refine" onClick="location.href='/construction'">決定</button>
                </form>
            </div>
        </div>

        <div class="dailyreport-conteiner">

            <main class="dailyreport-wrapper">
                <table class="table table-striped table-condensed table-bordered table-nonfluid" border="1">
                    <thead class="header">
                        <tr><th>日報作者名</th><th>部署名</th><th>日付</th><th>工事番号</th><th>工事名</th><th>コピー</th><th>編集</th><th>PDF</th><th>削除</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($dailyreports as $dailyreport)
                            <tr>
                                <td>{{$dailyreport->userName}}</td>
                                <td>{{$dailyreport->department}}</td>
                                <td>{{$dailyreport->date->format('Y年m月d日')}}</td>
                                <td>{{$dailyreport->constructionNumber}}</td>
                                <td>{{$dailyreport->constructionName}}</td>
                                <td>
                                    <form method="get" action="/copyreport/{{$dailyreport->id}}">
                                        <input type="submit" class="btn btn-primary btn-create-pdf" value="コピーして作成" />
                                    </form>
                                </td>
                                <td>
                                    <form method="get" action="/editreport/{{$dailyreport->id}}">
                                        <input type="submit" class="btn btn-primary btn-create-pdf" value="編集" />
                                    </form>
                                </td>
                                <td>
                                    <form method="get" action="/pdf/{{$dailyreport->id}}" target="_blank">
                                        <input type="submit" class="btn btn-primary btn-create-pdf" value="Preview" />
                                    </form>
                                </td>
                                <td>
                                    <input type="submit" class="btn btn-primary btn-create-pdf" onClick="waringDelete({{$dailyreport->id}})" value="削除" />
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

        </div>

    </div>

    <script>
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
        });

        // データ削除処理
        function waringDelete(id){
            ret = prompt("※この処理を実行するとデータが削除されます。\rそれでもよろしければ入力欄にdeleteと打ち込んでボタンを押してください。", "");
            if (ret == 'delete'){
                document.getElementById(id).click();
            }
        }
    </script>

@endsection
