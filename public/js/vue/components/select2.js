// Глобавлный Vue компонент для передачи данных из select2
Vue.component('select2', {
	props: ['options', 'value'],
	template: '#select2-template',
	mounted: function () {
		var vm = this;
		$(this.$el)
		// init select2
		.select2({
			placeholder: 'Выберите значение',
			data: this.options,
		})
		.val(this.value)
		.trigger('change')
		// emit event on change.
		.on('change', function () {
			// vm.$emit('input', this.value)
			vm.$emit('input', $(this).val())

		})
	},
	watch: {
		value: function (value) {
			// update value
			// условие добавляется для для мультивыбора
			// https://stackoverflow.com/questions/43941840/vue-js-select2-multiple-select
			if (Array.from(value).sort().join(",") !== Array.from($(this.$el).val()).sort().join(",")) {
				$(this.$el).val(value).trigger('change');
			}
		},
		options: function (options) {
			// update options
			$(this.$el).empty().select2({
				data: options,
				placeholder: 'Выберите значение',
			});
		}
	},
	destroyed: function () {
		$(this.$el).off().select2('destroy')
	}
 })