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
    <div class="col-md-12">

        {{--        <div class="table-responsive">--}}
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>{{__('vendor::dashboard.vendors.availabilities.form.day')}}</th>
                <th>{{__('vendor::dashboard.vendors.availabilities.form.time_status')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach(getDays() as $k => $day)
                <tr>
                    <td>
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input type="checkbox"
                                   class="group-checkable"
                                   {{ $vendor->workTimes()->where('day_code', $k)->value('status') == 1 ? 'checked' : '' }}
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
                                       {{ $vendor->workTimes()->where('day_code', $k)->first() == null || $vendor->workTimes()->where('day_code', $k)->first()->is_full_day == 1 ? 'checked' : '' }}
                                       onclick="hideCustomTime('{{$k}}')">
                                <label class="form-check-label" for="full_time-{{$k}}">
                                    {{__('vendor::dashboard.vendors.availabilities.form.full_time')}}
                                </label>
                            </span>

                            <span class="is_full_day">
                                <input class="form-check-input check-time" type="radio" name="is_full_day[{{$k}}]"
                                       id="custom_time-{{$k}}"
                                       value="0"
                                       {{ isset($vendor->workTimes()->where('day_code', $k)->first()->is_full_day) && $vendor->workTimes()->where('day_code', $k)->first()->is_full_day == 0 ? 'checked' : '' }}
                                       onclick="showCustomTime('{{$k}}')">
                                <label class="form-check-label" for="custom_time-{{$k}}">
                                    {{__('vendor::dashboard.vendors.availabilities.form.custom_time')}}
                                </label>
                            </span>
                        </div>

                    </td>
                </tr>

                @if(isset($vendor->workTimes()->where('day_code', $k)->first()->is_full_day) && $vendor->workTimes()->where('day_code', $k)->first()->is_full_day == 0)

                    <tr id="collapse-{{$k}}" class="">
                        <td colspan="3" id="div-content-{{$k}}">
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success"
                                            onclick="addMoreDayTimes(event, '{{$k}}')">
                                        {{__('vendor::dashboard.vendors.availabilities.form.btn_add_more')}}
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>

                            @foreach($vendor->workTimes()->where('day_code', $k)->first()->custom_times as $key => $time)
                                <div class="row times-row" id="rowId-{{$k}}-{{$key}}">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker 24_format"
                                                   name="availability[time_from][{{$k}}][]"
                                                   data-name="availability[time_from][{{$k}}][]"
                                                   value="{{ $time['time_from'] }}">
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
                                                   data-name="availability[time_to][{{$k}}][]"
                                                   value="{{ $time['time_to'] }}">
                                            <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                        </div>
                                    </div>

                                    @if($key != 0)
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-danger"
                                                    onclick="removeDayTimes('{{$k}}', '{{$key}}', 'row')">
                                                X
                                            </button>
                                        </div>
                                    @endif

                                </div>
                            @endforeach

                        </td>
                    </tr>
                @else
                    <tr id="collapse-{{$k}}" class="collapse-custom-time">
                        <td colspan="3" id="div-content-{{$k}}">
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success"
                                            onclick="addMoreDayTimes(event, '{{$k}}')">
                                        {{__('vendor::dashboard.vendors.availabilities.form.btn_add_more')}}
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row times-row" id="rowId-{{$k}}-0">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker 24_format"
                                               name="availability[time_from][{{$k}}][]"
                                               data-name="availability[time_from][{{$k}}][]" value="00">
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
                                               data-name="availability[time_to][{{$k}}][]" value="23">
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-md-3">

                                </div>
                            </div>
                        </td>
                    </tr>
                @endif

            @endforeach
            </tbody>
        </table>
        {{--        </div>--}}

    </div>
</div>
