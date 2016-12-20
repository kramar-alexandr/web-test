@extends('shared.layout')
@section('title', 'Студенты')
@section('javascript')
    <script src="{{ URL::asset('js/admin/students.js')}}"></script>
@endsection

@section('content')
    <div class="content">
        <div class="items">
            <div class="items-head">
                <h1>Администрирование учетных записей студентов</h1>
                <label class="adder" data-bind="click: $root.actions.start.create">Добавить</label>
            </div>
            <!-- ko if: $root.mode() === state.create -->
            <div class="details" data-bind="template: {name: 'update-user-info', data: $root.current.student}"></div>
            <!-- /ko -->
            <h3 class="text-center" data-bind="if: !filter.group()">Пожалуйста, выберите группу</h3>
            <div class="items-body" data-bind="if: current.students().length">
                <!-- ko foreach: current.students -->
                <div class="item" data-bind="click: $root.actions.show, css: {'current': id() === $root.current.student().id()}">
                    <span class="float-right" data-bind="if: active()">Подтверждена</span>
                    <span class="float-right" data-bind="if: !active()">Ожидает подтверждения</span>
                    <span data-bind="text: lastname() + ' ' + firstname() + ' ' + patronymic()"></span>
                </div>
                    <!-- ko if: $root.mode() !== state.none && $root.current.student().id() === id()  -->
                    <div class="details" data-bind="template: {name: 'student-info', data: $root.current.student }"></div>
                    <!-- /ko -->
                <!-- /ko -->
            </div>
            @include('admin.shared.pagination')
        </div>
        <div class="filter" data-bind="with: $root.filter">
            <div class="filter-block">
                <label class="title">ФИО студента</label>
                <input type="text" data-bind="value: name"/>
            </div>
            <div class="filter-block">
                <label class="title">Название группы</label>
                <select data-bind="options: $root.initial.groups,
                       optionsText: 'name',
                       value: group,
                       optionsCaption: 'Выберите группу'"></select>
            </div>
            <div class="filter-block"></div>
            <div class="filter-block"></div>
            <div class="filter-block"></div>
            <div class="filter-block"></div>
        </div>
    </div>
    @include('admin.shared.error-modal')
@endsection

<script type="text/html" id="student-info">
    <!-- ko if: $root.mode() === state.info -->
    <div class="details-row">
        <div class="details-column">
            <label class="title">ФИО</label>
            <span class="info" data-bind="text: lastname() + ' ' + firstname() + ' ' + patronymic()"></span>
        </div>
        <div class="details-column">
            <label class="title">E-mail</label>
            <span class="info" data-bind="text: email"></span>
        </div>
        <div class="details-column">
            <label class="title">Статус</label>
            <span class="radio-important" data-bind="if: active()">Подтверждена</span>
            <span class="radio-negative" data-bind="if: !active()">Ожидает подтверждения</span>
        </div>
    </div>
    <div class="details-row float-buttons">
        <button class="remove" data-bind="click: $root.actions.start.remove"><span class="fa">&#xf014;</span>&nbsp;Удалить</button>
        <button class="approve" data-bind="click: $root.actions.start.update"><span class="fa">&#xf040;</span>&nbsp;Редактировать</button>
    </div>
    <!-- /ko -->
    <!-- ko if: $root.mode() === state.update -->
        <!-- ko template: {name: 'update-user-info', data: $data} -->
        <!-- /ko -->
    <!-- /ko -->
</script>

<script type="text/html" id="update-user-info">
    <div class="details-row">
        <div class="details-column width-48p">
            <div class="details-row">
                <div class="details-column width-98p">
                    <label class="title">Фамилия</label>
                    <input type="text" data-bind="value: lastname"/>
                </div>
            </div>
            <div class="details-row">
                <div class="details-column width-98p">
                    <label class="title">Имя</label>
                    <input type="text" data-bind="value: firstname"/>
                </div>
            </div>
            <div class="details-row">
                <div class="details-column width-98p">
                    <label class="title">Отчество</label>
                    <input type="text" data-bind="value: patronymic"/>
                </div>
            </div>
        </div>
        <div class="details-column width-48p float-right">
            <div class="details-row">
                <div class="details-column width-98p">
                    <label class="title">Группа</label>
                    <select data-bind="options: $root.initial.groups,
                       optionsText: 'name',
                       value: $root.current.group,
                       optionsCaption: 'Выберите группу'"></select>
                </div>
            </div>
            <div class="details-row">
                <div class="details-column width-98p">
                    <label class="title">E-mail</label>
                    <input type="text" data-bind="value: email"/>
                </div>
            </div>
            <div class="details-row">
                <div class="details-column width-98p">
                    <label class="title">Пароль</label>
                    <!-- ko if: $root.mode() === state.update -->
                    <span class="radio-important" data-bind="click: $root.actions.password.change">Изменить пароль</span>
                    <!-- /ko -->
                    <!-- ko if: $root.mode() === state.create -->
                    <input type="password" data-bind="value: $root.current.password"/>
                    <!-- /ko -->
                </div>
            </div>
        </div>
    </div>
    <div class="details-row float-buttons">
        <div class="details-column width-100p">
            <label class="title">Статус учётной записи</label>
            <span class="radio radio-important">Подтвердить</span>
            <span>|</span>
            <span class="radio">Отклонить</span>
            <button class="cancel" data-bind="click: $root.actions.cancel">Отмена</button>
            <button class="approve" data-bind="click: $root.actions.end.update">Сохранить</button>
        </div>
    </div>
</script>

<div class="g-hidden">
    <div class="box-modal" id="change-password-modal">
        <div class="popup-delete">
            <div>
                <label class="title">Новый пароль</label>
                <input type="password" data-bind="value: $root.current.password" />
            </div>
            <div>
                <button data-bind="click: $root.actions.password.approve" class="approve">Изменить пароль</button>
                <button data-bind="click: $root.actions.password.cancel" class="cancel arcticmodal-close">Отмена</button>
            </div>
        </div>
    </div>
</div>

<div class="g-hidden">
    <div class="box-modal" id="change-success-modal">
        <div class="popup-delete">
            <div>
                <h3>Пароль успешно изменён</h3>
            </div>
            <div>
                <button class="approve arcticmodal-close">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="g-hidden">
    <div class="box-modal" id="remove-request-modal">
        <div class="popup-delete">
            <div><h3 class="text-center">Удалить выбранную заявку?</h3></div>
            <div>
                <button class="remove" data-bind="click: $root.actions.end.remove">Удалить</button>
                <button class="cancel arcticmodal-close">Отмена</button>
            </div>
        </div>
    </div>
</div>