<form id="form" role="form" data-name="addressesForm" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data"
    action="{{ route('dashboard.user_addresses.store') }}">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id ?? null }}">

    <div class="modal-body">

        <div class="row">

            <div class="col-md-12">

                @include('area::dashboard.shared._area_tree')

                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.username') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="username" class="form-control" data-name="username">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.email') }}
                    </label>
                    <div class="col-md-9">
                        <input type="email" name="email" class="form-control" data-name="email">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.mobile') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="mobile" class="form-control" data-name="mobile">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.block') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="block" class="form-control" data-name="block">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.building') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="building" class="form-control" data-name="building">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.street') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="street" class="form-control" data-name="street">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.avenue') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="avenue" class="form-control" data-name="avenue">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.floor') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="floor" class="form-control" data-name="floor">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.flat') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="flat" class="form-control" data-name="flat">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.automated_number') }}
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="automated_number" class="form-control" data-name="automated_number">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('user::dashboard.users.create.form.address_details.address') }}
                    </label>
                    <div class="col-md-9">
                        <textarea rows="4" name="address" class="form-control" data-name="address"></textarea>
                        <div class="help-block"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="modal-footer" style="text-align: {{ locale() == 'ar' ? 'right': 'left' }}">
        @include('apps::dashboard.layouts._ajax-msg')
        <button type="submit" id="submit"
            class="btn green">{{ __('apps::dashboard.general.add_save') }}</button>
        <button type="button" class="btn dark btn-outline"
            data-dismiss="modal">{{ __('apps::dashboard.general.close_btn') }}</button>
    </div>
</form>
