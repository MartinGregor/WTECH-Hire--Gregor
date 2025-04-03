<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $game->title }}</title>
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
            <a class="navbar-brand" href="#">PayPlay</a>
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

    <div class="container mt-5 px-lg-5 product-box">
        <div class="row">
            <div class="col-lg-7">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        @foreach ($game->images as $index => $image)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                        @foreach ($game->videos as $index => $video)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index + count($game->images) }}" class="{{ $index == 0 && count($game->images) == 0 ? 'active' : '' }}" aria-label="Video {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach ($game->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset($image->image_url) }}" class="d-block w-100 product-image" alt="...">
                            </div>
                        @endforeach
                        @foreach ($game->videos as $index => $video)
                            <div class="carousel-item">
                                <div class="ratio ratio-16x9">
                                    <iframe class="product-image" src="{{ $video->video_url }}" title="YouTube video" allowfullscreen></iframe>
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
                <h5 class="text-white mb-3">Categories:
                    @foreach ($game->genres as $genre)
                        {{ $genre->name }}@if(!$loop->last), @endif
                    @endforeach
                </h5>
                <h5 class="text-white">Price: {{ number_format($game->price, 2) }} €</h5>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-light">-</button>
                        <input type="text" id="quantity-input" class="form-control text-center mx-1 text-black-bold width-50" value="1">
                        <button class="btn btn-outline-light">+</button>
                    </div>
                    <button class="btn btn-dark btn-outline-light btn-md px-4 py-2 rounded-pill">Add to Cart</button>
                </div>
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
