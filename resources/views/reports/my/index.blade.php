@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Отчет по моим данным</div>
					<p>Для формирования отчета сперва заполните следующие поля:</p>
					{{--VUE--}}
					<div id="vue-report-query-builder" class="data-block">
						<loading-block :loading="loading"></loading-block>
						<div class="data-filter">
							<form class="data-filter-form">
								<div class="form-row">
									<div class="form-group col-lg-2 col-md-4">
										<label for="city">Город<span class="text-danger">*</span></label>
										<select name="city" id="city" class="form-control form-control-sm"
												v-model="selectedCityId">
											<option value="all" v-if="hasElements(cities.list)">Все</option>
											<option v-for="(city,id) of cities.list" :value="id">
												@{{ city }}
											</option>
										</select>
									</div>
									<div class="form-group col-lg-3 col-md-4">
										<label for="subProject">Проект<span class="text-danger">*</span></label>
										<select name="subProject" id="subProject" class="form-control form-control-sm"
												v-model="selectedSubProjectId">
											<option value="all" v-if="hasElements(subProjects.list)">Все</option>
											<option v-for="(subProject,id) of subProjects.list" :value="id">
												@{{ subProject }}
											</option>
										</select>
									</div>
									<div class="form-group col-lg-2 col-md-4">
										<label for="subProject">Канал</label>
										<select name="channel" id="channel" class="form-control form-control-sm"
												v-model="channels.selectedId">
											<option value="all" v-if="hasElements(channels.list)">Все</option>
											<option v-for="(channel,id) of channels.list" :value="id">
												@{{channel }}
											</option>
										</select>
									</div>
									<div class="form-group col-lg-2 col-md-4">
										<label for="subProject">Тег</label>
										<select name="tag" id="tag" class="form-control form-control-sm"
												v-model="tags.selectedId">
											<option value="" v-if="hasElements(tags.list)"></option>
											<option v-for="(tag,id) of tags.list" :value="id">
												@{{ tag }}
											</option>
										</select>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-lg-6 col-md-9">
										<div class="input-group input-daterange" name="date-range">
											<div class="mx-2 mt-2">Период<span class="text-danger">*</span> с</div>
											<input type="text" class="form-control form-control-sm datepicker-input" name="dateFrom" :value="dateFrom" @input="changeDates($emit)">
											<div class="mx-2 mt-2">по</div>
											<input type="text" class="form-control form-control-sm datepicker-input" name="dateTo" :value="dateTo">
										</div>
										{{--<input type="text" class="custom-select" name="date-range"  id="date-range" value="" placeholder="Период" readonly/>--}}
									</div>

									<div class="form-group col-md-3">
										<div class="btn btn-success" v-if="filterSettled" @click="loadReport()">
											Показать
										</div>
									</div>
								</div>
							</form>
						</div>

						<hr>

						<div class="data-table" v-if="loaded" v-html="report"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script type="text/javascript">
		const onlyMyReport = true;
	</script>
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.ru.min.js"></script>
	<script type="text/javascript" src="/vendor/moment/moment.js"></script>
	<script type="text/javascript" src="/vendor/vue/vue.js"></script>
	@js('/js/vue/components/loading-block.js')
	@js('/js/vue/apps/user-target-data/report-query-builder.js')
	<script type="text/javascript" src="/vendor/tables/css/datatable/dataTables.bootstrap4.min.css"></script>
	<script type="text/javascript" src="/vendor/tables/js/jquery.dataTables.min.js"></script>
	@js('/js/helpers/dataTables/order-functions.js')
@endpush
@push('css')
	<link type="text/css" rel="stylesheet" href="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css">
@endpush
