@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            if($dailyreport->userName != ""){
                $action = "/editreport/".$dailyreport->id;
            } else {
                $action = "/newreport";
            }
        ?>
        <form method="post" action="{{$action}}" enctype="multipart/form-data">
            @csrf

            <div class="item-conteiner">
                <h5>お名前</h5>
                <div class="col-md-12">
                    <input name="userName" class="tagsinput tagsinput-typeahead input-lg"  placeholder="建設　太郎" value="{{$dailyreport->userName}}" required />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>所属部署</h5>
                <div class="col-md-12">
                    <select name="department" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="">部署を選択</option>

                        @foreach(array("建築部", "土木部", "特殊建築部", "農業施設部") as $value)
                            @if($value == $dailyreport->department)
                                <option value="{{$value}}" selected="selected">{{$value}}</option>
                            @else
                                <option value="{{$value}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>日付</h5>
                <div class="col-md-12">
                    <input type="date" name="date" value="{{date('Y-m-d', strtotime( $dailyreport->date ))}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>天気</h5>
                <div class="col-md-12">
                    <span class="am">AM</span>
                    @foreach(array("sun", "cloud-sun", "cloud", "umbrella", "snowflake") as $value)
                        @if($value == $dailyreport->amWeather)
                            <input class="weather-icon" type="radio" name="amWeather" value="{{$value}}" checked="checked" /><i class="fas fa-{{$value}}"></i>
                        @else
                            <input class="weather-icon" type="radio" name="amWeather" value="{{$value}}" /><i class="fas fa-{{$value}}"></i>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-12">
                    <span class="pm">PM</span>
                    @foreach(array("sun", "cloud-sun", "cloud", "umbrella", "snowflake") as $value)
                        @if($value == $dailyreport->pmWeather)
                            <input class="weather-icon" type="radio" name="pmWeather" value="{{$value}}" checked="checked" /><i class="fas fa-{{$value}}"></i>
                        @else
                            <input class="weather-icon" type="radio" name="pmWeather" value="{{$value}}" /><i class="fas fa-{{$value}}"></i>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>工事番号・工事名</h5>
                <div class="col-md-12">
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            @if($construction->number == $dailyreport->constructionNumber)
                                <option value="{{$construction->number}}" selected="selected">{{$construction->number}}</option>
                            @else
                                <option value="{{$construction->number}}">{{$construction->number}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
                        <option value="">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            @if(str_replace("\n", "", $construction->name) == str_replace(array("\r","\n"), "", $dailyreport->constructionName))
                                <option value="{{$construction->name}}" selected="selected">{{$construction->name}}</option>
                            @else
                                <option value="{{$construction->name}}">{{$construction->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>労務</h5>
                @foreach (range(1,8) as $i)
                    <?php
                        $laborTraderName = "laborTraderName".$i;
                        $laborPeopleNumber = "laborPeopleNumber".$i;
                        $laborWorkTime = "laborWorkTime".$i;
                        $laborWorkVolume = "laborWorkVolume".$i;
                    ?>
                    <div class="col-md-12 col-xs-10 cells-containre">
                        <span class="inputform">
                            <input name="{{$laborTraderName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" value="{{$dailyreport->$laborTraderName}}"/>
                        </span>
                        <select name="{{$laborPeopleNumber}}" data-toggle="select" class="form-control select select-default mrs mbm">
                            <option value="">人数を選択</option>
                            @foreach(array("1", "2", "3", "4", "5") as $value)
                                @if($value == $dailyreport->$laborPeopleNumber)
                                    <option value="{{$value}}" selected="selected">{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="{{$laborWorkTime}}" data-toggle="select" class="form-control select select-default mrs mbm">
                            <option value="">時間を選択</option>
                            @foreach(array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10") as $value)
                                @if($value == $dailyreport->$laborWorkTime)
                                    <option value="{{$value}}" selected="selected">{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                        <span class="inputform">
                            <input name="{{$laborWorkVolume}}" class="work-volume tagsinput tagsinput-typeahead input-lg" placeholder="作業及び出来高等" value="{{$dailyreport->$laborWorkVolume}}"/>
                        </span>
                    </div>
                @endforeach
            <div>

            <div class="item-conteiner-top">
                <h5>重機車両</h5>
                @foreach (range(1,6) as $i)
                    <?php
                        $heavyMachineryTraderName = "heavyMachineryTraderName".$i;
                        $heavyMachineryModel = "heavyMachineryModel".$i;
                        $heavyMachineryTime = "heavyMachineryTime".$i;
                        $heavyMachineryRemarks = "heavyMachineryRemarks".$i;
                    ?>
                    <div class="col-md-12 col-xs-10 cells-containre">
                        <span class="inputform">
                            <input name="{{$heavyMachineryTraderName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" value="{{$dailyreport->$heavyMachineryTraderName}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$heavyMachineryModel}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="機種" value="{{$dailyreport->$heavyMachineryModel}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$heavyMachineryTime}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="時間" size="10" value="{{$dailyreport->$heavyMachineryTime}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$heavyMachineryRemarks}}" class="workvolume tagsinput tagsinput-typeahead input-lg" placeholder="備考" value="{{$dailyreport->$heavyMachineryRemarks}}" />
                        </span>
                    </div>
                @endforeach
            <div>

            <div class="item-conteiner-top">
                <h5>購入資材</h5>
                @foreach (range(1,5) as $i)
                    <?php
                        $materialTraderName = "materialTraderName".$i;
                        $materialName = "materialName".$i;
                        $materialShapeDimensions = "materialShapeDimensions".$i;
                        $materialQuantity = "materialQuantity".$i;
                        $materialUnit = "materialUnit".$i;
                        $materialResult = "materialResult".$i;
                        $materialInspectionMethods = "materialInspectionMethods".$i;
                        $materialInspector = "materialInspector".$i;
                    ?>
                    <div class="col-md-12 cells-containre">
                        <span class="inputform">
                            <input name="{{$materialTraderName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" value="{{$dailyreport->$materialTraderName}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$materialName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="資材名" value="{{$dailyreport->$materialName}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$materialShapeDimensions}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="形状寸法" value="{{$dailyreport->$materialShapeDimensions}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$materialQuantity}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="数量" size="10" value="{{$dailyreport->$materialQuantity}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$materialUnit}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="単位" size="10" value="{{$dailyreport->$materialUnit}}" />
                        </span>
                        <div>
                            <span class="col-md-12">
                                <span class="result">合否判定</span>
                                @foreach(array("pass", "fail") as $value)
                                    @if($value == $dailyreport->$materialResult)
                                        @if($value == "pass")
                                            <input type="radio" name="{{$materialResult}}" value="{{$value}}" checked="checked" />合
                                        @elseif($value == "fail")
                                            <input type="radio" name="{{$materialResult}}" value="{{$value}}" checked="checked" />非
                                        @endif
                                    @else
                                        @if($value == "pass")
                                            <input type="radio" name="{{$materialResult}}" value="{{$value}}" />合
                                        @elseif($value == "fail")
                                            <input type="radio" name="{{$materialResult}}" value="{{$value}}" />非
                                        @endif
                                    @endif
                                @endforeach
                            </span>
                            <span class="inputform">
                                <input name="{{$materialInspectionMethods}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査方法・資料" value="{{$dailyreport->$materialInspectionMethods}}" />
                            </span>
                            <span class="inputform">
                                <input name="{{$materialInspector}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査員" size="10" value="{{$dailyreport->$materialInspector}}" />
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="item-conteiner-top">
                <h5>工程内検査</h5>
                @foreach (range(1,4) as $i)
                    <?php
                        $processName = "processName".$i;
                        $processLocation = "processLocation".$i;
                        $processMethods = "processMethods".$i;
                        $processDocument = "processDocument".$i;
                        $processResult = "processResult".$i;
                        $processInspector = "processInspector".$i;
                    ?>
                    <div class="col-md-12 cells-containre">
                        <span class="inputform">
                            <input name="{{$processName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="工程内検査名" value="{{$dailyreport->$processName}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$processLocation}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査箇所" value="{{$dailyreport->$processLocation}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$processMethods}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査方法" value="{{$dailyreport->$processMethods}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$processDocument}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="資料等" value="{{$dailyreport->$processDocument}}" />
                        </span>
                        <div>
                            <span class="col-md-12">
                                <span class="result">合否判定</span>
                                @foreach(array("pass", "fail") as $value)
                                    @if($value == $dailyreport->$processResult)
                                        @if($value == "pass")
                                            <input type="radio" name="{{$processResult}}" value="{{$value}}" checked="checked" />合
                                        @elseif($value == "fail")
                                            <input type="radio" name="{{$processResult}}" value="{{$value}}" checked="checked" />非
                                        @endif
                                    @else
                                        @if($value == "pass")
                                            <input type="radio" name="{{$processResult}}" value="{{$value}}" />合
                                        @elseif($value == "fail")
                                            <input type="radio" name="{{$processResult}}" value="{{$value}}" />非
                                        @endif
                                    @endif
                                @endforeach
                            </span>
                            <span class="inputform">
                                <input name="{{$processInspector}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査員" size="10" value="{{$dailyreport->$processInspector}}" />
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="item-conteiner-top">
                <h5>測定機器点検</h5>
                @foreach (range(1,2) as $i)
                    <?php
                        $measuringEquipmentName = "measuringEquipmentName".$i;
                        $measuringEquipmentNumber = "measuringEquipmentNumber".$i;
                        $measuringEquipmentResult = "measuringEquipmentResult".$i;
                        $measuringEquipmentRemarks = "measuringEquipmentRemarks".$i;
                    ?>
                    <div class="col-md-12 cells-containre">
                        <span class="inputform">
                            <input name="{{$measuringEquipmentName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="測定機器名" value="{{$dailyreport->$measuringEquipmentName}}" />
                        </span>
                        <span class="inputform">
                            <input name="{{$measuringEquipmentNumber}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="管理番号" value="{{$dailyreport->$measuringEquipmentNumber}}" />
                        </span>
                        <span class="col-md-12">
                            <span class="result">異常</span>
                            @foreach(array("abnormal", "noabnormal") as $value)
                                @if($value == $dailyreport->$measuringEquipmentResult)
                                    @if($value == "abnormal")
                                        <input type="radio" name="{{$measuringEquipmentResult}}" value="{{$value}}" checked="checked" />有り
                                    @elseif($value == "noabnormal")
                                        <input type="radio" name="{{$measuringEquipmentResult}}" value="{{$value}}" checked="checked" />無し
                                    @endif
                                @else
                                    @if($value == "abnormal")
                                        <input type="radio" name="{{$measuringEquipmentResult}}" value="{{$value}}" />有り
                                    @elseif($value == "noabnormal")
                                        <input type="radio" name="{{$measuringEquipmentResult}}" value="{{$value}}" />無し
                                    @endif
                                @endif
                            @endforeach
                        </span>

                        <span class="inputform">
                            <input name="{{$measuringEquipmentRemarks}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="備考(使用場所等)" value="{{$dailyreport->$measuringEquipmentRemarks}}" />
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
                        @foreach(array("abnormal", "noabnormal") as $value)
                            @if($dailyreport->patrolResult == "")
                                @if($value == "abnormal")
                                    <input type="radio" name="patrolResult" value="{{$value}}" />有り
                                @elseif($value == "noabnormal")
                                    <input type="radio" name="patrolResult" value="{{$value}}" checked="checked" />無し
                                @endif
                            @elseif($value == $dailyreport->patrolResult)
                                @if($value == "abnormal")
                                    <input type="radio" name="patrolResult" value="{{$value}}" checked="checked" />有り
                                @elseif($value == "noabnormal")
                                    <input type="radio" name="patrolResult" value="{{$value}}" checked="checked" />無し
                                @endif
                            @else
                                @if($value == "abnormal")
                                    <input type="radio" name="patrolResult" value="{{$value}}" />有り
                                @elseif($value == "noabnormal")
                                    <input type="radio" name="patrolResult" value="{{$value}}" />無し
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-12">
                        <textarea name="patrolFindings" class="form-control" rows="5">{{$dailyreport->patrolFindings}}</textarea>
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
