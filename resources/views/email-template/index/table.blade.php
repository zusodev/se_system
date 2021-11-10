<?php /* @var App\Models\PhishingWebsite[]|Illuminate\Pagination\AbstractPaginator $paginator */
/** @var App\Models\PhishingWebsite $item */
?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th>#</th>
        <th>樣式名稱</th>
        <th>使用專案數</th>
        <th>操作</th>
    @endslot
    @forelse($paginator as $item)

        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->project_count }}</td>

            <td>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("email_templates.edit", [$item->id]) }}">
                    編輯
                </a>
                @if(!$item->project_count)
                <a class="btn btn-sm text-white btn-danger m-1" href="#"
                        @click="showDeleteModal(`{{ $item->id }}`, `{{ $item->name }}`)">
                    刪除
                </a>
                @endif
                <button type="button" class="btn btn-warning btn-sm" onclick="openModal(`{{ $item->id }}`)">寄送測試信件</button>
            </td>
        </tr>
    @empty
        @include("layouts.table-empty-row")
    @endforelse
@endcomponent




