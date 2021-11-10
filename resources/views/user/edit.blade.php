<?php    /** @var App\Models\User $uesr */
?>
@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route("users.update",[$user->id]) }}">
                        @csrf
                        @method("PUT")
                        @include("user.layout.form",[
                            "name" => old("name") ?? $user->name,
                            "email" => old("email") ?? $user->email,
                        ])
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">儲存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


