@extends('layouts.base')
@section('content')
    <h3> 寄件專案列表 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            <div class="row m-b-20">
                <div class="col-md">
                    <button class="btn btn-primary btn-sm"
                            onclick="location.href=`{{ route("email_projects.create") }}`">
                        新增寄件專案
                    </button>
                </div>
            </div>

            @include("email-project.index.table")
        </div>
    </div>
    @include("email-project.index.delete-modal")
@endsection

@php
    $random = "r_e_p_l_a_c_e__m_e";
@endphp

@section('javascript')
    <script src="{{ asset("js/vue.min.js") }}"></script>
    <script src="{{ asset("js/chart.js") }}"></script>

    <script>
        new Vue({
            el: "#layout-content",
            data: {
                itemName: ``,
            },
            methods: {
                /****************
                 * 以下為刪除功能 *
                 ***************/
                showDeleteModal(id, name) {
                    let url = `{{ '' }}`
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
