<?php

namespace App\Http\Requests;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch (Route::currentRouteName()) {
            case "users.store":
                return [
                    "name" => ["required", "string", "max:191"],
                    "email" => ["required", "string", "email", "max:191", "unique:users"],
                    "password" => ["required", "string", "confirmed"],
                ];
            case "users.update":
                return [
                    "name" => ["required", "string", "max:191"],
                    "email" => ["required", "string", "email", "max:191",
                        Rule::unique(User::TABLE)->ignore(
                            $this->route()->parameter("user")
                        ),
                    ],
                    "password" => ["nullable", "string", "confirmed"],
                ];
        }

        return [];
    }

    public function paginateWhere(): array
    {
        $where = [];
        $name = $this->get("name");
        if ($name) {
            $where[] = [User::NAME, "LIKE", "%" . $name . "%"];
        }

        $email = $this->get("email");
        if ($email) {
            $where[] = [User::EMAIL, "LIKE", "%" . $email . "%"];
        }

        return $where;
    }

    public function formAttributes(): array
    {
        $attributes = $this->only([
            "name",
            "email",
            "password"
        ]);
        if (isset($attributes["password"])) {
            $attributes["password"] = Hash::make($attributes["password"]);
        }

        return $attributes;
    }
}
