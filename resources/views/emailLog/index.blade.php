@php /** @var App\Models\EmailProject $selectedProject */
@endphp
@extends('layouts.base')
@section('content')
    <h3> 重新寄件 Log 列表 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            @component("email-project.layout.belong-header",["project" => $selectedProject])
                <p></p>
            @endcomponent
            <hr>
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="project_id" class="col-sm-3 col-form-label">專案：</label>
                            <div class="col-sm-9">
                                <select id="project_id" name="project_id"
                                        class="form-control">
                                    <?php /* @var App\Models\EmailProject[] $projects */ ?>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}"
                                                @if($project->id == $selectedProject->id) selected @endif>
                                            (ID：{{ $project->id }}){{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <div class="custom-control custom-checkbox">
                                <input id="is_not_send" name="is_not_send"
                                       type="checkbox" class="custom-control-input"
                                       @if(request("is_not_send")) checked @endif>
                                <label class="custom-control-label" for="is_not_send">尚未寄信/寄件失敗</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">搜尋</button>
            </form>
            <hr>
            <br>
            <form method="post" action="{{ route("email_logs.resend.log", request()->input()) }}">
                @csrf
                @include("emailLog.index.table")
                <button type="submit" class="btn btn-primary">寄送</button>
            </form>
        </div>
    </div>
@endsection
@section('javascript')

    <script>
        $("#check_all").change(function (event) {
            console.log('event');
            $('.ids').prop('checked', this.checked);
        })
    </script>
@endsection
