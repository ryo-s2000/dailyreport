@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            $url = url()->current();

            if(strpos($url, 'newreport') !== false){
                $action = "/newreport";
            } else if (strpos($url, 'copyreport') !== false){
                $action = "/newreport";
            } else if (strpos($url, 'editreport') !== false){
                $action = "/editreport/".$dailyreport->id;
            }

        ?>

        @if (count($errors) > 0)
        <!-- Form Error List -->
            <div class="alert alert-danger">
                <strong>エラーが発生しています！</strong>

                <br><br>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{$action}}" enctype="multipart/form-data">
            @csrf

            <div class="item-conteiner">
                <h5>お名前  <span class="required">[必須]</span></h5>
                <div class="col-md-12">
                    <input name="userName" class="tagsinput tagsinput-typeahead input-lg"  placeholder="建設　太郎" value="{{$dailyreport->userName}}" required />
                </div>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>所属部署  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <select name="department" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                        <option value="" label="default">部署を選択</option>

                        @foreach(array("住宅部", "土木部", "特殊建築部", "農業施設部") as $value)
                            @if($value == $dailyreport->department)
                                <option value="{{$value}}" selected="selected">{{$value}}</option>
                            @else
                                <option value="{{$value}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <select class="select-checker" name="departmentChecker" required>
                    <option label="default" selected><option>

                    @if($dailyreport->department != "")
                        <option value="true" selected>true</option>
                    @else
                        <option value="true">true</option>
                    @endif
                </select>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>工事番号・工事名  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            @if($construction->number == $dailyreport->constructionNumber)
                                <option value="{{$construction->number}}" selected="selected">{{$construction->number}}</option>
                            @else
                                <option value="{{$construction->number}}">{{$construction->number}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
                        <option value="" label="default">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            @if(str_replace("\n", "", $construction->name) == str_replace(array("\r","\n"), "", $dailyreport->constructionName))
                                <option value="{{$construction->name}}" selected="selected">{{$construction->name}}</option>
                            @else
                                <option value="{{$construction->name}}">{{$construction->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <select class="select-checker" name="constructionNumberChecker" required>
                    <option label="default" selected><option>

                    @if($dailyreport->constructionNumber != "")
                        <option value="true" selected>true</option>
                    @else
                        <option value="true">true</option>
                    @endif
                </select>
                <select class="select-checker" name="constructionNameChecker" required>
                    <option label="default" selected><option>

                    @if($dailyreport->constructionName != "")
                        <option value="true" selected>true</option>
                    @else
                        <option value="true">true</option>
                    @endif
                </select>
            </div>


            <div class="item-conteiner-top">
                <h5>日付  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <input type="date" name="date" value="{{date('Y-m-d', strtotime( $dailyreport->date ))}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>天気</h5>
                <div class="col-md-12">
                    <span class="am">AM</span>
                    @foreach(array("sun", "cloud-sun", "cloud", "umbrella", "snowflake") as $value)
                        @if($dailyreport->amWeather == "" and $value == "sun")
                            <input class="weather-icon" type="radio" name="amWeather" value="{{$value}}" checked="checked" /><i class="fas fa-{{$value}}"></i>
                        @elseif($value == $dailyreport->amWeather)
                            <input class="weather-icon" type="radio" name="amWeather" value="{{$value}}" checked="checked" /><i class="fas fa-{{$value}}"></i>
                        @else
                            <input class="weather-icon" type="radio" name="amWeather" value="{{$value}}" /><i class="fas fa-{{$value}}"></i>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-12">
                    <span class="pm">PM</span>
                    @foreach(array("sun", "cloud-sun", "cloud", "umbrella", "snowflake") as $value)
                        @if($dailyreport->pmWeather == "" and $value == "sun")
                            <input class="weather-icon" type="radio" name="pmWeather" value="{{$value}}" checked="checked" /><i class="fas fa-{{$value}}"></i>
                        @elseif($value == $dailyreport->pmWeather)
                            <input class="weather-icon" type="radio" name="pmWeather" value="{{$value}}" checked="checked" /><i class="fas fa-{{$value}}"></i>
                        @else
                            <input class="weather-icon" type="radio" name="pmWeather" value="{{$value}}" /><i class="fas fa-{{$value}}"></i>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="accbox">

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label1" class="cssacc" />
                    <label for="label1"><span class="label-font">労務</span></label>
                    <div class="accshow">
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
                                    @foreach(range(1,10) as $value)
                                        @if($value == $dailyreport->$laborPeopleNumber)
                                            <option value="{{$value}}" selected="selected">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select name="{{$laborWorkTime}}" data-toggle="select" class="form-control select select-default mrs mbm">
                                    <option value="">時間を選択</option>
                                    @foreach(range(1,10) as $value)
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
                    </div>
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label2" class="cssacc" />
                    <label for="label2"><span class="label-font">重機車両</span></label>
                    <div class="accshow">
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
                                    <input name="{{$heavyMachineryTime}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="台" size="10" value="{{$dailyreport->$heavyMachineryTime}}" />
                                </span>
                                <span class="inputform">
                                    <input name="{{$heavyMachineryRemarks}}" class="workvolume tagsinput tagsinput-typeahead input-lg" placeholder="備考" value="{{$dailyreport->$heavyMachineryRemarks}}" />
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label3" class="cssacc" />
                    <label for="label3"><span class="label-font">購入資材</span></label>
                    <div class="accshow">
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
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label4" class="cssacc" />
                    <label for="label4"><span class="label-font">工程内検査</span></label>
                    <div class="accshow">
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
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label5" class="cssacc" />
                    <label for="label5"><span class="label-font">測定機器点検</span></label>
                    <div class="accshow">
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
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label6" class="cssacc" />
                    <label for="label6"><span class="label-font">連絡・報告事項等</span></label>
                    <div class="accshow">
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
                                <textarea class="patrol-textarea" name="patrolFindings" rows="5" cols="98" wrap="hard" placeholder="5行以内">{{$dailyreport->patrolFindings}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label7" class="cssacc" />
                    <label for="label7"><span class="label-font">画像を選択(5枚まで)</span></label>
                    <div class="accshow">
                        @foreach (range(1,5) as $i)
                            <?php
                                $imagepath = "imagepath".$i;
                            ?>
                            <div class="col-md-12 col-xs-10 file-upload-container">
                                <img class="photo" src="{{ $dailyreport->$imagepath }}">
                                <input type="file" name="{{$imagepath}}">
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="item-conteiner-top">
                <input type="submit" class="btn btn-primary" value="日報を保存する" />
            </div>

        </form>
    </div>

    <script>
        $(function() {
            // selectチェッカー
            $('select[name="department"]').change(function(e, data) {
                if($(this).prop("selectedIndex")){
                    $('select[name="departmentChecker"]').val("true");
                } else {
                    $('select[name="departmentChecker"]').prop("selectedIndex", 0);
                }
            });
            $('select[name="constructionNumber"]').change(function(e, data) {
                if($(this).prop("selectedIndex")){
                    $('select[name="constructionNumberChecker"]').val("true");
                } else {
                    $('select[name="constructionNumberChecker"]').prop("selectedIndex", 0);
                }
            });
            $('select[name="constructionName"]').change(function(e, data) {
                if($(this).prop("selectedIndex")){
                    $('select[name="constructionNameChecker"]').val("true");
                } else {
                    $('select[name="constructionNameChecker"]').prop("selectedIndex", 0);
                }
            });

            // 工事番号、工事名同期処理
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
