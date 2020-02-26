const reportQueryBuilder = new Vue({
		el: '#vue-report-query-builder',
		data: {
			urls: {
				tags: '/tags/list',
				report: '/reports/passwords/data',
			},
			loadingCount: 0,
			loaded: false,
			dateFrom: null,
			dateTo: null,
			tags: {
				list: [],
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
			filterSettled() {
				return !!(this.dateFrom || this.dateTo);
			},
			selectedTagsIds: function () {
				return this.getSelectedIds(this.tags);
			},

		},
		mounted: function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			this.loadTags();
			this.datePickerInit();
		},
		methods: {
			hasElements(obj) {
				return !!Object.values(obj).length;
			},
			getSelectedIds(list) {
				let result = [];

				if (list.selectedId === '') return result;

				if (list.selectedId === 'all') {
					for (let id in list.list) result.push(id);
				} else {
					result.push(list.selectedId);
				}

				return result;
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
			dataTableInit() {
				$('.report-table').DataTable({
					// order: [[2, "asc"]],
					fixedHeader: {
						header: true,
						headerOffset: 45,
					},
					orderCellsTop: true,
					columnDefs: [
						{targets: [0], type: "string"},
						{targets: [1], type: 'reportWeek'},
						{targets: [2,3,4,5], type: 'reportNumeric'}
					],
					language: {
						"processing": "Подождите...",
						"search": "Поиск:",
						"lengthMenu": "Показать _MENU_ записей",
						"info": "Записи с _START_ до _END_ из _TOTAL_ записей",
						"infoEmpty": "Записи с 0 до 0 из 0 записей",
						"infoFiltered": "(отфильтровано из _MAX_ записей)",
						"infoPostFix": "",
						"loadingRecords": "Загрузка записей...",
						"zeroRecords": "Записи отсутствуют.",
						"emptyTable": "В таблице отсутствуют данные",
						"paginate": {
							"first": "Первая",
							"previous": "Предыдущая",
							"next": "Следующая",
							"last": "Последняя"
						},
						"aria": {
							"sortAscending": ": активировать для сортировки столбца по возрастанию",
							"sortDescending": ": активировать для сортировки столбца по убыванию"
						}
					}
				});
			},
			loadTags() {
				this.loading = true;

				$.ajax({
					url: this.urls.tags,
					type: "GET",
				}).done(data => {
					this.loading = false;
					this.tags.list = data;
				}).fail(error => {
					this.loading = false;
					console.error('LOAD tags error', error);
				});
			},
			loadReport() {
				this.loading = true;

				const filters = {
					tagIds: this.selectedTagsIds,
					dateFrom: this.dateSqlFormat(this.dateFrom),
					dateTo: this.dateSqlFormat(this.dateTo, moment().format('Y-MM-DD')),
				};

				$.ajax({
					url: this.urls.report,
					type: "POST",
					data: filters
				}).done(data => {
					this.loading = false;
					this.loaded = true;
					const changed = this.report != data;
					this.report = data;
					if (changed) {
						// Применяем только если изменялись данные
						// Когда DOM не меняется, то все живое остается и так
						setTimeout(() => {
							this.dataTableInit();
						}, 100);
					}
				}).fail(error => {
					this.loading = false;
					console.error('LOAD report error', error);
				});
			}

		}
	})
;
