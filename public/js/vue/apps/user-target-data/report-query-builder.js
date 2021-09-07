const reportQueryBuilder = new Vue({
	el: '#vue-report-query-builder',
	data: {
		urls: {
			cities: '/cities/list',
			projects: '/projects/list',
			subProjects: '/sub-projects/list',
			partners: '/partners/list',
            audienceTypes: '/audience-types/list',
            goals: '/goals/list',
            channels: '/channels/list',
			report: '/reports/main/data',
			reportMy: '/reports/my/data',
		},
		loadingCount: 0,
		loaded: false,
		dateFrom: null,
		dateTo: null,
        onlyMy: false,
		cities: {
			list: [],
			selectedIds: null,
		},
		projects: {
			list: [],
			selectedIds: null,
		},
		subProjects: {
			list: [],
			selectedIds: null,
		},
		partners: {
			list: [],
			selectedId: null,
		},
        audienceTypes: {
            list: [],
            selectedIds: null,
        },
        goals: {
            list: [],
            selectedIds: null,
        },
		channels: {
			list: [],
			selectedId: null,
            selectedIds: [],
		},
		report: null,
		notZeroCost: true,
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
				this.cities.selectedIds
				&& this.projects.selectedIds
				&& this.subProjects.selectedIds
				&& (this.partners.selectedId || this.onlyMy)
				&& this.goals.selectedIds
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
				this.cities.selectedIds = id;
				if (id === '' || id === undefined) {
					this.projects.list = [];
				} else {
					this.loadProjects();
					this.selectedProjectId = ''
				}
			},
			get: function () {
				return this.cities.selectedIds;
			}
		},
		selectedProjectIds: {
			set: function (id) {
				this.selectedProjectsId = id;
				if (id === '') {
					this.selectedSubProjectsId = '';
					this.selectedPartnerIds    = '';
				}
			},
			get: function () {
				return this.getSelectedIds(this.projects);
			}
		},
		selectedProjectId: {
			set: function (id) {
				this.projects.selectedIds = id;
				if (id === '' || id === undefined) {
					this.subProjects.list = [];
					this.partners.list = [];
				} else {
					this.loadSubProjects();
				}
				this.selectedSubProjectId = '';
			},
			get: function () {
				return this.projects.selectedIds;
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
				this.subProjects.selectedIds = id;
				if (id === '' || id === undefined) {
					this.partners.list = [];
				} else {
					this.loadPartners();
				}
			},
			get: function () {
				return this.subProjects.selectedIds;
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
		selectedAudienceTypeIds: {
			set: function (id) {
				this.selectedAudienceTypeId = id;
                if (id === '') {
                    this.selectedGoalIds = '';
                    this.selectedChannelIds = '';
                }
			},
			get: function () {
				return this.getSelectedIds(this.audienceTypes);
			}
		},
        selectedAudienceTypeId: {
			set: function (id) {
				this.audienceTypes.selectedIds = id;

                if (id === '' || id === undefined) {
                    this.goals.list = [];
                    this.channels.list = [];
                } else {
                    this.selectedGoalId = ''
                    this.selectedChannelIds = []
                    this.loadGoals().then(()=>{
                        this.loadChannels();
                    });

                }
			},
			get: function () {
				return this.audienceTypes.selectedIds;
			}
		},
		selectedGoalIds: {
			set: function (id) {
				this.selectedGoalId = id;
                if (id === '') this.selectedChannelIds = '';
			},
			get: function () {
				return this.getSelectedIds(this.goals);
			}
		},
        selectedGoalId: {
			set: function (id) {
				this.goals.selectedIds = id;
                if (id === '' || id === undefined) {
                    this.channels.list = [];
                } else {
                    this.selectedChannelId = ''
                    this.loadChannels();
                }
			},
			get: function () {
				return this.goals.selectedIds;
			}
		},
        selectedChannelIds: {
			set: function (id) {
				this.selectedChannelId = id;
			},
			get: function () {
				return this.getSelectedIds(this.channels);
			}
		},
        selectedChannelId: {
			set: function (id) {
				this.channels.selectedId = id;
			},
			get: function () {
				return this.channels.selectedId;
			}
		},
	},
	mounted: function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		this.loadCities();
		this.loadAudienceTypes()

		this.datePickerInit();

		this.dateFrom = moment().subtract(1, 'months').format('DD.MM.YYYY');
		this.dateTo   = moment().format('DD.MM.YYYY');

		if (typeof onlyMyReport !== 'undefined') this.onlyMy = true;
	},
	methods: {
		hasElements(obj) {
			return !!Object.values(obj).length;
		},
		getSelectedIds(list) {
			let result = [];

			if (list.selectedId !== undefined) {
				if (list.selectedId === '') return result;
				if (list.selectedId === 'all') {
					//for (let id in list.list) result.push(id);
					return 'all';
				} else
					result.push(list.selectedId);
			}

			if (list.selectedIds !== undefined) {
				result = !list.selectedIds.length ? 'all' : list.selectedIds
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
			var columnDefs = [
				{targets: [0, 1, 2, 3], type: "string"},
				{targets: [4], type: 'reportWeek'},
				{targets: [5, 6, 7, 8, 9, 10, 11, 12, 13], type: 'reportNumeric'}
			];
			if (this.onlyMy) {
				columnDefs = [
					{targets: [0, 1, 2], type: "string"},
					{targets: [3], type: 'reportWeek'},
					{targets: [4, 5, 6, 7, 8, 9, 10, 11, 12], type: 'reportNumeric'}
				];
			}

			$('.report-table').DataTable({
				// order: [[2, "asc"]],
				fixedHeader: {
					header: true,
					headerOffset: 45,
				},
				orderCellsTop: true,
				columnDefs: columnDefs,
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
			const filters = {};

			$.ajax({
				url: this.urls.cities,
				type: "GET",
				data: filters,
			}).done(data => {
				this.loading = false;
				this.cities.list = data;
				if (!this.cities.list.length) {
					this.subProjects.list = [];
				}
				this.selectedCityId = 'all';

			}).fail(error => {
				this.loading = false;
				console.error('LOAD Cities error', error);
			});
		},
		loadProjects() {
			this.loading = true;
			const filters = {};
			if (this.onlyMy) filters.my = true;

			if (this.selectedCityIds.length) {
				filters.cityIds = this.selectedCityIds;
			}

			$.ajax({
				url: this.urls.projects,
				type: "GET",
				data: filters,
			}).done(data => {
				this.loading = false;
				this.projects.list = data;
				if (!this.projects.list.length) {
					this.subProjects.list = [];
					this.partners.list = [];
				}
				this.selectedProjectId = 'all';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD projects error', error);
			});
		},
		loadSubProjects() {
			this.loading = true;
			const filters = {};
			if (this.onlyMy)                    filters.my = true;
			if (this.selectedCityIds.length)    filters.cityIds = this.selectedCityIds;
			if (this.selectedProjectId.length)  filters.project = this.selectedProjectId;

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
				this.selectedSubProjectId = 'all';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD subProjects error', error);
			});
		},
		loadPartners() {
			this.loading = true;
			const filters = {};

			if (this.selectedCityIds.length)       filters.cityIds = this.selectedCityIds;
			if (this.selectedSubProjectIds.length) filters.subProjectIds = this.selectedSubProjectIds;

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
				this.selectedPartnerId = 'all';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD partner error', error);
			});
		},
        loadAudienceTypes() {
            this.loading = true;
            const filters = {};

            return $.ajax({
                url: this.urls.audienceTypes,
                type: "GET",
            }).done(data => {
                this.loading = false;
                this.audienceTypes.list = data;

                if (!Object.values(this.audienceTypes.list).length) {
                    this.goals.list = [];
                    this.channels.list = [];
                }
                this.selectedAudienceTypeId = 'all';

            }).fail(error => {
                this.loading = false;
                console.error('LOAD audienceTypes error', error);
            });
        },
        loadGoals() {
            this.loading = true;
            const filters = {};

            if (this.selectedAudienceTypeIds.length)       filters.audienceTypeIds = this.selectedAudienceTypeIds;

            return $.ajax({
                url: this.urls.goals,
                type: "GET",
                data: filters,
            }).done(data => {
                this.loading = false;
                this.goals.list = data;

                if (!Object.values(this.goals.list).length) {
                    this.channels.list = [];
                }
                this.selectedGoalId = 'all';

            }).fail(error => {
                this.loading = false;
                console.error('LOAD goals error', error);
            });
        },
		loadChannels() {
			this.loading = true;
            const filters = {};

            if (this.selectedAudienceTypeIds.length)filters.audienceTypeIds = this.selectedAudienceTypeIds;
            if (this.selectedGoalIds.length)        filters.goalsIds = this.selectedGoalIds;

			$.ajax({
				url: this.urls.channels,
				type: "GET",
                data: filters,
			}).done(data => {
				this.loading = false;
				this.channels.list = data;
                this.selectedChannelId = '';
                this.channels.selectedIds = [];
			}).fail(error => {
				this.loading = false;
				console.error('LOAD channels error', error);
			});
		},
		loadReport() {
			this.loading = true;

			const filters = {
				cityIds:         this.selectedCityIds,
				projectIds:      this.selectedProjectIds,
				subProjectIds:   this.selectedSubProjectIds,
				partnerIds:      this.selectedPartnerIds,
                goalsIds:        this.selectedGoalIds,
                audienceTypeIds: this.selectedAudienceTypeIds,
                // channelIds:   this.selectedChannelIds,
                channelIds:      this.channels.selectedIds,
                dateFrom:        this.dateSqlFormat(this.dateFrom),
				dateTo:          this.dateSqlFormat(this.dateTo, moment().format('Y-MM-DD')),
				notZeroCost:     this.notZeroCost,
			};

			var reportUrl = this.urls.report
			if (this.onlyMy) reportUrl = this.urls.reportMy;

			$.ajax({
				url: reportUrl,
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
});
