<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fisherman Diary')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 0;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        nav {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 20px 30px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 25px;
            font-weight: 600;
            font-size: 16px;
            transition: opacity 0.3s;
        }
        nav a:hover { opacity: 0.8; }
        .content {
            padding: 40px;
        }
        h1 {
            color: #1f2937;
            margin-bottom: 10px;
            font-size: 32px;
        }
        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }
        .empty-state {
            margin-top: 40px;
            padding: 60px 40px;
            background: #f9fafb;
            border-radius: 12px;
            text-align: center;
            color: #9ca3af;
        }
        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        .sort-btn {
            padding: 8px 16px;
            background: #f3f4f6;
            color: #374151;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border: 2px solid transparent;
        }
        .sort-btn:hover {
            background: #e5e7eb;
        }
        .sort-btn.active {
            background: #2563eb;
            color: white;
            border-color: #1d4ed8;
        }
        /* Кнопки сортировки */
        .sort-btn {
            padding: 8px 14px;
            background: #f3f4f6;
            color: #374151;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border: 2px solid transparent;
            display: inline-block;
        }
        .sort-btn:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }
        .sort-btn.active {
            background: #2563eb;
            color: white;
            border-color: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <a href="/">🏠 Home</a>
            <a href="/catches">🎣 My Catches</a>
            <a href="/catches/create">➕ Add New</a>
        </nav>

        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
