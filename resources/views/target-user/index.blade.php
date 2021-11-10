@extends('layouts.base')
@section('content')
    <h3> 目標人員列表 </h3>
    <div class="row" style="margin: 5px 0;">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @component("target-company.layout.belong-header",["company" => $company, "department"=> $department])
                <a class="btn btn-sm text-white btn-primary" style="cursor: pointer" data-toggle="modal"
                   data-target="#search-modal">
                    條件搜尋
                </a>
                <a class="btn btn-sm text-white btn-primary" href="{{route("target_users.create")}}">
                    新增部門人員
                </a>
            @endcomponent
                @component("layouts.form.search-name", ["company" => $company, "department"=> $department])
                @endcomponent

            @include("target-user.index.table")
        </div>
    </div>
    @include("target-user.index.delete-modal")
    @include("target-user.index.search-modal")
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
                showDeleteModal(id, name) {
                    let url = `{{ route("target_users.destroy",[$random]) }}`
                        .replace(`{{ $random }}`, id);

                    $("#delete-form").attr("action", url);
                    this.itemName = name;
                    $("#delete-modal").modal();
                },
                deleteUser() {
                    $("#delete-form").submit();
                    $("#delete-modal").modal("hide");
                },
                cancelUser() {
                    $("#delete-modal").modal('hide');
                }
            },
            mounted() {
            }
        })
    </script>
@endsection
