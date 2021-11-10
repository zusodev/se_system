<?php /* @var App\Models\EmailTemplate $item */

/* @var Illuminate\Support\Collection $models */
?>
<div class="row m-b-10">
    <div class="col-md">
        <div class="float-left">
            總計 {{ $models->count() }} 筆資料
        </div>
    </div>
</div>
<br>
<div class="list-group">
    @foreach($models as $item)
        <a id="item-{{ $loop->index }}" href="#" onclick="clickItem(
            parseInt('{{ $item->id }}'),
            '{{ $item->name }}',
            '{{ $item->subject }}',
            `{{ $item->template  }}`,
            '{{ $item->attachment_name }}',
        {{ $loop->index }}
            )
            "
           class="list-group-item list-group-item-action">
            {{ $item->name }}
        </a>
    @endforeach
</div>
