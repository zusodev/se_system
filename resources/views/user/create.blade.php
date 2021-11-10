<?php /** @var App\Models\User $model */
/** @var App\Blade\Form $form */
?>
@extends('layouts.base')
@section('content')

    <div class="row">
        <div class="offset-md-2 col-md-8 col-sm-12">
            <h3>新增使用者</h3>
            <div class="card">
                <div class="card-body">
                    @include("layouts.result")

                    <form method="post" action="{{ route("users.store") }}">
                        @csrf
                        @include("user.layout.form",[
                            "name" => old("name"),
                            "email" => old("email"),
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


