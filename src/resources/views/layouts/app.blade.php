<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/weight.css') }}">

    <!-- flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <title>@yield('title')</title>
</head>

<body>

<header class="header">
  <div class="header-inner">

    <div class="logo">PiGLy</div>

    <div class="header-right">
      <a href="/weight_logs/goal_setting" class="btn-outline">
        ⚙目標体重設定
      </a>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-outline">ログアウト</button>
      </form>
    </div>

  </div>
</header>

@yield('content')

</body>