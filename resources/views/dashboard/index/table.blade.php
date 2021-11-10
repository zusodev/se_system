<table class="table table-striped table-bordered table-hover text-center">
    <thead>
    <tr>
        <th>部門名稱</th>
        <th>開啟信件人數</th>
        <th>點擊連結人數</th>
    </tr>
    </thead>
    <tbody>
    @forelse($groupOpenCounts as $item)
        <tr>
            <td>
                <a href="{{ route("email_jobs.show",[$item->job_id]) }}" target="_blank">{{ $item->name }}</a>
            </td>
            <td>{{ $item->open_count }} / {{ isZeroThenReplaceOne($item->users_count) }}</td>
            <td>{{ $item->open_link_count }} / {{ isZeroThenReplaceOne($item->users_count) }}</td>
        </tr>
    @empty
        @include("layouts.table-empty-row",["emptyColspan" => 5])
    @endforelse
    </tbody>
</table>
