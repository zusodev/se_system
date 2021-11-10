<?php
/* @var App\Models\TargetUser[]|Illuminate\Pagination\AbstractPaginator $paginator */
/** @var App\Models\TargetUser $item $input */
?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th>#</th>
        <th>人員名稱</th>
        <th>電子信箱</th>
        <th>部門</th>
        <th>操作</th>
    @endslot
    @foreach($paginator as $item)
        <?php
        $input = ["company_id" => $item->id];
        ?>
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->department_name }}</td>
            <td>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("target_users.edit", [$item->id]) }}">
                    編輯
                </a>
                @if(!$item->email_log_count)
                <a class="btn btn-sm text-white btn-danger m-1"
                   @click="showDeleteModal(`{{ $item->id }}`, `{{ $item->name }}`)">
                    刪除
                </a>
                @endif
            </td>
        </tr>
    @endforeach
@endcomponent
