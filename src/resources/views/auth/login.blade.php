@extends('layouts.auth')

@section('title', 'ログイン')

@section('content')

<div class="auth-container">
  <div class="auth-card">

    <h1 class="logo">PiGLy</h1>
    <h2 class="title">ログイン</h2>

    <form method="POST" action="{{ route('login') }}" novalidate>
      @csrf

      <div class="form-group">
        <label>メールアドレス</label>
        <input type="email" name="email" placeholder="メールアドレスを入力">
        @error('email')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>パスワード</label>
        <input type="password" name="password" placeholder="パスワードを入力">
        @error('password')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit">ログイン</button>

      <p class="login-link"><a href="/register/step1">アカウント作成はこちら</a></p>

    </form>

  </div>
</div>

@endsection