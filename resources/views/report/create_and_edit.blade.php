@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php
            $method = '';
            $action = '';

            $url = url()->current();
            if (str_contains($url, 'edit')) {
                $method = 'put';
                $action = route('reports.update', ['report' => $dailyreport->id]);
            } else {
                $method = 'post';
                $action = route('reports.store');
            }
        ?>

        {{-- @if (count($errors) > 0)
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
        @endif --}}

        <form method="post" action="{{$action}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="{{$method}}">

            <div class="item-conteiner">
                <h5>お名前  <span class="required">[必須]</span></h5>
                <div class="col-md-12">
                    <input name="userName" class="tagsinput tagsinput-typeahead input-lg"  placeholder="建設太郎" value="{{old('userName') ?? $dailyreport->userName}}" required />
                </div>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>所属部署  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <?php $selectedDepartment = false; ?>
                    <select name="department_id" id="department_id" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                        <option value="" label="default">部署を選択</option>

                        @foreach(array("住宅部", "土木部", "特殊建築部", "農業施設部", "東京支店", "第二建築部") as $value)
                            @if(
                                ( $loop->index+1 == old('department_id') )
                                ||
                                (
                                    ( old('department_id') == '' )
                                    &&
                                    ( $loop->index+1 == $dailyreport->department_id )
                                )
                            )
                                <option value="{{$loop->index+1}}" selected="selected">{{$value}}</option>
                                <?php $selectedDepartment = true; ?>
                            @else
                                <option value="{{$loop->index+1}}">{{$value}}</option>
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
                        $selectedName = false;
                    ?>
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            @if($construction->id == old('constructionNumber'))
                                <?php $selectedNumber = true; ?>
                                <option value="{{$construction->id}}" selected="selected">{{$construction->number_with_year}}</option>
                            @elseif(old('constructionNumber') == "" and isset($dailyreport->construction) and $construction->id == $dailyreport->construction->id)
                                <?php $selectedNumber = true; ?>
                                <option value="{{$construction->id}}" selected="selected">{{$construction->number_with_year}}</option>
                            @else
                                <option value="{{$construction->id}}">{{$construction->number_with_year}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
                        <option value="" label="default">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            @if($construction->id == old('constructionName'))
                                <?php $selectedName = true; ?>
                                <option value="{{$construction->id}}" selected="selected">{{$construction->name}}</option>
                            @elseif(old('constructionName') == "" and isset($dailyreport->construction) and $construction->id == $dailyreport->construction->id)
                                <?php $selectedName = true; ?>
                                <option value="{{$construction->id}}" selected="selected">{{$construction->name}}</option>
                            @else
                                <option value="{{$construction->id}}">{{$construction->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select name="construction_id" style="visibility:hidden">
                        <option value="" label="default">工事idを選択</option>
                        @foreach ($constructions as $construction)
                            @if($construction->id == old('construction_id'))
                                <option value="{{$construction->id}}" selected="selected">{{$construction->id}}</option>
                            @elseif(old('construction_id') == "" and $construction->id == $dailyreport->construction_id)
                                <option value="{{$construction->id}}" selected="selected">{{$construction->id}}</option>
                            @else
                                <option value="{{$construction->id}}">{{$construction->id}}</option>
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
                    <label for="label1">
                        <span class="label-font">労務</span>
                        <button type="button" id="laborButtonNameAll" class="btn btn--circle btn--circle--title"><i class="fas fa-times"></i></button>
                    </label>

                    <div class="accshow">
                        <div>
                            {{-- 業者を追加 --}}
                            <div style="margin: 20px 0;">
                                <button type="button" class="btn btn-info" onclick="(showTraderForm(this))">業者を追加</button>
                            </div>
                        </div>

                        @foreach (range(1,8) as $i)
                            <?php
                                $laborButtonName = 'laborButtonName'.$i;
                                $laborTraderId = 'laborTraderId'.$i;
                                $laborPeopleNumber = 'laborPeopleNumber'.$i;
                                $laborWorkTime = 'laborWorkTime'.$i;
                                $laborWorkVolume = 'laborWorkVolume'.$i;
                            ?>
                            <div class="col-md-12 col-xs-10 cells-containre">
                                <button type="button" id="{{$laborButtonName}}" class="btn btn--circle btn--circle--item"><i class="fas fa-times"></i></button>
                                <span class="inputform">

                                <select id="{{$laborTraderId}}" name="{{$laborTraderId}}" data-toggle="select" class="form-control select select-default mrs mbm">
                                    @foreach ($traders as $trader)
                                        @if($trader['id'] == $dailyreport->$laborTraderId)
                                            <option value="{{$trader['id']}}" selected="selected">{{$trader['name']}}</option>
                                        @else
                                            <option value="{{$trader['id']}}">{{$trader['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                </span>
                                <select id="{{$laborPeopleNumber}}" name="{{$laborPeopleNumber}}" data-toggle="select" class="form-control select select-default mrs mbm">
                                    <option value="">人数を選択</option>
                                    @foreach(range(1,100, 0.5) as $value)
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
                                    @foreach(range(1, 10, 0.5) as $value)
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
                    <label for="label2">
                        <span class="label-font">重機車両</span>
                        <button type="button" id="heavyMachineryTraderButtonAll" class="btn btn--circle btn--circle--title"><i class="fas fa-times"></i></button>
                    </label>

                    <div class="accshow">
                        <div>
                            {{-- 業者を追加 --}}
                            <div style="margin: 20px 0;">
                                <button type="button" class="btn btn-info" onclick="(showTraderForm(this))">業者を追加</button>
                            </div>

                            {{-- 機種を追加 --}}
                            <div style="margin: 20px 0;" id="addAssetForm">
                                <button type="button" class="btn btn-info" onclick="(addAssetForm())">機種を追加</button>
                            </div>
                            <div style="margin: 20px 0; display: none;" id="addAsset">
                                <select id="addAssetSelect" name="" data-toggle="select" class="form-control select select-default mrs mbm">
                                    @foreach ($traders as $trader)
                                        <option value="{{$trader['id']}}">{{$trader['name']}}</option>
                                    @endforeach
                                </select>

                                <input id="" name="" class="work-volume tagsinput tagsinput-typeahead input-lg" placeholder="追加したい機種" />
                                <button type="button" class="btn btn-info" onclick="(addAsset(this))">機種を追加</button>
                            </div>
                        </div>

                        @foreach (range(1,6) as $i)
                            <?php
                                $heavyMachineryTraderButton = 'heavyMachineryTraderButton'.$i;
                                $heavyMachineryTraderId = 'heavyMachineryTraderId'.$i;
                                $heavyMachineryModel = 'heavyMachineryModel'.$i;
                                $heavyMachineryTime = 'heavyMachineryTime'.$i;
                                $heavyMachineryRemarks = 'heavyMachineryRemarks'.$i;
                            ?>
                            <div class="col-md-12 col-xs-10 cells-containre">
                                <button type="button" id="{{$heavyMachineryTraderButton}}" class="btn btn--circle btn--circle--item"><i class="fas fa-times"></i></button>
                                <span class="inputform">
                                    <select id="{{$heavyMachineryTraderId}}" name="{{$heavyMachineryTraderId}}" data-toggle="select" class="form-control select select-default mrs mbm">
                                        @foreach ($traders as $trader)
                                            @if($trader['id'] == $dailyreport->$heavyMachineryTraderId)
                                                <option value="{{$trader['id']}}" selected="selected">{{$trader['name']}}</option>
                                            @else
                                                <option value="{{$trader['id']}}">{{$trader['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </span>
                                <span class="inputform">
                                    <select id="{{$heavyMachineryModel}}" name="{{$heavyMachineryModel}}" data-toggle="select" class="form-control select select-default mrs mbm">
                                        @foreach ($assets[$i-1] as $asset)
                                            @if($asset['id'] == $dailyreport->$heavyMachineryModel)
                                                <option value="{{$asset['id']}}" selected="selected">{{$asset['name']}}</option>
                                            @else
                                                <option value="{{$asset['id']}}">{{$asset['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
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
                    <label for="label3">
                        <span class="label-font">購入資材</span>
                        <button type="button" id="materialTraderButtonAll" class="btn btn--circle btn--circle--title"><i class="fas fa-times"></i></button>
                    </label>
                    <div class="accshow">
                        @foreach (range(1,5) as $i)
                            <?php
                                $materialTraderButton = 'materialTraderButton'.$i;
                                $materialTraderName = 'materialTraderName'.$i;
                                $materialName = 'materialName'.$i;
                                $materialShapeDimensions = 'materialShapeDimensions'.$i;
                                $materialQuantity = 'materialQuantity'.$i;
                                $materialUnit = 'materialUnit'.$i;
                                $materialResult = 'materialResult'.$i;
                                $materialInspectionMethods = 'materialInspectionMethods'.$i;
                                $materialInspector = 'materialInspector'.$i;
                            ?>
                            <div class="col-md-12 cells-containre">
                                <button type="button" id="{{$materialTraderButton}}" class="btn btn--circle btn--circle--item"><i class="fas fa-times"></i></button>
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
                    <label for="label4">
                        <span class="label-font">工程内検査</span>
                        <button type="button" id="processButtonAll" class="btn btn--circle btn--circle--title"><i class="fas fa-times"></i></button>
                    </label>
                    <div class="accshow">
                        @foreach (range(1,4) as $i)
                            <?php
                                $processButton = 'processButton'.$i;
                                $processName = 'processName'.$i;
                                $processLocation = 'processLocation'.$i;
                                $processMethods = 'processMethods'.$i;
                                $processDocument = 'processDocument'.$i;
                                $processResult = 'processResult'.$i;
                                $processInspector = 'processInspector'.$i;
                            ?>
                            <div class="col-md-12 cells-containre">
                                <button type="button" id="{{$processButton}}" class="btn btn--circle btn--circle--item"><i class="fas fa-times"></i></button>
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
                    <label for="label5">
                        <span class="label-font">測定機器点検</span>
                        <button type="button" id="measuringEquipmentButtonAll" class="btn btn--circle btn--circle--title"><i class="fas fa-times"></i></button>
                    </label>
                    <div class="accshow">
                        @foreach (range(1,2) as $i)
                            <?php
                                $measuringEquipmentButton = 'measuringEquipmentButton'.$i;
                                $measuringEquipmentName = 'measuringEquipmentName'.$i;
                                $measuringEquipmentNumber = 'measuringEquipmentNumber'.$i;
                                $measuringEquipmentResult = 'measuringEquipmentResult'.$i;
                                $measuringEquipmentRemarks = 'measuringEquipmentRemarks'.$i;
                            ?>
                            <div class="col-md-12 cells-containre">
                                <button type="button" id="{{$measuringEquipmentButton}}" class="btn btn--circle btn--circle--item"><i class="fas fa-times"></i></button>
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
            </div>

            <input id="transition-preview" name="transition-preview" value="false" style="display:none;">

            <div class="item-conteiner-top">
                <input type="submit" class="btn btn-primary" value="日報を保存する" />
                <input type="submit" id="transition-preview-button" class="btn btn-primary" style="background-color: #FF9800;" value="日報を保存してプレビューを開く" />
            </div>

        </form>
    </div>

    <script>
        // 業者追加
        const showTraderForm = (button_this) => {
            $(button_this).parent().append(`<input class="work-volume tagsinput tagsinput-typeahead input-lg" placeholder="追加したい業者名" />`);
            $(button_this).parent().append(`<button type="button" class="btn btn-info" style="margin:0 5px;" onclick="(checkTraderForm(this))">業者を追加</button>`);
            $(button_this).remove();
        };
        const hiddenTraderForm = (button_this) => {
            $(button_this).parent().append(`<button type="button" class="btn btn-info" onclick="(showTraderForm(this))">業者を追加</button>`);
            $(button_this).parent().children().eq(0).remove();
            $(button_this).parent().children().eq(0).remove();
            alert('データ更新完了');
        };
        const checkTraderForm = (button_this) => {
            const input_trader_name = $(button_this).parent().children('input').val();
            if(input_trader_name == '' ) {
                alert("業者名を入力してください。");
                return
            }
            if(input_trader_name.length > 100){
                alert("業者名は100文字以内にしてください。");
                return
            }

            const department_id = $('#department_id').val()
            if(department_id == '' ) {
                alert("部署を選択してください。");
                return
            }
            if(isNaN(department_id)){
                alert("部署が不適切です。");
                return
            }

            if(confirm(`この業者名を追加しますよろしいですか？\n「${input_trader_name}」`)) {
                saveTrader(input_trader_name, department_id);
            } else {
                alert("キャンセルしました。");
                return;
            }

            hiddenTraderForm(button_this);
        };
        const saveTrader = (name, department_id) => {
            $.ajax({
                    url: '/api/traders',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        name: name,
                        department_id: department_id,
                    },
                })
            .done(function (response) {
                traders = response;
                traders.unshift({'id':'', 'name':'業者名を選択してください'});
                update_trader(traders, false);
            })
            .fail(function () {
                alert('業者データ保存中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
            });
        }

        // 資産追加
        const addAssetForm = () => {
            $('#addAssetForm').hide();
            $('#addAsset').show();
        };
        const removeAssetForm = () => {
            $('#addAsset').children('select').prop("selectedIndex", 0).trigger('change', ['exit']);
            $('#addAsset').children('input').val('');

            $('#addAsset').hide();
            $('#addAssetForm').show();
        };
        const addAsset = (button_this) => {
            const select_value = $(button_this).parent().children('select').val();
            if(select_value == '' ) {
                alert("業者名を選択してください。");
                return
            }
            if(isNaN(select_value)){
                alert("業者名が不適切です。");
                return
            }

            const input_value = $(button_this).parent().children('input').val();
            if(input_value == '' ) {
                alert("機種名を入力してください。");
                return
            }
            if(input_value.length > 100){
                alert("機種名は100文字以内にしてください。");
                return
            }

            if(confirm(`この機種名を追加しますよろしいですか？\n業者名「${select_value}」\n機種名「${input_value}」`)) {
                saveAsset(input_value, select_value)
            } else {
                alert("キャンセルしました。");
                return;
            }

            removeAssetForm(button_this);
        };
        const saveAsset = (name, trader_id) => {
            $.ajax({
                    url: '/api/assets',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        name: name,
                        trader_id: trader_id,
                    },
                })
            .done(function (response) {
                assets = response;
                assets.unshift({'id':'', 'name':'選択してください'});
                for (let i = 1; i <= 6; i++) {
                    let trader_select_id = '#heavyMachineryTraderId' + i;
                    let asset_select_id = '#heavyMachineryModel' + i;

                    let trader_id = $(trader_select_id + ' option:selected').val();
                    if(!trader_id) {
                        return
                    }

                    update_asset(assets, asset_select_id, false);
                }
            })
            .fail(function () {
                alert('機種データ保存中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
            });
        };

        // 業者データを書き換え
        const update_trader = (traders, select_default) => {
            // 業者データを上書き
            const over_write = (traders, select_id, selected_value, select_default) => {
                // 全て取り除く
                $(select_id  + '> option').remove();

                // 追加
                traders.forEach(trader => {
                    $(select_id).append($('<option>').html(trader['name']).val(trader['id']));
                });

                // デフォルト選択表示にする
                if(select_default) {
                    $(select_id).prop("selectedIndex", 0).trigger('change', ['exit']);
                } else {
                    // 前回選択されていた項目を選択をする
                    let select_index = traders.map(x => x['id']).indexOf(Number(selected_value));
                    $(select_id).prop("selectedIndex", select_index).trigger('change', ['exit']);
                }
            }

            for (let i = 1; i <= 8; i++) {
                let select_id = '#laborTraderId' + i;
                let selected_value = $(`${select_id} option:selected`).val();
                over_write(traders, select_id, selected_value, select_default);
            }
            for (let i = 1; i <= 6; i++) {
                let select_id = '#heavyMachineryTraderId' + i;
                let selected_value = $(`${select_id} option:selected`).val();
                over_write(traders, select_id, selected_value, select_default);
            }
            over_write(traders, '#addAssetSelect', '', true);
        }

        // 資産データを書き換え
        const update_asset = (assets, select_id, select_default) => {
            let selected_value = $(`${select_id} option:selected`).val();

            // 全て取り除く
            $(select_id  + '> option').remove();

            // 追加
            assets.forEach(asset => {
                $(select_id).append($('<option>').html(asset['name']).val(asset['id']));
            });

            // デフォルト選択表示にする
            if(select_default) {
                $(select_id).prop("selectedIndex", 0).trigger('change', ['exit']);
            } else {
                // 前回選択されていた項目を選択をする
                let select_index = assets.map(x => x['id']).indexOf(Number(selected_value));
                $(select_id).prop("selectedIndex", select_index).trigger('change', ['exit']);
            }
        }

        $(function() {
            // selectチェッカー
            $('select[name="department_id"]').change(function(e, data) {
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
                    $('select[name="construction_id"]').prop("selectedIndex", $(this).prop("selectedIndex")).trigger('change', ['exit']);
                }
            });
            $('select[name="constructionName"]').change(function(e, data) {
                if(data !="exit"){
                    $('select[name="constructionNumber"]').prop("selectedIndex", $(this).prop("selectedIndex")).trigger('change', ['exit']);
                    $('select[name="construction_id"]').prop("selectedIndex", $(this).prop("selectedIndex")).trigger('change', ['exit']);
                }
            });

            // 部署を選択したら、業者データを更新
            $('#department_id').change(function() {
                let department_id = $('#department_id option:selected').val();
                if(!department_id) {
                    return
                }

                // 第二建築部が選択された場合は特殊建築部の業者を出す
                // 第二建築部で業者登録しても追加されないので注意
                if(department_id == 6) {
                    department_id = 3
                }

                // 業者データを取得
                $.ajax({
                    url: '/api/traders/' + department_id,
                    type: 'get',
                    dataType: 'json'
                })
                .done(function (response) {
                    traders = response;
                    traders.unshift({'id':'', 'name':'業者名を選択してください'});
                    update_trader(traders, true);
                })
                .fail(function () {
                    alert('業者データ取得中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
                });
            });

            // 業者を選択したら、資産データを更新
            for (let i = 1; i <= 6; i++) {
                let trader_select_id = '#heavyMachineryTraderId' + i;
                let asset_select_id = '#heavyMachineryModel' + i;

                $(trader_select_id).change(function() {
                    let trader_id = $(trader_select_id + ' option:selected').val();
                    if(!trader_id) {
                        return
                    }

                    // 資産データを取得
                    $.ajax({
                        url: '/api/assets/' + trader_id,
                        type: 'get',
                        dataType: 'json'
                    })
                    .done(function (response) {
                        assets = response;
                        assets.unshift({'id':'', 'name':'選択してください'});
                        update_asset(assets, asset_select_id, true);
                    })
                    .fail(function () {
                        alert('資産データ取得中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
                    });
                });
            }

            // previewページに遷移
            $('#transition-preview-button').on('click', function() {
                $('#transition-preview').val('true');
            });

            //clear-button
            $('#laborButtonName1').on('click', function() {
                document.getElementById("laborTraderId1").options[0].selected = true;
                document.getElementById("select2-chosen-6").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber1").options[0].selected = true;
                document.getElementById("select2-chosen-7").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime1").options[0].selected = true;
                document.getElementById("select2-chosen-8").innerHTML = '時間を選択';

                $('#laborWorkVolume1').val('');
            });
            $('#laborButtonName2').on('click', function() {
                document.getElementById("laborTraderId2").options[0].selected = true;
                document.getElementById("select2-chosen-9").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber2").options[0].selected = true;
                document.getElementById("select2-chosen-10").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime2").options[0].selected = true;
                document.getElementById("select2-chosen-11").innerHTML = '時間を選択';

                $('#laborWorkVolume2').val('');
            });
            $('#laborButtonName3').on('click', function() {
                document.getElementById("laborTraderId3").options[0].selected = true;
                document.getElementById("select2-chosen-12").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber3").options[0].selected = true;
                document.getElementById("select2-chosen-13").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime3").options[0].selected = true;
                document.getElementById("select2-chosen-14").innerHTML = '時間を選択';

                $('#laborWorkVolume3').val('');
            });
            $('#laborButtonName4').on('click', function() {
                document.getElementById("laborTraderId4").options[0].selected = true;
                document.getElementById("select2-chosen-15").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber4").options[0].selected = true;
                document.getElementById("select2-chosen-16").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime4").options[0].selected = true;
                document.getElementById("select2-chosen-17").innerHTML = '時間を選択';

                $('#laborWorkVolume4').val('');
            });
            $('#laborButtonName5').on('click', function() {
                document.getElementById("laborTraderId5").options[0].selected = true;
                document.getElementById("select2-chosen-18").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber5").options[0].selected = true;
                document.getElementById("select2-chosen-19").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime5").options[0].selected = true;
                document.getElementById("select2-chosen-20").innerHTML = '時間を選択';

                $('#laborWorkVolume5').val('');
            });
            $('#laborButtonName6').on('click', function() {
                document.getElementById("laborTraderId6").options[0].selected = true;
                document.getElementById("select2-chosen-21").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber6").options[0].selected = true;
                document.getElementById("select2-chosen-22").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime6").options[0].selected = true;
                document.getElementById("select2-chosen-23").innerHTML = '時間を選択';

                $('#laborWorkVolume6').val('');
            });
            $('#laborButtonName7').on('click', function() {
                document.getElementById("laborTraderId7").options[0].selected = true;
                document.getElementById("select2-chosen-24").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber7").options[0].selected = true;
                document.getElementById("select2-chosen-25").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime7").options[0].selected = true;
                document.getElementById("select2-chosen-26").innerHTML = '時間を選択';

                $('#laborWorkVolume7').val('');
            });
            $('#laborButtonName8').on('click', function() {
                document.getElementById("laborTraderId8").options[0].selected = true;
                document.getElementById("select2-chosen-27").innerHTML = '業者名を選択してください';

                document.getElementById("laborPeopleNumber8").options[0].selected = true;
                document.getElementById("select2-chosen-28").innerHTML = '人数を選択';

                document.getElementById("laborWorkTime8").options[0].selected = true;
                document.getElementById("select2-chosen-29").innerHTML = '時間を選択';

                $('#laborWorkVolume8').val('');
            });
            $('#laborButtonNameAll').on('click', function() {
                document.getElementById("laborTraderId1").options[0].selected = true;
                document.getElementById("select2-chosen-6").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber1").options[0].selected = true;
                document.getElementById("select2-chosen-7").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime1").options[0].selected = true;
                document.getElementById("select2-chosen-8").innerHTML = '時間を選択';
                $('#laborWorkVolume1').val('');

                document.getElementById("laborTraderId2").options[0].selected = true;
                document.getElementById("select2-chosen-9").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber2").options[0].selected = true;
                document.getElementById("select2-chosen-10").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime2").options[0].selected = true;
                document.getElementById("select2-chosen-11").innerHTML = '時間を選択';
                $('#laborWorkVolume2').val('');

                document.getElementById("laborTraderId3").options[0].selected = true;
                document.getElementById("select2-chosen-12").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber3").options[0].selected = true;
                document.getElementById("select2-chosen-13").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime3").options[0].selected = true;
                document.getElementById("select2-chosen-14").innerHTML = '時間を選択';
                $('#laborWorkVolume3').val('');

                document.getElementById("laborTraderId4").options[0].selected = true;
                document.getElementById("select2-chosen-15").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber4").options[0].selected = true;
                document.getElementById("select2-chosen-16").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime4").options[0].selected = true;
                document.getElementById("select2-chosen-17").innerHTML = '時間を選択';
                $('#laborWorkVolume4').val('');

                document.getElementById("laborTraderId5").options[0].selected = true;
                document.getElementById("select2-chosen-18").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber5").options[0].selected = true;
                document.getElementById("select2-chosen-19").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime5").options[0].selected = true;
                document.getElementById("select2-chosen-20").innerHTML = '時間を選択';
                $('#laborWorkVolume5').val('');

                document.getElementById("laborTraderId6").options[0].selected = true;
                document.getElementById("select2-chosen-21").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber6").options[0].selected = true;
                document.getElementById("select2-chosen-22").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime6").options[0].selected = true;
                document.getElementById("select2-chosen-23").innerHTML = '時間を選択';
                $('#laborWorkVolume6').val('');

                document.getElementById("laborTraderId7").options[0].selected = true;
                document.getElementById("select2-chosen-24").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber7").options[0].selected = true;
                document.getElementById("select2-chosen-25").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime7").options[0].selected = true;
                document.getElementById("select2-chosen-26").innerHTML = '時間を選択';
                $('#laborWorkVolume7').val('');

                document.getElementById("laborTraderId8").options[0].selected = true;
                document.getElementById("select2-chosen-27").innerHTML = '業者名を選択してください';
                document.getElementById("laborPeopleNumber8").options[0].selected = true;
                document.getElementById("select2-chosen-28").innerHTML = '人数を選択';
                document.getElementById("laborWorkTime8").options[0].selected = true;
                document.getElementById("select2-chosen-29").innerHTML = '時間を選択';
                $('#laborWorkVolume8').val('');
            });

            $('#heavyMachineryTraderButton1').on('click', function() {
                document.getElementById("heavyMachineryTraderId1").options[0].selected = true;
                document.getElementById("select2-chosen-31").innerHTML = '業者名を選択してください';

                document.getElementById("heavyMachineryModel1").options[0].selected = true;
                document.getElementById("select2-chosen-32").innerHTML = '業者名を選択してください';

                $('#heavyMachineryTime1').val('');
                $('#heavyMachineryRemarks1').val('');
            });
            $('#heavyMachineryTraderButton2').on('click', function() {
                document.getElementById("heavyMachineryTraderId2").options[0].selected = true;
                document.getElementById("select2-chosen-33").innerHTML = '業者名を選択してください';

                document.getElementById("heavyMachineryModel2").options[0].selected = true;
                document.getElementById("select2-chosen-34").innerHTML = '業者名を選択してください';

                $('#heavyMachineryTime2').val('');
                $('#heavyMachineryRemarks2').val('');
            });
            $('#heavyMachineryTraderButton3').on('click', function() {
                document.getElementById("heavyMachineryTraderId3").options[0].selected = true;
                document.getElementById("select2-chosen-35").innerHTML = '業者名を選択してください';

                document.getElementById("heavyMachineryModel3").options[0].selected = true;
                document.getElementById("select2-chosen-36").innerHTML = '業者名を選択してください';

                $('#heavyMachineryTime3').val('');
                $('#heavyMachineryRemarks3').val('');
            });
            $('#heavyMachineryTraderButton4').on('click', function() {
                document.getElementById("heavyMachineryTraderId4").options[0].selected = true;
                document.getElementById("select2-chosen-37").innerHTML = '業者名を選択してください';

                document.getElementById("heavyMachineryModel4").options[0].selected = true;
                document.getElementById("select2-chosen-38").innerHTML = '業者名を選択してください';

                $('#heavyMachineryTime4').val('');
                $('#heavyMachineryRemarks4').val('');
            });
            $('#heavyMachineryTraderButton5').on('click', function() {
                document.getElementById("heavyMachineryTraderId5").options[0].selected = true;
                document.getElementById("select2-chosen-39").innerHTML = '業者名を選択してください';

                document.getElementById("heavyMachineryModel5").options[0].selected = true;
                document.getElementById("select2-chosen-40").innerHTML = '業者名を選択してください';

                $('#heavyMachineryTime5').val('');
                $('#heavyMachineryRemarks5').val('');
            });
            $('#heavyMachineryTraderButton6').on('click', function() {
                document.getElementById("heavyMachineryTraderId6").options[0].selected = true;
                document.getElementById("select2-chosen-41").innerHTML = '業者名を選択してください';

                document.getElementById("heavyMachineryModel6").options[0].selected = true;
                document.getElementById("select2-chosen-42").innerHTML = '業者名を選択してください';

                $('#heavyMachineryTime6').val('');
                $('#heavyMachineryRemarks6').val('');
            });
            $('#heavyMachineryTraderButtonAll').on('click', function() {
                document.getElementById("heavyMachineryTraderId1").options[0].selected = true;
                document.getElementById("select2-chosen-31").innerHTML = '業者名を選択してください';
                document.getElementById("heavyMachineryModel1").options[0].selected = true;
                document.getElementById("select2-chosen-32").innerHTML = '業者名を選択してください';
                $('#heavyMachineryTime1').val('');
                $('#heavyMachineryRemarks1').val('');

                document.getElementById("heavyMachineryTraderId2").options[0].selected = true;
                document.getElementById("select2-chosen-33").innerHTML = '業者名を選択してください';
                document.getElementById("heavyMachineryModel2").options[0].selected = true;
                document.getElementById("select2-chosen-34").innerHTML = '業者名を選択してください';
                $('#heavyMachineryTime2').val('');
                $('#heavyMachineryRemarks2').val('');

                document.getElementById("heavyMachineryTraderId3").options[0].selected = true;
                document.getElementById("select2-chosen-35").innerHTML = '業者名を選択してください';
                document.getElementById("heavyMachineryModel3").options[0].selected = true;
                document.getElementById("select2-chosen-36").innerHTML = '業者名を選択してください';
                $('#heavyMachineryTime3').val('');
                $('#heavyMachineryRemarks3').val('');

                document.getElementById("heavyMachineryTraderId4").options[0].selected = true;
                document.getElementById("select2-chosen-37").innerHTML = '業者名を選択してください';
                document.getElementById("heavyMachineryModel4").options[0].selected = true;
                document.getElementById("select2-chosen-38").innerHTML = '業者名を選択してください';
                $('#heavyMachineryTime4').val('');
                $('#heavyMachineryRemarks4').val('');

                document.getElementById("heavyMachineryTraderId5").options[0].selected = true;
                document.getElementById("select2-chosen-39").innerHTML = '業者名を選択してください';
                document.getElementById("heavyMachineryModel5").options[0].selected = true;
                document.getElementById("select2-chosen-40").innerHTML = '業者名を選択してください';
                $('#heavyMachineryTime5').val('');
                $('#heavyMachineryRemarks5').val('');

                document.getElementById("heavyMachineryTraderId6").options[0].selected = true;
                document.getElementById("select2-chosen-41").innerHTML = '業者名を選択してください';
                document.getElementById("heavyMachineryModel6").options[0].selected = true;
                document.getElementById("select2-chosen-42").innerHTML = '業者名を選択してください';
                $('#heavyMachineryTime6').val('');
                $('#heavyMachineryRemarks6').val('');
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
