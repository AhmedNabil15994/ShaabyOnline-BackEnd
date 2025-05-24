<div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="modalLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="modalLabel-{{ $item->id }}">{{ __('catalog::dashboard.products.form.tabs.add_ons') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.add_ons_name')}} :
                    <b>{{ $item->name }}</b></div>
                <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.type')}} :
                    <b>{{ $item->type == 'single' ?  __('catalog::dashboard.products.form.add_ons.single') : __('catalog::dashboard.products.form.add_ons.multiple') }}</b>
                </div>
                <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.options_count')}} :
                    <b>{{ $item->options_count ?? '---' }}</b></div>
                <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.created_at')}} :
                    <b>{{ $item->created_at }}</b>
                </div>
                <br>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('catalog::dashboard.products.form.add_ons.option')}}</th>
                        <th>{{__('catalog::dashboard.products.form.add_ons.price')}}</th>
                        <th>{{__('catalog::dashboard.products.form.add_ons.default')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($item->addOnOptions as $k => $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->option }}</td>
                            <td>{{ $value->price }}</td>
                            <td>
                                {{ $value->default == null ? __('apps::dashboard.general.no_btn') : __('apps::dashboard.general.yes_btn') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{__('apps::dashboard.general.close_btn')}}</button>
            </div>
        </div>
    </div>
</div>
