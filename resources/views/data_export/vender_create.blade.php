@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/newreport.css') }}" rel="stylesheet">

    <div class="container main-container">
        <form method="post" enctype="multipart/form-data">
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
                <h5>部署  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <select name="department_id" id="department_id" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">部署を選択してください</option>

                        @foreach(array("住宅部", "土木部", "特殊建築部", "農業施設部") as $value)
                            <option value="{{$loop->index+1}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="item-conteiner-top select-checker-container">
                <h5>業者名  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <select name="traderId" id="traderId" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">部署を選択してください</option>
                    </select>
                </div>
            </div>

            <div class="item-conteiner-top">
                <div class="btn btn-primary" onclick="dataexport()">csvデータを作成する</div>
            </div>

        </form>
    </div>

    <script>
        const dataexport = async () => {
            if(validate()) {
                const csvData = await generateCsvData();
                downloadCsv(csvData['fileName'], csvData['content']);
            }
        };

        const validate = () => {
            if(!($('input[name="startDate"]').val())) {
                alert('開始日付を選択してください。')
                return false;
            }
            if(!($('input[name="endDate"]').val())) {
                alert('終了日付を選択してください。')
                return false;
            }
            if(!($('select[name="traderId"]').val())) {
                alert('業者名を選択してください')
                return false;
            }

            return true;
        }

        const generateCsvData = () => {
            const requestData = Object.assign(
                { 'startDate' : $('input[name="startDate"]').val() },
                { 'endDate' : $('input[name="endDate"]').val() },
                { 'traderId' : $('select[name="traderId"]').val() }
            );

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/api/data_exports/vender',
                    type: 'post',
                    dataType: 'json',
                    data: requestData
                })
                .done(function (response) {
                    resolve(response);
                })
                .fail(function () {
                    alert('CSVデータ作成中にエラーが発生しました、しばらくたってやり直しても治らない場合は管理者までお問い合わせください。');
                });
            });
        }

        const downloadCsv = (fileName, array) => {
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

        // 部署を選択したら、業者データを更新
        $('#department_id').change(function() {
            const department_id = $('#department_id option:selected').val();
            if(!department_id) {
                return
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

            over_write(traders, '#traderId', '', true);
        }
    </script>

@endsection
