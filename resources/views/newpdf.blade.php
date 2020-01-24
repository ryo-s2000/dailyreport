@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="/newpdf" enctype="multipart/form-data" target="_blank">
            @csrf

            <div>
                年　月　日
                <input type="date" name="date" value="{{$datetime}}">
            </div>
            <div>
                AM天気
                <input type="radio" name="amweather" value="sunny" checked="checked"><i class="fas fa-sun"></i>
                <input type="radio" name="amweather" value="sunnyandcloudy"><i class="fas fa-cloud-sun"></i>
                <input type="radio" name="amweather" value="cloudy"><i class="fas fa-cloud"></i>
                <input type="radio" name="amweather" value="rain"><i class="fas fa-umbrella"></i>
                <input type="radio" name="amweather" value="snow"><i class="far fa-snowflake"></i>
            </div>
            <div>
                PM天気
                <input type="radio" name="pmweather" value="sunny" checked="checked"><i class="fas fa-sun"></i>
                <input type="radio" name="pmweather" value="sunnyandcloudy"><i class="fas fa-cloud-sun"></i>
                <input type="radio" name="pmweather" value="cloudy"><i class="fas fa-cloud"></i>
                <input type="radio" name="pmweather" value="rain"><i class="fas fa-umbrella"></i>
                <input type="radio" name="pmweather" value="snow"><i class="far fa-snowflake"></i>
            </div>
            <div>
                工事番号
                <select name="constructionNumber">
                    <option value="">工事番号を選択</option>
                    <option value="MC-111">MC-111</option>
                    <option value="MC-222">MC-222</option>
                    <option value="MC-333">MC-333</option>
                    <option value="MC-444">MC-444</option>
                    <option value="MC-555">MC-555</option>
                </select>
            </div>
            {{-- <div>
                工事名
                <textarea cols="12" rows="2" wrap="hard" name="constructionName">いらんのでは？</textarea>
            </div> --}}
            労務
            <div>
                業者名<input name="traderName1">
                人数
                <select name="peopleNumber1">
                    <option value="">人数を選択</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                時間
                <select name="workingTime1">
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
                作業及び出来高等<input name="work1">
            </div>
            <div>
                業者名<input name="traderName2">
                人数
                <select name="peopleNumber2">
                    <option value="">人数を選択</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                時間
                <select name="workingTime2">
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
                作業及び出来高等<input name="work2">
            </div>
            <div>
                業者名<input name="traderName3">
                人数
                <select name="peopleNumber3">
                    <option value="">人数を選択</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                時間
                <select name="workingTime3">
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
                作業及び出来高等<input name="work3">
            </div>
            <div>
                業者名<input name="traderName4">
                人数
                <select name="peopleNumber4">
                    <option value="">人数を選択</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                時間
                <select name="workingTime4">
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
                作業及び出来高等<input name="work4">
            </div>
            <div>
                業者名<input name="traderName5">
                人数
                <select name="peopleNumber5">
                    <option value="">人数を選択</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                時間
                <select name="workingTime5">
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
                作業及び出来高等<input name="work5">
            </div>
            購入資材
            <div>
                業者名<input name="materialTraderName1">
                資材名<input name="materialName1">
                形状寸法<input name="shapeDimensions1">
                数量<input name="quantity1">
                単位<input name="unit1">
            </div>
            <div>
                業者名<input name="materialTraderName2">
                資材名<input name="materialName2">
                形状寸法<input name="shapeDimensions2">
                数量<input name="quantity2">
                単位<input name="unit2">
            </div>
            <div>
                業者名<input name="materialTraderName3">
                資材名<input name="materialName3">
                形状寸法<input name="shapeDimensions3">
                数量<input name="quantity3">
                単位<input name="unit3">
            </div>
            <div>
                業者名<input name="materialTraderName4">
                資材名<input name="materialName4">
                形状寸法<input name="shapeDimensions4">
                数量<input name="quantity4">
                単位<input name="unit4">
            </div>
            <div>
                業者名<input name="materialTraderName5">
                資材名<input name="materialName5">
                形状寸法<input name="shapeDimensions5">
                数量<input name="quantity5">
                単位<input name="unit5">
            </div>

            <input type="submit" value="PDFを作成">

        </form>
    </div>
@endsection
