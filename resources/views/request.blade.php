@if (session("status"))
    {{ session("status") }}
@endif

@if (session("error"))
    {{ session("error") }}
@endif

<form method="POST">
    <label>
        Email:
        <input type="email"
               name="github_email"
               value="{{ old("github_email") }}" />
    </label>
    <input
        type="hidden"
        name="_token"
        value="{{ csrf_token() }}" />
    <input
        type="submit"
        value="Send Password Reset Link" />
</form>
