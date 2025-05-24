@foreach ($values as $value)
  <div class="form-group">
      <label class="col-md-2">
      </label>
      <div class="col-md-7">
        <input type="text" name="option_values[{{ $value->option_id }}][{{ $value->id }}]" class="form-control" value="{{$value->title}}" readonly>
      </div>
      <span class="input-group-btn">
          <a data-input="images" data-preview="holder" class="btn btn-danger delete_options">
              <i class="glyphicon glyphicon-remove"></i>
          </a>
      </span>
  </div>
@endforeach
