$(document).ready(function(){
    var materialsViewModel = function(){
        return new function(){
            var self = this;

            initializeViewModel.call(self, {
                page: menu.admin.materials,
                mode: true,
                pagination: 10,
                multiselect: true
            });

            self.modal = {
                elfinderModal: '#elfinder'
            };

            self.current = {
                disciplines: ko.observableArray([]),
                discipline: ko.validatedObservable({
                    id: ko.observable(0),
                    name: ko.observable('').extend({
                        required: true,
                        maxLength: 200
                    }),
                    abbreviation: ko.observable('').extend({
                        required: true,
                        maxLength: 50
                    }),
                    description: ko.observable('')
                }),
                themes: ko.observableArray([]),
                theme: ko.observable({
                    id: ko.observable(0),
                    name: ko.observable(''),
                    mode: ko.observable(state.none)
                })
            };

            self.filter = {
                discipline: ko.observable(''),
                profile : ko.observable(),
                clear: function(){
                    self.filter.discipline('').profile(null);
                }
            };

            self.actions = {
                discipline: {
                    show: function(data){
                        if (self.mode() === state.none ||
                            self.current.discipline().id() !== data.id()){
                            self.mode(state.info);
                            self.alter.fill(data);
                            self.get.disciplineProfiles();
                            self.get.themes();
                            return;
                        }
                        self.actions.discipline.cancel();
                    },
                    start: {
                        add: function(){
                            self.mode() === state.create
                                ? self.mode(state.none)
                                : self.mode(state.create);
                            self.alter.empty();
                            self.multiselect.tags([]);
                            commonHelper.buildValidationList(self.validation);
                        },
                        update: function(){
                            self.mode(state.update);
                            commonHelper.buildValidationList(self.validation);
                        },
                        remove: function(){
                            self.mode(state.remove);
                            commonHelper.modal.open(self.modals.removeDiscipline);
                        }
                    },
                    end: {
                        update: function(){
                            if (!self.current.discipline.isValid()){
                                self.validation[$('[accept-validation]').attr('id')].open();
                                return;
                            }
                            if (!self.multiselect.tags().length){
                                self.validation[$('[special]').attr('id')].open();
                                return;
                            }
                            self.post.discipline();
                        },
                        remove: function(){
                            commonHelper.modal.close(self.modals.removeDiscipline);
                            self.post.removal.discipline();
                        }
                    },
                    addMedia: function (data) {
                            $('#elfinder').elfinder({
                                customData: {
                                    _token: ''
                                },
                                url: 'http://' + window.location.host + '/elfinder/connector',
                                lang: 'ru',
                                resizable: false,
                                commandsOptions: {
                                    getfile: { multiple: false }
                                },
                                getFileCallback : function(file) {
                                    var media = {
                                            name: file.name,
                                            type: file.mime.split('/')[0],
                                            path: file.path
                                        };

                                    var json = JSON.stringify({media: media});


                                    $.ajax({
                                        type: "POST",
                                        url: '/api/media/create',
                                        data: json,
                                        dataType: "json",
                                        success: function (data) {
                                            console.log(data);
                                        },
                                        error: function (data) {
                                            console.log(data);
                                        }
                                    });

                                   /*    $.post('/api/media/create', mediaJSON,
                                        function(data, status){
                                            alert("Data: " + data + "\nStatus: " + status);
                                        }); */

                                    /*$ajaxpost({
                                        url: '/api/media/create',
                                        errors: function(XMLHttpRequest, textStatus, errorThrown) {
                                            console.log(XMLHttpRequest);
                                        },
                                        data: mediaJSON,
                                        successCallback: function(){
                                            console.log('success');
                                        }
                                    }); */
                                }

                            }).dialog({
                                modal: true,
                                width : 1300,
                                resizable: true,
                                position: { my: "center top-70%", at: "center", of: window }
                            });
                    }

                }

            };

            self.alter = {
                fill: function(data){
                    self.current.discipline()
                        .id(data.id())
                        .name(data.name())
                        .abbreviation(data.abbreviation())
                        .description(data.description());
                },
                empty: function(){
                    self.current.discipline()
                        .id(0)
                        .name('')
                        .abbreviation('')
                        .description('');
                }
            };


            self.get = {
                disciplines: function(profileId){
                    var filter = self.filter;
                    var profile = '';
                    var name = 'name=' + filter.discipline();
                    var page = 'page=' + self.pagination.currentPage();
                    var pageSize = 'pageSize=' + self.pagination.pageSize();
                    var url = '/api/disciplines/show?' + page + '&' + pageSize + '&' + name + '&' + profile;

                    $ajaxget({
                        url: url,
                        errors: self.errors,
                        successCallback: function(data){
                            self.current.disciplines(data.data());
                            self.pagination.itemsCount(data.count());
                        }
                    });

                },
                disciplineProfiles: function(){
                    var id = self.current.discipline().id();
                    if (!id) return;
                    self.multiselect.tags([]);
                    $ajaxget({
                        url: '/api/disciplines/' + id + '/profiles',
                        errors: self.errors,
                        successCallback: function(data){
                            $.each(self.multiselect.data(), function(i, profile){
                                $.each(data(), function(i, elem){
                                    if (elem.profile_id() == profile.id())
                                        self.multiselect.tags.push(profile);
                                });
                            });
                        }
                    });
                },
                profiles: function(){
                    $ajaxget({
                        url: '/api/profiles',
                        errors: self.errors,
                        successCallback: function(data){
                            self.multiselect.data(data());
                        }
                    });
                },
                themes: function(){
                    var url = '/api/disciplines/' + self.current.discipline().id() +'/themes';
                    $.get(url, function(response){
                        var result = ko.mapping.fromJSON(response);
                        if (result.Success()){
                            self.current.themes(result.Data());
                            return;
                        }
                        self.errors.show(result.Message());
                    });
                }
            };
            self.get.disciplines();
            self.get.profiles();


            self.events.theme = function(data, e){
                if (e.which === 13)
                    self.actions.theme.end.add();
            };

            // SUBSCRIPTIONS
            self.pagination.itemsCount.subscribe(function(value){
                if (value){
                    self.pagination.totalPages(Math.ceil(
                        value/self.pagination.pageSize()
                    ));
                }
            });
            self.pagination.currentPage.subscribe(function(){
                self.mode(state.none);
                self.get.disciplines();
            });
            self.filter.discipline.subscribe(function(){
                self.mode(state.none);
                self.pagination.currentPage(1);
                self.get.disciplines();
            });
            self.filter.profile.subscribe(function(){
                self.mode(state.none);
                self.pagination.currentPage(1);
                self.get.disciplines();
            });





            return returnStandart.call(self);
        };
    };

    ko.applyBindings(materialsViewModel());
});