@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">

    <div class="container main-container">

        <div class="btn-container col-md-12">
            <button class="btn btn-primary btn-new-pdf" onclick="location.href='/newreport'">日報を作成する</button>
            <button class="photo-btn btn btn-primary btn-new-pdf" onclick="location.href='/photo'">画像一覧</button>
            <button class="edit-construction-btn btn btn-primary btn-new-pdf" onClick="waring()">工事番号編集</button>
        </div>
        <div class="btn-container col-md-12">
            <button class="btn-dataexport btn btn-primary btn-new-pdf" onclick="location.href='/dataexport'">CSVを出力する</button>
        </div>

        <div class="dailyreport-conteiner">
            <div class="dailyreport">
                <table border="1">
                    <tr><th>日報作者名</th><th>部署名</th><th>日付</th><th>工事番号</th><th>工事名</th><th>コピー</th><th>編集</th><th>PDF</th><th>削除</th></tr>

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
                                <button class="btn btn-primary btn-create-pdf" onClick="waringDelete({{$dailyreport->id}})">削除</button>
                            </td>
                        </tr>

                        <form method="POST" action="/delete/report/{{$dailyreport->id}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary btn-create-pdf delete-submit" id="{{$dailyreport->id}}"></button>
                        </form>
                    @endforeach

                </table>
            </div>
        </div>

    </div>

    <script>
        function waring(){
            ret = confirm("工事番号の編集ページへ遷移します。\r必ず管理者に許可を得てから編集してください。");
            if (ret == true){
                location.href = "/construction";
            }
        }

        function waringDelete(id){
            ret = prompt("※この処理を実行するとデータが削除されます。\rそれでもよろしければ入力欄にdeleteと打ち込んでボタンを押してください。", "");
            if (ret == 'delete'){
                document.getElementById(id).click();
            }
        }
    </script>

@endsection
