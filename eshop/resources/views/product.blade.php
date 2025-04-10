<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $game->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<main>
    <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary shadow-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PayPlay</a>
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

    <div class="container mt-5 px-lg-5 product-box">
        <div class="row">
            <div class="col-lg-7">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <!-- Logo indicator -->
                        @if ($game->logo)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Logo"></button>
                        @endif

                        <!-- Image indicators -->
                        @foreach ($game->images as $index => $image)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index + ($game->logo ? 1 : 0) }}" class="{{ $index == 0 && !$game->logo ? 'active' : '' }}" aria-current="{{ $index == 0 && !$game->logo ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach

                        <!-- Video indicators -->
                        @foreach ($game->videos as $index => $video)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index + count($game->images) + ($game->logo ? 1 : 0) }}" class="{{ $index == 0 && count($game->images) == 0 && !$game->logo ? 'active' : '' }}" aria-label="Video {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        <!-- Logo -->
                        @if ($game->logo)
                            <div class="carousel-item active">
                                <div class="aspect-ratio-box">
                                    <img src="{{ asset($game->logo) }}" class="logo-img" alt="Game Logo">
                                </div>
                            </div>
                        @endif

                        <!-- Images -->
                        @foreach ($game->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 && !$game->logo ? 'active' : '' }}">
                                <img src="{{ asset($image->image_url) }}" class="d-block w-100 product-image" alt="Image {{ $index + 1 }}">
                            </div>
                        @endforeach

                        <!-- Videos -->
                        @foreach ($game->videos as $index => $video)
                            <div class="carousel-item">
                                <div class="ratio ratio-16x9">
                                    <iframe class="product-image" src="{{ $video->video_url }}" title="Video {{ $index + 1 }}" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endforeach
                    </div>




                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 d-flex flex-column justify-content-center">
                <h2 class="fw-bold bg-white game-title">{{ $game->title }}</h2>
                <p class="text-white mb-5">{{ $game->description ?? 'No description available.' }}</p>
                <div class="d-flex align-items-center pb-2">
                    <h5 class="text-white mb-0 me-2">Platform: {{ $game->platform }}</h5>
                    <img class="platform" src="{{ asset('images/Logos/' .
                        ($game->platform == 'Play Station' ? 'playstation-logotype.png' :
                        ($game->platform == 'Xbox' ? 'xbox-logo.png' :
                        ($game->platform == 'Nintendo' ? 'nintendo-switch.png' :
                        ($game->platform == 'PC' ? 'computer.png' :
                        ($game->platform == 'Wii' ? 'wii.png' : 'computer.png')))))) }}" alt="Platform Logo">
                </div>
                <h5 class="text-white mb-3 me-2">Age restrictions: {{ $game->pg }}</h5>
                <h5 class="text-white mb-3 me-2">Gameplay style: {{ $game->style }}</h5>
                <h5 class="text-white mb-3">Genres:
                    @foreach ($game->genres as $genre)
                        {{ $genre->name }}@if(!$loop->last), @endif
                    @endforeach
                </h5>
                <h5 class="text-white">Price: {{ number_format($game->price, 2) }} €</h5>
                <form action="{{ route('insert.game.to.cart') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-light" onclick="changeQuantity(-1)">-</button>
                            <input type="text" id="quantity-input" name="quantity" class="form-control text-center mx-1 text-black-bold width-50" value="1">
                            <button type="button" class="btn btn-outline-light" onclick="changeQuantity(1)">+</button>
                        </div>
                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                        <button type="submit" class="btn btn-dark btn-outline-light btn-md px-4 py-2 rounded-pill">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="position-relative bottom-0 start-50 translate-middle-x text-white fw-bold py-2 px-4 d-inline-block text-center product-mark">
            © {{ $game->publisher }}
        </div>
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

<script>
    document.querySelector('.btn-outline-light:first-of-type').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity-input');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    document.querySelector('.btn-outline-light:last-of-type').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity-input');
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
</script>
