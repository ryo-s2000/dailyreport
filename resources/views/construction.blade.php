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
            <?php $action = '/construction/password'; ?>
        @else
            <div class="btn-container col-md-12">
                <button class="edit-construction-btn btn btn-primary btn-new-pdf display-none display-pc" onClick="root()">管理アカウントに変更</button>
            </div>
            <?php $action = '/construction'; ?>
        @endif

        <main class="dailyreport-wrapper">
            <form method="get" action="{{$action}}" enctype="multipart/form-data">
                <div><span class="refine-title">順番</span></div>
                <select name="sort" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                    <option value="" label="default">選択</option>
                    @foreach(array("工期自早い順", "工期自遅い順", '工期至早い順', '工期至遅い順', '安い順', '高い順') as $value)
                        @if($constructionsPalams['sort'] == $value)
                            <option value="{{$value}}" selected>{{$value}}</option>
                        @else
                            <option value="{{$value}}">{{$value}}</option>
                        @endif
                    @endforeach
                </select>

                <?php
                    $orderer = [];
                    $place = [];
                    $sales = [];
                    $supervisor = [];
                    foreach ($allConstructions as $construction) {
                        $orderer[] = $construction->orderer;
                        $place[] = $construction->place;
                        $sales[] = $construction->sales;
                        $supervisor[] = $construction->supervisor;
                    }
                ?>

                <div><span class="refine-title">絞り込み</span></div>
                <table class="table table-striped table-condensed table-bordered table-nonfluid" border="1">
                    <tr>
                        <td class="refine-td">
                            <select name="number" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                                <option value="" label="default">番号</option>

                                @foreach ($allConstructions as $construction)
                                    @if($constructionsPalams['number'] == $construction->number)
                                        <option value="{{$construction->number}}" selected>{{$construction->number}}</option>
                                    @else
                                        <option value="{{$construction->number}}">{{$construction->number}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <td class="refine-td">
                            <select name="name" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                                <option value="" label="default">工事名</option>

                                @foreach ($allConstructions as $construction)
                                    @if($constructionsPalams['name'] == $construction->name)
                                        <option value="{{$construction->name}}" selected>{{$construction->name}}</option>
                                    @else
                                        <option value="{{$construction->name}}">{{$construction->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <td class="refine-td">
                            <select name="orderer" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                                <option value="" label="default">発注者</option>

                                @foreach (array_unique(array_filter($orderer)) as $value)
                                    @if($constructionsPalams['orderer'] == $value)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <td class="refine-td">
                            <select name="place" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                                <option value="" label="default">工事箇所</option>

                                @foreach (array_unique(array_filter($place)) as $value)
                                    @if($constructionsPalams['place'] == $value)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <td class="refine-td">
                            <select name="sales" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                                <option value="" label="default">営業担当</option>

                                @foreach (array_unique(array_filter($sales)) as $value)
                                    @if($constructionsPalams['sales'] == $value)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <td class="refine-td">
                            <select name="supervisor" data-toggle="select" class="select2 form-control select select-default mrs mbm">
                                <option value="" label="default">工事担当</option>

                                @foreach (array_unique(array_filter($supervisor)) as $value)
                                    @if($constructionsPalams['supervisor'] == $value)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                    </tr>
                </table>
                <button type="button" class="btn btn-primary btn-create-pdf" onClick="window.reset();">条件をリセット</button>
                <button type="submit" class="btn btn-primary btn-refine" onClick="location.href='/construction'">決定</button>
            </form>

            <table class="table table-striped table-condensed table-bordered table-nonfluid" border="1">
                <thead class="header">
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
                </thead>

                <tbody>
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
                                        <input type="submit" class="btn btn-primary btn-create-pdf" onClick="waringDelete({{$construction->id}})" value="削除">
                                    </td>
                                @endif
                            </tr>

                            <form method="POST" action="/delete/construction/{{$construction->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary btn-create-pdf delete-submit" id="{{$construction->id}}"></button>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </main>
        </div>

    <script>
        // 削除処理
        function waringDelete(id){
            ret = prompt("※この処理を実行するとデータが削除されます。\rそれでもよろしければ入力欄にdeleteと打ち込んでボタンを押してください。", "");
            if (ret == 'delete'){
                document.getElementById(id).click();
            }
        }

        /// パスワード処理
        function root(){
            ret = prompt("※パスワードを入力してください。", "");
            url = "/construction/" + ret;
            location.href=url;
        }

        // 選択時カラー機能
        $(document).ready(function(){
            if($('select[name="sort"]').val() != ""){
                $('select[name="sort"]').addClass("select-choiced");
            }
            if($('select[name="number"]').val() != ""){
                $('select[name="number"]').addClass("select-choiced");
            }
            if($('select[name="name"]').val() != ""){
                $('select[name="name"]').addClass("select-choiced");
            }
            if($('select[name="orderer"]').val() != ""){
                $('select[name="orderer"]').addClass("select-choiced");
            }
            if($('select[name="place"]').val() != ""){
                $('select[name="place"]').addClass("select-choiced");
            }
            if($('select[name="sales"]').val() != ""){
                $('select[name="sales"]').addClass("select-choiced");
            }
            if($('select[name="supervisor"]').val() != ""){
                $('select[name="supervisor"]').addClass("select-choiced");
            }
        });

        $(function() {
            // 工事番号、工事名同期処理
            $('select[name="number"]').change(function(e, data) {
                if(data !="exit"){
                    $('select[name="name"]').prop("selectedIndex", $(this).prop("selectedIndex")).trigger('change', ['exit']);
                }
            });
            $('select[name="name"]').change(function(e, data) {
                if(data !="exit"){
                    $('select[name="number"]').prop("selectedIndex", $(this).prop("selectedIndex")).trigger('change', ['exit']);
                }
            });

            // 選択時カラー機能
            $('select[name="sort"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="sort"]').removeClass("select-choiced");
                } else {
                    $('select[name="sort"]').addClass("select-choiced");
                }
            });
            $('select[name="number"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="number"]').removeClass("select-choiced");
                } else {
                    $('select[name="number"]').addClass("select-choiced");
                }
            });
            $('select[name="name"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="name"]').removeClass("select-choiced");
                } else {
                    $('select[name="name"]').addClass("select-choiced");
                }
            });
            $('select[name="orderer"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="orderer"]').removeClass("select-choiced");
                } else {
                    $('select[name="orderer"]').addClass("select-choiced");
                }
            });
            $('select[name="place"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="place"]').removeClass("select-choiced");
                } else {
                    $('select[name="place"]').addClass("select-choiced");
                }
            });
            $('select[name="sales"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="sales"]').removeClass("select-choiced");
                } else {
                    $('select[name="sales"]').addClass("select-choiced");
                }
            });
            $('select[name="supervisor"]').change(function(e, data) {
                if($(this).prop("selectedIndex") == 0){
                    $('select[name="supervisor"]').removeClass("select-choiced");
                } else {
                    $('select[name="supervisor"]').addClass("select-choiced");
                }
            });

        });

        // リセット処理
        function reset(){
            ['number', 'name', 'orderer', 'place', 'sales', 'supervisor', 'sort'].forEach(name => {
                selectName = 'select[name="' + name + '"]';
                $(selectName).prop("selectedIndex", 0).trigger('change', ['exit']);
            });
        }
    </script>

@endsection
