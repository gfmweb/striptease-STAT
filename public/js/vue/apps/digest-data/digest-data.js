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
			dateTo: null
		},
		current: {
			dateFrom: null,
			dateTo: null,
		},
		digestData: [],
	},
	computed: {
		canEdit: function () {
			return this.startDate.diff(this.current.dateFrom) <= 0;
		},
		filterSettled() {
			return !!(this.filters.dateFrom && this.filters.dateTo);
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
		summaryByDigest(digest) {
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
		},
		haveChanges() {
			let changed = this.getChanges();
			return changed && changed.length;
		},
		getChanges() {
			return this.digestData && this.digestData.filter(row => row.changed);
		},
		prepareChanges(list) {
			let prepared = [];
			list.forEach(password => {
				for (let city in password.cities) {
					if (password.cities.hasOwnProperty(city)) {
						prepared.push({
							passwordId: password.id,
							cityId: password.cities[city].cityId,
							passwordCityId: password.cities[city].passwordCityId,
							activations: password.cities[city].activations,
						});
					}
				}
			});
			return prepared;
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
			console.log(data);
			data.forEach(row => {
				row.changed = false;
			});
			this.digestData = data;
		},
		load() {
			// Сохраняем текущие настройки выборки
			this.current.dateFrom = this.filters.dateFrom;
			this.current.dateTo = this.filters.dateTo;
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
			const dataForSend = this.prepareChanges(this.getChanges());

			if (dataForSend.length) {
				console.log('SAVE DATA:', dataForSend);
				this.loading = true;
				$.ajax({
					url: this.urls.save,
					type: "POST",
					data: {
						dateFrom: this.current.dateFrom,
						dateTo: this.current.dateTo,
						changed: dataForSend
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
