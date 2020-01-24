const chat = new Vue({
          el: '#vue-project-data',
          data: {
              urls: {
                  get: '/project-data/list',
                  save: '/project-data/save'
              },
              errors: null,
              loading: false,
              init: false,
              filters: {
                  dateFrom: null,
                  dateTo: null
              },
              current: {
                  dateFrom: null,
                  dateTo: null,
                  subProjectId: null,
              },
              projects: {
                  list: [],
                  selected: null
              },
              subProjects: {
                  list: [],
                  selected: null
              },
              channels: null,
              data: [],
          },
          mounted: function () {
              this.init             = true;
              this.projects.list    = dataProjects;
              this.subProjects.list = dataSubProjects;
              this.fillChannels(dataChannels);
              this.updateData([]);

              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              this.datePickerInit();
          },
          computed: {
              subProjectByProject() {
                  return this.subProjects.list.filter((subProject) => subProject.project_id === this.projects.selected);
              },
              filterSettled() {
                  return !!(this.filters.dateFrom && this.filters.dateTo && this.projects.selected && this.subProjects.selected);
              },

          },
          methods: {
              saveChanges() {
                  const changed     = this.getChangedChannels();
                  const dataForSend = [];
                  if (changed && changed.length) {
                      changed.forEach(ch => {
                          this.data[ch.id].channel_id = ch.id;
                          return dataForSend.push(this.data[ch.id]);
                      });
                  }
                  if (dataForSend.length) {
                      console.log('SAVE DATA:', dataForSend);
                      $.ajax({
                          url: this.urls.save,
                          type: "POST",
                          data: {
                              list: dataForSend,
                              dateFrom: this.current.dateFrom,
                              dateTo: this.current.dateTo,
                              subProjectId: this.current.subProjectId,
                          },
                          dataType: 'json'
                      }).done(data => {
                          console.log('SAVE:', data);
                          this.clearChangedList();
                      }).fail(error => console.log('SAVE error', error));
                  }
              },
              haveChanges() {
                  let changed = this.getChangedChannels();
                  return changed && changed.length;
              },
              getChangedChannels() {
                  return this.channels && this.channels.filter((chl, i) => chl.changed);
              },
              clearChangedList() {
                  const changed = this.getChangedChannels();
                  changed && changed.forEach(ch => this.$set(ch, 'changed', false));
              },
              fillChannels(channels) {
                  this.channels = channels;
                  this.channels.forEach(ch => this.$set(ch, 'changed', false));
              },
              resetSubProjectSelect() {
                  this.subProjects.selected = null;
              },
              datePickerInit() {
                  const weekPicker         = $("#date-range");
                  const weekPickerDateFrom = weekPicker.find('[name="dateFrom"]');
                  const weekPickerDateTo   = weekPicker.find('[name="dateTo"]');
                  weekPicker.datepicker({
                      format: 'dd.mm.yyyy',
                      language: 'ru',
                      calendarWeeks: true,
                  });
                  let that = this;

                  function onDateChange(e) {
                      let value = weekPicker.val();
                      if (!value.trim().length) return;

                      let firstDate         = moment(value, "DD.MM.YYYY").day(1);
                      let lastDate          = moment(value, "DD.MM.YYYY").day(7);
                      that.filters.dateFrom = firstDate.format("YYYY-MM-DD");
                      that.filters.dateTo   = lastDate.format("YYYY-MM-DD");

                      weekPicker.val(`${firstDate.format("DD.MM.YYYY")} - ${lastDate.format("DD.MM.YYYY")}`);
                  }

                  //Get the value of Start and End of Week
                  weekPicker.on('changeDate', onDateChange);
                  weekPicker.on('hide', onDateChange);
              },
              load() {
                  // Сохраняем текущие настройки выборки
                  this.current.dateFrom     = this.filters.dateFrom;
                  this.current.dateTo       = this.filters.dateTo;
                  this.current.subProjectId = this.subProjects.selected;

                  $.ajax({
                      url: this.urls.get,
                      type: "GET",
                      data: this.current,
                  }).done(data => {
                      this.updateData(data);
                      this.clearChangedList();
                  }).fail(error => {
                      console.log('error', error);
                  });
              },
              updateData(data) {
                  this.channels.forEach((channel, i) => {
                      Vue.set(this.data, channel.id, {
                          isEdit: false,
                          channel_id: data[channel.id] && data[channel.id].channel_id || null,
                          coverage: data[channel.id] && data[channel.id].coverage || 0,
                          transition: data[channel.id] && data[channel.id].transition || 0,
                          clicks: data[channel.id] && data[channel.id].clicks || 0,
                          leads: data[channel.id] && data[channel.id].leads || 0,
                          activations: data[channel.id] && data[channel.id].activations || 0,
                          price: data[channel.id] && data[channel.id].price || '0.00',
                      });
                  });
                  console.log(this.data);
              },

              log(e, m) {
                  console.log('log:', e, m);
              },

              formatDate(date, forSql = false) {
                  const H = date.getHours() > 9 ? date.getHours() : '0' + date.getHours();
                  const i = date.getMinutes() > 9 ? date.getMinutes() : '0' + date.getMinutes();
                  const s = date.getSeconds() > 9 ? date.getSeconds() : '0' + date.getSeconds();
                  const Y = date.getFullYear();
                  let d   = date.getDate();
                  let m   = date.getMonth() + 1;
                  d       = d > 9 ? d : '0' + d;
                  m       = m > 9 ? m : '0' + m;
                  if (forSql)
                      return `${Y}-${m}-${d} ${H}:${i}:${s}`;
                  else
                      return `${d}.${m}.${Y} ${H}:${i}`;
              },
          }
      })
;
