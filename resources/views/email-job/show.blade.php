@extends('layouts.base')
<?php
/* @var App\Models\EmailJob $emailJob */
/* @var App\Models\EmailProject $project */
/* @var App\Models\EmailLog[]|Illuminate\Contracts\Pagination\LengthAwarePaginator $logPaginator */
?>
@section('content')
    <h4> 專案名稱
        <span class="badge badge-primary badge-pill " style="font-size: 1.2rem">
            {{ $emailJob->project_name }}
        </span>
    </h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <canvas id="chart" style="height:40vh; width:60vw"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br>
    <form>
        <div class="card">
            <div class="card-body">
                <form>
                    @include("email-job.show.new-form",[
                            "name" => $project->name,
                            "sender_name" => $project->sender_name,
                            "description" => $project->description,
                            "sender_email" => $project->sender_email,

                            "email_tempalte_name" => $project->emailTemplate->name,
                            "website_name" => $project->phishing_website_id ? $project->website->name :'',

                            "start_at" => $project->start_at->format("Y-m-d\TH:i"),
                            "log_redirect_to" => $project->log_redirect_to,
                        ])
                </form>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h6>
                        公司
                        <span class="badge badge-primary badge-pill " style="font-size: 1.2rem">
            {{ $emailJob->company_name }}
        </span>
                        部門名稱
                        <span class="badge badge-primary badge-pill " style="font-size: 1.2rem">
            {{ $emailJob->department_name }}
        </span>
                    </h6>
                </div>
            </div>
            <div class="row">
                @include("email-job.show.table",["paginator" => $logPaginator])
            </div>
        </div>
    </div>
    {{--@include("emailJob.show.detailModal")--}}
@endsection

@section('javascript')
    <script src="{{ asset("js/vue.min.js") }}"></script>
    <script src="{{ asset("js/chart.js") }}"></script>

    <script>
        $('input').attr('disabled', true);
        $('textarea').attr('disabled', true);


        const backgroundColor = ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"];

        const borderColor = ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"];

        new Chart(document.getElementById("chart"), {
            "type": "bar",
            "data": {
                "labels": [
                    "開啟信件", "開啟連結", "開啟附件", "填寫表單"],
                "datasets": [{
                    "label": `{{ $emailJob->department_name }} 部門統計`,
                    "data": JSON.parse(`@json($chartData)`),
                    "fill": false,
                    backgroundColor,
                    borderColor,
                    "borderWidth": 1
                }]
            },
            "options": {"scales": {"yAxes": [{"ticks": {"beginAtZero": true}}]}}
        });
    </script>
@endsection
