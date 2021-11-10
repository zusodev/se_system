<?php /* @var App\Models\PhishingWebsite[]|Illuminate\Pagination\AbstractPaginator $paginator */
/** @var App\Models\PhishingWebsite $item */
?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th>#</th>
        <th>樣式名稱</th>
        <th>使用專案數</th>
        <th>表單接收驗證狀態</th>
        <th>操作</th>
    @endslot
    @forelse($paginator as $item)

        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->project_count }}</td>
            <td>
                @if($item->received_form_data_is_ok)
                    <span class="badge badge-pill badge-success">驗證成功</span>
                @else
                    <span class="badge badge-pill badge-warning">尚未驗證成功</span>
                @endif
            </td>
            <td>
                <a class="btn btn-sm text-white btn-primary m-1"
                    target="_blank"
                   href="{{ route("phishing_websites.show", [$item->id]) }}">
                    Demo & 驗證
                </a>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("phishing_websites.edit", [$item->id]) }}">
                    編輯
                </a>
                @if(!$item->project_count)
                <a class="btn btn-sm text-white btn-danger m-1" href="#"
                        @click="showDeleteModal(`{{ $item->id }}`, `{{ $item->name }}`)">
                    刪除
                </a>
                @endif
            </td>
        </tr>
    @empty
        @include("layouts.table-empty-row")
    @endforelse
@endcomponent




