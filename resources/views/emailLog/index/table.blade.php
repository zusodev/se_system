<?php /* @var App\Models\EmailLog[]|Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */ ?>



@component('layouts.table', ["paginator" => $paginator, 'hidden_footer' => true])
    @slot("trTitles")
        <th style="width: 20%">名稱 & 部門</th>
        <th style="width: 20%;">Email</th>
        <th style="width: 10%">是否發信</th>
        <th style="width: 10%">開啟信件</th>
        <th style="width: 10%">開啟連結</th>
        <th style="width: 10%">開啟附件</th>
        <th style="width: 10%">提交表單</th>
        <th style="width: 20%">
            <div class="custom-control custom-checkbox" style="display: inline">

                <input id="check_all" name="check_all"
                       type="checkbox" class="custom-control-input">

                <label class="custom-control-label" for="check_all">全選</label>
            </div>
        </th>
    @endslot
    @forelse($paginator as $item)
        <tr>
            <td>{{ $item->user_name }}( {{$item->department_name}} )</td>
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
                @if(!$item->is_send)
                    <div class="custom-control custom-checkbox">
                        <input id="{{$item->uuid}}" name="ids[]"
                               type="checkbox" class="ids custom-control-input"
                               value="{{$item->uuid}}">
                        <label class="custom-control-label" for="{{$item->uuid}}">重新寄信</label>
                    </div>
                @endif
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


