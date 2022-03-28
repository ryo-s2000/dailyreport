@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/showreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <h5>詳細情報</h5>
        <div class="btn-container">
            <div>
                <form method="get" action="/editreport/{{$dailyreport->id}}">
                    <input type="submit" class="btn btn-primary btn-new-pdf" value="編集" />
                </form>
            </div>

            <div>
                <input type="submit" class="edit-construction-btn btn btn-primary btn-new-pdf" onClick="waringDelete({{$dailyreport->id}})" value="削除" />
            </div>

            <form method="POST" action="/delete/report/{{$dailyreport->id}}" style="display: none;">
                @csrf
                @method('DELETE')
                <button style="display: none;" type="submit" class="btn btn-primary btn-create-pdf delete-submit" id="{{$dailyreport->id}}"></button>
            </form>

            <div>
                <form method="get" action="/pdf/{{$dailyreport->id}}" target="_blank">
                    <input type="submit" class="photo-btn btn btn-primary btn-new-pdf" value="Preview" />
                </form>
            </div>
        </div>
        <main class="detail-dailyreport-wrapper">
            <table class="table table-striped table-condensed table-bordered table-nonfluid datail-table" border="1">
                    <tr><th>日報作者名</th><td>{{$dailyreport->userName}}</td></tr>
                    <tr>
                        <th>部署名</th>
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
                    </tr>
                    <tr><th>日付</th><td>{{$dailyreport->date->format('Y年m月d日')}}</td></tr>
                    <tr><th>工事番号</th><td>{{$dailyreport->constructionNumber}}</td></tr>
                    <tr><th>工事名</th><td>{{$dailyreport->constructionName}}</td></tr>
            </table>
        </main>
    </div>

    <script>
        // データ削除処理
        function waringDelete(id){
            ret = prompt("※この処理を実行するとデータが削除されます。\rそれでもよろしければ入力欄にdeleteと打ち込んでボタンを押してください。", "");
            if (ret == 'delete'){
                document.getElementById(id).click();
            }
        }
    </script>

@endsection
