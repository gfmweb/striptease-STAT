const reportQueryBuilder = new Vue({
		el: '#vue-report-query-builder',
		data: {
			urls: {
				report: '/reports/digestnew/data',
			},
			loadingCount: 0,
			loaded: false,
			dateFrom: null,
			dateTo: null,
            dateFromT: null,
            dateToT: null,
			city: {
				selectedId: 6,
			},
			report: null,
            reportT: null,
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
            tbl(table){
              var tbl = document.getElementById(table)
              var tblstyle = tbl.style

            },
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
                const pickerDateFromT = $('input[name="dateFromT"]');
                const pickerDateToT = $('input[name="dateToT"]');

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
///////////////////////////////////
                pickerDateFromT.datepicker({
                    format: 'dd.mm.yyyy',
                    language: 'ru',
                    calendarWeeks: true,
                    autoclose: true,
                    orientation: 'bottom',
                });
                pickerDateFromT.on('changeDate', () => {
                    this.dateFromT = pickerDateFromT.val()
                });
                pickerDateFromT.on('hide', () => {
                    this.dateFromT = pickerDateFromT.val()
                });

                pickerDateToT.datepicker({
                    format: 'dd.mm.yyyy',
                    language: 'ru',
                    calendarWeeks: true,
                    autoclose: true,
                    orientation: 'bottom',
                });
                pickerDateToT.on('changeDate', () => {
                    this.dateToT = pickerDateToT.val()
                });
                pickerDateToT.on('hide', () => {
                    this.dateToT = pickerDateToT.val()
                });
			},
			loadReport() {

				this.loading = true;
                if(this.dateToT!==null && this.dateFromT!==null){
                  /// Несколько значений принимаем АПППГ
                    const filters = {

                        dateFrom: this.dateSqlFormat(this.dateFrom),
                        dateTo: this.dateSqlFormat(this.dateTo, moment().format('Y-MM-DD')),
                        dateFromT: this.dateSqlFormat(this.dateFromT),
                        dateToT: this.dateSqlFormat(this.dateToT, moment().format('Y-MM-DD')),
                    };
                    // Первый запрос
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
                    //второй запрос
                    const filtersT = {
                        dateFrom: this.dateSqlFormat(this.dateFromT),
                        dateTo: this.dateSqlFormat(this.dateToT, moment().format('Y-MM-DD')),
                    };

                    $.ajax({
                        url: this.urls.report,
                        type: "get",
                        data: filtersT
                    }).done(data => {

                        this.loading = false;
                        this.loaded = true;
                        const changed = this.report != data;
                        this.reportT = data;


                    }).fail(error => {
                        this.loading = false;
                        console.error('LOAD report error', error);
                    });

                }
                else{
                    const filters = {

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

		}
	})
;
