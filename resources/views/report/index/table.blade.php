<?php /* @var App\Models\EmailProject[]|Illuminate\Pagination\AbstractPaginator $paginator */
/** @var App\Models\EmailProject $item */
?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th>專案 ID & 名稱</th>
        <th>公司</th>
        <th>參與總人數</th>
        <th>開啟信件數</th>
        <th>開啟連結數</th>
        <th>開啟附件數</th>
        <th>提交表單數</th>
        <th>無異常數</th>
        <th>操作</th>
    @endslot
    @forelse($paginator as $item)
        <tr>
            <td>
                <a href="{{ route("email_jobs.index",["project_id" => $item->id]) }}" target="_blank">
                    ({{ $item->id }}) {{ $item->name }}
                </a>
            </td>
            <td>{{ $item->company_name }}</td>
            <td>
                <a href="{{ route("email_logs.index",["project_id" => $item->id]) }}">
                    {{ $item->user_count }}
                </a>
            </td>
            <td>{{ $item->open_count }}</td>
            <td>{{ $item->open_link_count }}</td>
            <td>{{ $item->open_attachment_count }}</td>
            <td>{{ $item->post_count }}</td>
            <td>{{ $item->none_count }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-info"
                        onclick="openDownloadModal(`{{$item->id}}`)">
                    下載
                </button>
            </td>
        </tr>
    @empty
        @include("layouts.table-empty-row")
    @endforelse
@endcomponent




