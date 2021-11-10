@extends('layouts.base')
@section('content')
    <h3> 系統管理者列表 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            <div class="row m-b-20">
                <div class="col-md">
                    <a class="btn btn-sm text-white btn-primary" style="cursor: pointer" data-toggle="modal"
                       data-target="#search-modal">
                        搜尋條件
                    </a>
                    <a class="btn btn-sm text-white btn-primary" href="{{ route("users.create") }}">
                        新增系統管理者
                    </a>
                </div>
            </div>

            @include("user.index.table")
        </div>
    </div>
    @include("user.index.delete-modal")
    @include("user.index.search")
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
                isShowSearch: `{{ json_encode( !request()->has("page")  )  }}`,
                /** 刪除 */
                itemName: ``,
            },
            methods: {
                showSearch() {
                    this.isShowSearch = !this.isShowSearch;
                },
                showDeleteModal(id, name) {
                    let url = `{{ route("users.destroy",[$random]) }}`.replace(`{{ $random }}`, id);

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
