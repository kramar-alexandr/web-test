@extends('shared.layout')
@section('title', 'Дисциплины')
@section('javascript')
    <script src="{{ URL::asset('js/knockout.autocomplete.js')}}"></script>
    <script src="{{ URL::asset('js/admin/disciplines.js')}}"></script>
@endsection

@section('content')
<div class="content">
    <div class="filter">
        <div>
            <label>Название дисциплины</label></br>
            <input type="text" data-bind="value: $root.filter.discipline, valueUpdate: 'keyup'">
        </div>
        <div>
            <label>Направление</label></br>
            <select data-bind="options: $root.multiselect.data,
                       optionsText: 'fullname',
                       value: $root.filter.profile,
                       optionsCaption: 'Выберите профиль'"></select>
        </div>
    </div>
    <div class="org-accordion">
        <div data-bind="click: $root.csed.startAdd" class="org-item">
            <span class="fa">&#xf067;</span>
        </div>
        <!-- ko if: $root.mode() === 'add'-->
            <div data-bind="template: {name: 'show-details', data: $root.current.discipline}"></div>
        <!-- /ko -->
        <!-- ko foreach: disciplines -->
            <div class="org-item" data-bind="text: name, click: $root.csed.show"></div>
            <!-- ko if: $root.mode() !== 'none' && $data.id() === $root.current.discipline().id()-->
                <div data-bind="template: {name: 'show-details', data: $root.current.discipline}"></div>
            <!-- /ko -->
        <!-- /ko -->
    </div>
    <!-- ko if: $root.pagination.itemsCount() > $root.pagination.pageSize() -->
    <div class="pager-wrap">
        <!-- ko if: ($root.pagination.totalPages()) > 0 -->
        <div class="pager">
            <!-- ko ifnot: $root.pagination.currentPage() == 1 -->
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, 1)">&lsaquo;&lsaquo;</button>
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, ($root.pagination.currentPage() - 1))">&lsaquo;</button>
            <!-- /ko -->
            <!-- ko foreach: new Array($root.pagination.totalPages()) -->
            <span data-bind="visible: $root.pagination.dotsVisible($index() + 1)">...</span>
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, ($index()+1)), text: ($index()+1), visible: $root.pagination.pageNumberVisible($index() + 1), css: {current: ($index() + 1) == $root.pagination.currentPage()}"></button>
            <!-- /ko -->
            <!-- ko ifnot: $root.pagination.currentPage() == $root.pagination.totalPages() -->
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, ($root.pagination.currentPage() + 1))">&rsaquo;</button>
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, $root.pagination.totalPages())">&rsaquo;&rsaquo;</button>
            <!-- /ko -->
        </div>
        <!-- /ko -->
    </div>
    <!-- /ko -->
</div>

<div class="g-hidden">
    <div class="box-modal" id="delete-modal">
        <div class="popup-delete">
            <div><h3>Удалить выбранную дисциплину?</h3></div>
            <div>
                <button data-bind="click: $root.csed.remove" class="fa">&#xf00c;</button>
                <button data-bind="click: $root.csed.cancel" class="fa danger arcticmodal-close">&#xf00d;</button>
            </div>
        </div>
    </div>
</div>
<div class="g-hidden">
    <div class="box-modal" id="remove-theme-modal">
        <div class="popup-delete">
            <div><h3>Удалить выбранную тему?</h3></div>
            <div>
                <button data-bind="click: $root.csed.theme.remove" class="fa">&#xf00c;</button>
                <button class="fa danger arcticmodal-close">&#xf00d;</button>
            </div>
        </div>
    </div>
</div>
<div class="g-hidden">
    <div class="box-modal" id="add-theme-modal">
        <div>
            <div><span>Добавление темы</span></div>
            <div>
                <label>Название</label>
                <input type="text" data-bind="value: $root.current.theme().name">
            </div>
            <div>
                <button data-bind="click: $root.csed.theme.add" class="fa">&#xf00c;</button>
                <button class="fa danger arcticmodal-close">&#xf00d;</button>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="show-details">
    <div class="org-info">
        <!-- ko if: $root.mode() === 'info' || $root.mode() === 'delete' || $root.mode() === 'section' -->
        <div class="width100" data-bind="template: {name: 'info-mode', data: $data}"></div>
        <!-- /ko -->
        <!-- ko if: $root.mode() === 'edit' || $root.mode() === 'add'-->
        <div class="width100" data-bind="template: {name: 'edit-mode', data: $data}"></div>
        <!-- /ko -->
        <!-- ko if: $root.mode() !== 'add' -->
        <div class="width100">
            <table class="theme">
                <thead>
                <tr><th>#</th><th>Темы</th><th>Действия</th></tr>
                </thead>
                <tbody>
                <!-- ko foreach: $root.current.themes-->
                <tr>
                    <td data-bind="text: $index()+1"></td>
                    <td><a data-bind="text: name, click: $root.moveTo.theme"></a></td>
                    <td><button data-bind="click: $root.csed.theme.showSections" class="fa success">&#xf0f6;</button>
                        <button data-bind="click: $root.csed.theme.startRemove" class="fa danger">&#xf014;</button>
                    </td>
                </tr>
                <!-- /ko -->

                </tbody>
            </table>
        </div>
        <!-- /ko -->
    </div>
</script>
<script type="text/html" id="info-mode">
    <div class="org-info-details width100 discipline-info">
        <div>
            <label>Аббревиатура</label></br>
            <span data-bind="text: abbreviation"></span>
        </div>
        <div>
            <label>Полное название дисциплины</label></br>
            <span data-bind="text: name"></span>
        </div>
        <div>
        <i>
            <button class="move" data-bind="click: $root.csed.theme.startAdd"><span class="fa">&#xf067;</span>&nbsp;Добавить тему</button>
            <button class="move" data-bind="click: $root.moveTo.tests"><span class="fa">&#xf044;</span>&nbsp;Тесты</button>
        </i>
        <i>
            <button data-bind="click: $root.csed.startUpdate" class="fa">&#xf040;</button>
            <button data-bind="click: $root.csed.startRemove" class="fa danger">&#xf014;</button>
        </i>
        </div>
    </div>
</script>
<script type="text/html" id="edit-mode">
    <div class="org-info-edit width100 discipline-edit">
        <div>
            <label>Аббревиатура</label></br>
            <input type="text" data-bind="value: abbreviation">
        </div>
        <div>
            <label>Полное название дисциплины</label></br>
            <input type="text" data-bind="value: name">
        </div>
        <div>
            <label>Профили</label></br>
            <div class="multiselect-wrap">
                <!-- ko if: $root.multiselect.tags().length -->
                <div class="multiselect">
                    <ul data-bind="foreach: $root.multiselect.tags">
                        <li><span data-bind="click: $root.multiselect.remove" class="fa">&#xf00d;</span><span data-bind="text: fullname"></span></li>
                    </ul>
                </div>
                <!-- /ko -->
                <input data-bind="autocomplete: { data: $root.multiselect.data, format: $root.multiselect.show, onSelect: $root.multiselect.select}, css: {'full': $root.multiselect.tags().length}" value=""/>
            </div>
        </div>
        <div class="float-btn-group">
            <button data-bind="click: $root.csed.update" class="fa">&#xf00c;</button>
            <button data-bind="click: $root.csed.cancel" class="fa danger">&#xf00d;</button>
        </div>
    </div>
</script>

<div class="g-hidden">
    <div class="box-modal" id="sections-modal">
        <div class="box-modal_close arcticmodal-close">закрыть</div>
        <div class="width100">
            <div>
                <button data-bind="click: $root.csed.theme.addSection" class="add-section"><span class="fa">&#xf067;</span>&nbsp;Добавить новую секцию</button>
            </div>
            <!-- ko if:  $root.current.sections().length > 0-->
            <div class="section-info">
            <table class="theme">
                <thead>
                <tr><th>#</th><th>Название</th><th>Действия</th></tr>
                </thead>
                <tbody>
                <!-- ko foreach: $root.current.sections-->
                <tr>
                    <td data-bind="text: $index()+1"></td>
                    <td><a data-bind="text: name"></a></td>
                    <td><button data-bind="click: $root.csed.section.info" class="fa success">&#xf0f6;</button>
                        <button data-bind="click: $root.csed.section.edit" class="fa info">&#xf040;</button>
                        <button data-bind="click: $root.csed.section.startRemove" class="fa danger">&#xf014;</button>
                    </td>
                </tr>
                <!-- /ko -->
                </tbody>
            </table>
            </div>
            <!-- /ko -->
            <!-- ko if:  $root.current.sections().length == 0-->
            <div class="section-info">
                <p>Для данной темы секции отсутствуют</p>
            </div>
            <!-- /ko -->

        </div>
    </div>
</div>
<div class="g-hidden">
    <div class="box-modal" id="remove-section-modal">
        <div class="popup-delete">
            <div><span>Удалить выбранную секцию?</span></div>
            <div>
                <button data-bind="click: $root.csed.section.remove" class="fa">&#xf00c;</button>
                <button class="fa danger arcticmodal-close">&#xf00d;</button>
            </div>
        </div>
    </div>
</div>




@endsection