@extends('layouts.base')
@section('content')
    <h3> 新增寄件專案 </h3>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include("layouts.result")

                    <form method="post" action="{{ route("email_projects.store") }}">
                        @include("email-project.layout.form",[
                            "name" => old("name"),
                            "sender_name" => old("sender_name"),
                            "description" => old("description"),
                            "sender_email" => old("sender_email"),

                            "company_id" => old("company_id"),
                            "email_template_id" => old("email_template_id"),
                            "phishing_website_id" => old("phishing_website_id"),

                            "start_at" => old("start_at") ?? now()->format("Y-m-d\TH:i"),
                            "log_redirect_to" => old("log_redirect_to"),

                            "emailTemplates" => $emailTemplates,
                            "phishingWebsites" => $phishingWebsites,
                            "companies" => $companies
                        ])
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">新增</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("javascript")
    {{--<script src="{{ asset("js/datetimepicker.min.js") }}" type="text/javascript"></script>--}}
    {{--<link href="{{ asset("css/datetimepicker.min.css") }}" rel="stylesheet" type="text/css"/>--}}
    <script src="{{ asset("js/vue.min.js") }}"></script>
    <script>
        new Vue({
            el: "#layout-content",
            data: {
                selectedCompanyId: `{{ old("company_id") ?? '' }}`,
                deparmentsMap: JSON.parse(`@json($deparmentsMap)`),
                deparmentsOptions: [],
                selectedDepartments: JSON.parse(`@json(old("department_ids") ?? [])`),
            },
            methods: {
                selectCompany() {
                    this.selectedDepartments = [];
                    this.selectedCompanyId = document.getElementById('company_id').value;
                    console.log(`this.selectedCompanyId`);
                    console.log(this.selectedCompanyId);
                    this.setDepartmentsOptionsAndShowForm();
                },
                setDepartmentsOptionsAndShowForm() {
                    const departmentOptions = this.deparmentsMap[this.selectedCompanyId];

                    if (!R.is(Array, departmentOptions)) {
                        this.deparmentsOptions = [];
                        this.departmentsIsEmpty = true;
                        return;
                    }

                    this.deparmentsOptions = [...departmentOptions];
                    this.departmentsIsEmpty = !(departmentOptions.length);
                }
            },
            mounted() {
                this.selectCompany();
            }
        })
    </script>
@endsection
