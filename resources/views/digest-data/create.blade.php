@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Внесение данных по дайджестам за неделю</div>
					{{-- <p>Для заполнения данных по порядку выберите неделю</p> --}}
					{{--VUE--}}
					<div id="vue-digest-data" class="data-block">
						<div class="data-filter">
							<form class="data-filter-form">
								<div class="form-row">
									<div class="form-group col-lg-3 col-md-6">
										<label for="date-range">Неделя</label><br>
										<input type="text" class="custom-select" name="date-range" id="date-range" value="" placeholder="Неделя" readonly/>
									</div>

									<div class="form-group col-lg-3 col-md-6">
										<label for="city_id">Город</label>
										<select name="city_id" id="city_id" class="form-control" v-model="selectedCityId">
											@foreach ($cities as $id => $name)
												<option value="{{ $id }}">{{ $name }}</option>
											@endforeach
										</select>
									</div>

									<div class="form-row">
										<div class="form-group col-lg-3 col-md-4 filter-buttons flex-bottom-space">
											<div class="btn btn-vimeo" v-if="filterSettled" @click="load()">
												Показать
											</div>
											<div class="btn btn-success ml-2" v-if="haveChanges()" @click="save()">Сохранить
											</div>
										</div>
									</div>

							</form>
						</div>

						<div class="data-table" v-if="loaded">
							<loading-block :loading="loading"></loading-block>
							<table class="table table-bordered table-sm">
								<thead>
									<tr>
										<th colspan="2">Наши действия</th>
										<th>Получатели</th>
										<th>Лиды</th>
										<th>Активации</th>
										<th>Бюджет</th>
									</tr>
								</thead>
								<tbody>
									<template v-for="(group, i_group) in digestData">
										<tr v-for="(digest, i_digest) in group" :class="{'project-row-edited':digest.changed}">
											<td
												:rowspan="group.length"
												v-if="i_digest == 0"
											>@{{ digest.group_name }}</td>
											<td>@{{ digest.name }}</td>
											<td>
												<editable-field v-model="digest.data.coverage" @input="digest.changed = true"></editable-field>
											</td>
											<td>
												<editable-field v-model="digest.data.leads" @input="digest.changed = true"></editable-field>
											</td>
											<td>
												<editable-field v-model="digest.data.activations" @input="digest.changed = true"></editable-field>
											</td>
											<td>
												<editable-field v-model="digest.data.budget" @input="digest.changed = true"></editable-field>
											</td>
										</tr>
									</template>
								</tbody>
							</table>
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

	<script type="text/javascript" src="/js/vue/components/editable-field.js"></script>
	<script type="text/javascript" src="/js/vue/components/loading-block.js"></script>
	<script type="text/javascript" src="/js/vue/apps/digest-data/digest-data.js"></script>
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
