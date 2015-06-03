<h1>Developers</h1>
<ol>
    @foreach($developers as $developer)
        <li>{{ $developer->github_name }}</li>
    @endforeach
</ol>
<a href="{{ url("redirect/github") }}">Connect to Github</a>