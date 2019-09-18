@if (count($errors) > 0)
<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h5 class="center">
    <b>Error:</b>
  </h5>
    <ul>
      @foreach ($errors->all() as $error)
        <li class="center">
          <i class="fa fa-exclamation-circle"></i>
          <strong>{{ $error }}</strong>
        </li>
      @endforeach
    </ul>
</div>
@endif
