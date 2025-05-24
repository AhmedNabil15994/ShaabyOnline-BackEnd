<div class="form-group">
    <label class="col-md-2">
        {{ __('user::dashboard.users.create.form.address_details.country') }}
    </label>
    <div class="col-md-9">
        <select class="form-control select2 select2Input" name="country_id" id="addressCountryId">
            <option value="">
                --- {{ __('user::dashboard.users.create.form.address_details.country') }} ---
            </option>
            @if (isset($countries) && count($countries) > 0)
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}"
                        {{ old('country_id') == $country->id || $country->id == '1' ? 'selected' : '' }}>
                        {{ $country->title }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div id="countryCityStatesSection">
    <div class="form-group">
        <label class="col-md-2">
            {{ __('user::dashboard.users.create.form.address_details.city') }}
        </label>
        <div class="col-md-9">
            <select class="form-control select2 select2Input" name="state" id="addressStateId">
                <option value="">
                    --- {{ __('user::dashboard.users.create.form.address_details.city') }} ---
                </option>
                @foreach ($cityWithStates as $city)
                    <optgroup label="{{ $city->title }}">
                        @foreach ($city->states as $state)
                            <option value="{{ $state->id }}" {{ old('state') == $state->id ? 'selected' : '' }}>
                                {{ $state->title }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
</div>
