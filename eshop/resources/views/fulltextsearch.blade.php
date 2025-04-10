<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
<main>
    <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary shadow-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">PayPlay</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <form class="d-flex" role="search" method="GET" action="{{ route('fulltextsearch') }}">
                        <input name="title" class="form-control me-1" type="search" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-outline-light d-none" type="submit">Text-Search</button>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('search') }}">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('cart') }}">Cart</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Log In</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-5 px-lg-5">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-2 row-cols-xl-1 g-4">
            @foreach($games as $game)
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <a href="{{ route('game.show', ['id' => $game->id]) }}">
                        <div class="card h-100">
                            <img src="{{ $game->logo }}" class="card-img-top" alt="{{ $game->title }}">
                            <div class="card-img-overlay">
                                <img src="{{ asset('images/Logos/' .
                                ($game->platform == 'Play Station' ? 'playstation-logotype.png' :
                                ($game->platform == 'Xbox' ? 'xbox-logo.png' :
                                ($game->platform == 'Nintendo' ? 'nintendo-switch.png' :
                                ($game->platform == 'PC' ? 'computer.png' :
                                ($game->platform == 'Wii' ? 'wii.png' : 'computer.png')))))) }}"
                                     class="overlay-img" alt="Platform Logo">
                                <div class="price-tag">{{ number_format($game->price, 2) }} €</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container mt-5 px-lg-5 d-flex justify-content-center">
        @if ($games->lastPage() > 1)
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $games->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link text-black rounded-pill rounded-end" href="{{ $games->previousPageUrl() }}&title={{ request('title') }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    {{-- Page Numbers --}}
                    @php
                        $currentPage = $games->currentPage();
                        $totalPages = $games->lastPage();
                        $pageRange = 3; // Number of pages to display before and after the current page
                        $startPage = max(1, $currentPage - $pageRange);
                        $endPage = min($totalPages, $currentPage + $pageRange);
                    @endphp

                    {{-- First Page --}}
                    @if ($startPage > 1)
                        <li class="page-item">
                            <a class="page-link text-black" href="{{ $games->url(1) }}&title={{ request('title') }}">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link text-black {{ $i == $currentPage ? 'bg-dark text-white' : '' }}" href="{{ $games->url($i) }}&title={{ request('title') }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Last Page --}}
                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link text-black" href="{{ $games->url($totalPages) }}&title={{ request('title') }}">{{ $totalPages }}</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    <li class="page-item {{ $games->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link text-black rounded-pill rounded-start" href="{{ $games->nextPageUrl() }}&title={{ request('title') }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
</main>

<footer class="py-0 my-4 mb-0">
    <div class="bg-dark">
        <div class="container">
            <footer class="py-4 bg-dark">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Features</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-light">About</a></li>
                </ul>
                <p class="text-center text-light">© 2025 PayPlay</p>
            </footer>
        </div>
    </div>
</footer>
</body>
</html>
