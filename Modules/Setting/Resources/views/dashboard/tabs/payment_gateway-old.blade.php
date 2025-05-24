<div class="tab-pane fade" id="payment_gateway">
    {{--<h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.payment_gateway') }}</h3>--}}

    <div class="row">
        <div class="col-md-6 col-md-offset-4">

            <div class="form-group">

                {{--<label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.title') }}
                </label>--}}

                <div class="col-md-9">
                    <div class="mt-radio-inline">
                        <label class="mt-radio mt-radio-outline">
                            {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.test_mode') }}
                            <input type="radio" name="payment_gateway[upayment][payment_mode]" value="test_mode"
                                   @if (config('setting.payment_gateway.upayment.payment_mode') != 'live_mode')
                                   checked
                                @endif>
                            <span></span>
                        </label>
                        <label class="mt-radio mt-radio-outline">
                            {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.live_mode') }}
                            <input type="radio" name="payment_gateway[upayment][payment_mode]" value="live_mode"
                                   @if (config('setting.payment_gateway.upayment.payment_mode') == 'live_mode')
                                   checked
                                @endif>
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-7 col-md-offset-2" id="testModelData"
             style="{{ config('setting.payment_gateway.upayment.payment_mode') == 'live_mode' ? 'display: none': 'display: block' }}">

            <h3 class="page-title text-center">UPayment Gateway ( Test Mode )</h3>
            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.merchant_id') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][MERCHANT_ID]"
                       value="{{ config('setting.payment_gateway.upayment.test_mode.MERCHANT_ID') ?? '' }}"/>
            </div>

            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.api_key') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][API_KEY]"
                       value="{{ config('setting.payment_gateway.upayment.test_mode.API_KEY') ?? '' }}"/>
            </div>

            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.username') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][USERNAME]"
                       value="{{ config('setting.payment_gateway.upayment.test_mode.USERNAME') ?? '' }}"/>
            </div>

            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.password') }}
                </label>
                <input type="text" class="form-control"
                       name="payment_gateway[upayment][test_mode][PASSWORD]"
                       value="{{ config('setting.payment_gateway.upayment.test_mode.PASSWORD') ?? '' }}"/>
            </div>

            {{--<div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.iban') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][IBAN]"
                       value="{{ config('setting.payment_gateway.upayment.test_mode.IBAN') ?? '' }}"/>
            </div>--}}

        </div>

        <div class="col-md-7 col-md-offset-2" id="liveModelData"
             style="{{ config('setting.payment_gateway.upayment.payment_mode') == 'live_mode' ? 'display: block': 'display: none' }}">

            <h3 class="page-title text-center">UPayment Gateway ( Live Mode )</h3>
            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.merchant_id') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][MERCHANT_ID]"
                       value="{{ config('setting.payment_gateway.upayment.live_mode.MERCHANT_ID') ?? '' }}"/>
            </div>

            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.api_key') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][API_KEY]"
                       value="{{ config('setting.payment_gateway.upayment.live_mode.API_KEY') ?? '' }}"/>
            </div>

            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.username') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][USERNAME]"
                       value="{{ config('setting.payment_gateway.upayment.live_mode.USERNAME') ?? '' }}"/>
            </div>

            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.password') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][PASSWORD]"
                       value="{{ config('setting.payment_gateway.upayment.live_mode.PASSWORD') ?? '' }}"/>
            </div>

            <div class="form-group">
                <label>
                    {{ __('setting::dashboard.settings.form.payment_gateway.upayment.iban') }}
                </label>
                <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][IBAN]"
                       value="{{ config('setting.payment_gateway.upayment.live_mode.IBAN') ?? '' }}"/>
            </div>

        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-7 col-md-offset-3">

            <div class="form-group">
                <label
                    class="col-md-3">{{ __('setting::dashboard.settings.form.payment_gateway.payment_types.title') }}</label>
                <div class="col-md-8">
                    <label class="checkbox-inline">
                        <input type="checkbox"
                               name="other[supported_payments][]"
                               @if (in_array('cash', config('setting.other.supported_payments') ?? []))
                               checked
                               @endif
                               value="cash"> {{ __('setting::dashboard.settings.form.payment_gateway.payment_types.cash') }}
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox"
                               name="other[supported_payments][]"
                               @if (in_array('online', config('setting.other.supported_payments') ?? []))
                               checked
                               @endif
                               value="online"> {{ __('setting::dashboard.settings.form.payment_gateway.payment_types.online') }}
                    </label>
                </div>
            </div>

        </div>
    </div>

</div>
