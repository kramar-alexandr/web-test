<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon        " href="{{ URL::asset('images/favicon.ico')}}"/>                                                                  
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.arcticmodal.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster.bundle.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster-sideTip-light.min.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/simple.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css')}}"/>

    @yield('style')

    <script src="{{ URL::asset('js/min/student-common.js')}}"></script>
    {{--<script src="{{ URL::asset('js/jquery-3.1.1.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/jquery.cookie.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/knockout-3.4.0.debug.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/knockout.mapping.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/knockout.validation.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/ru-RU.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/tooltipster.bundle.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/ko-copy.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/ko-progressbar.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/ko-postget.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/common.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/ko-events.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/tooltip.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/jquery.arcticmodal.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/modals.js')}}"></script>--}}
    {{--<script src="{{ URL::asset('js/helpers/user-info.js')}}"></script>--}}

    @yield('javascript')
</head>
<body>
<div class="page-wrap">
    <div class="loading">
        <img src="{{ URL::asset('images/loading.gif')}}" />
    </div>
    @yield('menu')
    @yield('content')
    @include('shared.common-modals')
</div>
@include('shared.footer')
</body>
</html>