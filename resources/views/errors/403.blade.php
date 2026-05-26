<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - គ្មានសិទ្ធ</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Kantumruy Pro', sans-serif;
            min-height: 100vh;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1rem;
        }
        .icon { font-size: 4rem; margin-bottom: 1rem; }
        h1 { font-size: 1.5rem; color: #1E293B; margin-bottom: .5rem; }
        p  { color: #64748B; font-size: .9rem; margin-bottom: 1.5rem; }
        a  {
            display: inline-block;
            padding: .65rem 1.5rem;
            background: #4F46E5;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover { background: #3730A3; }
    </style>
</head>
<body>
    <div>
        <div class="icon">🚫</div>
        <h1>403 — គ្មានសិទ្ធចូល</h1>
        <p>{{ $exception->getMessage() ?: 'អ្នកមិនមានសិទ្ធចូលទំព័រនេះទេ។' }}</p>
        <a href="{{ url()->previous() }}">⬅ ត្រឡប់ក្រោយ</a>
    </div>
</body>
</html>
