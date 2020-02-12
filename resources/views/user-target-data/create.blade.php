@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Внесение данных за неделю</div>
					<p>Для заполнения данных пожалуйста сперва укажите неделю и проект.</p>
					{{--VUE--}}
					<div id="vue-user-target-data" class="data-block">
						<div class="data-filter">
							<form class="data-filter-form form-row">
								<div class="form-group col-lg-3 col-md-6">
									<label for="date-range">Неделя</label><br>
									<input type="text" class="custom-select" name="date-range" id="date-range" value=""
										   placeholder="Неделя"
										   readonly/>
								</div>
								<div class="form-group col-lg-3 col-md-6">
									<label for="city">Город</label>
									<select name="city" id="city" class="custom-select" v-model="selectedCityId">
										<option value="all" v-if="hasElements(cities.list)">Все</option>
										<option v-for="(city,id) of cities.list" :value="id">
											@{{ city }}
										</option>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-6">
									<label for="subProject">Проект</label><br>
									<select name="subProject" id="subProject" class="custom-select"
											v-model="subProjects.selected">
										<option v-for="(subProject,id) of subProjects.list" :value="id">
											@{{subProject }}
										</option>
									</select>
								</div>
								<div class="form-group col-lg-3 col-md-4 filter-buttons flex-bottom-space">
									<div class="btn btn-vimeo" v-if="filterSettled" @click="load()">
										Показать
									</div>
									<div class="btn btn-success" v-if="haveChanges() && filterSettled"
										 @click="save()">Сохранить
									</div>
								</div>
							</form>
						</div>

						<div class="data-table" v-if="loaded">
							<loading-block :loading="loading"></loading-block>
							<table class="table table-bordered table-sm">
								<thead>
									<tr>
										<th style="width: 200px;">Канал</th>
										<th style="min-width: 80px;">Охват</th>
										<th>Переходы/просмотры</th>
										<th style="min-width: 70px;">Клики</th>
										<th>Кол-во лидов</th>
										<th>Кол-во активациий</th>
										<th>Затраты, руб.</th>
										<th title="Стоимость лида. Формула: [Затраты] / [Кол-во лидов]">CPL, руб.</th>
										<th>Стоимость активации, руб.</th>
										<th title="Формула: [Кол-во активаций] / [Кол-во лидов] * 100%">Конверсия, %</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="row in userTargetData"
										:class="{'project-row-edited':row.changed}">
										<th>@{{ row.targetChannelName }}</th>
										<td>
											<editable-field v-model="row.values.coverage" @input="row.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ row.values.coverage }}</span>
										</td>
										<td>
											<editable-field v-model="row.values.transition" @input="row.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ row.values.transition }}</span>
										</td>
										<td>
											<editable-field v-model="row.values.clicks" @input="row.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ row.values.clicks }}</span>
										</td>
										<td>
											<editable-field v-model="row.values.leads" @input="row.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ row.values.leads }}</span>
										</td>
										<td>
											<editable-field v-model="row.values.activations" @input="row.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ row.values.activations }}</span>
										</td>
										<td>
											<editable-field v-model="row.values.cost" @input="row.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ row.values.cost }}</span>
										</td>
										<td class="text-right">
											@{{ (row.values.leads ? row.values.cost / row.values.leads : 0).toFixed(2) }}
										</td>
										<td>
											@{{ (row.values.activations ? row.values.cost / row.values.activations : 0).toFixed(2) }}
										</td>
										<td class="text-right">
											@{{ (row.values.leads ? row.values.activations / row.values.leads * 100 : 0).toFixed(2) }}%
										</td>
									</tr>
								</tbody>
							</table>
							<p v-if="!canEdit" class="text-danger">Данные внести невозможно. Прошли допустимые сроки на редактирование данной недели.</p>
						</div>
					</div>
					{{--/VUE--}}
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.ru.min.js"></script>
	<script type="text/javascript" src="/vendor/moment/moment.js"></script>
	<script type="text/javascript" src="/vendor/vue/vue.js"></script>
	@js('/js/vue/apps/user-target-data/components/editable-field.js')
	@js('/js/vue/components/loading-block.js')
	@js('/js/vue/apps/user-target-data/user-target-data.js')
@endpush
@push('css')
	<link type="text/css" rel="stylesheet" href="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<style>
		.datepicker-days tr:hover {
			background-color: #d8d8d8;
		}

		.datepicker-days tr:hover td {
			border-radius: 0;
		}

		.vue-editable-field input {
			transition: all .3s ease;
			border: 0;
			width: 100%;
			position: absolute;
			text-align: right;
		}

		.vue-editable-field input:hover, .vue-editable-field input:focus {
			box-shadow: 2px 2px 14px rgba(0, 0, 0, 0.17);
			padding: 4px;
			margin-top: -4px;
			z-index: 10;
			cursor: pointer;
			border-radius: 4px;
			background-color: white;
			color: black;
		}

		.vue-editable-field {
			position: relative;
		}

		.project-row-edited {
			transition: all .3s ease;
			background-color: #8ec7a0;;
			color: white;
		}

		.project-row-edited input {
			background-color: #8ec7a0;;
			color: white;
		}

		.datepicker table tr td.day.focused,
		.datepicker table tr td.day:hover {
			background: #d8d8d8;
		}

	</style>
@endpush
