<div class="row">
    <div class="col-md-12 col-12">

        @php
            $checkCountryInFees = !is_null(Cart::getCondition('company_delivery_fees')) && isset(Cart::getCondition('company_delivery_fees')->getAttributes()['country_id']) ? Cart::getCondition('company_delivery_fees')->getAttributes()['country_id'] : null;
        @endphp

        <div class="form-group">
            <select class="select-detail" name="country_id" id="addressCountryId">
                <option value="">
                    --- {{ __('user::frontend.addresses.form.select_country') }} ---
                </option>
                @if (isset($countries) && count($countries) > 0)
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ old('country_id') == $country->id || (!is_null($checkCountryInFees) && $checkCountryInFees == $country->id) ? 'selected' : '' }}>
                            {{ $country->title }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- <div id="countryCitiesSection" style="display: none">
            <div class="form-group">
                <select class="select-detail" name="city_id"
                        id="addressCityId">
                    <option value="">
                        --- {{ __('user::frontend.addresses.form.select_city') }} ---
                    </option>
                </select>
            </div>
        </div>

        <div id="countryCityStatesSection" style="display: none">
            <div class="form-group">
                <select class="select-detail" name="state_id"
                        id="addressStateId">
                    <option value="">
                        --- {{ __('user::frontend.addresses.form.select_state') }} ---
                    </option>
                </select>
            </div>
        </div> --}}

        <div id="countryStateLoader" style="display: none; font-weight: bold; text-align: center; margin-bottom: 20px;">
            {{ __('apps::frontend.general.loader') }}
        </div>

        <div id="countryCityStatesSection"
            style="display: {{ old('state_id') || !is_null(Cart::getCondition('company_delivery_fees')) ? 'block' : 'none' }}">
            <div class="form-group">
                <select class="select-detail" name="state_id" id="addressStateId">
                    <option value="">
                        --- {{ __('user::frontend.addresses.form.select_state') }} ---
                    </option>
                    @if (isset($citiesWithStatesDelivery) && count($citiesWithStatesDelivery) > 0)
                        @foreach ($citiesWithStatesDelivery as $city)
                            <optgroup label="{{ $city->title }}">
                                @foreach ($city->states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('state_id') == $state->id || (!is_null(Cart::getCondition('company_delivery_fees')) && Cart::getCondition('company_delivery_fees')->getAttributes()['state_id'] == $state->id) ? 'selected' : '' }}>
                                        {{ $state->title }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

    </div>
</div>
