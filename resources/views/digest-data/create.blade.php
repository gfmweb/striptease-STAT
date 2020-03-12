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
									<div class="form-row">
										<div class="form-group col-lg-3 col-md-4 filter-buttons flex-bottom-space">
											<div class="btn btn-vimeo" v-if="filterSettled" @click="load()">
												Показать
											</div>
											<div class="btn btn-success ml-2" v-if="haveChanges() && filterSettled"
												 @click="save()">Сохранить
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
										<th rowspan="2">Пароль</th>
										<th colspan="4">Кол-во активациий по городам</th>
										<th rowspan="2">Сумма</th>
									</tr>
									<tr>
										<th>Москва</th>
										<th>Санкт-Петербург</th>
										<th>Казань</th>
										<th>Чебоксары</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="digest in digestData" :class="{'project-row-edited':digest.changed}">
										<th>@{{ digest.name }}</th>
										<td v-if="digest.cities.msk">
											<editable-field v-model="digest.cities.msk.activations" @input="digest.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ digest.cities.msk.activations }}</span>
										</td>
										<td v-else>—</td>
										<td v-if="digest.cities.spb">
											<editable-field v-model="digest.cities.spb.activations" @input="digest.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ digest.cities.spb.activations }}</span>
										</td>
										<td v-else>—</td>
										<td v-if="digest.cities.kzn">
											<editable-field v-model="digest.cities.kzn.activations" @input="digest.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ digest.cities.kzn.activations }}</span>
										</td>
										<td v-else>—</td>
										<td v-if="digest.cities.che">
											<editable-field v-model="digest.cities.che.activations" @input="digest.changed = true" v-if="canEdit"></editable-field>
											<span v-else>@{{ digest.cities.che.activations }}</span>
										</td>
										<td v-else>—</td>
										{{-- <td>@{{ summaryByDigest(digest) }}</td> --}}
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
	@js('/js/vue/components/editable-field.js')
	@js('/js/vue/components/loading-block.js')
	@js('/js/vue/apps/digest-data/digest-data.js')
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
