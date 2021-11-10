@php
    /** @var App\Models\EmailProject $project */
@endphp
@extends('layouts.base')
@section('content')
    <h3> 寄件專案部門列表 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            @component("email-project.layout.belong-header",["project" => $project])

            @endcomponent

            @component("layouts.form.search-name", ["project" => $project])
            @endcomponent

            <br>

            @include("email-job.index.table")
        </div>
    </div>
    @include("email-job.index.deleteModal")
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
                    let url = `{{ route("email_jobs.destroy",[$random]) }}`
                        .replace(`{{ $random }}`, id);

                    $("#delete-form").attr("action", url);
                    this.itemName = name;
                    $("#delete-modal").modal();
                },
                deleteUser() {
                    console.log('deleteUser');
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
