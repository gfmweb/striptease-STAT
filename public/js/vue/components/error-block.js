/*
 Глобавлный Vue компонент для отображения ошибок возвращаемых валидатором Laravel
 */
Vue.component('error-block', {
    props: ['value'],
    computed: {
        show() {
            return this.value != null;
        },
        errors() {
            return this.value;
        }
    },
    methods: {
        clear: function () {
            this.$emit("input", null) ;
        }
    },
    template: '<div class="alert alert-danger alert-dismissible" v-if="show">\n' +
        '            <button type="button" class="close" data-dismiss="alert"\n' +
        '                    @click="clear">×\n' +
        '            </button>\n' +
        '            <h4><i class="icon fa fa-ban"></i>Ошибка</h4>\n' +
        '            <ul v-for="error in errors">\n' +
        '                <li>{{ error[0] }}</li>\n' +
        '            </ul>\n' +
        '        </div>'
});