const digestData = new Vue({
	el: '#vue-digest-data',
	data: {
		urls: {
			get: '/digest-data/list',
			save: '/digest-data/save',
		},
		startDate: null,
		loading: false,
		loaded: false,
		filters: {
			dateFrom: null,
			dateTo: null,
		},
		current: {
			dateFrom: null,
			dateTo: null,
			city: null,
		},
		city: {
			selectedId: null,
		},
		digestData: [],
	},
	computed: {
		filterSettled() {
			return !!(this.filters.dateFrom && this.filters.dateTo && this.city.selectedId);
		},
		selectedCityId: {
			set: function (id) {
				if (id === '' || id === undefined) {
					this.city.selectedId = null;
				} else {
					this.city.selectedId = id;
				}
				this.loaded = false;
			},
			get: function () {
				return this.city.selectedId;
			}
		},
	},
	mounted: function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		moment.updateLocale("en", {
			week: {
				dow: 1, // First day of week is Monday
			}
		});

		this.startDate = moment().subtract(3, 'day').startOf('week');
		this.datePickerInit();
	},
	methods: {
		/*summaryByDigest(digest) {
			const cities = {
				msk: Number(digest.cities.msk && digest.cities.msk.activations || 0),
				spb: Number(digest.cities.spb && digest.cities.spb.activations || 0),
				kzn: Number(digest.cities.kzn && digest.cities.kzn.activations || 0),
				che: Number(digest.cities.che && digest.cities.che.activations || 0),
			};

			return cities.msk + cities.spb + cities.kzn + cities.che;
		},
		hasElements(obj) {
			return !!Object.values(obj).length;
		},*/
		haveChanges() {
			let changed = this.getChanges();
			return changed && changed.length;
		},
		getChanges() {
			// проходим по схлопнутому массиву и считываем у digest свойство changed
			return this.digestData && this.digestData.flat().filter(digest => digest.changed);
		},
		clearChangedList() {
			const changed = this.getChanges();
			changed && changed.forEach(row => row.changed = false);
		},
		datePickerInit() {
			const weekPicker = $("#date-range");
			const weekPickerDateFrom = weekPicker.find('[name="dateFrom"]');
			const weekPickerDateTo = weekPicker.find('[name="dateTo"]');
			weekPicker.datepicker({
				format: 'dd.mm.yyyy',
				language: 'ru',
				calendarWeeks: true,
				autoclose: true,
				orientation: 'bottom',
			});
			let that = this;

			function onDateChange(e) {
				that.loaded = false;

				let value = weekPicker.val();
				if (!value.trim().length) return;

				let firstDate = moment(value, "DD.MM.YYYY").day(1);
				let lastDate = moment(value, "DD.MM.YYYY").day(7);
				that.filters.dateFrom = firstDate.format("YYYY-MM-DD");
				that.filters.dateTo = lastDate.format("YYYY-MM-DD");

				weekPicker.val(`${firstDate.format("DD.MM.YYYY")} - ${lastDate.format("DD.MM.YYYY")}`);
			}

			//Get the value of Start and End of Week
			weekPicker.on('changeDate', onDateChange);
			weekPicker.on('hide', onDateChange);
		},
		updateData(data) {
			data.forEach(group => {
				group.forEach(digest => {
					digest.changed = false;
				})
			});
			this.digestData = data;
		},
		load() {
			// Сохраняем текущие настройки выборки
			this.current.dateFrom = this.filters.dateFrom;
			this.current.dateTo   = this.filters.dateTo;
			this.current.city     = this.city.selectedId;
			this.loading = true;

			$.ajax({
				url: this.urls.get,
				type: "GET",
				data: this.current,
			}).done(data => {
				this.loading = false;
				this.loaded = true;
				this.updateData(data);
			}).fail(error => {
				this.loading = false;
				console.error('LOAD error', error);
			});
		},
		save() {
			const changed = this.getChanges();
			const dataForSend = [];
			if (changed && changed.length) {
				changed.forEach(row => {
					dataForSend.push({
						digestId: row.id,
						values: row.data,
					});
				});
			}

			if (dataForSend.length) {
				console.log('SAVE DATA:', dataForSend);
				this.loading = true;
				$.ajax({
					url: this.urls.save,
					type: "POST",
					data: {
						dateFrom: this.current.dateFrom,
						dateTo: this.current.dateTo,
						city: this.current.city,
						changed: dataForSend,
					},
					dataType: 'json'
				}).done(data => {
					this.loading = false;
					this.clearChangedList();
				}).fail(error => {
					this.loading = false;
					console.error('SAVE error', error);
				});
			}
		},
	}
});
