$(document).ready(function () {
    var editorViewModel = function () {
        return new function () {
            var self = this;

            initializeViewModel.call(self, {
                page: menu.admin.materials,
                mode: true
            });

            self.modals = {
                move: '#move-modal'
            };

            self.media = ko.observable({
                id: ko.observable(0),
                type: ko.observable(''),
                content: ko.observable(''),
                path: ko.observable(''),
                name: ko.observable(''),
                hash: ko.observable('')
            });

            self.name = ko.observable('');

            self.getMedia = function () {
                var currentUrl = window.location.href;
                var urlParts = currentUrl.split('/');
                var mediaId = +urlParts[urlParts.length-1];
                $ajaxget({
                    url: '/api/media/' + mediaId,
                    errors: self.errors,
                    successCallback: function(data){
                        self.fill(data);
                        self.name(data.name().substring(0, data.name().lastIndexOf('.')));
                    }
                });
            };

            self.initializeEditor = function () {
                tinymce.init({
                    selector:'#editor',
                    language: 'ru',
                    height: 500,
                    plugins: [
                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                        'insertdatetime nonbreaking save table contextmenu directionality',
                        'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
                    ],
                    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
                });
            };

            self.getMedia();
            self.initializeEditor();
            self.fill = function (data) {
                self.media()
                    .id(data.id())
                    .type(data.type())
                    .content(data.content())
                    .path(data.path())
                    .name(data.name())
                    .hash(data.hash());
            };

            self.move = function () {
                window.location.href = '/admin/materials/';
            };

            self.update = function (media) {
                $ajaxpost({
                    url: '/api/media/update',
                    error: self.errors,
                    data: JSON.stringify({media: media}),
                    successCallback: function(){
                        commonHelper.modal.open(self.modals.move);
                    }
                });
            };

            self.check = function (hash, media) {
                $ajaxget({
                    url: '/api/media/hash/' + hash, // есть ли файл с таким же названием
                    errors: self.errors,
                    successCallback: function(data){
                        if (data().length == 0)
                            self.update(media);
                        else {
                            self.errors.show('Файл с таким названием уже существует!');
                        }
                    }
                });
            };

            self.approve = function () {
                self.confirm.show({
                    message: 'Вы уверены, что хотите сохранить изменения?',
                    approve: function(){
                        // новый хэш
                        var volumeId = 'l1_';
                        var oldPath = self.media().path();
                        var extension = self.media().name().substring(self.media().name().lastIndexOf('.'), self.media().name().length);
                        var newPath = oldPath.substring(oldPath.indexOf('/'), oldPath.lastIndexOf('/')) + self.name() + extension;
                        var hash = volumeId + btoa(unescape(encodeURIComponent(newPath)))
                                .replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '.')
                                .replace(/\.+$/, '');

                        var media = {
                            id: self.media().id(),
                            type: self.media().type(),
                            content: tinyMCE.activeEditor.getContent({format : 'raw'}),
                            path: self.media().path(),
                            name: self.name() + extension,
                            hash: hash
                        };

                        if (self.media().name().substring(0, self.media().name().lastIndexOf('.')) == self.name()) self.update(media);
                        else self.check(hash, media);
                    }
                });

            };

        };
    };

    ko.applyBindings(editorViewModel());
});
