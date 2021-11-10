<?php /* @var App\Models\User[]|Illuminate\Database\Eloquent\Collection $paginator */
/** @var App\Models\User $item */
?>

@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th>#</th>
        <th>管理者名稱</th>
        <th>電子信箱</th>
        <th>建立時間</th>
        <th>操作</th>
    @endslot
    @forelse($paginator as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->created_at }}</td>
            <td>
                <a class="btn btn-sm text-white btn-primary" style="cursor: pointer" href="{{ route("users.edit",[$item->id]) }}">
                    編輯
                </a>
                <a class="btn btn-sm text-white btn-danger" style="cursor: pointer" @click="showDeleteModal(`{{ $item->id }}`, `{{ $item->name }}`)">
                    刪除
                </a>
            </td>
        </tr>
    @empty
        @include("layouts.table-empty-row")
    @endforelse
@endcomponent
