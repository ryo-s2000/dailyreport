@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <form method="post" action="/newreport" enctype="multipart/form-data">
            @csrf

            <div class="item-conteiner">
                <h5>お名前</h5>
                <div class="col-md-12">
                    <input name="username" class="tagsinput tagsinput-typeahead input-lg"  placeholder="建設　太郎" required />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>日付</h5>
                <div class="col-md-12">
                    <input type="date" name="date" value="{{$datetime}}">
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>天気</h5>
                <div class="col-md-12">
                    <span class="am">AM</span>
                    <input class="weather-icon" type="radio" name="amweather" value="sunny" checked="checked"><i class="fas fa-sun"></i>
                    <input class="weather-icon" type="radio" name="amweather" value="sunnyandcloudy"><i class="fas fa-cloud-sun"></i>
                    <input class="weather-icon" type="radio" name="amweather" value="cloudy"><i class="fas fa-cloud"></i>
                    <input class="weather-icon" type="radio" name="amweather" value="rain"><i class="fas fa-umbrella"></i>
                    <input class="weather-icon" type="radio" name="amweather" value="snow"><i class="far fa-snowflake"></i>
                </div>
                <div class="col-md-12">
                    <span class="pm">PM</span>
                    <input class="weather-icon" type="radio" name="pmweather" value="sunny" checked="checked"><i class="fas fa-sun"></i>
                    <input class="weather-icon" type="radio" name="pmweather" value="sunnyandcloudy"><i class="fas fa-cloud-sun"></i>
                    <input class="weather-icon" type="radio" name="pmweather" value="cloudy"><i class="fas fa-cloud"></i>
                    <input class="weather-icon" type="radio" name="pmweather" value="rain"><i class="fas fa-umbrella"></i>
                    <input class="weather-icon" type="radio" name="pmweather" value="snow"><i class="far fa-snowflake"></i>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事番号 工事名</h5>
                <div class="col-md-12">
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->number}}">{{$construction->number}}</option>
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="constructionName form-control select select-default mrs mbm">
                        <option value="">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->name}}">{{$construction->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>労務</h5>
                @foreach (range(1,5) as $i)
                    <div class="col-md-12 col-xs-10 cells-containre">
                        <span class="inputform">
                            <input name="traderName{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" />
                        </span>
                        <select name="peopleNumber{{$i}}" data-toggle="select" class="form-control select select-default mrs mbm">
                            <option value="">人数を選択</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <select name="workingTime{{$i}}" data-toggle="select" class="form-control select select-default mrs mbm">
                            <option value="">時間を選択</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <span class="inputform">
                            <input name="work{{$i}}" class="workvolume tagsinput tagsinput-typeahead input-lg" placeholder="作業及び出来高等"/>
                        </span>
                    </div>
                @endforeach
            <div>

            <div class="item-conteiner-top">
                <h5>購入資材</h5>
                @foreach (range(1,5) as $i)
                    <div class="col-md-12 cells-containre">
                        <span class="inputform">
                            <input name="materialTraderName{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" />
                        </span>
                        <span class="inputform">
                            <input name="materialName{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="資材名" />
                        </span>
                        <span class="inputform">
                            <input name="shapeDimensions{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="形状寸法" />
                        </span>
                        <span class="inputform">
                            <input name="quantity{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="数量" size="10" />
                        </span>
                        <span class="inputform">
                            <input name="unit{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="単位" size="10" />
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="item-conteiner-top">
                <button type="button" class="btn btn-primary" onclick="submit();">日報を保存する</button>
            </div>

        </form>
    </div>

    <script>
        $(function() {
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

    </script>

@endsection
