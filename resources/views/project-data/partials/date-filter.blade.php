<div>
    {!! Form::open(['method' => 'GET', 'class'=>'form-inline']) !!}

    <div class="input-group input-daterange" id="datetime-week-select">
        <div class="input-group-append">
            <div class="input-group-text">ОТ</div>
        </div>
        {!! Form::text('dateFrom','',['class'=>'form-control form-control-sm week-range' ]) !!}
        <div class="input-group-append input-group-prepend">
            <div class="input-group-text">ДО</div>
        </div>
        {!! Form::text('dateTo','',['class'=>'form-control form-control-sm week-range']) !!}
    </div>
    {{ Form::submit('Заполнить', ['class' => 'btn btn-success ml-3 form-control-sm']) }}
    {!! Form::close() !!}
    <small id="rangeHelp" class="form-text text-muted">
        Укажите неделю которую в дальнейшем заполим данными
    </small>
</div>
@push('js')
    <script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-datepicker/bootstrap-datepicker.ru.min.js"></script>
    <script type="text/javascript" src="/vendor/moment/moment.js"></script>
    <script type="text/javascript">

        $(function () {
            const weekPicker         = $("#datetime-week-select");
            const weekPickerDateFrom = weekPicker.find('[name="dateFrom"]');
            const weekPickerDateTo   = weekPicker.find('[name="dateTo"]');
            //Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
            weekPicker.datepicker({
                format: 'dd.mm.yyyy',
                language: 'ru',
                calendarWeeks: true,
            });


            function onDateChange(e) {
                let value = weekPickerDateFrom.val();
                if (!value.trim().length) return;
                let firstDate = moment(value, "DD.MM.YYYY").day(1).format("DD.MM.YYYY");
                let lastDate  = moment(value, "DD.MM.YYYY").day(7).format("DD.MM.YYYY");
                weekPickerDateFrom.val(firstDate);
                weekPickerDateTo.val(lastDate);
            }

            //Get the value of Start and End of Week
            weekPicker.on('changeDate', onDateChange);
            weekPicker.on('hide', onDateChange);
        });
    </script>
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