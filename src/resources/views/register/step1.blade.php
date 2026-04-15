@extends('layouts.auth')

@section('title', '会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="auth-container">
  <div class="auth-card">

    <h1 class="logo">PiGLy</h1>
    <h2 class="title">新規会員登録</h2>
    <p>STEP1 アカウント情報の登録</p>

    <form action="/register/step1" method="POST" novalidate>
      @csrf

      <div class="form-group">
        <label>お名前</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="お名前を入力">
        @error('name')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>メールアドレス</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">
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

      <button type="submit">次に進む</button>

      <p class="login-link"><a href="/login">ログインはこちら</a></p>
    </form>

  </div>
</div>

@endsection