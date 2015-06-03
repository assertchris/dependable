<?php

use App\Models\Developer;
use App\Models\Repository;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

Route::get("/", function () {
    $developers = Developer::all();

    return view("index", [
        "developers" => $developers
    ]);
});

Route::get("redirect/github", function () {
    return Socialite::with("github")->redirect();
});

Route::get("connect/github", function () {
    $data = Socialite::with("github")->user();

    $developer = Developer::where("github_id", $data->id)
        ->first();

    if (!$developer) {
        Developer::create([
            "github_id"       => $data->id,
            "github_nickname" => $data->nickname,
            "github_name"     => $data->name,
            "github_email"    => $data->email,
            "github_avatar"   => $data->avatar
        ]);
    }

    return redirect("/");
});

Route::get("repositories", function () {
    $repositories = Developer::first()->repositories;

    return view("repositories", [
        "repositories" => $repositories
    ]);
});

Route::get("repositories/refresh", function () {
    $developer = Developer::first();

    $client = new GuzzleHttp\Client();

    if (!Cache::has("github.urls")) {
        try {
            $response = $client->get("https://api.github.com");

            Cache::put("github.urls", $response->json(), 5);
        } catch (Exception $e) {
            abort(500);
        }
    }

    $urls = Cache::get("github.urls");
    $repositories_url = null;

    try {
        $url = str_replace(
            "{user}",
            $developer->github_nickname,
            $urls["user_url"]
        );

        $response = $client->get($url);

        $developer_urls = $response->json();

        $repositories_url = $developer_urls["repos_url"];
    } catch (Exception $e) {
        abort(500);
    }

    $repositories = [];

    try {
        $response = $client->get($repositories_url);

        $repositories = $response->json();
    } catch (Exception $e) {
        abort(500);
    }

    foreach ($repositories as $repository) {
        $existing = Repository::where(
            "github_name", $repository["name"]
        )->first();

        if (!$existing) {
            Repository::create([
                "github_name"  => $repository["name"],
                "developer_id" => $developer->id,
            ]);
        }
    }

    return redirect("repositories");
});

Route::get("request", function () {
    return view("request");
});

Route::post("request",
    function (Request $request, PasswordBroker $passwords) {
        $validator = Validator::make($request->all(), [
            "github_email" => "required|email",
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()
                ->first("github_email");

            return redirect()->back()
                ->with("error", $error);
        }

        $response = $passwords->sendResetLink(
            $request->only("github_email"),
            function (Message $message) {
                $message->subject("Password Reset Link");
            }
        );

        if ($response === PasswordBroker::RESET_LINK_SENT) {
            return redirect()->back()
                ->with("status", "Link sent");
        }

        return redirect()->back()
            ->with("error", "Invalid email");
    }
);
