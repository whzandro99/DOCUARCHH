<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login | DOCUARCH</title><link rel="stylesheet" href="{{ asset('css/style.css') }}"></head>
<body class="login-body">
<div class="login-wrap"><div class="login-brand"><span class="brand-mark large">D</span><div><h1>DOCUARCH</h1><p>Document Archiving System</p></div></div>
<div class="login-card"><span class="eyebrow">WELCOME BACK</span><h2>Sign in to your account</h2><p class="muted">Access your office's centralized document archive.</p>
@if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('login.post') }}">@csrf
<label>Email address</label><input type="email" name="email" value="{{ old('email') }}" placeholder="name@office.com" required autofocus>
<label>Password</label><input type="password" name="password" placeholder="Enter your password" required>
<label class="remember"><input type="checkbox" name="remember"> Remember me</label>
<button class="btn primary full" type="submit">Sign in</button></form>
<div class="login-note">Authorized users only. Contact your administrator if you need an account.</div></div>
<div class="login-foot">© {{ date('Y') }} DOCUARCH</div></div></body></html>
