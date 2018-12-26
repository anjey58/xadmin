// --------------- READY ---------------
$(function(module) {
// --------------- DIRECTIVE ---------------
    // ----- СЧЕТЧИК КОЛИЧЕСТВА СИМВОЛОВ -----
    Vue.directive('charcounter', {
        bind: function () {
            $(this.el).characterCounter().focus(function() {$(this).trigger('change');});
        }
    });

// --------------- MODULE ---------------
    module.exports={
        el: "#xadmin",

        // --------------- DATA ---------------
        data: function () {
            return window.$data;
        },

        // --------------- ФИЛЬТР ---------------
        filters: {
            // ----- ПРОПИСНЫЕ СИМВОЛЫ -----
            lowercase: {
                // -----модель - представление
                read: function(val, space) {
                    return val;
                },
                // -----представление - модель
                write: function(val) {
                    return (!!val && val != null) ? val.toLowerCase() : val;
                }
            },
        },

        // --------------- МЕТОДЫ ---------------
        methods: {
            // --------------- ЗАГРУЗКА URL-АДРЕСА ВХОДА В ПАНЕЛЬ АДМИНИСТРАТОРА ---------------
            loadurladmin: function () {
                var vm=this;

                // -----ajax-запрос
                $('#wait').css('display', 'block'); // анимация загрузки контента
                vm.$http.post('/admin/xadmin/bd/loadoptions')
                    .then(function (res) { // успешно
                        var options=res.data; // данные настроек
                        var urllogin=(!!options['URLLOGIN']) ? options['URLLOGIN'] : ''; // url-адрес входа в панель администратора, не undefined
                        vm.$set('urllogin', urllogin); // обновление данных
                        // -----информационное сообщение
                        iziToast.show({
                            title: this.$trans('Url-address loaded successfully'),
                            icon: 'ico-success',
                            layout: 1,
                            position: 'bottomLeft',
                            transitionOut: 'fadeOutLeft'
                        });
                    })
                    .catch(function (error) { // ошибка
                        iziToast.error({title: 'XAdmin', message: parsererror(error)});
                    })
                    .finally(function () { // по окончанию
                        $('#wait').fadeOut(300); // скрываем анимацию загрузки контента
                    });

            },

            // --------------- СОХРАНЕНИЕ URL-АДРЕСА ВХОДА В ПАНЕЛЬ АДМИНИСТРАТОРА ---------------
            saveurladmin: function () {
                var vm=this;
                // -----проверка обязательных полей
                if (!/^[a-z0-9]+$/.test(vm.urllogin)) {
                    $('#xadmin input[name=UNAME]').focus(); // элемент в фокус
                    iziToast.warning({title: 'XAdmin', message: this.$trans('Fill in the "Url-address", valid characters: a-z, 0-9')});
                    return false;
                }

                // -----ajax-запрос
                $('#wait').css('display', 'block'); // анимация загрузки контента
                vm.$http.post('/admin/xadmin/bd/saveoptions', {data: {'URLLOGIN': vm.urllogin}})
                    .then(function (res) { // успешно
                        iziToast.success({title: 'XAdmin', message: this.$trans('Url-address saved successfully')});
                    })
                    .catch(function (error) { // ошибка
                        iziToast.error({title: 'XAdmin', message: parsererror(error)});
                    })
                    .finally(function () { // по окончанию
                        $('#wait').fadeOut(300); // скрываем анимацию загрузки контента
                    });

            }
        }
    };
    Vue.ready(module.exports);
});