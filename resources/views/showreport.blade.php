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
                    <tr><th>部署名</th><td>{{$dailyreport->department}}</td></tr>
                    <tr><th>日付</th><td>{{$dailyreport->date->format('Y年m月d日')}}</td></tr>
                    <tr><th>工事番号</th><td>{{$dailyreport->constructionNumber}}</td></tr>
                    <tr><th>工事名</th><td>{{$dailyreport->constructionName}}</td></tr>
            </table>
        </main>

        <h5 style="margin-top: 50px;">写真</h5>
        <div class="photo-container">
            @foreach(array("imagepath1", "imagepath2", "imagepath3", "imagepath4", "imagepath5") as $path)
                @if($dailyreport->$path)
                    <div class="photo-cell">
                        <div>
                            <img class="photo" src={{$dailyreport->$path}}>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <h5 style="margin-top: 50px;">確認用署名</h5>
        <div class="btn-container">
            <form method="get" action="/newsignature/{{$dailyreport->id}}">
                <input type="submit" class="btn btn-primary btn-new-pdf" value="署名を作成" />
            </form>
        </div>

        <main class="signature-wrapper">
            <table class="table table-striped table-condensed table-bordered table-nonfluid" border="1">
                <thead class="header">
                    <tr><th>名前</th><th>確認時間</th><th>備考</th><th>編集</th><th>削除</th></tr>
                </thead>
                <tbody>

                    @foreach ($signatures as $signature)
                        <tr>
                            <td>{{$signature->name}}</td>
                            <td>{{$signature->updated_at->format('Y年m月d日')}}</td>
                            <td>{{$signature->remarks}}</td>
                            <td>
                                <form method="get" action="/editsignature/{{$signature->id}}">
                                    <input type="submit" class="btn btn-primary btn-create-pdf" value="編集" />
                                </form>
                            </td>
                            <td>
                                <input type="submit" class="btn btn-primary btn-create-pdf" onClick="waringSignatureDelete({{$signature->id}})" value="削除" />
                            </td>
                        </tr>

                        <form method="POST" action="/delete/signature/{{$signature->id}}/{{$signature->reportid}}" style="display: none;">
                            @csrf
                            @method('DELETE')
                            <button style="display: none;" type="submit" class="btn btn-primary btn-create-pdf delete-submit" id="signature-{{$signature->id}}"></button>
                        </form>
                    @endforeach

                </tbody>
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

        function waringSignatureDelete(id){
            ret = prompt("※この処理を実行するとデータが削除されます。\rそれでもよろしければ入力欄にdeleteと打ち込んでボタンを押してください。", "");
            if (ret == 'delete'){
                elementId = 'signature-' + id
                document.getElementById(elementId).click();
            }
        }
    </script>

@endsection
