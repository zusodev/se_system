@extends("layouts.base")
@section("content")
    <h5>{{ $name }}</h5>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h4 class="text-primary">已開始統計資料，請耐心稍候，完成後將自動下載</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $('document').ready(function () {
            let url = `{!! $downloadReportUrl !!}`;
            window.open(
                url,
                "_blank" // <- This is what makes it open in a new window.
            );
        });
    </script>
@endsection
