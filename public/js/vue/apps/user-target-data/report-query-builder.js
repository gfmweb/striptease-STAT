const chat = new Vue({
		el: '#vue-report-query-builder',
		data: {
			urls: {
				cities: '/cities/list',
				subProjects: '/sub-projects/list',
				partners: '/partners/list',
				channels: '/channels/list',
				report: '/reports/main',
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
				selectedId: null,
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
					&& this.dateFrom
					&& this.dateTo
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

		},
		mounted: function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			this.loadCities();
			this.loadChannels();
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
			dateSqlFormat(dateString) {
				return dateString.replace(/(\d{2}).(\d{2}).(\d{4})/, '$3-$2-$1');
			},
			datePickerInit() {
				const picker = $("#date-range");
				const that = this;
				picker.datepicker({
					format: 'dd.mm.yyyy',
					language: 'ru',
					calendarWeeks: true,
					autoclose: true,
					orientation: 'bottom',
				});

				function onDateChange(e) {
					that.dateFrom = picker.find('input[name="dateFrom"]').val();
					that.dateTo = picker.find('input[name="dateTo"]').val();
				}

				picker.on('changeDate', onDateChange);
				picker.on('hide', onDateChange);
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
				const filters = {};

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
			loadReport() {
				this.loading = true;

				const filters = {
					subProjectIds: this.selectedSubProjectIds,
					partnerIds: this.selectedPartnerIds,
					channelIds: this.selectedChannelIds,
					dateFrom: this.dateSqlFormat(this.dateFrom),
					dateTo: this.dateSqlFormat(this.dateTo),
				};

				$.ajax({
					url: this.urls.report,
					type: "POST",
					data: filters
				}).done(data => {
					this.loading = false;
					this.loaded = true;
					this.report = data;
				}).fail(error => {
					this.loading = false;
					console.error('LOAD report error', error);
				});
			}

		}
	})
;
