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
                    <tr><th>工事番号</th><th>工事名</th><th>発注者</th><th>値段</th><th>更新日</th><th>編集</th></tr>

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
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>

    </div>

@endsection
