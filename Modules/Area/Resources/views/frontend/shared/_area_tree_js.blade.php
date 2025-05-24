<script>
    /* Start - Address Country & City & State */
    $('#addressCountryId').on('select2:select', function(e) {
        var data = e.params.data;
        if (data.id == '') {
            $('#addressCityId').empty().html(
                `<option value="">--- {{ __('user::frontend.addresses.form.select_city') }} ---</option>`);
            $('#addressStateId').empty().html(
                `<option value="">--- {{ __('user::frontend.addresses.form.select_state') }} ---</option>`);
            $('#countryCitiesSection').hide();
            $('#countryCityStatesSection').hide();

        } else {
            getChildAreasByParent(data.id, 'city_with_states');
        }
    });

    $('#addressCityId').on('select2:select', function(e) {
        var data = e.params.data;
        if (data.id == '') {
            $('#addressStateId').empty().html(
                `<option value="">--- {{ __('user::frontend.addresses.form.select_state') }} ---</option>`);
            $('#countryCityStatesSection').hide();
        } else {
            getChildAreasByParent(data.id, 'state');
        }
    });

    $('#addressStateId').on('select2:select', function(e) {
        var data = e.params.data;
        @if (request()->route()->getName() == 'frontend.checkout.index' && auth()->guest())
            getDeliveryPriceOnStateChanged(data.id);
        @endif
    });

    function getChildAreasByParent(parentId, type = 'city') {
        let data = {
            'parent_id': parentId,
            'type': type,
        };

        $.ajax({
            method: "GET",
            url: '{{ route('frontend.area.get_child_area_by_parent') }}',
            data: data,
            beforeSend: function() {
                $('#countryStateLoader').show();
            },
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
        } else if (type === 'state' || type == 'city_with_states') {
            id = 'addressStateId';
            section = 'countryCityStatesSection';
            label = '--- {{ __('user::frontend.addresses.form.select_state') }} ---';
        }

        var row = `<option value="">${label}</option>`;
        $.each(data, function(inx, val) {
            row += `<optgroup label="${val.title}">`;
            $.each(val.states, function(i, value) {
                row += `<option value="${value.id}">${value.title}</option>`;
            });
            row += `</optgroup>`;
        });
        $('#countryStateLoader').hide();
        $('#' + section).show();
        $('#' + id).html(row);
    }

    /* End - Address Country & City & State */

    /* Start - Checkout - Calculate Delivery Charge Based On State */
    function getDeliveryPriceOnStateChanged(stateId, addressId = null) {
        var type = 'selected_state',
            data = {
                'state_id': stateId,
                'address_id': addressId,
                'company_id': $("input[name='shipping_company[id]']").val(),
                'type': type,
            };
        getDeliveryPrice(data, stateId, type);
    }

    function getDeliveryPrice(data, stateId, type, vendorId = null, companyId = null) {

        $('#deliveryPriceLoaderDiv').show();
        var deliveryPriceRow;

        $.ajax({
            method: "GET",
            url: '{{ route('frontend.checkout.get_state_delivery_price') }}',
            data: data,
            beforeSend: function() {},
            success: function(data) {
                var totalCompaniesDeliveryPrice = $('#totalCompaniesDeliveryPrice');

                if (type === 'selected_state') {

                    $('.checkedCompanyInput').prop('checked', false);
                    $('.checkedCompany').removeClass("cut-radio-style");
                    $('.checkedCompany').attr('data-state', 0);
                    $(".vendor-company-input").val('');

                    deliveryPriceRow = `
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.shipping') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="totalDeliveryPrice">${data.data.totalDeliveryPrice} {{ __('apps::frontend.master.kwd') }}</span>
                                </div>
                                `;
                    totalCompaniesDeliveryPrice.html(deliveryPriceRow);

                } else {

                    if (data.data.price != null) {
                        deliveryPriceRow = `
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.shipping') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="totalDeliveryPrice">${data.data.totalDeliveryPrice} {{ __('apps::frontend.master.kwd') }}</span>
                                </div>
                                `;
                        totalCompaniesDeliveryPrice.html(deliveryPriceRow);
                    }

                }

            },
            error: function(data) {
                $('#deliveryPriceLoaderDiv').hide();
                // $('#btnCheckoutSaveInformation').show();
                displayErrorsMsg(data);

                var getJSON = $.parseJSON(data.responseText);

                if (getJSON.data.price == null) {

                    if (type !== 'selected_state') {
                        $('#check-vendor-company-' + vendorId + '-' + companyId).prop('checked', false);
                        $('.checkout-company-' + vendorId).removeClass("cut-radio-style");
                        $("input[name='vendor_company[" + vendorId + "]']").val('');
                    }

                    var totalCompaniesDeliveryPrice = $('#totalCompaniesDeliveryPrice');
                    deliveryPriceRow = `
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.shipping') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="totalDeliveryPrice">${data.data.totalDeliveryPrice} {{ __('apps::frontend.master.kwd') }}</span>
                                </div>
                                `;
                    totalCompaniesDeliveryPrice.html(deliveryPriceRow);
                }
            },
            complete: function(data) {
                $('#deliveryPriceLoaderDiv').hide();
                var getJSON = $.parseJSON(data.responseText);
                if (getJSON.data) {
                    $('#cartTotalAmount').html(getJSON.data.total +
                        " {{ __('apps::frontend.master.kwd') }}");
                }
            },
        });
    }

    /* End - Checkout - Calculate Delivery Charge Based On State */
</script>
