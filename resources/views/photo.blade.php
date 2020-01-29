@extends('layouts.app')

@section('content')

    <!-- Styles -->
    <link href="{{ asset('css/photo.css') }}" rel="stylesheet">

    <div class="container main-container">
        <?php $beforReportDate = "" ?>

        @foreach($dailyreports as $dailyreport)
            @foreach(array("imagepath1", "imagepath2", "imagepath3", "imagepath4", "imagepath5") as $path)
                @if($dailyreport->$path)
                    @if($beforReportDate == "")
                        <h6>
                            {{date( 'Y年m月d日', strtotime( $dailyreport->date ))}}
                        </h6>

                        <div class="photo-container">
                            <div class="photo-cell">
                                <div>
                                    <img class="photo" src={{$dailyreport->$path}}>
                                </div>
                                <div class="photo-info">
                                    {{$dailyreport->constructionNumber}}<br />
                                    <p class="construction-name">{{$dailyreport->constructionName}}</p>
                                </div>
                            </div>
                        {{-- もしこの場所で繰り返しが途切れても自動で補正してくれる --}}
                    @elseif($dailyreport->date != $beforReportDate)
                        </div>
                            <h6>
                                {{date( 'Y年m月d日', strtotime( $dailyreport->date ))}}
                            </h6>

                            <div class="photo-container">
                                <div class="photo-cell">
                                    <div>
                                        <img class="photo" src={{$dailyreport->$path}}>
                                    </div>
                                    <div class="photo-info">
                                        {{$dailyreport->constructionNumber}}<br />
                                        <p class="construction-name">{{$dailyreport->constructionName}}</p>
                                    </div>
                                </div>
                    @else
                        <div class="photo-cell">
                            <div>
                                <img class="photo" src={{$dailyreport->$path}}>
                            </div>
                            <div class="photo-info">
                                {{$dailyreport->constructionNumber}}<br />
                                <p class="construction-name">{{$dailyreport->constructionName}}</p>
                            </div>
                        </div>
                    @endif
                <?php $beforReportDate = $dailyreport->date ?>
                @endif
            @endforeach
        @endforeach

@endsection
