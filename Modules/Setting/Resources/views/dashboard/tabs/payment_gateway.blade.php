<div class="tab-pane fade" id="payment_gateway">

    <ul class="nav nav-tabs">
        @foreach (config('services.supportedPayments') ?? [] as $key => $value)
            <li class="@if ($loop->first) active @endif">
                <a data-toggle="tab"
                    href="#first_payment_{{ $key }}">{{ __('setting::dashboard.settings.form.supported_payments.form.methods.' . $key) }}</a>
            </li>
        @endforeach
    </ul>

    {{-- tab for content --}}
    <div class="tab-content">

        @foreach (config('services.supportedPayments') ?? [] as $key => $value)
            <div id="first_payment_{{ $key }}"
                class="tab-pane fade @if ($loop->first) in active @endif">

                @if ($key != 'cash')
                    <div class="row">
                        <div class="col-md-6 col-md-offset-4">

                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio mt-radio-outline">
                                            {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.test_mode') }}
                                            <input type="radio"
                                                name="supported_payments[{{ $key }}][payment_mode]"
                                                onchange="onChangePaymentMode('test_mode', '{{ $key }}')"
                                                value="test_mode" @if (config('setting.supported_payments.' . $key . '.payment_mode') != 'live_mode') checked @endif>
                                            <span></span>
                                        </label>
                                        <label class="mt-radio mt-radio-outline">
                                            {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.live_mode') }}
                                            <input type="radio"
                                                name="supported_payments[{{ $key }}][payment_mode]"
                                                onchange="onChangePaymentMode('live_mode', '{{ $key }}')"
                                                value="live_mode" @if (config('setting.supported_payments.' . $key . '.payment_mode') == 'live_mode') checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        @if (isset($value['keys']) && !empty($value['keys']))
                            @php
                                $currentMode = config('setting.supported_payments.' . $key . '.payment_mode') == 'live_mode' ? 'live_mode' : 'test_mode';
                            @endphp

                            <div class="col-md-7 col-md-offset-2" id="liveModelData-{{ $key }}"
                                style="display: {{ $currentMode == 'live_mode' ? 'block' : 'none' }}">
                                {{-- <h3 class="page-title text-center">{{ $key }} ( Live Mode )</h3> --}}
                                @foreach ($value['keys'] as $index => $k)
                                    <div class="form-group">
                                        <label>
                                            {{ __('setting::dashboard.settings.form.payment_gateway.upayment.' . $k) }}
                                        </label>
                                        <input type="text" class="form-control"
                                            name="supported_payments[{{ $key }}][live_mode][{{ $k }}]"
                                            value="{{ config('setting.supported_payments.' . $key . '.live_mode.' . $k) ?? '' }}" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-7 col-md-offset-2" id="testModelData-{{ $key }}"
                                style="display: {{ $currentMode == 'live_mode' ? 'none' : 'block' }}">
                                {{-- <h3 class="page-title text-center">{{ $key }} ( Test Mode )</h3> --}}
                                @foreach ($value['keys'] as $index => $k)
                                    @if ($currentMode == 'live_mode' || ($currentMode == 'test_mode' && $k != 'iban'))
                                        <div class="form-group">
                                            <label>
                                                {{ __('setting::dashboard.settings.form.payment_gateway.upayment.' . $k) }}
                                            </label>
                                            <input type="text" class="form-control"
                                                name="supported_payments[{{ $key }}][test_mode][{{ $k }}]"
                                                value="{{ config('setting.supported_payments.' . $key . '.test_mode.' . $k) ?? '' }}" />
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>
                    <hr>
                @endif

                <div class="row">
                    <div class="col-md-12">

                        @foreach (config('translatable.locales') as $code)
                            <div class="form-group">
                                <label class="col-md-2">
                                    {{ __('setting::dashboard.settings.form.supported_payments.form.title') }}
                                    - {{ $code }}
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control"
                                        name="supported_payments[{{ $key }}][title][{{ $code }}]"
                                        value="{{ config('setting.supported_payments.' . $key . '.title.' . $code) ?? '' }}" />
                                </div>
                            </div>
                        @endforeach

                        @if ($key == 'upayment')
                            <hr>

                            <div class="row">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="form-group">
                                        <div class="col-md-9">
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio mt-radio-outline">
                                                    {{ __('setting::dashboard.settings.form.payment_gateway.account_type.client_account') }}
                                                    <input type="radio"
                                                        name="supported_payments[{{ $key }}][account_type]"
                                                        onchange="onChangePaymentAccountType('client_account', '{{ $key }}')"
                                                        value="client_account"
                                                        @if (config('setting.supported_payments.' . $key . '.account_type') != 'vendor_account') checked @endif>
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline">
                                                    {{ __('setting::dashboard.settings.form.payment_gateway.account_type.vendor_account') }}
                                                    <input type="radio"
                                                        name="supported_payments[{{ $key }}][account_type]"
                                                        onchange="onChangePaymentAccountType('vendor_account', '{{ $key }}')"
                                                        value="vendor_account"
                                                        @if (config('setting.supported_payments.' . $key . '.account_type') == 'vendor_account') checked @endif>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content" id="vendorAccountSection-{{ $key }}"
                                style="display: {{ config('setting.supported_payments.' . $key . '.account_type') == 'vendor_account' ? 'block' : 'none' }}">
                                <ul class="nav nav-tabs">
                                    @foreach (config('services.knet_cc_commissions') as $index => $val)
                                        <li class="@if ($loop->first) active @endif">
                                            <a data-toggle="tab"
                                                href="#knet_cc_payment_commission_{{ $key }}_{{ $index }}">{{ $val }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                @foreach (config('services.knet_cc_commissions') as $index => $val)
                                    <div id="knet_cc_payment_commission_{{ $key }}_{{ $index }}"
                                        class="tab-pane fade @if ($loop->first) in active @endif">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('setting::dashboard.settings.form.supported_payments.form.commissions.fixed_app_commission') }}
                                                - {{ $index }}
                                            </label>
                                            <div class="col-md-7">
                                                <input type="number" step="0.01" min="0" class="form-control"
                                                    name="supported_payments[{{ $key }}][commissions][{{ $index }}][fixed_app_commission]"
                                                    value="{{ config('setting.supported_payments.' . $key . '.commissions.' . $index . '.fixed_app_commission') ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('setting::dashboard.settings.form.supported_payments.form.commissions.percentage_app_commission') }}
                                                - {{ $index }}
                                            </label>
                                            <div class="col-md-7">
                                                <input type="number" step="0.01" min="0" class="form-control"
                                                    name="supported_payments[{{ $key }}][commissions][{{ $index }}][percentage_app_commission]"
                                                    value="{{ config('setting.supported_payments.' . $key . '.commissions.' . $index . '.percentage_app_commission') ?? '' }}" />
                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                            </div>

                            <div class="tab-content" id="clientAccountSection-{{ $key }}"
                                style="display: {{ config('setting.supported_payments.' . $key . '.account_type') != 'vendor_account' ? 'block' : 'none' }}">
                                <ul class="nav nav-tabs">
                                    @foreach (config('services.knet_cc_commissions') as $index => $val)
                                        <li class="@if ($loop->first) active @endif">
                                            <a data-toggle="tab"
                                                href="#knet_cc_payment_client_commission_{{ $key }}_{{ $index }}">{{ $val }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                @foreach (config('services.knet_cc_commissions') as $index => $val)
                                    <div id="knet_cc_payment_client_commission_{{ $key }}_{{ $index }}"
                                        class="tab-pane fade @if ($loop->first) in active @endif">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('setting::dashboard.settings.form.supported_payments.form.commissions.commission_type') }}
                                                - {{ $index }}
                                            </label>
                                            <div class="col-md-7">
                                                <select class="form-control"
                                                    name="supported_payments[{{ $key }}][client_commissions][{{ $index }}][commission_type]">
                                                    <option value="fixed"
                                                        {{ config('setting.supported_payments.' . $key . '.client_commissions.' . $index . '.commission_type') == 'fixed' ? 'selected' : '' }}>
                                                        Fixed</option>
                                                    <option value="percentage"
                                                        {{ config('setting.supported_payments.' . $key . '.client_commissions.' . $index . '.commission_type') == 'percentage' ? 'selected' : '' }}>
                                                        Percentage</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('setting::dashboard.settings.form.supported_payments.form.commissions.commission') }}
                                                - {{ $index }}
                                            </label>
                                            <div class="col-md-7">
                                                <input type="number" step="0.01" min="0"
                                                    class="form-control"
                                                    name="supported_payments[{{ $key }}][client_commissions][{{ $index }}][commission]"
                                                    value="{{ config('setting.supported_payments.' . $key . '.client_commissions.' . $index . '.commission') ?? '' }}" />
                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        @endif

                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2">
                                {{ __('setting::dashboard.settings.form.status') }}
                            </label>
                            <div class="col-md-9">
                                <input type="checkbox" class="make-switch" data-size="small"
                                    {{ config('setting.supported_payments.' . $key . '.status') ? 'checked' : '' }}
                                    name="supported_payments[{{ $key }}][status]">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

    </div>
</div>
