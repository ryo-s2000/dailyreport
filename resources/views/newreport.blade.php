@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            $url = url()->current();
            $action = '';

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
                    <input name="userName" class="tagsinput tagsinput-typeahead input-lg"  placeholder="建設　太郎" value="{{old('userName') ?? $dailyreport->userName}}" required />
                </div>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>所属部署  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <?php $selectedDepartment = false ?>
                    <select name="department" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                        <option value="" label="default">部署を選択</option>

                        @foreach(array("住宅部", "土木部", "特殊建築部", "農業施設部") as $value)
                            @if($value == (old('department')))
                                <option value="{{$value}}" selected="selected">{{$value}}</option>
                                <?php $selectedDepartment = true ?>
                            @elseif(old('department') == "" and $value == $dailyreport->department)
                                <option value="{{$value}}" selected="selected">{{$value}}</option>
                                <?php $selectedDepartment = true ?>
                            @else
                                <option value="{{$value}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <select class="select-checker" name="departmentChecker" required>
                    <option label="default" selected><option>

                    @if($selectedDepartment)
                        <option value="true" selected>true</option>
                    @else
                        <option value="true">true</option>
                    @endif
                </select>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>工事番号・工事名  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <?php
                        $selectedNumber = false;
                        $selectedName = false ;
                    ?>
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            @if($construction->number == old('constructionNumber'))
                                <?php $selectedNumber = true ?>
                                <option value="{{$construction->number}}" selected="selected">{{$construction->number}}</option>
                            @elseif(old('constructionNumber') == "" and $construction->number == $dailyreport->constructionNumber)
                                <?php $selectedNumber = true ?>
                                <option value="{{$construction->number}}" selected="selected">{{$construction->number}}</option>
                            @else
                                <option value="{{$construction->number}}">{{$construction->number}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
                        <option value="" label="default">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            @if($construction->name == old('constructionName'))
                                <?php $selectedName = true ?>
                                <option value="{{$construction->name}}" selected="selected">{{$construction->name}}</option>
                            @elseif(old('constructionName') == "" and str_replace(array("\r","\n"), "", $construction->name) == str_replace(array("\r","\n"), "", $dailyreport->constructionName))
                                <?php $selectedName = true ?>
                                <option value="{{$construction->name}}" selected="selected">{{$construction->name}}</option>
                            @else
                                <option value="{{$construction->name}}">{{$construction->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <select class="select-checker" name="constructionNumberChecker" required>
                    <option label="default" selected><option>

                    @if($selectedNumber)
                        <option value="true" selected>true</option>
                    @else
                        <option value="true">true</option>
                    @endif
                </select>
                <select class="select-checker" name="constructionNameChecker" required>
                    <option label="default" selected><option>

                    @if($selectedName)
                        <option value="true" selected>true</option>
                    @else
                        <option value="true">true</option>
                    @endif
                </select>
            </div>


            <div class="item-conteiner-top">
                <h5>日付  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <input type="date" name="date" value="{{old('date') ?? date('Y-m-d', strtotime( $dailyreport->date ))}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>天気</h5>
                <div class="col-md-12">
                    <span class="am">AM</span>
                    @foreach(array("sun", "cloud-sun", "cloud", "umbrella", "snowflake") as $value)
                        @if($dailyreport->amWeather == "" and $value == "sun")
                            <input class="weather-icon" type="radio" name="amWeather" value="{{$value}}" checked="checked" /><i class="fas fa-{{$value}}"></i>
                        @elseif($value == (old('amWeather') ?? $dailyreport->amWeather))
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
                        @elseif($value == (old('pmWeather') ?? $dailyreport->pmWeather))
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
                    <label for="label1"><span class="label-font">労務</span><button type="button" id="laborButtonNameAll" style="margin-left:10px;border-radius:18px; height:36px; width:36px;">×</button></label>
                    <div class="accshow">
                        @foreach (range(1,8) as $i)
                            <?php
                                $laborButtonName = "laborButtonName".$i;
                                $laborTraderName = "laborTraderName".$i;
                                $laborPeopleNumber = "laborPeopleNumber".$i;
                                $laborWorkTime = "laborWorkTime".$i;
                                $laborWorkVolume = "laborWorkVolume".$i;
                            ?>
                            <div class="col-md-12 col-xs-10 cells-containre">
                                <button type="button" id="{{$laborButtonName}}" style="border-radius:17px; height:34px; width:34px;">×</button>
                                <span class="inputform">
                                    <input id="{{$laborTraderName}}" name="{{$laborTraderName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" value="{{old($laborTraderName) ?? $dailyreport->$laborTraderName}}"/>
                                </span>
                                <select id="{{$laborPeopleNumber}}" name="{{$laborPeopleNumber}}" data-toggle="select" class="form-control select select-default mrs mbm">
                                    <option value="">人数を選択</option>
                                    @foreach(range(1,100) as $value)
                                        @if($value == old($laborPeopleNumber))
                                            <option value="{{$value}}" selected="selected">{{$value}}</option>
                                        @elseif(old($laborPeopleNumber) == "" and $value == $dailyreport->$laborPeopleNumber)
                                            <option value="{{$value}}" selected="selected">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select id="{{$laborWorkTime}}" name="{{$laborWorkTime}}" data-toggle="select" class="form-control select select-default mrs mbm">
                                    <option value="">時間を選択</option>
                                    @foreach(range(1,10) as $value)
                                        @if($value == old($laborWorkTime))
                                            <option value="{{$value}}" selected="selected">{{$value}}</option>
                                        @elseif(old($laborWorkTime) == "" and $value == $dailyreport->$laborWorkTime)
                                            <option value="{{$value}}" selected="selected">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="inputform">
                                    <input id="{{$laborWorkVolume}}" name="{{$laborWorkVolume}}" class="work-volume tagsinput tagsinput-typeahead input-lg" placeholder="作業及び出来高等" value="{{old($laborWorkVolume) ?? $dailyreport->$laborWorkVolume}}"/>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label2" class="cssacc" />
                    <label for="label2"><span class="label-font">重機車両</span><button type="button" id="heavyMachineryTraderButtonAll" style="margin-left:10px;border-radius:18px; height:36px; width:36px;">×</button></label>
                    <div class="accshow">
                        @foreach (range(1,6) as $i)
                            <?php
                                $heavyMachineryTraderButton = "heavyMachineryTraderButton".$i;
                                $heavyMachineryTraderName = "heavyMachineryTraderName".$i;
                                $heavyMachineryModel = "heavyMachineryModel".$i;
                                $heavyMachineryTime = "heavyMachineryTime".$i;
                                $heavyMachineryRemarks = "heavyMachineryRemarks".$i;
                            ?>
                            <div class="col-md-12 col-xs-10 cells-containre">
                                <button type="button" id="{{$heavyMachineryTraderButton}}" style="border-radius:17px; height:34px; width:34px;">×</button>
                                <span class="inputform">
                                    <input id="{{$heavyMachineryTraderName}}" name="{{$heavyMachineryTraderName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" value="{{old($heavyMachineryTraderName) ?? $dailyreport->$heavyMachineryTraderName}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$heavyMachineryModel}}" name="{{$heavyMachineryModel}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="機種" value="{{old($heavyMachineryModel) ?? $dailyreport->$heavyMachineryModel}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$heavyMachineryTime}}" name="{{$heavyMachineryTime}}" type="number" class="tagsinput tagsinput-typeahead input-lg" placeholder="台" size="10" value="{{old($heavyMachineryTime) ?? $dailyreport->$heavyMachineryTime}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$heavyMachineryRemarks}}" name="{{$heavyMachineryRemarks}}" class="workvolume tagsinput tagsinput-typeahead input-lg" placeholder="備考" value="{{old($heavyMachineryRemarks) ?? $dailyreport->$heavyMachineryRemarks}}" />
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label3" class="cssacc" />
                    <label for="label3"><span class="label-font">購入資材</span><button type="button" id="materialTraderButtonAll" style="margin-left:10px;border-radius:18px; height:36px; width:36px;">×</button></label>
                    <div class="accshow">
                        @foreach (range(1,5) as $i)
                            <?php
                                $materialTraderButton = "materialTraderButton".$i;
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
                                <button type="button" id="{{$materialTraderButton}}" style="border-radius:17px; height:34px; width:34px;">×</button>
                                <span class="inputform">
                                    <input id="{{$materialTraderName}}" name="{{$materialTraderName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="業者名" value="{{old($materialTraderName) ?? $dailyreport->$materialTraderName}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$materialName}}" name="{{$materialName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="資材名" value="{{old($materialName) ?? $dailyreport->$materialName}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$materialShapeDimensions}}" name="{{$materialShapeDimensions}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="形状寸法" value="{{old($materialShapeDimensions) ?? $dailyreport->$materialShapeDimensions}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$materialQuantity}}" name="{{$materialQuantity}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="数量" size="10" value="{{old($materialQuantity) ?? $dailyreport->$materialQuantity}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$materialUnit}}" name="{{$materialUnit}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="単位" size="10" value="{{old($materialUnit) ?? $dailyreport->$materialUnit}}" />
                                </span>
                                <div>
                                    <span class="col-md-12">
                                        <span class="result">合否判定</span>
                                        @foreach(array("pass", "fail") as $value)
                                            @if($value == old($materialResult))
                                                @if($value == "pass")
                                                    <input type="radio" name="{{$materialResult}}" value="{{$value}}" checked="checked" />合
                                                @elseif($value == "fail")
                                                    <input type="radio" name="{{$materialResult}}" value="{{$value}}" checked="checked" />否
                                                @endif
                                            @elseif(old($materialResult) == "" and $value == $dailyreport->$materialResult)
                                                @if($value == "pass")
                                                    <input type="radio" name="{{$materialResult}}" value="{{$value}}" checked="checked" />合
                                                @elseif($value == "fail")
                                                    <input type="radio" name="{{$materialResult}}" value="{{$value}}" checked="checked" />否
                                                @endif
                                            @else
                                                @if($value == "pass")
                                                    <input type="radio" name="{{$materialResult}}" value="{{$value}}" />合
                                                @elseif($value == "fail")
                                                    <input type="radio" name="{{$materialResult}}" value="{{$value}}" />否
                                                @endif
                                            @endif
                                        @endforeach
                                    </span>
                                    <span class="inputform">
                                        <input id="{{$materialInspectionMethods}}" name="{{$materialInspectionMethods}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査方法・資料" value="{{old($materialInspectionMethods) ?? $dailyreport->$materialInspectionMethods}}" />
                                    </span>
                                    <span class="inputform">
                                        <input id="{{$materialInspector}}" name="{{$materialInspector}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査員" size="10" value="{{old($materialInspector) ?? $dailyreport->$materialInspector}}" />
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label4" class="cssacc" />
                    <label for="label4"><span class="label-font">工程内検査</span><button type="button" id="processButtonAll" style="margin-left:10px;border-radius:18px; height:36px; width:36px;">×</button></label>
                    <div class="accshow">
                        @foreach (range(1,4) as $i)
                            <?php
                                $processButton = "processButton".$i;
                                $processName = "processName".$i;
                                $processLocation = "processLocation".$i;
                                $processMethods = "processMethods".$i;
                                $processDocument = "processDocument".$i;
                                $processResult = "processResult".$i;
                                $processInspector = "processInspector".$i;
                            ?>
                            <div class="col-md-12 cells-containre">
                                <button type="button" id="{{$processButton}}" style="border-radius:17px; height:34px; width:34px;">×</button>
                                <span class="inputform">
                                    <input id="{{$processName}}" name="{{$processName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="工程内検査名" value="{{old($processName) ?? $dailyreport->$processName}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$processLocation}}" name="{{$processLocation}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査箇所" value="{{old($processLocation) ?? $dailyreport->$processLocation}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$processMethods}}" name="{{$processMethods}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査方法" value="{{old($processMethods) ?? $dailyreport->$processMethods}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$processDocument}}" name="{{$processDocument}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="資料等" value="{{old($processDocument) ?? $dailyreport->$processDocument}}" />
                                </span>
                                <div>
                                    <span class="col-md-12">
                                        <span class="result">合否判定</span>
                                        @foreach(array("pass", "fail") as $value)
                                            @if($value == old($processResult))
                                                @if($value == "pass")
                                                    <input type="radio" name="{{$processResult}}" value="{{$value}}" checked="checked" />合
                                                @elseif($value == "fail")
                                                    <input type="radio" name="{{$processResult}}" value="{{$value}}" checked="checked" />否
                                                @endif
                                            @elseif(old($processResult) == "" and $value == $dailyreport->$processResult)
                                                @if($value == "pass")
                                                    <input type="radio" name="{{$processResult}}" value="{{$value}}" checked="checked" />合
                                                @elseif($value == "fail")
                                                    <input type="radio" name="{{$processResult}}" value="{{$value}}" checked="checked" />否
                                                @endif
                                            @else
                                                @if($value == "pass")
                                                    <input type="radio" name="{{$processResult}}" value="{{$value}}" />合
                                                @elseif($value == "fail")
                                                    <input type="radio" name="{{$processResult}}" value="{{$value}}" />否
                                                @endif
                                            @endif
                                        @endforeach
                                    </span>
                                    <span class="inputform">
                                        <input id="{{$processInspector}}" name="{{$processInspector}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="検査員" size="10" value="{{old($processInspector) ?? $dailyreport->$processInspector}}" />
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="item-conteiner-top">
                    <input type="checkbox" id="label5" class="cssacc" />
                    <label for="label5"><span class="label-font">測定機器点検</span><button type="button" id="measuringEquipmentButtonAll" style="margin-left:10px;border-radius:18px; height:36px; width:36px;">×</button></label>
                    <div class="accshow">
                        @foreach (range(1,2) as $i)
                            <?php
                                $measuringEquipmentButton = "measuringEquipmentButton".$i;
                                $measuringEquipmentName = "measuringEquipmentName".$i;
                                $measuringEquipmentNumber = "measuringEquipmentNumber".$i;
                                $measuringEquipmentResult = "measuringEquipmentResult".$i;
                                $measuringEquipmentRemarks = "measuringEquipmentRemarks".$i;
                            ?>
                            <div class="col-md-12 cells-containre">
                                <button type="button" id="{{$measuringEquipmentButton}}" style="border-radius:17px; height:34px; width:34px;">×</button>
                                <span class="inputform">
                                    <input id="{{$measuringEquipmentName}}" name="{{$measuringEquipmentName}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="測定機器名" value="{{old($measuringEquipmentName) ?? $dailyreport->$measuringEquipmentName}}" />
                                </span>
                                <span class="inputform">
                                    <input id="{{$measuringEquipmentNumber}}" name="{{$measuringEquipmentNumber}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="管理番号" value="{{old($measuringEquipmentNumber) ?? $dailyreport->$measuringEquipmentNumber}}" />
                                </span>
                                <span class="col-md-12">
                                    <span class="result">異常</span>
                                    @foreach(array("abnormal", "noabnormal") as $value)
                                        @if($value == old($measuringEquipmentResult))
                                            @if($value == "abnormal")
                                                <input type="radio" name="{{$measuringEquipmentResult}}" value="{{$value}}" checked="checked" />有り
                                            @elseif($value == "noabnormal")
                                                <input type="radio" name="{{$measuringEquipmentResult}}" value="{{$value}}" checked="checked" />無し
                                            @endif
                                        @elseif(old($measuringEquipmentResult) == "" and $value == $dailyreport->$measuringEquipmentResult)
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
                                    <input id="{{$measuringEquipmentRemarks}}" name="{{$measuringEquipmentRemarks}}" class="tagsinput tagsinput-typeahead input-lg" placeholder="備考(使用場所等)" value="{{old($measuringEquipmentRemarks) ?? $dailyreport->$measuringEquipmentRemarks}}" />
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
                                    @if($dailyreport->patrolResult == "" and old('patrolResult') == "")
                                        @if($value == "abnormal")
                                            <input type="radio" name="patrolResult" value="{{$value}}" />有り
                                        @elseif($value == "noabnormal")
                                            <input type="radio" name="patrolResult" value="{{$value}}" checked="checked" />無し
                                        @endif
                                    @elseif($value == old('patrolResult'))
                                        @if($value == "abnormal")
                                            <input type="radio" name="patrolResult" value="{{$value}}" checked="checked" />有り
                                        @elseif($value == "noabnormal")
                                            <input type="radio" name="patrolResult" value="{{$value}}" checked="checked" />無し
                                        @endif
                                    @elseif(old('patrolResult') == "" and $value == $dailyreport->patrolResult)
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
                                <textarea class="patrol-textarea" name="patrolFindings" rows="5" cols="98" wrap="hard" placeholder="5行以内">{{old('patrolFindings') ?? $dailyreport->patrolFindings}}</textarea>
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

            <input id="transition-preview" name="transition-preview" value="false" style="display:none;">

            <div class="item-conteiner-top">
                <input type="submit" class="btn btn-primary" value="日報を保存する" />
                <input type="submit" id="transition-preview-button" class="btn btn-primary" style="background-color: #FF9800;" value="日報を保存してプレビューを開く" />
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

            // previewページに遷移
            $('#transition-preview-button').on('click', function() {
                $('#transition-preview').val('true');
            });

            //clear-button
            $('#laborButtonName1').on('click', function() {
                $('#laborTraderName1').val('')
                $('#laborPeopleNumber1').val('')
                $('#laborWorkTime1').val('')
                $('#laborWorkVolume1').val('')
            });
            $('#laborButtonName2').on('click', function() {
                $('#laborTraderName2').val('')
                $('#laborPeopleNumber2').val('')
                $('#laborWorkTime2').val('')
                $('#laborWorkVolume2').val('')
            });
            $('#laborButtonName3').on('click', function() {
                $('#laborTraderName3').val('')
                $('#laborPeopleNumber3').val('')
                $('#laborWorkTime3').val('')
                $('#laborWorkVolume3').val('')
            });
            $('#laborButtonName4').on('click', function() {
                $('#laborTraderName4').val('')
                $('#laborPeopleNumber4').val('')
                $('#laborWorkTime4').val('')
                $('#laborWorkVolume4').val('')
            });
            $('#laborButtonName5').on('click', function() {
                $('#laborTraderName5').val('')
                $('#laborPeopleNumber5').val('')
                $('#laborWorkTime5').val('')
                $('#laborWorkVolume5').val('')
            });
            $('#laborButtonName6').on('click', function() {
                $('#laborTraderName6').val('')
                $('#laborPeopleNumber6').val('')
                $('#laborWorkTime6').val('')
                $('#laborWorkVolume6').val('')
            });
            $('#laborButtonName7').on('click', function() {
                $('#laborTraderName7').val('')
                $('#laborPeopleNumber7').val('')
                $('#laborWorkTime7').val('')
                $('#laborWorkVolume7').val('')
            });
            $('#laborButtonName8').on('click', function() {
                $('#laborTraderName8').val('')
                $('#laborPeopleNumber8').val('')
                $('#laborWorkTime8').val('')
                $('#laborWorkVolume8').val('')
            });
            $('#laborButtonNameAll').on('click', function() {
                $('#laborTraderName1').val('')
                $('#laborPeopleNumber1').val('')
                $('#laborWorkTime1').val('')
                $('#laborWorkVolume1').val('')
                $('#laborTraderName2').val('')
                $('#laborPeopleNumber2').val('')
                $('#laborWorkTime2').val('')
                $('#laborWorkVolume2').val('')
                $('#laborTraderName3').val('')
                $('#laborPeopleNumber3').val('')
                $('#laborWorkTime3').val('')
                $('#laborWorkVolume3').val('')
                $('#laborTraderName4').val('')
                $('#laborPeopleNumber4').val('')
                $('#laborWorkTime4').val('')
                $('#laborWorkVolume4').val('')
                $('#laborTraderName5').val('')
                $('#laborPeopleNumber5').val('')
                $('#laborWorkTime5').val('')
                $('#laborWorkVolume5').val('')
                $('#laborTraderName6').val('')
                $('#laborPeopleNumber6').val('')
                $('#laborWorkTime6').val('')
                $('#laborWorkVolume6').val('')
                $('#laborTraderName7').val('')
                $('#laborPeopleNumber7').val('')
                $('#laborWorkTime7').val('')
                $('#laborWorkVolume7').val('')
                $('#laborTraderName8').val('')
                $('#laborPeopleNumber8').val('')
                $('#laborWorkTime8').val('')
                $('#laborWorkVolume8').val('')
            });

            $('#heavyMachineryTraderButton1').on('click', function() {
                $('#heavyMachineryTraderName1').val('')
                $('#heavyMachineryModel1').val('')
                $('#heavyMachineryTime1').val('')
                $('#heavyMachineryRemarks1').val('')
            });
            $('#heavyMachineryTraderButton2').on('click', function() {
                $('#heavyMachineryTraderName2').val('')
                $('#heavyMachineryModel2').val('')
                $('#heavyMachineryTime2').val('')
                $('#heavyMachineryRemarks2').val('')
            });
            $('#heavyMachineryTraderButton3').on('click', function() {
                $('#heavyMachineryTraderName3').val('')
                $('#heavyMachineryModel3').val('')
                $('#heavyMachineryTime3').val('')
                $('#heavyMachineryRemarks3').val('')
            });
            $('#heavyMachineryTraderButton4').on('click', function() {
                $('#heavyMachineryTraderName4').val('')
                $('#heavyMachineryModel4').val('')
                $('#heavyMachineryTime4').val('')
                $('#heavyMachineryRemarks4').val('')
            });
            $('#heavyMachineryTraderButton5').on('click', function() {
                $('#heavyMachineryTraderName5').val('')
                $('#heavyMachineryModel5').val('')
                $('#heavyMachineryTime5').val('')
                $('#heavyMachineryRemarks5').val('')
            });
            $('#heavyMachineryTraderButton6').on('click', function() {
                $('#heavyMachineryTraderName6').val('')
                $('#heavyMachineryModel6').val('')
                $('#heavyMachineryTime6').val('')
                $('#heavyMachineryRemarks6').val('')
            });
            $('#heavyMachineryTraderButtonAll').on('click', function() {
                $('#heavyMachineryTraderName1').val('')
                $('#heavyMachineryModel1').val('')
                $('#heavyMachineryTime1').val('')
                $('#heavyMachineryRemarks1').val('')
                $('#heavyMachineryTraderName2').val('')
                $('#heavyMachineryModel2').val('')
                $('#heavyMachineryTime2').val('')
                $('#heavyMachineryRemarks2').val('')
                $('#heavyMachineryTraderName3').val('')
                $('#heavyMachineryModel3').val('')
                $('#heavyMachineryTime3').val('')
                $('#heavyMachineryRemarks3').val('')
                $('#heavyMachineryTraderName4').val('')
                $('#heavyMachineryModel4').val('')
                $('#heavyMachineryTime4').val('')
                $('#heavyMachineryRemarks4').val('')
                $('#heavyMachineryTraderName5').val('')
                $('#heavyMachineryModel5').val('')
                $('#heavyMachineryTime5').val('')
                $('#heavyMachineryRemarks5').val('')
                $('#heavyMachineryTraderName6').val('')
                $('#heavyMachineryModel6').val('')
                $('#heavyMachineryTime6').val('')
                $('#heavyMachineryRemarks6').val('')
            });

            $('#materialTraderButton1').on('click', function() {
                $('#materialTraderName1').val('')
                $('#materialName1').val('')
                $('#materialShapeDimensions1').val('')
                $('#materialQuantity1').val('')
                $('#materialUnit1').val('')
                $('input[name="materialResult1"]').prop('checked', false)
                $('#materialInspectionMethods1').val('')
                $('#materialInspector1').val('')
            });
            $('#materialTraderButton2').on('click', function() {
                $('#materialTraderName2').val('')
                $('#materialName2').val('')
                $('#materialShapeDimensions2').val('')
                $('#materialQuantity2').val('')
                $('#materialUnit2').val('')
                $('input[name="materialResult2"]').prop('checked', false)
                $('#materialInspectionMethods2').val('')
                $('#materialInspector2').val('')
            });
            $('#materialTraderButton3').on('click', function() {
                $('#materialTraderName3').val('')
                $('#materialName3').val('')
                $('#materialShapeDimensions3').val('')
                $('#materialQuantity3').val('')
                $('#materialUnit3').val('')
                $('input[name="materialResult3"]').prop('checked', false)
                $('#materialInspectionMethods3').val('')
                $('#materialInspector3').val('')
            });
            $('#materialTraderButton4').on('click', function() {
                $('#materialTraderName4').val('')
                $('#materialName4').val('')
                $('#materialShapeDimensions4').val('')
                $('#materialQuantity4').val('')
                $('#materialUnit4').val('')
                $('input[name="materialResult4"]').prop('checked', false)
                $('#materialInspectionMethods4').val('')
                $('#materialInspector4').val('')
            });
            $('#materialTraderButton5').on('click', function() {
                $('#materialTraderName5').val('')
                $('#materialName5').val('')
                $('#materialShapeDimensions5').val('')
                $('#materialQuantity5').val('')
                $('#materialUnit5').val('')
                $('input[name="materialResult5"]').prop('checked', false)
                $('#materialInspectionMethods5').val('')
                $('#materialInspector5').val('')
            });
            $('#materialTraderButtonAll').on('click', function() {
                $('#materialTraderName1').val('')
                $('#materialName1').val('')
                $('#materialShapeDimensions1').val('')
                $('#materialQuantity1').val('')
                $('#materialUnit1').val('')
                $('input[name="materialResult1"]').prop('checked', false)
                $('#materialInspectionMethods1').val('')
                $('#materialInspector1').val('')
                $('#materialTraderName2').val('')
                $('#materialName2').val('')
                $('#materialShapeDimensions2').val('')
                $('#materialQuantity2').val('')
                $('#materialUnit2').val('')
                $('input[name="materialResult2"]').prop('checked', false)
                $('#materialInspectionMethods2').val('')
                $('#materialInspector2').val('')
                $('#materialTraderName3').val('')
                $('#materialName3').val('')
                $('#materialShapeDimensions3').val('')
                $('#materialQuantity3').val('')
                $('#materialUnit3').val('')
                $('input[name="materialResult3"]').prop('checked', false)
                $('#materialInspectionMethods3').val('')
                $('#materialInspector3').val('')
                $('#materialTraderName4').val('')
                $('#materialName4').val('')
                $('#materialShapeDimensions4').val('')
                $('#materialQuantity4').val('')
                $('#materialUnit4').val('')
                $('input[name="materialResult4"]').prop('checked', false)
                $('#materialInspectionMethods4').val('')
                $('#materialInspector4').val('')
                $('#materialTraderName5').val('')
                $('#materialName5').val('')
                $('#materialShapeDimensions5').val('')
                $('#materialQuantity5').val('')
                $('#materialUnit5').val('')
                $('input[name="materialResult5"]').prop('checked', false)
                $('#materialInspectionMethods5').val('')
                $('#materialInspector5').val('')
            });

            $('#processButton1').on('click', function() {
                $('#processName1').val('')
                $('#processLocation1').val('')
                $('#processMethods1').val('')
                $('#processDocument1').val('')
                $('input[name="processResult1"]').prop('checked', false)
                $('#processInspector1').val('')
            });
            $('#processButton2').on('click', function() {
                $('#processName2').val('')
                $('#processLocation2').val('')
                $('#processMethods2').val('')
                $('#processDocument2').val('')
                $('input[name="processResult2"]').prop('checked', false)
                $('#processInspector2').val('')
            });
            $('#processButton3').on('click', function() {
                $('#processName3').val('')
                $('#processLocation3').val('')
                $('#processMethods3').val('')
                $('#processDocument3').val('')
                $('input[name="processResult3"]').prop('checked', false)
                $('#processInspector3').val('')
            });
            $('#processButton4').on('click', function() {
                $('#processName4').val('')
                $('#processLocation4').val('')
                $('#processMethods4').val('')
                $('#processDocument4').val('')
                $('input[name="processResult4"]').prop('checked', false)
                $('#processInspector4').val('')
            });
            $('#processButtonAll').on('click', function() {
                $('#processName1').val('')
                $('#processLocation1').val('')
                $('#processMethods1').val('')
                $('#processDocument1').val('')
                $('input[name="processResult1"]').prop('checked', false)
                $('#processInspector1').val('')
                $('#processName2').val('')
                $('#processLocation2').val('')
                $('#processMethods2').val('')
                $('#processDocument2').val('')
                $('input[name="processResult2"]').prop('checked', false)
                $('#processInspector2').val('')
                $('#processName3').val('')
                $('#processLocation3').val('')
                $('#processMethods3').val('')
                $('#processDocument3').val('')
                $('input[name="processResult3"]').prop('checked', false)
                $('#processInspector3').val('')
                $('#processName4').val('')
                $('#processLocation4').val('')
                $('#processMethods4').val('')
                $('#processDocument4').val('')
                $('input[name="processResult4"]').prop('checked', false)
                $('#processInspector4').val('')
            });

            $('#measuringEquipmentButton1').on('click', function() {
                $('#measuringEquipmentName1').val('')
                $('#measuringEquipmentNumber1').val('')
                $('input[name="measuringEquipmentResult1"]').prop('checked', false)
                $('#measuringEquipmentRemarks1').val('')
            });
            $('#measuringEquipmentButton2').on('click', function() {
                $('#measuringEquipmentName2').val('')
                $('#measuringEquipmentNumber2').val('')
                $('input[name="measuringEquipmentResult2"]').prop('checked', false)
                $('#measuringEquipmentRemarks2').val('')
            });
            $('#measuringEquipmentButtonAll').on('click', function() {
                $('#measuringEquipmentName1').val('')
                $('#measuringEquipmentNumber1').val('')
                $('input[name="measuringEquipmentResult1"]').prop('checked', false)
                $('#measuringEquipmentRemarks1').val('')
                $('#measuringEquipmentName2').val('')
                $('#measuringEquipmentNumber2').val('')
                $('input[name="measuringEquipmentResult2"]').prop('checked', false)
                $('#measuringEquipmentRemarks2').val('')
            });

        });


        // Enter無効
        $(document).ready(function () {
            $('input,textarea[readonly]').not($('input[type="button"],input[type="submit"]')).keypress(function (e) {
                if (!e) var e = window.event;
                if (e.keyCode == 13)
                    return false;
            });
        });
    </script>

@endsection
