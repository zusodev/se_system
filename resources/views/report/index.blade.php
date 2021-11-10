@extends('layouts.base')
@section('content')

    <h3> 報表統計 </h3>
    {{--<div class="card">
        <div class="card-body">
            @include("report.index.form")
        </div>
    </div>--}}

    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    統計數為即時計算，倘若專案仍在發信中，則計算數字將會異動，直至所有信件發信完畢。
                </li>
            </ul>
            {{--<ul>
                <li> TODO
                    若部門勾選為測試部門，則資料不予以統計
                </li>
            </ul>--}}
            @include("report.index.table")
        </div>
    </div>

    @include("report.index.download-modal")
    <form id="download-form" target="_blank" style="display: none">
        <input id="project-id" type="text">
        <input id="type" name="type" type="text">
    </form>
@endsection
@section('javascript')
    <script>
        function openDownloadModal(projectId) {
            document.getElementById('project-id').value = projectId;
            $('#download-modal').modal();
        }

        function startDownload(type) {
            const url = `{{ route("report.download.page",["_project_id_", "_type_"]) }}`
                .replace('_project_id_', document.getElementById('project-id').value)
                .replace('_type_', type);


            $("#download-modal").modal('hide');
            document.getElementById('download-form')
                .setAttribute('action', url);
            document.getElementById('download-form')
                .submit();
        }
    </script>
@endsection
