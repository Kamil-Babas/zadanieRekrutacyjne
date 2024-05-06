<link rel="stylesheet" href="{{asset('css/navbar.css')}}">

@if(auth()->check())

    <nav class="nav">
        <span class="menu-buttons-container">
            <a href="/excel/load" class="nav-button">Load Excel</a>
            <form action="/auth/logout" method="Post">
                @csrf
                <button type="submit" style="background-color: inherit; border: none; cursor: pointer" class="nav-button logoutButton">Logout</button>
            </form>
        </span>
    </nav>

@else
    <nav class="nav">
        <span class="menu-buttons-container">
            <a href="/login" class="nav-button">Sign in</a>
            <a href="/register" class="register nav-button">Register</a>
        </span>
    </nav>
@endif
