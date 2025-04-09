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
    <nav class="navbar sticky-top navbar-expand-md bg-body-tertiary shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">PayPlay</a>
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

    <div class="container d-flex justify-content-center align-items-center search-bar">
        <form method="GET" action="{{ route('search') }}" class="row g-2 w-100">

            <div class="btn-group d-flex w-100" role="group" aria-label="Platform radio toggle button group">
                <input type="radio" class="btn-check" name="platform" id="platform-xbox" autocomplete="off" value="Xbox" {{ request('platform') == 'Xbox' ? 'checked' : '' }}>
                <label class="btn btn-outline-dark flex-fill text-center" for="platform-xbox">Xbox</label>

                <input type="radio" class="btn-check" name="platform" id="platform-playstation" autocomplete="off" {{ request('platform') == 'Play Station' ? 'checked' : '' }}>
                <label class="btn btn-outline-dark flex-fill text-center" for="platform-playstation">PlayStation</label>

                <input type="radio" class="btn-check" name="platform" id="platform-wii" autocomplete="off" {{ request('platform') == 'Wii' ? 'checked' : '' }}>
                <label class="btn btn-outline-dark flex-fill text-center" for="platform-wii">Wii</label>

                <input type="radio" class="btn-check" name="platform" id="platform-nintendo" autocomplete="off" {{ request('platform') == 'Nintendo' ? 'checked' : '' }}>
                <label class="btn btn-outline-dark flex-fill text-center" for="platform-nintendo">Nintendo</label>

                <input type="radio" class="btn-check" name="platform" id="platform-pc" autocomplete="off" {{ request('platform') == 'PC' ? 'checked' : '' }}>
                <label class="btn btn-outline-dark flex-fill text-center" for="platform-pc">PC</label>
            </div>


            <!-- Style -->
            <div class="col-12 col-sm-6 col-md-2 filter-group">
                <div class="input-group">
                    <span class="input-group-text bg-dark text-light">Game Style</span>
                    <select class="form-select" name="style">
                        <option value="ALL" {{ request('style') == 'ALL' ? 'selected' : '' }}>ALL</option>
                        <option value="Singleplayer" {{ request('style') == 'Singleplayer' ? 'selected' : '' }}>Singleplayer</option>
                        <option value="Multiplayer" {{ request('style') == 'Multiplayer' ? 'selected' : '' }}>Multiplayer</option>
                        <option value="Coop" {{ request('style') == 'Coop' ? 'selected' : '' }}>Coop</option>
                        <option value="PvP" {{ request('style') == 'PvP' ? 'selected' : '' }}>PvP</option>
                        <option value="PvE" {{ request('style') == 'PvE' ? 'selected' : '' }}>PvE</option>
                    </select>
                </div>
            </div>

            <!-- Pegi -->
            <div class="col-12 col-sm-6 col-md-2 filter-group">
                <div class="input-group">
                    <span class="input-group-text bg-dark text-light">Pegi</span>
                    <select class="form-select" name="pg">
                        <option value="ALL" {{ request('pg') == 'ALL' ? 'selected' : '' }}>ALL</option>
                        <option value="PG-3" {{ request('pg') == 'PG-3' ? 'selected' : '' }}>PG-3</option>
                        <option value="PG-7" {{ request('pg') == 'PG-7' ? 'selected' : '' }}>PG-7</option>
                        <option value="PG-12" {{ request('pg') == 'PG-12' ? 'selected' : '' }}>PG-12</option>
                        <option value="PG-16" {{ request('pg') == 'PG-16' ? 'selected' : '' }}>PG-16</option>
                        <option value="PG-18" {{ request('pg') == 'PG-18' ? 'selected' : '' }}>PG-18</option>
                    </select>
                </div>
            </div>

            <!-- Genre -->
            <div class="col-12 col-sm-6 col-md-2 filter-group">
                <div class="input-group">
                    <span class="input-group-text bg-dark text-light">Genre</span>
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
            <div class="col-12 col-sm-6 col-md-3 filter-group">
                <div class="input-group">
                    <span class="input-group-text bg-dark text-light">Price</span>
                    <input class="form-control" type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min">
                    <span class="input-group-text bg-dark text-light">-</span>
                    <input class="form-control" type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max">
                </div>
            </div>

            <!-- Game Title -->
            <div class="col-12 col-sm-6 col-md-1 filter-group">
                <div class="input-group">
                    <input class="form-control" type="text" name="title" value="{{ request('title') }}" placeholder="Search...">
                </div>
            </div>

            <!-- Sorting -->
            <div class="col-12 col-sm-6 col-md-1 filter-group">
                <select class="form-select" name="sort">
                    <option value="Price⇧" {{ request('sort') == 'Price⇧' ? 'selected' : '' }}>Price⇧</option>
                    <option value="Price⇩" {{ request('sort') == 'Price⇩' ? 'selected' : '' }}>Price⇩</option>
                    <option value="Date⇧" {{ request('sort') == 'Date⇧' ? 'selected' : '' }}>Date⇧</option>
                    <option value="Date⇩" {{ request('sort') == 'Date⇩' ? 'selected' : '' }}>Date⇩</option>
                </select>
            </div>

            <!-- Search Button -->
            <div class="col-12 col-sm-6 col-md-1 filter-group">
                <button class="btn btn-light btn-outline-dark w-100 rounded-pill" type="submit">
                    <i class="fas fa-search"></i>
                </button>
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
