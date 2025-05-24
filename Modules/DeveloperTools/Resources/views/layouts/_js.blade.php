@if (is_rtl() == 'rtl')
    <script src="/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-rtl.min.js"
            type="text/javascript">
    </script>
@else
    <script src="/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript">
    </script>
@endif

<script src="/vendor/laravel-filemanager/js/single-stand-alone-button.js"></script>


<script>
    $(document).ready(function () {
        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });
    })
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".emojioneArea").emojioneArea();
    });
</script>

<style>
    .emojionearea .emojionearea-picker.emojionearea-picker-position-top {
        margin-bottom: -286px !important;
        right: -14px;
        z-index: 90000000000000;
    }

    .emojionearea .emojionearea-button.active + .emojionearea-picker-position-top {
        margin-top: 0px !important;
    }
</style>

<script>
    // DELETE ROW FROM DATATABLE
    function deleteRow(url, rowId = '', flag = '') {
        var _token = $('input[name=_token]').val();

        bootbox.confirm({
            message: '{{__('apps::dashboard.general.delete_message')}}',
            buttons: {
                confirm: {
                    label: '{{__('apps::dashboard.general.yes_btn')}}',
                    className: 'btn-success'
                },
                cancel: {
                    label: '{{__('apps::dashboard.general.no_btn')}}',
                    className: 'btn-danger'
                }
            },

            callback: function (result) {
                if (result) {

                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {
                            _token: _token
                        },
                        success: function (msg) {
                            toastr["success"](msg[1]);
                            if (flag === 'advertising_groups') {
                                $('#advertisingGroup-' + rowId).remove();
                            } else {
                                $('#dataTable').DataTable().ajax.reload();
                            }
                        },
                        error: function (msg) {
                            toastr["error"](msg[1]);
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    });

                }
            }
        });
    }

    function deleteAllChecked(url) {
        var someObj = {};
        someObj.fruitsGranted = [];

        $("input:checkbox").each(function () {
            var $this = $(this);

            if ($this.is(":checked")) {
                someObj.fruitsGranted.push($this.attr("value"));
            }
        });

        var ids = someObj.fruitsGranted;

        bootbox.confirm({
            message: '{{__('apps::dashboard.general.deleteAll_message')}}',
            buttons: {
                confirm: {
                    label: '{{__('apps::dashboard.general.delete_yes_btn')}}',
                    className: 'btn-success'
                },
                cancel: {
                    label: '{{__('apps::dashboard.general.delete_no_btn')}}',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {

                    $.ajax({
                        type: "GET",
                        url: url,
                        data: {
                            ids: ids,
                        },
                        success: function (msg) {

                            if (msg[0] == true) {
                                toastr["success"](msg[1]);
                                $('#dataTable').DataTable().ajax.reload();
                            } else {
                                toastr["error"](msg[1]);
                            }

                        },
                        error: function (msg) {
                            toastr["error"](msg[1]);
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    });

                }
            }
        });
    }

    $(document).ready(function () {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            if (start.isValid() && end.isValid()) {
                $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $('input[name="from"]').val(start.format('YYYY-MM-DD'));
                $('input[name="to"]').val(end.format('YYYY-MM-DD'));
            } else {
                $('#reportrange .form-control').val('Without Dates');
                $('input[name="from"]').val('');
                $('input[name="to"]').val('');
            }
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                '{{__('apps::dashboard.general.date_range.today')}}': [moment(), moment()],
                '{{__('apps::dashboard.general.date_range.yesterday')}}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '{{__('apps::dashboard.general.date_range.7days')}}': [moment().subtract(6, 'days'), moment()],
                '{{__('apps::dashboard.general.date_range.30days')}}': [moment().subtract(29, 'days'), moment()],
                '{{__('apps::dashboard.general.date_range.month')}}': [moment().startOf('month'), moment().endOf('month')],
                '{{__('apps::dashboard.general.date_range.last_month')}}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            },
            @if (is_rtl() == 'rtl')
            opens: 'left',
            @endif
            buttonClasses: ['btn'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-danger',
            format: 'YYYY-MM-DD',
            separator: 'to',
            locale: {
                applyLabel: '{{__('apps::dashboard.general.date_range.save')}}',
                cancelLabel: '{{__('apps::dashboard.general.date_range.cancel')}}',
                fromLabel: 'from',
                toLabel: 'to',
                customRangeLabel: '{{__('apps::dashboard.general.date_range.custom')}}',
                firstDay: 1
            }
        }, cb);

        cb(start, end);

    });

</script>

<script>
    $('.lfm').filemanager('image');

    $('.delete').click(function () {
        $(this).closest('.form-group').find($('.' + $(this).data('input'))).val('');
        $(this).closest('.form-group').find($('.' + $(this).data('preview'))).html('');
    });

</script>

<script src="https://js.pusher.com/5.0/pusher.min.js"></script>

<script>
    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: '{{env('PUSHER_APP_CLUSTER')}}',
        forceTLS: true
    });

    pusher.subscribe('{{ config('core.config.constants.DASHBOARD_CHANNEL') }}').bind('{{ config('core.config.constants.DASHBOARD_ACTIVITY_LOG') }}', function (data) {

        $('#dataTable').DataTable().ajax.reload();

        if (data.activity.type === 'orders') {
            openActivity(data.activity);
        }

    });

    function playSound() {
        var audio = new Audio('{{ url('uploads/media/doorbell-5.mp3') }}');
        audio.play();
    }

    function openActivity(response) {
        playSound();
        // Show
        var showUrl = response.url;

        swal({
            title: response.description_{{locale()}},
            icon: "success",
            buttons: true,
            dangerMode: true,
        })
            .then((willDone) => {
                if (willDone) {
                    window.location.href = showUrl;
                }
            });
    }

    $("#showAllDeleted").bootstrapSwitch({
        onSwitchChange: function (e, state) {
            var data = {};
            if (state)
                data['deleted'] = 'only';

            $('#dataTable').DataTable().destroy();
            tableGenerate(data);
        }
    });
</script>

@include('order::dashboard.shared._bulk_order_actions_js')
