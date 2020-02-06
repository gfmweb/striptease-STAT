@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Внесение данных за неделю</div>
					{{--VUE--}}
					<div id="vue-user-target-data" class="data-block">
						<div class="data-filter">
							<form class="data-filter-form m-3 form-inline">
								<div class="form-group m-1">
									<label for="date-range">Неделя</label><br>
									<input type="text" class="custom-select" name="date-range" id="date-range" value=""
										   placeholder="Неделя"
										   readonly/>
								</div>
								{{--<div class="form-group m-1">
									<label for="project-select">Проект</label><br>
									<select name="project" id="project-select" class="custom-select"
											v-model="projects.selected" @change="resetSubProjectSelect()">
										<option v-for="project in projects.list" :value="project.id">
											@{{ project.name }}
										</option>
									</select>
								</div>--}}
								<div class="form-group m-1">
									<label for="subProject">Проект</label><br>
									<select name="subProject" id="subProject" class="custom-select"
											v-model="subProjects.selected">
										<option v-for="subProject in subProjects.list" :value="subProject.id">
											@{{subProject.name }}
										</option>
									</select>
								</div>
								<div class="form-group m-1">
									<div class="btn btn-success ml-4 mt-3" v-if="filterSettled" @click="load()">
										Показать
									</div>
									<div class="btn btn-success ml-4 mt-3" v-if="haveChanges() && filterSettled"
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
										<th>Охват</th>
										<th>Переходы/просмотры</th>
										<th>Клики</th>
										<th>Кол-во лидов</th>
										<th>Кол-во активациий</th>
										<th>Затраты, руб.</th>
										<th>CPL, руб. / Стоимость лида</th>
										<th>Стоимость активации, руб.</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="row in userTargetData"
										:class="{'project-row-edited':row.changed}">
										<th>@{{ row.targetChannelName }}</th>
										<td>
											<editable-field v-model="row.values.coverage"
															@input="row.changed = true"></editable-field>
										</td>
										<td>
											<editable-field v-model="row.values.transition"
															@input="row.changed = true"></editable-field>
										</td>
										<td>
											<editable-field v-model="row.values.clicks"
															@input="row.changed = true"></editable-field>
										</td>
										<td>
											<editable-field v-model="row.values.leads"
															@input="row.changed = true"></editable-field>
										</td>
										<td>
											<editable-field v-model="row.values.activations"
															@input="row.changed = true"></editable-field>
										</td>
										<td class="text-right">
											@{{ (row.values.activations * row.values.price).toFixed(2) }}
										</td>
										<td class="text-right">
											@{{ (row.values.leads ? row.values.activations *
											row.values.price / row.values.leads : 0).toFixed(2) }}
										</td>
										<td>
											<editable-field v-model="row.values.price"
															@input="row.changed = true" def="0.00"></editable-field>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script type="text/javascript">
		// For Vue mount
		const dataSubProjects = false || {!! $dataSubProjects !!};
	</script>
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.ru.min.js"></script>
	<script type="text/javascript" src="/vendor/moment/moment.js"></script>
	<script type="text/javascript" src="/js/vue/helpers/work-with-object.js"></script>
	<script type="text/javascript" src="/vendor/vue/vue.js"></script>
	<script type="text/javascript" src="/js/vue/apps/user-target-data/components/editable-field.js"></script>
	<script type="text/javascript" src="/js/vue/components/loading-block.js"></script>
	<script type="text/javascript" src="/js/vue/apps/user-target-data/user-target-data.js"></script>

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
	</style>
	{{-- <style>
		 .data-block {
			 display: flex;
			 justify-content: center;
			 flex-direction: column;
			 align-items: center;
			 align-content: space-around;
		 }

		 .data-filter-form {
			 background-color: #f7f7f7;
			 padding: 10px;
			 border-radius: 10px;
			 margin: auto;
			 align-content: space-around;
			 display: flex;
			 justify-content: center;
			 flex-direction: row;
			 align-items: center;
		 }

		 .data-filter-form input,
		 .data-filter-form select {
			 margin-bottom: 0;
		 }
	 </style>--}}
@endpush
