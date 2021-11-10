<?php /* @var  Illuminate\Support\ViewErrorBag $errors */
?>
@if (session("status"))
    <div class="card card-inverse-success" id="context-menu-access">
        <div class="card-body">
            <p class="card-text">{{ session("status") }}</p>
        </div>
    </div><br>
@elseif($errors->has("operation.message"))
    <div class="card card-inverse-danger" id="context-menu-access">
        <div class="card-body">
            <p class="card-text">{{ $errors->first("operation.message") }}</p>
        </div>
    </div><br>
@endif
