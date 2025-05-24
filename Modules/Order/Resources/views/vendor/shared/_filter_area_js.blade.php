<script>
    /* Start - Address Country & City & State */
    $('#filterCountryId').on('select2:select', function(e) {
        var data = e.params.data;
        if (data.id == '') {
            $('#filterCityId').empty().html(
                `<option value="">--- {{ __('user::frontend.addresses.form.select_city') }} ---</option>`);
            $('#filterStateId').empty().html(
                `<option value="">--- {{ __('user::frontend.addresses.form.select_state') }} ---</option>`
            );
            $('#countryCitiesSection').hide();
            $('#countryCityStatesSection').hide();

        } else {
            getChildAreasByParent(data.id, 'city');
        }
    });

    $('#filterCityId').on('select2:select', function(e) {
        var data = e.params.data;
        if (data.id == '') {
            $('#filterStateId').empty().html(
                `<option value="">--- {{ __('user::frontend.addresses.form.select_state') }} ---</option>`
            );
            $('#countryCityStatesSection').hide();
        } else {
            getChildAreasByParent(data.id, 'state');
        }
    });

    function getChildAreasByParent(parentId, type = 'city') {
        let data = {
            'parent_id': parentId,
            'type': type,
        };

        $.ajax({
            method: "GET",
            url: '{{ route('vendor.area.get_child_area_by_parent') }}',
            data: data,
            beforeSend: function() {
                if (type == 'city') {
                    $('#countryCitiesSection').hide();
                    $('#countryCityStatesSection').hide();
                    $('#filterStateId').empty();
                } else if (type == 'state') {
                    $('#countryCityStatesSection').hide();
                }
                $('#countryCitiesLoader').show();
            },
            success: function(data) {},
            error: function(data) {
                displayErrorsMsg(data);
            },
            complete: function(data) {
                var getJSON = $.parseJSON(data.responseText);
                buildSelectDropdown(getJSON.data, type);

                $('#countryCitiesLoader').hide();

                if (type == 'city') {
                    $('#countryCitiesSection').show();
                    $('#countryCityStatesSection').show();
                } else if (type == 'state') {
                    $('#countryCityStatesSection').show();
                }
            },
        });
    }

    function buildSelectDropdown(data, type) {
        let id = '',
            label = '',
            section = '';
        if (type === 'city') {
            id = 'filterCityId';
            section = 'countryCitiesSection';
            label = '--- {{ __('user::frontend.addresses.form.select_city') }} ---';
        } else if (type === 'state') {
            id = 'filterStateId';
            section = 'countryCityStatesSection';
            label = '--- {{ __('user::frontend.addresses.form.select_state') }} ---';
        }

        var row = `<option value="">${label}</option>`;
        $.each(data, function(i, value) {
            row += `<option value="${value.id}">${value.title}</option>`;
        });
        $('#' + section).show();
        $('#' + id).html(row);
    }
</script>
