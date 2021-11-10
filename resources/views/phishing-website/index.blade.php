@extends('layouts.base')
@section('content')
    <h3> 釣魚網站樣式列表 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            <div class="row m-b-20">
                <div class="col-md">
                    <button class="btn btn-primary btn-sm"
                            @click="showCreateModal()">
                        新增釣魚網站
                    </button>
                </div>
            </div>

            @include("phishing-website.index.table")
        </div>
    </div>
    @include("phishing-website.index.create-modal")
    @include("phishing-website.index.delete-modal")
@endsection

@php
    $random = "r_e_p_l_a_c_e__m_e";
@endphp

@section('javascript')
    <script src="{{ asset("js/vue.min.js") }}"></script>

    <script>
        new Vue({
            el: "#layout-content",
            data: {
                itemName: ``,
            },
            methods: {
                showCreateModal(){
                    $("#create-modal").modal();
                },
                submitCreateModalForm(){
                    $("#create-modal").modal('hide');
                    $("#create-form")
                        .submit();
                },
                showDeleteModal(id, name) {
                    let url = `{{ route("phishing_websites.destroy",[$random]) }}`
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
