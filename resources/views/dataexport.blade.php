@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    {{-- 単価入力フォーム --}}
    <div style="display:none;" class="unit_price_wrapper" id="unit_price_input_form">
        <div class="unit_price_input">
            <div class="close-icon" onclick="close_unit_price_form()">
                <div></div>
                <div></div>
            </div>

            <div class="unit_price_form_item" id="laborTraderUnitPrice">
                <h5>オペ・従業員</h5>
            </div>
            <div class="unit_price_form_item" id="heavyMachineUnitPrice">
                <h5>重機類</h5>
            </div>

            <div class="unit_price_form_submit">
                <button class="btn btn-primary" onclick="export_data()">csvデータを出力する</button>
            </div>
        </div>
    </div>

    <div class="container main-container">

        <form method="post" action="/dataexport" enctype="multipart/form-data">
            @csrf

            <div class="item-conteiner-top">
                <h5>開始日付  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <input type="date" name="startDate" value="{{date('Y-m-d' , strtotime("-1 month"))}}" />
                </div>
            </div>

            <div class="item-conteiner-top">
                <h5>終了日付  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <input type="date" name="endDate" value="{{date('Y-m-d')}}" />
                </div>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>工事番号・工事名  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <select name="constructionNumber" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">工事番号を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->number}}">{{$construction->number}}</option>
                        @endforeach
                    </select>
                    <select name="constructionName" data-toggle="select" class="construction-name form-control select select-default mrs mbm">
                        <option value="" label="default">工事名を選択</option>
                        @foreach ($constructions as $construction)
                            <option value="{{$construction->name}}">{{$construction->name}}</option>
                        @endforeach
                    </select>
                </div>

                <select class="select-checker" name="constructionNumberChecker" required>
                    <option label="default" selected><option>
                        <option value="true">true</option>
                </select>
                <select class="select-checker" name="constructionNameChecker" required>
                    <option label="default" selected><option>
                        <option value="true">true</option>
                </select>
            </div>

            <div class="item-conteiner-top">
                <div class="btn btn-primary" onclick="dataexport()">csvデータを作成する</div>
            </div>

        </form>

    </div>

    <script>
        const dataexport = () => {
            if(!($('input[name="startDate"]').val())) {
                alert('開始日付を選択してください。')
                return
            }
            if(!($('input[name="endDate"]').val())) {
                alert('終了日付を選択してください。')
                return
            }
            if(!($('select[name="constructionNameChecker"]').val() && $('select[name="constructionNameChecker"]').val())) {
                alert('工事番号・工事名を選択してください')
                return
            }

            $.ajax({
                url: '/api/data_exports/unit_price',
                type: 'post',
                dataType: 'json',
                data: {
                    startDate: $('input[name="startDate"]').val(),
                    endDate: $('input[name="endDate"]').val(),
                    constructionNumber: $('select[name="constructionNumber"]').val()
                },
            })
            .done(function (response) {
                const unit_price_input = response;
                const laborTraderData  = unit_price_input['laborTraderIds'];
                const heavyMachineData = unit_price_input['heavyMachineryModels'];

                laborTraderData.forEach(element =>
                    $('#laborTraderUnitPrice').append(`<div><span>業者名「${element["laborTraderName"]}」</span><input id="${element["laborTraderId"]}" style="display:none;"><input placeholder="単価" type="number" class="price"></div>`)
                );
                heavyMachineData.forEach(element =>
                    $('#heavyMachineUnitPrice').append(`<div><span>業者名「${element["heavyMachineTraderName"]}」 名称「${element["heavyMachineName"]}」</span><input id="${element["heavyMachineryModel"]}" style="display:none;"><input placeholder="単価" type="number"></div>`)
                );

                $('#unit_price_input_form').show();
            })
            .fail(function () {
                alert('CSVデータ保存中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
            });
        };

        const close_unit_price_form = () => {
            $('#laborTraderUnitPrice').children('div').remove()
            $('#heavyMachineUnitPrice').children('div').remove()
            $('#unit_price_input_form').hide();
        }

        const export_data = () => {
            const get_unit_price = (id) => {
                let unit_prices = [];
                $('#'+id).children('div').each((index,div)  => {
                        unit_prices.push({'id':div.children[1].id, 'price':div.children[2].value})
                    }
                )

                return { [id] : unit_prices };
            }

            const unit_prices = Object.assign(
                get_unit_price('laborTraderUnitPrice'),
                get_unit_price('heavyMachineUnitPrice'),
                { 'startDate' : $('input[name="startDate"]').val() },
                { 'endDate' : $('input[name="endDate"]').val() },
                { 'constructionNumber' : $('select[name="constructionNumber"]').val() },
                { 'constructionName' : $('select[name="constructionName"]').val() }
            );
            $.ajax({
                url: '/api/data_exports',
                type: 'post',
                dataType: 'json',
                data: unit_prices
            })
            .done(function (response) {
                downloadCsv(response['csv'], response['fileName']);
                $('#laborTraderUnitPrice').children('div').remove()
                $('#heavyMachineUnitPrice').children('div').remove()
                $('#unit_price_input_form').hide();
            })
            .fail(function () {
                alert('CSVデータ作成中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
            });
        }

        const downloadCsv = (array, fileName) => {
            var UTF_8_BOM = '%EF%BB%BF';

            var csv = [];

            array.forEach(function (row, index) {
                csv.push(row.join(','));
            });

            csv = csv.join('\n');
            var data = 'data:text/csv;charset=utf-8,' + UTF_8_BOM + encodeURIComponent(csv);
            var element = document.createElement('a');
            element.href = data;
            element.setAttribute('download', fileName);
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }

        $(function() {
            // selectチェッカー
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
