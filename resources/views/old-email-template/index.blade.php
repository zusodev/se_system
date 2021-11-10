@extends('layouts.base')
@section('content')
    <h3> 電子郵件樣式 </h3>
    @include("layouts.result")
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    @include("old-email-template.index.table")
                    <br>
                    <button type="button" id="openCreateModalBuuton" class="btn btn-primary ">新增樣式</button>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <p>以下為系統自動替換的名詞</p>
                    <ul>
                        <li>
                            <span class="badge badge-primary " style="font-size: 16px;">@name@</span>
                            ：名稱
                        </li>
                        <li>
                            <span class="badge badge-primary " style="font-size: 16px;">@email@</span>
                            ：信箱
                        </li>
                        <li>
                            <span class="badge badge-primary " style="font-size: 16px;">@embedded_link@</span>
                            ：內嵌釣魚網址
                        </li>
                    </ul>
                    <form id="update-form" method="post" enctype="multipart/form-data">
                        <input id="item-id" style="display: none">
                        @method("PUT")
                        @csrf
                        <div class="form-group">
                            <label id="nameLabel" for="name">樣式名稱</label>
                            <input type="text" class="form-control" id="update-name" name="name" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label id="subjectLabel" for="subject">寄件標題</label>
                            <input type="text" class="form-control" id="subject" name="subject" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="template">樣式內容</label>
                            <div class="custom-file">
                                <textarea name="template" id="template"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="attachment" name="attachment" required>
                                <label for="attachment" class="custom-file-label">Attachment</label>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <button type="button" id="submitUpdateForm" class="btn btn-primary ">儲存</button>
                            <button type="button" id="submitDeleteForm" class="btn btn-danger ">刪除</button>
                        </div>
                    </form>
                    <hr>
                    <div class="form-group">
                        <button id="openSendEmailModal" type="button" class="btn btn-primary">寄送測試信件</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    @include("old-email-template.index.createModal")
    @include("old-email-template.index.sendEmailModal")
@endsection
@php
    $random = "r_e_p_l_a_c_e__m_e";
@endphp
@section('javascript')
    <script src="{{ asset("js/ckeditor4/ckeditor.js") }}"></script>
    <script>
        CKEDITOR.replace('template', {
            filebrowserImageUploadUrl: `{{ $imageUrl }}`,
            fileTools_requestHeaders: {
                ['X-CSRF-TOKEN']: `{{ csrf_token() }}`
            },
        });
    </script>
    <script>
        const itemsLength = parseInt('{{ $models->count() }}');
        $("#openCreateModalBuuton").click(function () {
            $("#create-modal").modal();
        });
        $("#openSendEmailModal").click(function () {
            const form = document.getElementById("send-email-form");
            const realAction = form
                .action
                .replace(`{{ $random }}`, $("#item-id").val());

            form.setAttribute('action', realAction);

            $("#send-email-modal").modal();
        });
        $("#createTemplateButton").click(function () {
            $("#create-modal").modal('hide');
            $("#create-form")
                .submit();
        });
        $("#cancelCreateModalButton").click(function () {
            $("#create-modal").modal('hide');
        });

        function clickItem(id, name, subject, template, attachment_name, itemIndex) {
            $("#item-id").val(id);
            let itemElement;
            for (let i = 0; i <= itemsLength; i++) {
                let selector = '#item-' + i;
                $(selector).removeClass('active');
            }
            itemElement = $('#item-' + itemIndex);
            itemElement.addClass('active');
            /*const domEditableElement = document.querySelector('.ck-editor__editable');
            const editorInstance = domEditableElement.ckeditorInstance;
            editorInstance.setData(decodeHtmlspecialChars(template));*/
            CKEDITOR.instances.template.setData(decodeHtmlspecialChars(template));

            if (attachment_name) {
                const url = `{{ route("email_templates.show",[$random]) }}`
                    .replace(`{{ $random }}`, id);
                let fileName = `<a href="${url}">${attachment_name}</a>`;
                $("#subjectLabel").html(`寄件標題(${fileName})`);
            } else {
                $("#subjectLabel").text(`寄件標題`);
            }
            $('#subject').val(subject);
            $("#update-name").val(name);

            let url = `{{ route("email_templates.update",[$random]) }}`.replace(`{{ $random }}`, id);

            $("#update-form").attr("action", url)
        }

        @if($models->count())
        setTimeout(function () {
            clickItem(
                parseInt('{{ $models[0]->id }}'),
                '{!! $models[0]->name !!}',
                `{!! $models[0]->subject !!}`,
                `{{ $models[0]->template }}`,
                '{!! $models[0]->attachment_name !!}',
                0
            )
        }, 1);
        @endif

        $("#submitUpdateForm").click(function () {
            const id = $("#item-id").val();
            $("[name='_method']").val('PUT');

            const url = `{{ route("email_templates.update",[$random]) }}`.replace(`{{ $random }}`, id);
            $("#update-form")
                .attr("action", url)
                .submit();
        });
        $("#submitDeleteForm").click(function () {
            const id = $("#item-id").val();
            $("[name='_method']").val('DELETE');

            const url = `{{ route("email_templates.destroy",[$random]) }}`.replace(`{{ $random }}`, id);
            $("#update-form")
                .attr("action", url)
                .submit();
        });

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
    </script>
@endsection
