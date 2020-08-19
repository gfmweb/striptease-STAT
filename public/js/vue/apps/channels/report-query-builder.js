const reportQueryBuilder = new Vue({
	el: '#vue-report-query-builder',
	data: {
		urls: {
			cities: '/cities/list',
			projects: '/projects/list',
			subProjects: '/sub-projects/list',
			partners: '/partners/list',
			channels: '/channels/list',
			report: '/reports/channels/data',
		},
		loadingCount: 0,
		loaded: false,
		cities: {
			list: [],
			selectedId: null,
		},
		projects: {
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
				&& this.projects.selectedId
				&& this.subProjects.selectedId
				&& (this.partners.selectedId)
				&& this.channels.selectedId
			);
		},
		selectedCityIds: {
			set: function (id) {
				this.selectedCitiesId = id;
			},
			get: function () {
				return this.getSelectedIds(this.cities);
			}
		},
		selectedCityId: {
			set: function (id) {
				this.cities.selectedId = id;
			},
			get: function () {
				return this.cities.selectedId;
			}
		},
		selectedProjectIds: {
			set: function (id) {
				this.selectedProjectsId = id;
			},
			get: function () {
				return this.getSelectedIds(this.projects);
			}
		},
		selectedProjectId: {
			set: function (id) {
				this.projects.selectedId = id;
				if (id === '' || id === undefined) {
					this.subProjects.list = [];
					this.channels.list = [];
				} else {
					this.loadSubProjects();
				}
				this.selectedSubProjectId = '';
				this.selectedChannelId = '';
			},
			get: function () {
				return this.projects.selectedId;
			}
		},
		selectedSubProjectIds: {
			set: function (id) {
				this.selectedSubProjectsId = id;
			},
			get: function () {
				return this.getSelectedIds(this.subProjects);
			}
		},
		selectedSubProjectId: {
			set: function (id) {
				this.subProjects.selectedId = id;
				if (id === '' || id === undefined) {
					this.channels.list = [];
				} else {
					this.loadChannels();
				}
				this.selectedChannelId = '';
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

				if (id === '' || id === undefined) {
					this.projects.list = [];
					this.subProjects.list = [];
					this.channels.list = [];
				} else {
					this.loadProjects();
				}

				this.selectedProjectId = '';
				this.selectedSubProjectId = '';
				this.selectedChannelsId = '';
			},
			get: function () {
				return this.partners.selectedId;
			}
		},
		selectedChannelIds: function () {
			return this.getSelectedIds(this.channels);
		},
	},
	mounted: function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		this.loadPartners();
		this.loadCities();
		this.loadChannels();
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
		getUrlParams() {
			const params = {};
			location.search
				.replace('?', '')
				.split('&')
				.map(pair => pair.split('=')
					.map(i => decodeURIComponent(i)))
				.forEach(pair => {
					let name;
					if (pair[0].includes('[]')) {
						name = pair[0].replace('[]', '');
						if (!f[name]) f[name] = [];
						f[name].push(pair[1]);
					} else {
						name = pair[0];
						f[name] = pair[1];
					}
				});
			return params;

		},
		popState() {
			const filters = this.getUrlParams();
			// TODO: Подумать о запоминании url с параметрами
		},
		pushState(filters = []) {
			history.pushState(null, null, location.origin + location.pathname + '?' + $.param(filters));
		},
		dataTableInit() {
			const columnDefs = [
				{targets: [0, 1, 2, 3, 4], type: "string"},
			];

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
		loadPartners() {
			this.loading = true;
			const filters = {};

			$.ajax({
				url: this.urls.partners,
				type: "GET",
				data: filters,
			}).done(data => {
				this.loading = false;
				this.partners.list = data;
				if (!this.partners.list.length) {
					this.projects.list = [];
				}
				this.selectedPartnerIds = '';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD partner error', error);
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
				this.selectedCityIds = '';

			}).fail(error => {
				this.loading = false;
				console.error('LOAD Cities error', error);
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
		loadProjects() {
			this.loading = true;
			const filters = {};
			if (this.onlyMy) filters.my = true;

			if (this.selectedPartnerIds.length) {
				filters.partnerIds = this.selectedPartnerIds;
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
					this.channels.list = [];
				}
				this.selectedProjectIds = '';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD projects error', error);
			});
		},
		loadSubProjects() {
			this.loading = true;
			const filters = {};

			if (this.selectedPartnerIds.length) filters.partnerIds = this.selectedPartnerIds;
			if (this.selectedCityIds.length) filters.cityIds = this.selectedCityIds;
			if (this.selectedProjectId.length) filters.project = this.selectedProjectId;

			$.ajax({
				url: this.urls.subProjects,
				type: "GET",
				data: filters,
			}).done(data => {
				this.loading = false;
				this.subProjects.list = data;
				if (!this.subProjects.list.length) {
					this.channels.list = [];
				}
				this.selectedSubProjectIds = '';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD subProjects error', error);
			});
		},
		loadReport() {
			this.loading = true;

			const filters = {
				subProjectIds: this.selectedSubProjectIds,
				partnerIds: this.selectedPartnerIds,
				channelIds: this.selectedChannelIds,
				cityIds: this.selectedCityIds,
			};

			//this.pushState(filters); TODO: Подумать о запоминании url с параметрами

			let reportUrl = this.urls.report;
			if (this.onlyMy) reportUrl = this.urls.reportMy;

			$.ajax({
				url: reportUrl,
				type: "POST",
				data: filters
			}).done(data => {
				this.loading = false;
				this.loaded = true;
				const changed = this.report !== data;
				this.report = data;

				if (changed && $(data).find('tr.report-row').length) {
					// Применяем только если изменялись данные и они вообще есть
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