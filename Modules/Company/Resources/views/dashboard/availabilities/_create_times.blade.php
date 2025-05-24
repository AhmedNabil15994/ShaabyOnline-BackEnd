@section('css')

    <style>
        .is_full_day {
            margin-left: 15px;
            margin-right: 15px;
        }

        .collapse-custom-time {
            display: none;
        }

        .times-row {
            margin-bottom: 5px;
        }
    </style>

@endsection

<div class="tab-pane fade in" id="availabilities">
    {{--  <h3 class="page-title">{{ __('company::dashboard.companies.form.tabs.availabilities') }}</h3>  --}}
    <div class="col-md-12">

        {{--        <div class="table-responsive">--}}
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>{{__('company::dashboard.companies.availabilities.form.day')}}</th>
                <th>{{__('company::dashboard.companies.availabilities.form.time_status')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach(getDays() as $k => $day)
                <tr>
                    <td>
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input type="checkbox"
                                   class="group-checkable"
                                   value="{{ $k }}"
                                   name="days_status[]">
                            <span></span>
                        </label>
                    </td>
                    <td>
                        {{ $day }}
                    </td>
                    <td>
                        <div class="form-check form-check-inline">

                            <span class="is_full_day">
                                <input class="form-check-input check-time" type="radio" name="is_full_day[{{$k}}]"
                                       id="full_time-{{$k}}"
                                       value="1"
                                       checked
                                       onclick="hideCustomTime('{{$k}}')">
                                <label class="form-check-label" for="full_time-{{$k}}">
                                    {{__('company::dashboard.companies.availabilities.form.full_time')}}
                                </label>
                            </span>

                            <span class="is_full_day">
                                <input class="form-check-input check-time" type="radio" name="is_full_day[{{$k}}]"
                                       id="custom_time-{{$k}}"
                                       value="0"
                                       onclick="showCustomTime('{{$k}}')">
                                <label class="form-check-label" for="custom_time-{{$k}}">
                                    {{__('company::dashboard.companies.availabilities.form.custom_time')}}
                                </label>
                            </span>

                        </div>
                    </td>
                </tr>
                <tr id="collapse-{{$k}}" class="collapse-custom-time">
                    <td colspan="3" id="div-content-{{$k}}">
                        <div class="row" style="margin-bottom: 5px;">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success"
                                        onclick="addMoreDayTimes(event, '{{$k}}')">
                                    {{__('company::dashboard.companies.availabilities.form.btn_add_more')}}
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row times-row" id="rowId-{{$k}}-0">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker 24_format"
                                           name="availability[time_from][{{$k}}][]"
                                           data-name="availability[time_from][{{$k}}][]" value="00:01">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker 24_format"
                                           name="availability[time_to][{{$k}}][]"
                                           data-name="availability[time_to][{{$k}}][]" value="23:59">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                {{--<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox"
                                           class="group-checkable"
                                           name="availability[status][{{$k}}][0]"
                                           data-name="availability[status][{{$k}}][0]">
                                    <span></span>
                                </label>--}}
                                {{--<button type="button" class="btn btn-danger"
                                         onclick="removeDayTimes('{{$k}}', 0, 'row')">X
                                 </button>--}}
                            </div>
                        </div>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
        {{--        </div>--}}

    </div>
</div>


@section('scripts')

    <script>

        var timePicker = $(".timepicker");
        timePicker.timepicker();

        var rowCountsArray = [0];

        function hideCustomTime(id) {
            $("#collapse-" + id).hide();
        }

        function showCustomTime(id) {
            $("#collapse-" + id).show();
        }

        function addMoreDayTimes(e, dayCode) {

            if (e.preventDefault) {
                e.preventDefault();
            } else {
                e.returnValue = false;
            }

            var rowCount = Math.floor(Math.random() * 9000000000) + 1000000000;
            rowCountsArray.push(rowCount);

            var divContent = $('#div-content-' + dayCode);
            var newRow = `
            <div class="row times-row" id="rowId-${dayCode}-${rowCount}">
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control timepicker 24_format" name="availability[time_from][${dayCode}][]"
                               data-name="availability[time_from][${dayCode}][]" value="00:01">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control timepicker 24_format" name="availability[time_to][${dayCode}][]"
                               data-name="availability[time_to][${dayCode}][]" value="23:59">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger" onclick="removeDayTimes('${dayCode}', ${rowCount}, 'row')">X</button>
                </div>
            </div>
            `;

            divContent.append(newRow);

            $(".timepicker").timepicker();
        }

        function removeDayTimes(dayCode, index, flag = '') {

            {{-- if (rowCountsArray.length > 1) { --}}

            if (flag === 'row') {
                $('#rowId-' + dayCode + '-' + index).remove();
                const i = rowCountsArray.indexOf(index);
                if (i > -1) {
                    rowCountsArray.splice(i, 1);
                }
            }

            {{--} else {--}}
            {{--    alert("{{__('company::dashboard.companies.availabilities.form.at_least_one_element')}}");--}}
            {{--    return false;--}}
            {{--}--}}

        }

    </script>

@endsection