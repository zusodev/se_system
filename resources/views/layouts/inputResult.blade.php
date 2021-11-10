<?php /* @var  Illuminate\Support\ViewErrorBag $errors */?>
@if($errors->any())
<div class="row" style="margin: 5px 5px;">
    <div class="col-md-8">
        <ol>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
</div>
@endif
