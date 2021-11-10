<?php /* @var Illuminate\Contracts\Pagination\LengthAwarePaginator|App\Models\UploadFailedTargetUser[] $paginator */

?>

@component("layouts.table",[
    "paginator" => $paginator,
])
    @slot('trTitles')
        <th>#</th>
        <th>公司名稱</th>
        <th>Email</th>
        <th>上傳檔案名稱</th>
        <th>建立時間</th>
        <th>訊息</th>
    @endslot
    @forelse($paginator as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->company_name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->file_name }}</td>
            <td>{{ $item->uploaded_at }}</td>
            <td>{{ $item->reason }}</td>
        </tr>
    @empty
        @include("layouts.table-empty-row",["emptyColspan" => 7])
    @endforelse
@endcomponent
