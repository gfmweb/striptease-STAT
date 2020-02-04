/*
 Глобавлный Vue компонент для отображения оверлея загрузки
 */
Vue.component('loading-block', {
	props: ['loading'],
	template: '<div class="overlay-wrapper" v-if="loading">\n' +
		'        <div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>\n' +
		'    </div>'
});