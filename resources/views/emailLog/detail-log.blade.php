<?php
/* @var App\Models\EmailDetailLog[]|Illuminate\Database\Eloquent\Collection $detailLogs */
/** @var App\Models\EmailLog $log */
?>
@extends('layouts.base')
@section('content')
    <h3> Log 詳細資訊 </h3>
    <div class="card">
        <div class="card-body">
            <div class="row m-b-10">
                <div class="col-md">
                    <h4 class="card-title text-left"> 總計 {{ $detailLogs->count() }} 筆資料</h4>
                </div>
            </div>
            <h5>UUID：{{ $log->uuid }}</h5>
            <h5>使用者名稱：{{ $log->targetUser->name }}</h5>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>行為</th>
                    <th>建立時間</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($detailLogs as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{!! $item->actionHtml() !!}</td>
                        <td>{{ $item->created_at->format("Y-m-d H:i:s") }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"
                                    @click="showInfoModal('IPv4 Address', `{{ $item->ips }}`, true)">
                                顯示 IPv4 Address
                            </button>
                            <button class="btn btn-sm btn-outline-primary"
                                    @click="showInfoModal('User Agent', `{{ $item->agent }}`, false)">
                                顯示 User Agent
                            </button>
                            @if($item->action == 'is_post_from_website')
                                <button class="btn btn-sm btn-outline-primary"
                                        @click="showInfoModal('表單數值', `{{ $item->request_body }}`, true)">
                                    顯示表單數值
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    @include("layouts.table-empty-row",["emptyColspan" => 8])
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3>@{{ type }}</h3>
            <div>
                <pre class="d-block p-2 bg-dark text-white">@{{ values }}</pre>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset("js/vue.min.js") }}"></script>
    <script>
        function jsonPretty(json) {
            console.log('jsonPretty');
            return JSON.stringify(json, null, "\t");
        }
        new Vue({
            el: "#layout-content",
            data: {
                type: ``,
                values: ``,
            },
            methods: {
                /****************
                 * 以下為刪除功能 *
                 ***************/
                showInfoModal(type, values, isJsonString) {
                    this.type = type;
                    this.values = isJsonString ? jsonPretty(JSON.parse(values)) : values;

                    $("#info-modal").modal();
                },
            }
        });
    </script>
@endsection
