@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendors.sorting.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.vendors.index')) }}">
                        {{__('vendor::dashboard.vendors.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('vendor::dashboard.vendors.sorting.title')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                  <div class="row">
                      <div class="profile-content">
                          <div class="portlet light">
                              <div class="portlet-body">
                                  <ul id="sortable" class="dd-list">
                                      @foreach ($vendors as $vendor)
                                      <li id="vendors-{{$vendor->id}}" class="dd-item">
                                          <div class="dd-handle"> {{$vendor->title}}</div>
                                      </li>
                                      @endforeach
                                  </ul>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-actions">
                              @include('apps::dashboard.layouts._ajax-msg')
                              <div class="form-group">
                                  <button type="button" id="submit" class="btn btn-lg blue re_order">
                                      {{__('apps::dashboard.general.sorting_btn')}}
                                  </button>
                                  <a href="{{url(route('dashboard.vendors.index')) }}" class="btn btn-lg red">
                                      {{__('apps::dashboard.general.back_btn')}}
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('scripts')

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
      $('.re_order').on('click', function(e) {

          var data = $('#sortable').sortable('serialize');

          $.ajax({

              url: '{{url(route('dashboard.vendors.store.sorting'))}}',
              type: 'GET',
              dataType: 'JSON',
              data:  data,
              contentType: false,
              cache: false,
              processData:false,
              success:function(data){
                  if (data[0] == true){
                      toastr["success"](data[1]);
                  }else{
                      console.log(data);
                      toastr["error"](data[1]);
                  }
              },
             error: function(data){
                  console.log(data);
              },
          });

      });

      $(document).ready(function () {
        $('#sortable').sortable();
      });
  </script>
@stop
