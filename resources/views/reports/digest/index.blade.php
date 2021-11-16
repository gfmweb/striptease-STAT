
@extends('layouts.private')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="card-title mb-4">Отчет по дайджестам</div>
					<p>Для формирования отчета сперва заполните следующие поля:</p>
					{{--VUE--}}
					<div id="vue-report-query-builder" class="data-block">
						<loading-block :loading="loading"></loading-block>
						<div class="data-filter">
							<form class="data-filter-form">

								<div class="form-row">
									<div class="form-group col-lg-3 col-md-6">
										<label>Период <span class="text-danger">*</span></label>
										<div class="input-group input-daterange" name="date-range">
											<div class="mx-2 mt-2">с</div>
											<input type="text" class="form-control form-control-sm datepicker-input" name="dateFrom" :value="dateFrom" @input="changeDates($emit)">
											<div class="mx-2 mt-2">по</div>
											<input type="text" class="form-control form-control-sm datepicker-input" name="dateTo" :value="dateTo">
										</div>
									</div>

                                    <div class="form-group col-lg-3 col-md-6">
                                        <label>Период  2</label>
                                        <div class="input-group input-daterange" name="date-range2">
                                            <div class="mx-2 mt-2">с</div>
                                            <input type="text" class="form-control form-control-sm"
                                                   name="dateFromT"  v-model="dateFromT"  >
                                            <div class="mx-2 mt-2">по</div>
                                            <input type="text" class="form-control form-control-sm datepicker-input"
                                                   name="dateToT" >
                                        </div>
                                    </div>
<!--									<div class="form-group col-lg-3 col-md-6">
										<label for="city_id">Город</label>
										<select name="city_id" id="city_id" class="form-control" v-model="selectedCityId" disabled>
											<option value="">Все города</option>
											@foreach ($cities as $id => $name)
												<option value="{{ $id }}">{{ $name }}</option>
											@endforeach
										</select>
									</div>-->

									<div class="form-group col-md-3">
										<div class="btn btn-success" style="margin-top: 30px" v-if="filterSettled" @click="loadReport()">
											Показать
										</div>
									</div>

								</div>
							</form>
						</div>


                                <div class="row justify-content-center mb-4">

<!--                                    <div class="col-lg-3">
                                        <div class="row justify-content-between mb-4">
                                            <div class="col">
                                                <label>Общая</label>
                                                <input type="checkbox" class="form-check"  v-model="tglob" >
                                            </div>
                                            <div class="col">
                                                <label>Поиск</label>
                                                <input type="checkbox" class="form-check" v-model="tsearch" >
                                            </div>
                                            <div class="col">
                                                <label>Медийная</label>
                                                <input type="checkbox" class="form-check" v-model="tmedia" >
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                                  <div class="row justify-content-between">
                                      <div class="col" v-if="loaded && reportT==null">
						                    <div class="data-table"  v-html="report" ></div>
                                      </div>
                                      <div class="col-6" v-if="loaded && reportT!==null" style="overflow-x: auto">
                                          <div class="data-table"  v-html="report" ></div>
                                      </div>
                                      <div class="col" v-if="loaded && reportT!==null" style="overflow-x: auto">
                                            <div class="data-table"  v-html="reportT"></div>
                                      </div>
                                  </div>
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
	<script type="text/javascript" src="/vendor/moment/moment.js"></script>
	<script type="text/javascript" src="/vendor/vue/vue.js"></script>

	<script type="text/javascript" src="/js/vue/components/loading-block.js"></script>
	<script type="text/javascript" src="/js/vue/apps/digest-data/report-query-builder.js"></script>

	<link type="text/css" rel="stylesheet" href="/vendor/tables/css/datatable/dataTables.bootstrap4.min.css">
	<script type="text/javascript" src="/vendor/tables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="/js/helpers/dataTables/order-functions.js"></script>

@endpush
@push('css')
	<link type="text/css" rel="stylesheet" href="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css">
@endpush
