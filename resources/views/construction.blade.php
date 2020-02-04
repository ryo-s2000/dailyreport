@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
    <link href="{{ asset('css/construction.css') }}" rel="stylesheet">

    <div class="container main-container">

        @if( $user ?? false == 'root')
            <div class="btn-container col-md-12">
                <button class="btn btn-primary btn-new-pdf display-none display-pc display-root" onClick="location.href='/newconstruction'">工事番号登録</button>
            </div>
        @else
            <div class="btn-container col-md-12">
                <button class="edit-construction-btn btn btn-primary btn-new-pdf" onClick="root()">管理用アカウントに変更する</button>
            </div>
        @endif

        <div class="dailyreport-conteiner">
            <div class="dailyreport">
                <table border="1">
                    <tr>
                        <th class="display-none display-pc display-sp">工事番号</th>
                        <th class="display-none display-pc display-sp">工事名</th>
                        <th class="display-none display-pc">発注者</th>
                        <th class="display-none display-pc">値段</th>
                        <th class="display-none display-pc display-sp">工期自</th>
                        <th class="display-none display-pc display-sp">工期至</th>
                        <th class="display-none display-pc display-sp">工事箇所</th>
                        <th class="display-none display-pc display-sp">営業担当</th>
                        <th class="display-none display-pc display-sp">工事担当</th>
                        <th class="display-none display-pc display-sp">備考</th>
                        @if( $user ?? false == 'root')
                            <th class="display-none display-pc display-root">編集</th>
                            <th class="display-none display-pc display-root">削除</th>
                        @endif
                    </tr>

                    @foreach ($constructions as $construction)
                        <tr>
                            <td class="display-none display-pc display-sp">{{$construction->number}}</td>
                            <td class="display-none display-pc display-sp">{{$construction->name}}</td>
                            <td class="display-none display-pc">{{$construction->orderer}}</td>
                            <td class="display-none display-pc">{{number_format($construction->price)}}</td>
                            <td class="display-none display-pc display-sp">
                                @if(date('Y-m-d', strtotime($construction->start)) != date('Y-m-d', strtotime('0000-00-00')))
                                    {{$construction->start->format('Y年m月d日')}}
                                @endif
                            </td>
                            <td class="display-none display-pc display-sp">
                                @if(date('Y-m-d', strtotime($construction->end)) != date('Y-m-d', strtotime('0000-00-00')))
                                    {{$construction->end->format('Y年m月d日')}}
                                @endif
                            </td>
                        <td class="display-none display-pc display-sp">{{$construction->place}}</td>
                            <td class="display-none display-pc display-sp">{{$construction->sales}}</td>
                            <td class="display-none display-pc display-sp">{{$construction->supervisor}}</td>
                            <td class="display-none　display-pc display-sp">{{$construction->remarks}}</td>
                            @if( $user ?? false == 'root')
                                <td class="display-none display-pc display-root">
                                    <form method="get" action="/editconstruction/{{$construction->id}}">
                                        <input type="submit" class="btn btn-primary btn-create-pdf" value="編集" />
                                    </form>
                                </td>
                                <td class="display-none display-pc display-root">
                                    <button class="btn btn-primary btn-create-pdf" onClick="waringDelete({{$construction->id}})">削除</button>
                                </td>
                            @endif
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

        function root(){
            ret = prompt("※パスワードを入力してください。", "");
            url = "/construction/" + ret;
            location.href=url;
        }
    </script>

@endsection
