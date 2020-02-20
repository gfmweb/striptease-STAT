const chat = new Vue({
		el: '#vue-report-query-builder',
		data: {
			urls: {
				cities: '/cities/list',
				subProjects: '/sub-projects/list',
				partners: '/partners/list',
				channels: '/channels/list',
				tags: '/tags/list',
				report: '/reports/main/data',
			},
			loadingCount: 0,
			loaded: false,
			dateFrom: null,
			dateTo: null,
			cities: {
				list: [],
				selectedId: null,
			},
			subProjects: {
				list: [],
				selectedId: null,
			},
			partners: {
				list: [],
				selectedId: null,
			},
			channels: {
				list: [],
				selectedId: 'all',
			},
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
				return !!(
					this.cities.selectedId
					&& this.subProjects.selectedId
					&& this.partners.selectedId
					&& this.channels.selectedId
					&& (this.dateFrom || this.dateTo)
				);
			},
			selectedCityIds: {
				set: function (id) {
					this.selectedCitiesId = id;
					if (id === '') this.selectedSubProjectIds = '';
				},
				get: function () {
					return this.getSelectedIds(this.cities);
				}
			},
			selectedCityId: {
				set: function (id) {
					this.cities.selectedId = id;
					if (id === '' || id === undefined) {
						this.subProjects.list = [];
					} else {
						this.loadSubProjects();
					}

				},
				get: function () {
					return this.cities.selectedId;
				}
			},
			selectedSubProjectIds: {
				set: function (id) {
					this.selectedSubProjectsId = id;
					if (id === '') this.selectedPartnerIds = '';
				},
				get: function () {
					return this.getSelectedIds(this.subProjects);
				}
			},
			selectedSubProjectId: {
				set: function (id) {
					this.subProjects.selectedId = id;
					if (id === '' || id === undefined) {
						this.partners.list = [];
					} else {
						this.loadPartners();
					}

				},
				get: function () {
					return this.subProjects.selectedId;
				}
			},
			selectedPartnerIds: {
				set: function (id) {
					this.selectedPartnerId = id;
				},
				get: function () {
					return this.getSelectedIds(this.partners);
				}
			},
			selectedPartnerId: {
				set: function (id) {
					this.partners.selectedId = id;
				},
				get: function () {
					return this.partners.selectedId;
				}
			},
			selectedChannelIds: function () {
				return this.getSelectedIds(this.channels);
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

			this.loadCities();
			this.loadChannels();
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
						{targets: [0, 1, 2, 3], type: "string"},
						{targets: [4], type: 'reportWeek'},
						{targets: [5, 6, 7, 8, 9, 10], type: 'reportNumeric'}
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
			loadCities() {
				this.loading = true;

				$.ajax({
					url: this.urls.cities,
					type: "GET",
					data: {},
				}).done(data => {
					this.loading = false;
					this.cities.list = data;
					if (!this.cities.list.length) {
						this.subProjects.list = [];
					}
					this.selectedCityIds = '';

				}).fail(error => {
					this.loading = false;
					console.error('LOAD Cities error', error);
				});
			},
			loadSubProjects() {
				this.loading = true;
				const filters = {
					field: 'fullName'
				};

				if (this.selectedCityIds.length) {
					filters.cityIds = this.selectedCityIds;
				}

				$.ajax({
					url: this.urls.subProjects,
					type: "GET",
					data: filters,
				}).done(data => {
					this.loading = false;
					this.subProjects.list = data;
					if (!this.subProjects.list.length) {
						this.partners.list = [];
					}
					this.selectedSubProjectIds = '';
				}).fail(error => {
					this.loading = false;
					console.error('LOAD subProjects error', error);
				});
			},
			loadPartners() {
				this.loading = true;
				const filters = {};

				if (this.selectedSubProjectIds.length) {
					filters.subProjectIds = this.selectedSubProjectIds;
				}
				if (this.selectedCityIds.length) {
					filters.cityIds = this.selectedCityIds;
				}

				$.ajax({
					url: this.urls.partners,
					type: "GET",
					data: filters,
				}).done(data => {
					this.loading = false;
					this.partners.list = data;
					if (!this.partners.list.length) {
						// this.partners.list = [];
					}
					this.selectedPartnerIds = '';
				}).fail(error => {
					this.loading = false;
					console.error('LOAD partner error', error);
				});
			},
			loadChannels() {
				this.loading = true;

				$.ajax({
					url: this.urls.channels,
					type: "GET",
				}).done(data => {
					this.loading = false;
					this.channels.list = data;
				}).fail(error => {
					this.loading = false;
					console.error('LOAD channels error', error);
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
					subProjectIds: this.selectedSubProjectIds,
					partnerIds: this.selectedPartnerIds,
					channelIds: this.selectedChannelIds,
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
