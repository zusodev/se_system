@extends('layouts.base')
@section('content')
    <h3> 信件樣式列表 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            <div class="row m-b-20">
                <div class="col-md">
                    <button class="btn btn-primary btn-sm"
                            @click="showCreateModal()">
                        新增信件樣式
                    </button>
                </div>
            </div>

            @include("email-template.index.table")
        </div>
    </div>
    @include("email-template.index.create-modal")
    @include("email-template.index.delete-modal")
    @include("email-template.index.send-email-modal")

@endsection

@php
    $random = "r_e_p_l_a_c_e__m_e";
@endphp

@section('javascript')
    <script src="{{ asset("js/vue.min.js") }}"></script>

    <script>
        function openModal(id) {
            $("#send-email-modal").modal();
            const form = document.getElementById('send-email-form');
            form.setAttribute('action', form.action.replace('r_e_p_l_a_c_e', id));
        }

        function closeSendMailModal() {
            $("#send-email-modal").modal('hide');
        }

        new Vue({
            el: "#layout-content",
            data: {
                itemName: ``,
            },
            methods: {
                showCreateModal() {
                    $("#create-modal").modal();
                },
                submitCreateModalForm() {
                    $("#create-modal").modal('hide');
                    $("#create-form")
                        .submit();
                },
                showDeleteModal(id, name) {
                    let url = `{{ route("email_templates.destroy",[$random]) }}`
                        .replace(`{{ $random }}`, id);
                    $("#delete-form").attr("action", url);
                    this.itemName = name;
                    $("#delete-modal").modal();
                },
                deleteItem() {
                    $("#delete-form").submit();
                    $("#delete-modal").modal("hide");
                },
                cancelDelete() {
                    $("#delete-modal").modal('hide');
                }
            }
        });
    </script>
@endsection
