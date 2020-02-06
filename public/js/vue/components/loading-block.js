/*
 Глобавлный Vue компонент для отображения оверлея загрузки
 */
Vue.component('loading-block', {
    props: {
        'loading': {
            type: Boolean,
            default: false
        },
        'opacity': {
            type: [String, Number],
            default: 70
        }
    },
    computed: {
        notDefaultOpacity: function () {
            return this.opacity !== 70;
        },
        opacityStyle: function () {
            const op = (this.opacity / 100).toFixed(2);
            return this.notDefaultOpacity ? {background: `rgba(255, 255, 255, ${op})`} : {};
        }
    },
    template: `<div class="overlay-wrapper" v-if="loading">
                    <div class="overlay" :style="opacityStyle"><i class="fa fa-refresh fa-spin"></i></div>
               </div>`
});