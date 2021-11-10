<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>名稱</th>
    </tr>
    </thead>
    <tbody>
    @forelse($files as $item)
        <tr>
            <td>
                <a href="{{ route("system_logs.index", ["fileName" => $item]) }}">{{ $item }}</a>
            </td>
        </tr>
    @empty
        @include("layouts.table-empty-row",["emptyColspan" => 2])
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <th>名稱</th>
    </tr>
    </tfoot>
</table>
