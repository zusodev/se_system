<?php /* @var App\Models\TargetDepartment[]|Illuminate\Pagination\AbstractPaginator $paginator */ ?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th style="width: 15%">#</th>
        <th style="width: 40%;">部門名稱</th>
        <th style="width: 15%;">部門人數</th>
        <th style="width: 10%">測試部門</th>
        <th style="width: 20%;">操作</th>
    @endslot
    @forelse($paginator as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>
                <a target="_blank" href="{{ route("target_users.index", ["department_id" => $item->id]) }}">
                    共 {{ $item->target_user_count }} 人
                </a>
            </td>
            <td>
                @if($item->is_test)
                    <span class="badge badge-success">YES</span>
                @else
                    <span class="badge badge-secondary">NO</span>
                @endif
            </td>
            <td>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("target_departments.edit", [$item->id]) }}">
                    編輯
                </a>
                @if(!$item->target_user_count && !$item->emailJobs()->count())
                    <a class="btn btn-sm text-white btn-danger m-1"
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
