<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'System')</title>
    <style>
        td {
            word-break: break-word;
        }
        
        nav {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        nav a {
            text-decoration: none;
        }

        .nav-btn {
            padding: 6px 10px;
            cursor: pointer;
        }

        .spacer {
            margin-left: auto;
        }

        /* Dropdown (details) */
        details {
            position: relative;
        }

        details > summary {
            list-style: none;
            cursor: pointer;
            padding: 6px 10px;
            border: 1px solid #ddd;
            display: inline-block;
        }
        details > summary::-webkit-details-marker { display: none; }

        .dropdown {
            position: absolute;
            top: 38px;
            left: 0;
            border: 1px solid #ddd;
            background: #fff;
            min-width: 160px;
            padding: 6px;
        }

        .dropdown a {
            display: block;
            padding: 6px 8px;
        }

        .dropdown a:hover {
            background: #f2f2f2;
        }

        .page {
            padding: 12px;
        }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('dashboard') }}"> <button class="nav-btn">Home</button> </a>
    <a href="{{ route('notifications') }}"><button class="nav-btn">Notification</button></a>
    <a href="{{ route('tasks') }}"><button class="nav-btn">Task</button></a>

    @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin']))
        <a href="{{ route('admin.index') }}"><button class="nav-btn">Admin</button></a>
    @endif

    @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin', 'vendor']))
        <a href="{{ route('vendor.index') }}"><button class="nav-btn">Vendor</button></a>
    @endif

    @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin', 'tenant']))
        <a href="{{ route('tenant') }}"><button class="nav-btn">Tenant</button></a>
    @endif

    <details>
        <summary>Unit ▾</summary>
        <div class="dropdown">
            <a href="{{ route('units.index') }}">Unit</a>
            <a href="">Rooms</a>
        </div>
    </details>

    <details>
        <summary>Agreement ▾</summary>
        <div class="dropdown">
            <a href="{{ route('agreement.template') }}">Agreement Template</a>
        </div>
    </details>

    <a href="{{ route('chat') }}"><button class="nav-btn">Chat</button></a>

    <div class="spacer"></div>

    <div>
        @if(auth()->check())
            <small>{{ auth()->user()->name }} ({{ auth()->user()->role }})</small>
        @endif

        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button class="nav-btn" type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="page">
    @yield('content')
</div>

</body>
</html>