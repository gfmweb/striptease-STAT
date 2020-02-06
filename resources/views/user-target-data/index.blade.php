@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title">Отчет по партнерам</div>
					{{--VUE--}}
					<div id="vue-report-query-builder" class="data-block">
						<loading-block :loading="loading"></loading-block>
						<div class="data-filter">
							<form class="data-filter-form m-3 form-inline">
								<div class="form-group m-1">
									<label for="subProject">Город</label><br>
									<select name="city" id="city" class="custom-select"
											v-model="selectedCityId">
										<option value="all" v-if="hasElements(cities.list)">Все</option>
										<option v-for="(city,id) of cities.list" :value="id">
											@{{ city }}
										</option>
									</select>
								</div>
								<div class="form-group m-1">
									<label for="subProject">Проект</label><br>
									<select name="subProject" id="subProject" class="custom-select"
											v-model="selectedSubProjectId">
										<option value="all" v-if="hasElements(subProjects.list)">Все</option>
										<option v-for="(subProject,id) of subProjects.list" :value="id">
											@{{ subProject }}
										</option>
									</select>
								</div>
								<div class="form-group m-1">
									<label for="subProject">Исполнитель</label><br>
									<select name="partner" id="partner" class="custom-select"
											v-model="selectedPartnerId">
										<option value="all" v-if="hasElements(partners.list)">Все</option>
										<option v-for="(partner,id) of partners.list" :value="id">
											@{{partner }}
										</option>
									</select>
								</div>
								<div class="form-group m-1">
									<label for="subProject">Канал</label><br>
									<select name="channel" id="channel" class="custom-select"
											v-model="channels.selectedId">
										<option value="all" v-if="hasElements(channels.list)">Все</option>
										<option v-for="(channel,id) of channels.list" :value="id">
											@{{channel }}
										</option>
									</select>
								</div>
								<br>
								<div class="form-group m-1">
									<label for="date-range" class="mr-3">Период:</label>
									<div class="input-group input-daterange" name="date-range" id="date-range">
										<input type="text" class="custom-select datepicker-input" name="dateFrom" :value="dateFrom" @input="changeDates($emit)">
										<div class="mx-2 mt-2">по</div>
										<input type="text" class="custom-select datepicker-input" name="dateTo" :value="dateTo">
									</div>
									{{--<input type="text" class="custom-select" name="date-range"  id="date-range" value=""
										   placeholder="Период"
										   readonly/>--}}
								</div>
								<div class="form-group m-1">
									<div class="btn btn-success" v-if="filterSettled" @click="loadReport()">
										Показать
									</div>
								</div>
							</form>
						</div>

						<div class="data-table" v-if="loaded" v-html="report"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script type="text/javascript">

	</script>
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.ru.min.js"></script>
	<script type="text/javascript" src="/js/vue/helpers/work-with-object.js"></script>
	<script type="text/javascript" src="/vendor/vue/vue.js"></script>
	<script type="text/javascript" src="/js/vue/components/loading-block.js"></script>
		<script type="text/javascript" src="/js/vue/apps/user-target-data/report-query-builder.js"></script>

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

	</style>
@endpush
