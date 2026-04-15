@extends('layouts.auth')

@section('title', '初期体重登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="auth-container">
  <div class="auth-card">

  <h1 class="logo">PiGLy</h1>
  <h2 class="title">体重登録</h2>
  <p>STEP2 体重データの入力</p>

  <form action="/register/step2" method="POST">
    @csrf

    <div class="form-group">
      <label>現在の体重</label>

    <div class="input-with-unit">
      <input type="text" name="weight" value="{{ old('weight') }}" placeholder="現在の体重を入力">
      <span>㎏</span>
    </div>

    @error('weight')
      <p class="error">{{ $message }}</p>
    @enderror
</div>

    <div class="form-group">
      <label>目標体重</label>

    <div class="input-with-unit">
      <input type="text" name="target_weight" value="{{ old('target_weight') }}" placeholder="目標の体重を入力">
      <span>㎏</span>
    </div>

     @error('target_weight')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

    <button type="submit">アカウント作成</button>
  </form>

