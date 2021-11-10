<?php /* @var App\Models\EmailJob[]|Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */ ?>


@component('layouts.table', ["paginator" => $paginator])
    @slot("trTitles")
        <th>#</th>
        <th>部門</th>
        <th>目前寄信人數/總人數</th>
        <th>狀態</th>
        <th>建立時間</th>
        <th>操作</th>
    @endslot
    @php
        $now = now();
    @endphp
    @forelse($paginator as $item)
        <tr style="font-size: 18px;">
            <td>{{ $item->id }}</td>
            <td>{{ $item->department_name }}</td>
            <td>{{ $item->send_total }} / {{ $item->expected_send_total }}</td>
            <td>
                {!! App\Presenters\EmailJobPresenter::statusText($item->status) !!}
            </td>
            <td>{{ $item->created_at }}</td>
            <td>
                <a class="btn btn-sm text-white btn-primary" href="{{ route("email_jobs.show",[$item->id]) }}">
                    詳細資訊
                </a>
            </td>
        </tr>
    @empty
        @include("layouts.table-empty-row")
    @endforelse
@endcomponent
