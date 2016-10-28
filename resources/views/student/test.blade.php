@extends('student.layout')
@section('title', 'Тест')
@section('javascript')
    <script src="{{ URL::asset('js/student/test.js')}}"></script>
@endsection

@section('content')
    <div class="content">
        <!-- ko if: current.question() -->
        <div>
            <h3 data-bind="text: current.question().text"></h3>
            <h3 data-bind="timer: current.timeLeft"></h3>
        </div>

        <!-- ko if: current.answers().length -->
        <div data-bind="foreach: current.answers">
            <!-- ko if: $root.current.question().type() === 1 -->
                <input data-bind="attr: {id: id}, checked: $root.current.singleAnswer, value: id" type="radio" group="answers">
                <label data-bind="text: text, attr: {for: id}"></label> </br>
            <!-- /ko -->
            <!-- ko if: $root.current.question().type() === 2-->
                <input data-bind="attr: {id: id, checked: isRight}" type="checkbox">
                <label data-bind="text: text, attr: {for: id}"></label> </br>
            <!-- /ko -->
        </div>
        <!-- /ko -->
        <!-- ko if: $root.current.question().type() === 3 -->
            <label>Однострочный ответ</label> </br>
            <input data-bind="value: $root.current.answerText" type="text">
        <!-- /ko -->
        <!-- ko if: $root.current.question().type() === 4 -->
            <label>Многострочный ответ</label> </br>
            <textarea data-bind="value: $root.current.answerText" type=""></textarea>
        <!-- /ko -->
        <!-- /ko -->
        <button data-bind="click: $root.actions.answer">Ответить</button>
    </div>
@endsection