@extends('layouts.base')
@section('content')
    <h3> 目標公司列表 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            <div class="row">
                <div class="col-md">
                    <button class="btn btn-primary btn-sm"
                            onclick="location.href=`{{ route("target_companys.create") }}`">
                        新增目標公司
                    </button>
                </div>
            </div>

            @include("target-company.index.table")
        </div>
    </div>
    @include("target-company.index.delete-modal")
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
                /****************
                 * 以下為刪除功能 *
                 ***************/
                showDeleteModal(id, name) {
                    let url = `{{ route("target_companys.destroy",[$random]) }}`
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
