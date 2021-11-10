<?php /* @var App\Models\EmailLog[]|Illuminate\Contracts\Pagination\LengthAwarePaginator $logPaginator */ ?>
<?php /* @var App\Models\EmailLog $item */ ?>


@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th style="width: 10%">人員名稱</th>
        <th style="width: 20%;">Email</th>
        <th style="width: 10%">是否發信</th>
        <th style="width: 10%">開啟信件</th>
        <th style="width: 10%">開啟連結</th>
        <th style="width: 10%">開啟附件</th>
        <th style="width: 10%">提交表單</th>
        <th style="width: 20%">操作</th>
    @endslot
    @forelse($paginator as $item)
        <?php $input = ["company_id" => $item->id]; ?>
        <tr>
            <td>{{ $item->user_name }}</td>
            <td>{{ $item->email }}</td>
            <td>
                @if($item->is_send)
                    <span class="badge badge-success">YES</span>
                @else
                    <span class="badge badge-secondary">NO</span>
                @endif
            </td>
            <td>
                @if($item->is_open)
                    <span class="badge badge-success">YES</span>
                @else
                    <span class="badge badge-secondary">NO</span>
                @endif
            </td>
            <td>
                @if($item->is_open_link)
                    <span class="badge badge-success">YES</span>
                @else
                    <span class="badge badge-secondary">NO</span>
                @endif
            </td>
            <td>
                @if($item->is_open_attachment)
                    <span class="badge badge-success">YES</span>
                @else
                    <span class="badge badge-secondary">NO</span>
                @endif
            </td>
            <td>
                @if($item->is_post_from_website)
                    <span class="badge badge-success">YES</span>
                @else
                    <span class="badge badge-secondary">NO</span>
                @endif
            </td>
            <td>
                <a class="btn btn-sm text-white btn-primary m-1"
                   href="{{ route("email_logs.show.detail", $item->id) }}">
                    詳細資訊
                </a>
            </td>
        </tr>
    @empty
        @include("layouts.table-empty-row")
    @endforelse
@endcomponent
