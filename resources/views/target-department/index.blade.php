@php /** @var App\Models\TargetCompany $company */ @endphp
@extends('layouts.base')
@section('content')
    <h3> 目標部門列表 </h3>

    <div class="card">
        <div class="card-body">
            @include("layouts.result")

            @php
                $createArguments = [];
                if($company){
                    $createArguments["company_id"] = $company->id;
                }
            @endphp

            @component("target-company.layout.belong-header",["company" => $company])
                <button class="btn btn-primary btn-sm"
                        onclick="location.href=`{{ route("target_departments.create", $createArguments) }}`">
                    新增目標部門
                </button>
            @endcomponent
            @component("layouts.form.search-name", ["company" => $company])
            @endcomponent


            @include("target-department.index.table")
        </div>
    </div>
    @include("target-department.index.delete-modal")
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
                    let url = `{{ route("target_departments.destroy",[$random]) }}`
                        .replace(`{{ $random }}`, id);
                    $("#delete-form").attr("action", url);
                    this.itemName = name;
                    $("#delete-modal").modal();
                },
                deleteItem() {
                    $("#delete-form").submit();
                    $("#delete-modal").modal("hide");
                }
            },
            mounted() {
            }
        });
    </script>
@endsection
