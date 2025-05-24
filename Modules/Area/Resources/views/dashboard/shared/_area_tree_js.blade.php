<script>

    {{--  $('.select-detail').select2();  --}}

    /* Start - Address Country & City & State */
    $('#addressCountryId').on('select2:select', function(e) {
        var data = e.params.data;
        if (data.id == '') {
            $('#addressStateId').empty().html(
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
            url: "{{ route('dashboard.area.get_city_with_states_by_parent') }}",
            data: data,
            beforeSend: function() {},
            success: function(data) {},
            error: function(data) {
                displayErrorsMsg(data);
            },
            complete: function(data) {
                var getJSON = $.parseJSON(data.responseText);
                buildSelectDropdown(getJSON.data, type);
            },
        });
    }

    function buildSelectDropdown(data, type) {
        let id = '',
            label = '',
            section = '';
        if (type === 'city') {
            id = 'addressCityId';
            section = 'countryCitiesSection';
            label = '--- {{ __('user::frontend.addresses.form.select_city') }} ---';
        } else if (type === 'state') {
            id = 'addressStateId';
            section = 'countryCityStatesSection';
            label = '--- {{ __('user::frontend.addresses.form.select_state') }} ---';
        }

        var row = `<option value="">${label}</option>`;
        $.each(data, function(i, value) {
            row += `<optgroup label="${value.title}">`;
            $.each(value.states, function(inx, state) {
                row += `<option value="${state.id}">${state.title}</option>`;
            });
            row += `</optgroup>`;
        });
        $('#' + section).show();
        $('#' + id).html(row);
    }

    /* End - Address Country & City & State */
</script>
