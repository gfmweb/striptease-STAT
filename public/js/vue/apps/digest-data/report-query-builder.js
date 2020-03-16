const reportQueryBuilder = new Vue({
		el: '#vue-report-query-builder',
		data: {
			urls: {
				report: '/reports/digest/data',
			},
			loadingCount: 0,
			loaded: false,
			dateFrom: null,
			dateTo: null,
			city: {
				selectedId: '',
			},
			report: null,
		},
		computed: {
			loading: {
				set: function (set) {
					this.loadingCount += set ? 1 : -1;
					if (this.loadingCount < 0) this.loadingCount = 0;
				},
				get: function () {
					return !!this.loadingCount;
				}
			},
			selectedCityId: {
				set: function (id) {
					this.city.selectedId = id;
				},
				get: function () {
					return this.city.selectedId;
				}
			},
			filterSettled() {
				return !!(this.dateFrom || this.dateTo);
			},
		},
		mounted: function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			this.datePickerInit();
		},
		methods: {
			hasElements(obj) {
				return !!Object.values(obj).length;
			},

			dateSqlFormat(dateString, def = '0000-00-00') {
				if (!dateString || !dateString.match(/(\d{2}).(\d{2}).(\d{4})/)) return def;
				return dateString.replace(/(\d{2}).(\d{2}).(\d{4})/, '$3-$2-$1');
			},
			datePickerInit() {
				const pickerDateFrom = $('input[name="dateFrom"]');
				const pickerDateTo = $('input[name="dateTo"]');

				pickerDateFrom.datepicker({
					format: 'dd.mm.yyyy',
					language: 'ru',
					calendarWeeks: true,
					autoclose: true,
					orientation: 'bottom',
				});
				pickerDateFrom.on('changeDate', () => {
					this.dateFrom = pickerDateFrom.val()
				});
				pickerDateFrom.on('hide', () => {
					this.dateFrom = pickerDateFrom.val()
				});

				pickerDateTo.datepicker({
					format: 'dd.mm.yyyy',
					language: 'ru',
					calendarWeeks: true,
					autoclose: true,
					orientation: 'bottom',
				});
				pickerDateTo.on('changeDate', () => {
					this.dateTo = pickerDateTo.val()
				});
				pickerDateTo.on('hide', () => {
					this.dateTo = pickerDateTo.val()
				});
			},
			loadReport() {
				this.loading = true;

				const filters = {
					city: this.city.selectedId,
					dateFrom: this.dateSqlFormat(this.dateFrom),
					dateTo: this.dateSqlFormat(this.dateTo, moment().format('Y-MM-DD')),
				};

				$.ajax({
					url: this.urls.report,
					type: "get",
					data: filters
				}).done(data => {
					this.loading = false;
					this.loaded = true;
					const changed = this.report != data;
					this.report = data;
				}).fail(error => {
					this.loading = false;
					console.error('LOAD report error', error);
				});
			}

		}
	})
;
