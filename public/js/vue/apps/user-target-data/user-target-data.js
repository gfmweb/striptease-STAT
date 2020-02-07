const chat = new Vue({
		el: '#vue-user-target-data',
		data: {
			urls: {
				get: '/user-target-data/list',
				save: '/user-target-data/save'
			},
			loading: false,
			loaded: false,
			filters: {
				dateFrom: null,
				dateTo: null
			},
			current: {
				dateFrom: null,
				dateTo: null,
				subProjectId: null,
			},
			subProjects: {
				list: [],
				selected: null
			},
			userTargetData: [],
		},
		computed: {
			filterSettled() {
				return !!(this.filters.dateFrom && this.filters.dateTo && this.subProjects.selected);
			},
		},
		mounted: function () {
			this.subProjects.list = dataSubProjects;

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			this.datePickerInit();
		},
		methods: {
			haveChanges() {
				let changed = this.getChangedChannels();
				return changed && changed.length;
			},
			getChangedChannels() {
				return this.userTargetData && this.userTargetData.filter(row => row.changed);
			},
			clearChangedList() {
				const changed = this.getChangedChannels();
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
				data.forEach(row => row.changed = false);
				this.userTargetData = data;
				console.log(this.userTargetData);
			},

			load() {
				// Сохраняем текущие настройки выборки
				this.current.dateFrom = this.filters.dateFrom;
				this.current.dateTo = this.filters.dateTo;
				this.current.subProjectId = this.subProjects.selected;
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
				const changed = this.getChangedChannels();
				const dataForSend = [];
				if (changed && changed.length) {
					changed.forEach(row => {
						dataForSend.push({
							userTargetId: row.userTargetId,
							values: row.values,
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
	})
;
