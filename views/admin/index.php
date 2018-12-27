<?php $view->style('window.notification', 'xadmin:css/plugins/window.notification.css') ?>

<?php $view->style('xadmin_index', 'xadmin:css/admin/index.css', ['theme']) ?>
<?php $view->script('xadmin_index', 'xadmin:js/admin/index.js', ['vue', 'jquery']) ?>

<?php $view->script('window.notification', 'xadmin:js/plugins/window.notification.js') ?>

<?php $view->script('text.charactercounter', 'xadmin:js/plugins/text.charactercounter.js') ?>
<?php $view->style('text.charactercounter', 'xadmin:css/plugins/text.charactercounter.css') ?>

<div id="xadmin">
    <!-- анимация ожидания загрузки -->
    <div id="wait"></div>

    <!-- панель управления -->
    <div class="uk-flex uk-flex-space-between uk-flex-wrap">
        <!-- заголовок -->
        <h3 class="uk-margin-small-top uk-margin-small-bottom">{{ 'Settings XAdmin' | trans }}</h3>

        <!-- панель кнопок -->
        <div>
            <!-- кнопка "ОБНОВИТЬ" -->
            <button class="uk-button" @click.prevent="loadurladmin()">{{ 'Refresh' | trans }}</button>
        </div>
    </div>

    <!-- разделительная линия -->
    <hr class="uk-margin-small-top" style="border-top: 1px solid #3A94E0;" />

    <!-- контент -->
    <div class="uk-panel uk-panel-box" style="border: 1px solid #9E9E9E;">
        <!-- заголовок -->
        <div class="uk-badge uk-badge-notification uk-position-top-left uk-margin-small-top uk-margin-small-left">{{ 'Managing the url-address login of admin panel' | trans }}</div>

        <!-- панель кнопок -->
        <div class="uk-position-top-right uk-margin-small-right uk-margin-small-top">
            <!-- кнопка "СОХРАНИТЬ" -->
            <button class="uk-button-simple hvr-round-corners" @click.prevent="saveurladmin($index)"><i class="uk-icon-save uk-margin-small-right"></i>{{ 'Save' | trans }}</button>
        </div>

        <!-- разделительная линия -->
        <hr class="uk-margin--top" style="color: #9e9e9e; border-color: #9e9e9e; border-style: dashed;" />

        <!-- данные -->
        <div class="uk-panel">
            <dl class="uk-margin-small-top uk-description-list-horizontal">
                <!-- поле "НАЗВАНИЕ ПРОЕКТА" -->
                <dt>{{ 'Url-address' | trans }}:</dt>
                <dd>
                    <div class="uk-width-1-1 uk-form-icon">
                        <!-- иконка пустого/непустого значения -->
                        <i class="uk-icon-check" style="color: #4ec900;" v-if="urllogin"></i><i class="uk-icon-exclamation"  style="color: #e53935;" v-else></i>
                        <!-- значение -->
                        <input type="text" name="UNAME" class="inputcharcounter" placeholder="{{ 'Enter the url-address of the login to the admin panel' | trans }}" maxlength="50" v-model="urllogin | lowercase" v-charcounter>
                    </div>
                    <!-- пример ur-адреса url-адреса входа в панель администратора -->
                    <p class="uk-form-help-block"><i class="uk-icon-exclamation-triangle uk-margin-small-right"></i>{{ 'Resulting url-address' | trans }}: "{{ domain }}admin/{{ urllogin }}"</p>
                </dd>
            </dl>
        </div>
    </div>

    <!-- массив данных -->
    <!--<pre>{{ $data | json }}</pre>-->
</div>
