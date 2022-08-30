@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/edit_trader.css') }}" rel="stylesheet">

    <div class="container main-container">
        <div>
            <button type="button" class="btn btn-info" onclick="(showTraderForm(this))">業者を追加</button>
        </div>

        <ul>
            @foreach ($traders as $trader)
                <div class="trader_item" id="{{ $trader['id'] }}">
                    <li>
                        @switch ($trader['department_id'])
                            @case(1)
                                住宅部
                                @break
                            @case(2)
                                土木部
                                @break
                            @case(3)
                                特殊建築部
                                @break
                            @case(4)
                                農業施設部
                                @break
                            @case(5)
                                <td>東京支店</td>
                                @break
                            @default
                                <td></td>
                        @endswitch
                        <span> : </span><span class="changeTraderForm" onclick="(changeTraderForm(this))" data-id="{{ $trader['id'] }}">{{ $trader['name'] }}</span>
                    </li>

                    <ul>
                        @foreach ($assets as $asset)
                            @if($asset['trader_id'] == $trader['id'])
                                <li><span data-id="{{ $asset['id'] }}" class="changeAssetForm" onclick="(changeAssetForm(this))">{{ $asset['name'] }}</span></li>
                            @endif
                        @endforeach
                        <li>
                            <button type="button" class="btn btn--circle" onclick="(showAssetsForm(this))"><i class="fas fa-plus"></i></button>
                        </li>
                    </ul>
                </div>
            @endforeach
        </ul>
    </div>

    <script>
        //////////// 業者追加 ////////////
        const showTraderForm = (button_this) => {
            $(button_this).parent().append(`<select class="department"><option value="">部署を選択してください</option><option value="1">住宅部</option><option value="2">土木部</option><option value="3">特殊建築部</option><option value="4">農業施設部</option><option value="5">東京支店</option></select>`);
            $(button_this).parent().append(`<input class="work-volume tagsinput tagsinput-typeahead input-lg" placeholder="追加したい業者名" />`);
            $(button_this).parent().append(`<button type="button" class="btn btn-info" style="margin:0 5px;" onclick="(checkTraderForm(this))">業者を追加</button>`);
            $(button_this).remove();
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
                // データ更新が面倒なのでページを再描写
                window.location.href = '/edit_trader';
            })
            .fail(function () {
                alert('業者データ保存中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
            });
        };

        const checkTraderForm = (button_this) => {
            const select_department_id = $(button_this).parent().children('select').val();
            if(select_department_id == '' ) {
                alert("部署を選択してください。");
                return
            }
            if(isNaN(select_department_id)){
                alert("部署が不適切です。");
                return
            }

            const input_trader_name = $(button_this).parent().children('input').val();
            if(input_trader_name == '' ) {
                alert("業者名を入力してください。");
                return
            }
            if(input_trader_name.length > 100){
                alert("業者名は100文字以内にしてください。");
                return
            }

            if(confirm(`この業者名を追加しますよろしいですか？\n「${input_trader_name}」`)) {
                saveTrader(input_trader_name, select_department_id);
            } else {
                alert("キャンセルしました。");
                return;
            }
        };

        //////////// 資産追加 ////////////
        const showAssetsForm = (button_this) => {
            $(button_this).parent().parent().append(`<li><input class="work-volume tagsinput tagsinput-typeahead input-lg" size="40" placeholder="追加したい機種" /><button type="button" class="btn btn-info assets_button" onclick="(checkAssetsForm(this))">機種を追加</button></li>`);
            $(button_this).parent().remove();
        };

        const hiddenAssetForm = (button_this, new_assets) => {
            $(button_this).parent().parent().append(`<li><span data-id="${new_assets['id']}" class="changeAssetForm" onclick="(changeAssetForm(this))">${new_assets['name']}</span></li>`);
            $(button_this).parent().parent().append(`<li><button type="button" class="btn btn--circle" onclick="(showAssetsForm(this))"><i class="fas fa-plus"></i></button></li>`);
            $(button_this).parent().remove();
        }

        const saveAsset = (name, trader_id) => {
            const resutl = $.ajax({
                url: '/api/assets',
                type: 'post',
                dataType: 'json',
                data: {
                    name: name,
                    trader_id: trader_id,
                }
            });
            return resutl;
        };

        const checkAssetsForm = (button_this) => {
            const input_assets_name = $(button_this).parent().children('input').val();
            if(input_assets_name == '' ) {
                alert("機種名を入力してください。");
                return
            }
            if(input_assets_name.length > 100){
                alert("機種名は100文字以内にしてください。");
                return
            }

            const trader_id = $(button_this).parent().parent().parent().attr('id');

            if(confirm(`この機種名を追加しますよろしいですか？\n機種名「${input_assets_name}」`)) {
                saveAsset(input_assets_name, trader_id)
                    .done(function (response) {
                        const new_assets = response.slice(-1)[0];
                        hiddenAssetForm(button_this, new_assets);
                    })
                    .fail(function () {
                        alert('機種データ保存中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
                    });
            } else {
                alert("キャンセルしました。");
                return;
            }
        };

        //////////// 業者編集 ////////////
        const changeTraderForm = (trader_name_this) => {
            if($(trader_name_this).children('input').length == 1) {
                return
            }

            const trader_name = $(trader_name_this).text();
            const trader_id = $(trader_name_this).attr('data-id');
            $(trader_name_this).html(`<input class="work-volume tagsinput tagsinput-typeahead input-lg" value="${trader_name}" /><button type="button" class="btn btn-info assets_button" onclick="(checkUpdateTraderForm(this, ${trader_id}))">保存</button>`);
        };

        const updateTrader = (id, name) => {
            $.ajax({
                    url: `/api/traders/${id}/edit`,
                    type: 'get',
                    dataType: 'json',
                    data: {
                        name: name
                    },
                })
            .fail(function () {
                alert('業者データ更新中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
            });
        };

        const checkUpdateTraderForm = (trader_edit_form_this, trader_id) => {
            const trader_name = $(trader_edit_form_this).parent().children('input').val();

            if(trader_name == '' ) {
                alert("業者名が空です。");
                return
            }
            if(trader_name.length > 100){
                alert("業者名は100文字以内にしてください。");
                return
            }

            $(trader_edit_form_this).parent().parent().append(`<span class="changeTraderForm" onclick="(changeTraderForm(this))" data-id="${trader_id}">${trader_name}</span>`);
            $(trader_edit_form_this).parent().remove();

            updateTrader(trader_id, trader_name);
        };

        //////////// 資産編集 ////////////
        const changeAssetForm = (asset_name_this) => {
            if($(asset_name_this).children('input').length == 1) {
                return
            }

            const asset_name = $(asset_name_this).text();
            const asset_id = $(asset_name_this).attr('data-id');
            $(asset_name_this).html(`<input type="text" class="work-volume tagsinput tagsinput-typeahead input-lg" value="${asset_name}" /><button type="button" class="btn btn-info assets_button" onclick="(checkUpdateAssetForm(this, ${asset_id}))">保存</button>`);
        };

        const updateAsset = (id, name) => {
            $.ajax({
                    url: `/api/assets/${id}/edit`,
                    type: 'get',
                    dataType: 'json',
                    data: {
                        name: name
                    },
                })
            .fail(function () {
                alert('機種データ更新中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
            });
        };

        const checkUpdateAssetForm = (asset_edit_form_this, asset_id) => {
            const asset_name = $(asset_edit_form_this).parent().children('input').val();

            if(asset_name == '' ) {
                alert("機種名を入力してください。");
                return
            }
            if(asset_name.length > 100){
                alert("機種名は100文字以内にしてください。");
                return
            }

            $(asset_edit_form_this).parent().parent().html(`<span data-id="${asset_id}" class="changeAssetForm" onclick="(changeAssetForm(this))">${asset_name}</span>`);

            updateAsset(asset_id, asset_name);
        };
    </script>

@endsection
