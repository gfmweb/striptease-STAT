const userTargetData = new Vue({
	el: '#vue-user-target-data',
	data: {
		urls: {
			get: '/user-target-data/list',
			save: '/user-target-data/save',
			cities: '/cities/list',
			projects: '/projects/list',
			subProjects: '/sub-projects/list',
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
			subProjectId: null,
		},
		cities: {
			list: [],
			selectedId: null,
		},
		projects: {
			list: [],
			selected: null,
		},
		subProjects: {
			list: [],
			selected: null,
		},
		userTargetData: [],
	},
	computed: {
		canEdit: function () {
			return this.startDate.diff(this.current.dateFrom) <= 0;
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
					this.projects.list = [];
				} else {
					this.loadProjects();
				}
				this.loaded = false;
				this.projects.selected = null;
				this.subProjects.list = [];
				this.subProjects.selected = null;
			},
			get: function () {
				return this.cities.selectedId;
			}
		},
		selectedProjectId: {
			set: function (id) {
				this.projects.selected = id;
				if (id === '' || id === undefined) {
					this.subProjects.list = [];
				} else {
					this.loadSubProjects();
				}
				this.loaded = false;
				this.subProjects.selected = null;
			},
			get: function () {
				return this.projects.selected;
			}
		},
		filterSettled() {
			return !!(
				this.filters.dateFrom
				&& this.filters.dateTo
				&& this.projects.selected
				&& this.subProjects.selected
			);
		},
	},
	mounted: function () {
		this.loadCities();
		// this.loadProjects();
		// this.loadSubProjects();

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
		hasElements(obj) {
			return !!Object.values(obj).length;
		},
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
		loadCities() {
			this.loading = true;

			$.ajax({
				url: this.urls.cities,
				type: "GET",
				data: {},
			}).done(data => {
				this.loading = false;
				this.cities.list = data;
				this.selectedCityIds = '';

			}).fail(error => {
				this.loading = false;
				console.error('LOAD Cities error', error);
			});
		},
		loadProjects() {
			this.loading = true;
			const filters = {};
			if (this.onlyMy) filters.my = true;

			if (this.selectedCityIds.length && this.selectedCityIds[0] !== null) {
				filters.cityIds = this.selectedCityIds;
			}

			$.ajax({
				url: this.urls.projects,
				type: "GET",
				data: filters,
			}).done(data => {
				this.loading = false;
				this.projects.list = data;
				this.selectedProjectIds = '';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD projects error', error);
			});
		},
		loadSubProjects() {
			this.loading = true;
			const filters = {
				my: true,
				field: 'url',
			};
			// фильтр по городам
			if (this.selectedCityIds.length && this.selectedCityIds[0] !== null) {
				filters.cityIds = this.selectedCityIds;
			}
			// фильтр по проектам
			if (this.projects.selected) {
				filters.project = this.projects.selected;
			}

			$.ajax({
				url: this.urls.subProjects,
				type: "GET",
				data: filters,
			}).done(data => {
				this.loading = false;
				this.subProjects.list = data;
				this.selectedSubProjectIds = '';
			}).fail(error => {
				this.loading = false;
				console.error('LOAD subProjects error', error);
			});
		},
		datePickerInit() {
			const weekPicker = $("#date-range");
			const weekPickerDateFrom = weekPicker.find('[name="dateFrom"]');
			const weekPickerDateTo = weekPicker.find('[name="dateTo"]');
			weekPicker.datepicker({
				format: 'dd.mm.yyyy',
				language: 'ru',
				// startDate: this.startDate.format('DD.MM.Y'),
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
		},

		load() {
			// Сохраняем текущие настройки выборки
			this.current.dateFrom = this.filters.dateFrom;
			this.current.dateTo = this.filters.dateTo;
			this.current.projectId = this.projects.selected;
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
});
