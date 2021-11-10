<?php /* @var App\Models\TargetCompany[]|Illuminate\Pagination\AbstractPaginator $paginator */
/** @var App\Models\TargetCompany $item */
?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th style="width: 5%">#</th>
        <th style="width: 30%;">名稱</th>
        <th style="width: 10%;">總部門</th>
        <th style="width: 10%;">總人數</th>
        <th style="width: 20%;">建立時間</th>
        <th style="width: 25%;">操作</th>
    @endslot
    @forelse($paginator as $item)
        <?php
        $input = ["company_id" => $item->id];
        ?>
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>
                <a target="_blank" href="{{ route("target_departments.index", $input) }}">
                    共 {{ !empty($countMap[$item->id]) ? $countMap[$item->id]->department_count : 0 }} 個
                </a>
            </td>
            <td>
                <a target="_blank" href="{{ route("target_users.index", $input) }}">
                    共 {{ !empty($countMap[$item->id]) ? $countMap[$item->id]->user_count : 0 }} 人
                </a>
            </td>
            <td>{{ $item->created_at }}</td>
            <td>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("target_companys.edit", [$item->id]) }}">
                    編輯
                </a>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("target_users.upload.create", [$item->id]) }}">
                    名單上傳
                </a>
                @if(empty($countMap[$item->id]))
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




