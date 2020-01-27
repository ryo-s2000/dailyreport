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
                    <input name="userName" class="tagsinput tagsinput-typeahead input-lg"  placeholder="建設　太郎" required />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>所属部署</h5>
                <div class="col-md-12">
                    <select name="department" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="">部署を選択</option>
                        <option value="建築部">建築部</option>
                        <option value="土木部">土木部</option>
                        <option value="特殊建築部">特殊建築部</option>
                        <option value="農業施設部">農業施設部</option>
                    </select>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>日付</h5>
                <div class="col-md-12">
                    <input type="date" name="date" value="{{$datetime}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>天気</h5>
                <div class="col-md-12">
                    <span class="am">AM</span>
                    <input class="weather-icon" type="radio" name="amWeather" value="sunny" checked="checked" /><i class="fas fa-sun"></i>
                    <input class="weather-icon" type="radio" name="amWeather" value="sunnyandcloudy" /><i class="fas fa-cloud-sun"></i>
                    <input class="weather-icon" type="radio" name="amWeather" value="cloudy" /><i class="fas fa-cloud"></i>
                    <input class="weather-icon" type="radio" name="amWeather" value="rain" /><i class="fas fa-umbrella"></i>
                    <input class="weather-icon" type="radio" name="amWeather" value="snow" /><i class="far fa-snowflake"></i>
                </div>
                <div class="col-md-12">
                    <span class="pm">PM</span>
                    <input class="weather-icon" type="radio" name="pmWeather" value="sunny" checked="checked" /><i class="fas fa-sun"></i>
                    <input class="weather-icon" type="radio" name="pmWeather" value="sunnyandcloudy" /><i class="fas fa-cloud-sun"></i>
                    <input class="weather-icon" type="radio" name="pmWeather" value="cloudy" /><i class="fas fa-cloud"></i>
                    <input class="weather-icon" type="radio" name="pmWeather" value="rain" /><i class="fas fa-umbrella"></i>
                    <input class="weather-icon" type="radio" name="pmWeather" value="snow" /><i class="far fa-snowflake"></i>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事番号・工事名</h5>
                <div class="col-md-12">
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->number}}">{{$construction->number}}</option>
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
                        <option value="">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->name}}">{{$construction->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>労務</h5>
                @foreach (range(1,8) as $i)
                    <div class="col-md-12 col-xs-10 cells-containre">
                        <span class="inputform">
                            <input name="laborTraderName{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" />
                        </span>
                        <select name="laborPeopleNumber{{$i}}" data-toggle="select" class="form-control select select-default mrs mbm">
                            <option value="">人数を選択</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <select name="laborWorkTime{{$i}}" data-toggle="select" class="form-control select select-default mrs mbm">
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
                            <input name="laborWorkVolume{{$i}}" class="work-volume tagsinput tagsinput-typeahead input-lg" placeholder="作業及び出来高等" />
                        </span>
                    </div>
                @endforeach
            <div>

            <div class="item-conteiner-top">
                <h5>重機車両</h5>
                @foreach (range(1,6) as $i)
                    <div class="col-md-12 col-xs-10 cells-containre">
                        <span class="inputform">
                            <input name="heavyMachineryTraderName{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" />
                        </span>
                        <span class="inputform">
                            <input name="heavyMachineryModel{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="機種" />
                        </span>
                        <span class="inputform">
                            <input name="heavyMachineryTime{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="時間" size="10" />
                        </span>
                        <span class="inputform">
                            <input name="heavyMachineryRemarks{{$i}}" class="workvolume tagsinput tagsinput-typeahead input-lg" placeholder="備考"/>
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
                            <input name="materialShapeDimensions{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="形状寸法" />
                        </span>
                        <span class="inputform">
                            <input name="materialQuantity{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="数量" size="10" />
                        </span>
                        <span class="inputform">
                            <input name="materialUnit{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="単位" size="10" />
                        </span>
                        <div>
                            <span class="col-md-12">
                                <span class="result">合否判定</span>
                                <input type="radio" name="materialResult{{$i}}" value="pass" />合
                                <input type="radio" name="materialResult{{$i}}" value="fail" />非
                            </span>
                            <span class="inputform">
                                <input name="materialInspectionMethods{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査方法・資料" />
                            </span>
                            <span class="inputform">
                                <input name="materialInspector{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査員" size="10" />
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="item-conteiner-top">
                <h5>工程内検査</h5>
                @foreach (range(1,4) as $i)
                    <div class="col-md-12 cells-containre">
                        <span class="inputform">
                            <input name="processName{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="工程内検査名" />
                        </span>
                        <span class="inputform">
                            <input name="processLocation{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査箇所" />
                        </span>
                        <span class="inputform">
                            <input name="processMethods{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査方法" />
                        </span>
                        <span class="inputform">
                            <input name="processDocument{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="資料等" />
                        </span>
                        <div>
                            <span class="col-md-12">
                                <span class="result">合否判定</span>
                                <input type="radio" name="processResult{{$i}}" value="pass" />合
                                <input type="radio" name="processResult{{$i}}" value="fail" />非
                            </span>
                            <span class="inputform">
                                <input name="processInspector{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査員" size="10" />
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="item-conteiner-top">
                <h5>測定機器点検</h5>
                @foreach (range(1,2) as $i)
                    <div class="col-md-12 cells-containre">
                        <span class="inputform">
                            <input name="measuringEquipmentName{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="測定機器名" />
                        </span>
                        <span class="inputform">
                            <input name="measuringEquipmentNumber{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="管理番号" />
                        </span>
                        <span class="col-md-12">
                            <span class="result">異常</span>
                            <input type="radio" name="measuringEquipmentResult{{$i}}" value="abnormal" />有り
                            <input type="radio" name="measuringEquipmentResult{{$i}}" value="noabnormal" />無し
                        </span>
                        <span class="inputform">
                            <input name="measuringEquipmentRemarks{{$i}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="備考(使用場所等)" />
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="item-conteiner-top">
                <h5>連絡・報告事項等</h5>
                <div class="col-md-12 cells-containre">
                    <div class="col-md-12">現場代理人の巡視所見</div>
                    <div class="col-md-12">
                        <span class="result">異常</span>
                        <input type="radio" name="patrolResult" value="abnormal" />有り
                        <input type="radio" name="patrolResult" value="noabnormal" checked="checked" />無し
                    </div>
                    <div class="col-md-12">
                        <textarea name="patrolFindings" class="form-control" rows="5"></textarea>
                    </div>
                </div>
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
