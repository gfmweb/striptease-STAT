@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Отчет по статусам каналов</div>
					<p>Для формирования отчета по порядку заполните следующие поля:</p>
					{{--VUE--}}
					<div id="vue-report-query-builder" class="data-block">
						<loading-block :loading="loading"></loading-block>
						<div class="data-filter">
							<form class="data-filter-form">
								<div class="form-row">
									<div class="form-group col-lg-3 col-md-2">
										<label for="subProject">Исполнитель<span class="text-danger">*</span></label>
										<select name="partner" id="partner" class="form-control form-control-sm"
												v-model="selectedPartnerId">
											<option value="all" v-if="hasElements(partners.list)">Все</option>
											<option v-for="(partner,id) of partners.list" :value="id">
												@{{partner }}
											</option>
										</select>
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-lg-3 col-md-2">
										<label for="city">Город<span class="text-danger">*</span></label>
										<select name="city" id="city" class="form-control form-control-sm"
												v-model="selectedCityId">
											<option value="all" v-if="hasElements(cities.list)">Все</option>
											<option v-for="(city,id) of cities.list" :value="id">
												@{{ city }}
											</option>
										</select>
									</div>
									<div class="form-group col-lg-3 col-md-2">
										<label for="project_select">Проект<span class="text-danger">*</span></label>
										<select name="project" id="project_select" class="form-control form-control-sm" v-model="selectedProjectId">
											<option value="all" v-if="hasElements(projects.list)">Все</option>
											<option v-for="(project,id) of projects.list" :value="id">
												@{{ project }}
											</option>
										</select>
									</div>
									<div class="form-group col-lg-3 col-md-2">
										<label for="subProject">Подпроект<span class="text-danger">*</span></label>
										<select name="subProject" id="subProject" class="form-control form-control-sm" v-model="selectedSubProjectId">
											<option value="all" v-if="hasElements(subProjects.list)">Все</option>
											<option v-for="(subProject,id) of subProjects.list" :value="id">
												@{{ subProject }}
											</option>
										</select>
									</div>
									<div class="form-group col-md-3">
										<label for="channel">Канал</label>
										<select name="channel" id="channel" class="form-control"
												v-model="channels.selectedId">
											<option value="all" v-if="hasElements(channels.list)">Все</option>
											<option v-for="(channel,id) of channels.list" :value="id">
												@{{channel }}
											</option>
										</select>
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
	<script type="text/javascript" src="/vendor/vue/vue.js"></script>
	@js('/js/vue/components/loading-block.js')
	@js('/js/vue/apps/channels/report-query-builder.js')
	<link type="text/css" rel="stylesheet" href="/vendor/tables/css/datatable/dataTables.bootstrap4.min.css">
	<script type="text/javascript" src="/vendor/tables/js/jquery.dataTables.min.js"></script>
	@js('/js/helpers/dataTables/order-functions.js')
@endpush
