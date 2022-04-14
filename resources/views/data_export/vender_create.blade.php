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
                <h5>業者名  <span class="required">[必須]</h5>
                <div class="col-md-12">
                    <select name="traderId" data-toggle="select" class="form-control select select-default mrs mbm">
                        <option value="" label="default">業者名を選択</option>
                        @foreach ($traders as $trader)
                            <option value="{{$trader->id}}">{{$trader->name}}</option>
                        @endforeach
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
    </script>

@endsection
