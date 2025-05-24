<script>
    function onBulkActionsChange(printPage = 'orders') {
        var value = $("#bulkActionsSelect").val();
        if (value === 'edit_status') {
            var status = $('#orderStatusSelect').val();
            if (status !== '') {
                applyBulkActions('{{ url(route('vendor.orders.update_bulk_order_status')) }}', 'edit_status', {'order_status': status});
            } else {
                alert('Please, Select order status.');
            }
        } else if (value === 'print') {
            printAllChecked('{{ url(route('vendor.orders.print_selected_items')) }}', printPage);
        } else if (value === 'delete') {
            applyBulkActions('{{ url(route('vendor.orders.deletes')) }}', 'delete');
        } else {
            console.log('not action !!');
        }
    }

    // Apply bulk actions, like delete, edit status, ...
    function applyBulkActions(url, type, someData = {}) {
        var someObj = {};
        someObj.ids = [];

        $("input:checkbox").each(function () {
            var $this = $(this);

            if ($this.is(":checked")) {
                someObj.ids.push($this.attr("value"));
            }
        });

        var ids = someObj.ids;
        var idsObj = {ids: ids};
        const requestData = {...someData, ...idsObj};

        if (ids.length > 0) {
            bootbox.confirm({
                message: returnMessageType(type),
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
                            data: requestData,
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
        } else {
            alert('Please, Select at least one item.');
        }

    }

    function returnMessageType(type) {
        let text = '';
        switch (type) {
            case 'edit_status':
                text = '{{__('apps::dashboard.general.bulkOrderStatus_message')}}';
                break;
            case 'delete':
                text = '{{__('apps::dashboard.general.deleteAll_message')}}';
                break;
            default:
                text = "";
        }
        return text;
    }

    $(document).ready(function () {
        $("#bulkActionsSelect").change(function () {
            if ($(this).val() === 'edit_status') {
                $('#orderStatusSelect').show();
            } else {
                $('#orderStatusSelect').hide();
            }
        });
    });

    // Print Selected Rows From DATATABLE
    function printAllChecked(url, page = '') {
        var someObj = {};
        someObj.ids = [];

        $("input:checkbox").each(function () {
            var $this = $(this);

            if ($this.is(":checked")) {
                var val = $this.attr("value");
                val = val.split(" ")[0];
                someObj.ids.push(val);
            }
        });

        var ids = someObj.ids;
        if (ids != null && ids !== '' && ids.length > 0) {
            window.location.href = url + '?page=' + page + '&ids=' + ids;
        } else {
            alert('Please, Select at least one item.');
        }
    }
</script>
