<?php /** @var App\Models\EmailProject[]|Illuminate\Pagination\AbstractPaginator $paginator */
?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th>專案ID</th>
        <th>名稱</th>
        <th>目標公司</th>
        <th>參與演練部門</th>
        <th>執行時間</th>
        <th>建立時間</th>
        {{--<th >操作</th--}}
    @endslot
    @forelse($paginator as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->company_name }}</td>
            <td>
                <a target="_blank" href="{{ route("email_jobs.index", ["project_id" => $item->id]) }}">
                    共 {{ $item->job_count }} 個
                </a>
            </td>
            <td>
            @if($item->start_at > now())
                    剩餘 {{ now()->diffInMinutes($item->start_at) }} 分鐘
                @else
                    {{ $item->start_at }}
                @endif
            </td>
            <td>{{ $item->created_at }}</td>
            {{--<td>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("target_companys.edit", [$item->id]) }}">
                    編輯
                </a>
                <a class="btn btn-sm text-white btn-danger m-1" href="#"
                        @click="showDeleteModal(`{{ $item->id }}`, `{{ $item->name }}`)">
                    刪除
                </a>
            </td>--}}
        </tr>
    @empty
        @include("layouts.table-empty-row")
    @endforelse
@endcomponent




