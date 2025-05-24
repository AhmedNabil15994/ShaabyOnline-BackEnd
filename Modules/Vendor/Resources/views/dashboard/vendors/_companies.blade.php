<div class="tab-pane fade in" id="companies">
    <h3 class="page-title">{{__('vendor::dashboard.vendors.create.form.companies_and_states')}}</h3>
    <div class="col-md-12">

        <div class="form-group">
            <label class="col-md-2">
                {{__('vendor::dashboard.vendors.create.form.companies')}}
            </label>
            <div class="col-md-9">
                <select name="companies[]" class="form-control select2-allow-clear" multiple>
                    <option value=""></option>
                    @foreach ($companies as $company)
                        <option value="{{ $company['id'] }}"
                                {{ isset($vendor) ? (in_array($company['id'], $vendor->companies->pluck('id')->toArray()) ? 'selected' : '') : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <h5 class="" style="font-size: 16px;">{{__('vendor::dashboard.vendors.create.form.states')}}</h5>

        {{-- RIGHT SIDE --}}
        <div class="col-md-4">
            <div class="panel-group accordion scrollable">
                <div class="panel panel-default">
                    {{--<div class="panel-heading">
                        <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                    </div>--}}
                    <div id="collapse_2_1" class="panel-collapse in">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach ($cities as $key => $city)
                                    <li class="{{ $key == 0 ? 'active' : '' }}">
                                        <a href="#cities_{{ $key }}" data-toggle="tab">
                                            {{ $city->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PAGE CONTENT --}}
        <div class="col-md-8">
            <div class="tab-content">
                {{-- UPDATE FORM --}}
                @foreach ($cities as $key2 => $city2)
                    <div class="tab-pane fade in {{ $key2 == 0 ? 'active' : '' }}" id="cities_{{ $key2 }}">
                        <h3 class="page-title">
                            <span class="ml-4">{{ $city2->title }}</span>
                            <span class="">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" onclick="CheckAllStates('{{ $city2->id }}')"
                                           class="group-checkable">
                                    <span></span>
                                </label>
                           </span>
                        </h3>
                        <div class="col-md-12">
                            @foreach ($city2->states as $key3 => $state)
                                <div class="form-group">
                                    <label class="col-md-9">
                                        {{ $state->title }}
                                    </label>
                                    <div class="col-md-3">

                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox"
                                                   class="group-checkable states-checkbox-{{ $city2->id }}"
                                                   value="{{ $state->id }}"
                                                   name="states[]" {{ request()->route()->getName() == 'dashboard.vendors.edit' ? (in_array($state->id, $vendor->states->pluck('id')->toArray()) ? 'checked' : '') : '' }}>
                                            <span></span>
                                        </label>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                {{-- END UPDATE FORM --}}

            </div>
        </div>

    </div>
</div>