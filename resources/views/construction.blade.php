@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">

    <div class="container main-container">

        <div class="btn-container col-md-12">
            <button class="btn btn-primary btn-new-pdf" onclick="location.href='/newconstruction'">工事番号登録</button>
        </div>

        <div class="dailyreport-conteiner">
            <div class="dailyreport">
                <table border="1">
                    <tr><th>工事番号</th><th>工事名</th><th>発注者</th><th>値段</th><th>更新日</th><th>編集</th><th>削除</th></tr>

                    @foreach ($constructions as $construction)
                        <tr>
                            <td>{{$construction->number}}</td>
                            <td>{{$construction->name}}</td>
                            <td>{{$construction->orderer}}</td>
                            <td>{{$construction->price}}</td>
                            <td>{{$construction->updated_at->format('Y年m月d日')}}</td>
                            <td>
                                <form method="get" action="/editconstruction/{{$construction->id}}">
                                    <input type="submit" class="btn btn-primary btn-create-pdf" value="編集" />
                                </form>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-create-pdf" onClick="waringDelete({{$construction->id}})">削除</button>
                            </td>
                        </tr>

                        <form method="POST" action="/delete/construction/{{$construction->id}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary btn-create-pdf delete-submit" id="{{$construction->id}}"></button>
                        </form>
                    @endforeach

                </table>
            </div>
        </div>

    </div>

    <script>
        function waringDelete(id){
            ret = prompt("※この処理を実行するとデータが削除されます。\rそれでもよろしければ入力欄にdeleteと打ち込んでボタンを押してください。", "");
            if (ret == 'delete'){
                document.getElementById(id).click();
            }
        }
    </script>

@endsection
