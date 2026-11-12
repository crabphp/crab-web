@props(string $title, string $slot = '')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <style>
        body { font: 16px/1.5 system-ui, sans-serif; max-width: 40rem; margin: 3rem auto; padding: 0 1rem; color: #1c1c1c; }
        form { display: flex; gap: .5rem; margin: 1.5rem 0; }
        input { flex: 1; font: inherit; padding: .5rem .75rem; border: 1px solid #c8c8c8; border-radius: .375rem; }
        button { font: inherit; padding: .5rem 1rem; border: 0; border-radius: .375rem; background: #1c1c1c; color: #fff; cursor: pointer; }
        .flash { padding: .5rem .75rem; border-radius: .375rem; background: #e8f5ec; color: #135c2c; }
        .note { padding: .75rem 0; border-bottom: 1px solid #eee; }
        .muted { color: #6b6b6b; font-size: .875rem; }
    </style>
</head>
<body>
    <main>{!! $slot !!}</main>
</body>
</html>
