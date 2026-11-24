<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | DOCUARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script defer src="{{ asset('js/script.js') }}"></script>
</head>
<body>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">D</span><span>DOCUARCH<small>Document Archiving System</small></span></a>
        <div class="side-label">WORKSPACE</div>
        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">▦ <span>Dashboard</span></a>
            <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.*') ? 'active' : '' }}">▤ <span>Documents</span></a>
            @if(in_array(auth()->user()->role, ['admin','personnel']))
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">▥ <span>Reports</span></a>
            @endif
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">♙ <span>User Management</span></a>
            @endif
        </nav>
        <div class="sidebar-bottom">
            <div class="user-mini"><div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div><div><strong>{{ auth()->user()->name }}</strong><small>{{ ucfirst(auth()->user()->role) }}</small></div></div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="logout-btn" type="submit">↪ Sign out</button></form>
        </div>
    </aside>
    <main class="main-area">
        <header class="topbar"><button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">☰</button><div><span class="eyebrow">DOCUMENT RECORDS MANAGEMENT</span><h1>@yield('heading', 'Dashboard')</h1></div><div class="top-user">{{ auth()->user()->name }} <span class="top-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span></div></header>
        <section class="page-content">
            @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert error"><strong>Please check the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </section>
        <footer class="footer">DOCUARCH · Document Archiving System</footer>
    </main>
</div>
</body>
</html>
