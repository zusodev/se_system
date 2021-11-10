@php /** @var App\Models\EmailTemplate $template */ @endphp
@extends('layouts.base')
@section('content')
    @php
        $templateContent = old("template") ?? $template->template;
    @endphp
    <div class="row">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> 修改信件樣式 </h5>
                </div>
                <div class="card-body">
                    <form id="template-form"
                          method="post"
                          action="{{ route("email_templates.update",[$template->id]) }}"
                          enctype="multipart/form-data">
                        @method("PUT")
                        @include("email-template.layout.form",[
                            "id" => $template->id,
                            "name" => old("name") ?? $template->name,
                            "subject" => old("subject") ?? $template->subject,
                            "attachment_name" => $template->attachment_name,
                            'attachment_templates' => $attachmentTemplates
                        ])
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" onclick="formSubmit()">儲存</button>
                            </div>
                        </div>
                        <div style="display: none">
                            <input id="exe_attachment_file_name" name="exe_attachment_file_name" value="" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include("email-template.edit.set-exe-attachment")
@endsection
@section("javascript")
    <script src="{{ asset("js/ckeditor4/ckeditor.js") }}"></script>
    <script>
        CKEDITOR.replace('template', {
            filebrowserImageUploadUrl: `{{ $imageUrl }}`,
            fileTools_requestHeaders: {
                ['X-CSRF-TOKEN']: `{{ csrf_token() }}`
            },
            height: '20rem',
            // startupMode:'source'
        });
        CKEDITOR.instances.template.setData(decodeHtmlspecialChars(`{{ $templateContent }}`));

        function openSetExeAttathmentModal() {
            $("#set-attachment-modal").modal();
        }

        function submitAttachmentModal() {
            $("#set-attachment-modal").modal('hide');
            const value = document.querySelector('#modal_file_name').value;
            document.querySelector('#exe_attachment_file_name').value = value;
            document.querySelector('#attachment_info').value = value + '.exe';
        }

        function decodeHtmlspecialChars(text) {
            var map = {
                '&amp;': '&',
                '&#038;': "&",
                '&lt;': '<',
                '&gt;': '>',
                '&quot;': '"',
                '&#039;': "'",
                '&#8217;': "’",
                '&#8216;': "‘",
                '&#8211;': "–",
                '&#8212;': "—",
                '&#8230;': "…",
                '&#8221;': '”'
            };

            return text.replace(/\&[\w\d\#]{2,5}\;/g, function (m) {
                return map[m];
            });
        }

        function clearAttachmentInfo() {
            document.querySelector('#attachment_info').value = '';
        }

        function formSubmit() {
            const originalFileName = '{{ $template->attachment_name }}';

            const currentFileName = document.querySelector('#attachment_info').value;

            const isDeleteAttachment = currentFileName !== originalFileName && !currentFileName;
            if (isDeleteAttachment) {
                document.querySelector("#is_delete_attachment").disabled = false;
            }

            const exe_attachment_file_name = document.querySelector("#exe_attachment_file_name").value;
            if (!exe_attachment_file_name || exe_attachment_file_name !== currentFileName) {
                document.querySelector("#exe_attachment_file_name").disabled = false;
            }


            document.getElementById('template-form').submit();
        }

    </script>
@endsection
