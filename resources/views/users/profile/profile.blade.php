<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile</title>
</head>
<body>
<h1>{{ auth()->user()->name ?? 'User' }} — Profile</h1>
<p>Email: {{ auth()->user()->email ?? '—' }}</p>
</body>
</html>
