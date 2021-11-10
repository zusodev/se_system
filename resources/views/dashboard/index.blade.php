
@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <a class="card" >
                <div class="card-body text-center">
                    <div class="text-primary mb-2">
                        <i class="mdi mdi-account-multiple mdi-36px"></i>
                    </div>
                    <h1 class="font-weight-light" style="color:#777">{{ $companyCount }}</h1>
                    <p class="mb-0 text-primary">公司數量</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <a class="card" >
                <div class="card-body text-center">
                    <div class="text-danger mb-2">
                        <i class="mdi mdi-account mdi-36px"></i>
                    </div>
                    <h1 class="font-weight-light" style="color:#777">{{ $userCount }}</h1>
                    <p class="mb-0 text-danger">全人員數量</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <a class="card" >
                <div class="card-body text-center">
                    <div class="text-info mb-2">
                        <i class="mdi mdi-checkbox-multiple-marked mdi-36px"></i>
                    </div>
                    <h1 class="font-weight-light" style="color:#777">{{ $projectCount }}</h1>
                    <p class="mb-0 text-info">專案數量</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <a class="card" >
                <div class="card-body text-center">
                    <div class="text-success mb-2">
                        <i class="mdi mdi-email-outline mdi-36px"></i>
                    </div>
                    <h1 class="font-weight-light" style="color:#777">{{ $emailLogCount }}</h1>
                    <p class="mb-0 text-success">總寄信量</p>
                </div>
            </a>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>近十次專案統計</h5>

                    <ul>
                        <li>
                            統計數為即時計算，倘若專案仍在發信中，則計算數字將會異動，直至所有信件發信完畢。
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>專案 ID & 名稱</th>
                                <th>公司</th>
                                <th>參與總人數</th>
                                <th>開啟信件數</th>
                                <th>開啟連結數</th>
                                <th>開啟附件數</th>
                                <th>提交表單數</th>
                                <th>無異常數</th>
                                <th>執行日期</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($emailProjects as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route("email_jobs.index",["project_id" => $item->id]) }}" target="_blank">
                                                ({{ $item->id }}) {{ $item->name }}
                                            </a>
                                        </td>
                                        <td>{{ $item->company_name }}</td>
                                        <td>
                                            <a href="{{ route("email_logs.index",["project_id" => $item->id]) }}">
                                                {{ $item->user_count }}
                                            </a>
                                        </td>
                                        <td>{{ $item->open_count }}</td>
                                        <td>{{ $item->open_link_count }}</td>
                                        <td>{{ $item->open_attachment_count }}</td>
                                        <td>{{ $item->post_count }}</td>
                                        <td>{{ $item->none_count }}</td>
                                        <td>{{ $item->start_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')

@endsection


