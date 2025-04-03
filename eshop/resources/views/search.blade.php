<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
<main>
    <nav class="navbar sticky-top navbar-expand-md bg-body-tertiary shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.html">PayPlay</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('search') }}">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="cart.html">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center search-bar">
        <form method="GET" action="{{ route('search') }}" class="row g-2 w-100">
            <!-- Platform -->
            <div class="col-12 col-sm-6 col-md-2">
                <div class="input-group">
                    <span class="input-group-text bg-dark text-light">Platform</span>
                    <select class="form-select" name="platform">
                        <option value="ALL" {{ request('platform') == 'ALL' ? 'selected' : '' }}>ALL</option>
                        <option value="Xbox" {{ request('platform') == 'Xbox' ? 'selected' : '' }}>Xbox</option>
                        <option value="Play Station" {{ request('platform') == 'Play Station' ? 'selected' : '' }}>PlayStation</option>
                        <option value="Wii" {{ request('platform') == 'Wii' ? 'selected' : '' }}>Wii</option>
                        <option value="Nintendo" {{ request('platform') == 'Nintendo' ? 'selected' : '' }}>Nintendo</option>
                        <option value="PC" {{ request('platform') == 'PC' ? 'selected' : '' }}>PC</option>
                    </select>
                </div>
            </div>

            <!-- Category -->
            <div class="col-12 col-sm-6 col-md-2">
                <div class="input-group">
                    <span class="input-group-text bg-dark text-light">Category</span>
                    <select class="form-select" name="category">
                        <option value="ALL" {{ request('category') == 'ALL' ? 'selected' : '' }}>ALL</option>
                        @foreach(App\Models\Genre::all() as $genre)
                            <option value="{{ $genre->name }}" {{ request('category') == $genre->name ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Price Range -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-dark text-light">Price</span>
                    <input class="form-control" type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min">
                    <span class="input-group-text bg-dark text-light">-</span>
                    <input class="form-control" type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max">
                </div>
            </div>

            <!-- Game Title -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="input-group">
                    <input class="form-control" type="text" name="title" value="{{ request('title') }}" placeholder="Search...">
                </div>
            </div>

            <!-- Sorting -->
            <div class="col-12 col-sm-6 col-md-1">
                <select class="form-select" name="sort">
                    <option value="Price⇧" {{ request('sort') == 'Price⇧' ? 'selected' : '' }}>Price⇧</option>
                    <option value="Price⇩" {{ request('sort') == 'Price⇩' ? 'selected' : '' }}>Price⇩</option>
                    <option value="Date⇧" {{ request('sort') == 'Date⇧' ? 'selected' : '' }}>Date⇧</option>
                    <option value="Date⇩" {{ request('sort') == 'Date⇩' ? 'selected' : '' }}>Date⇩</option>
                </select>
            </div>

            <!-- Search Button -->
            <div class="col-12 col-sm-6 col-md-1">
                <button class="btn btn-light btn-outline-dark w-100 rounded-pill" type="submit">Search</button>
            </div>
        </form>
    </div>


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
                        <a class="page-link text-black rounded-pill rounded-end" href="{{ $games->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $games->lastPage(); $i++)
                        <li class="page-item {{ $i == $games->currentPage() ? 'active' : '' }}">
                            <a class="page-link text-black {{ $i == $games->currentPage() ? 'bg-dark text-white' : '' }}" href="{{ $games->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Next Page Link --}}
                    <li class="page-item {{ $games->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link text-black rounded-pill rounded-start" href="{{ $games->nextPageUrl() }}" aria-label="Next">
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
