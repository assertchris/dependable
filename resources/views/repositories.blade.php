<h1>Repositories</h1>
<ol>
    @foreach($repositories as $repository)
        <li>{{ $repository->github_name }}</li>
    @endforeach
</ol>
<a href="{{ url("repositories/refresh") }}">Refresh</a>