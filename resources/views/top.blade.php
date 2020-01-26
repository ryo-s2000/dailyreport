@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">

    <div class="container main-container">

        <div class="btn-new-pdf-conteiner">
            <button class="btn btn-primary btn-new-pdf" onclick="location.href='/newreport'">日報を作成する</button>
        </div>

        <div class="dailyreport-conteiner">
            <div class="dailyreport">
                <table border="1">
                    <tr><th>日報作者名</th><th>日付</th><th>工事番号</th><th>工事名</th><th>PDF</th></tr>

                    @foreach ($dailyreports as $dailyreport)
                        <tr>
                            <td>{{$dailyreport->username}}</td>
                            <td>{{$dailyreport->date->format('Y年m月d日')}}</td>
                            <td>{{$dailyreport->constructionNumber}}</td>
                            <td>{{$dailyreport->constructionName}}</td>
                            <td>
                                <form method="get" action="/pdf/{{$dailyreport->id}}" enctype="multipart/form-data" target="_blank">
                                    @csrf
                                    <input type="submit" class="btn btn-primary btn-create-pdf" value="Preview" />
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>

    </div>

@endsection
