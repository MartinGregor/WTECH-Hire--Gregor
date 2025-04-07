@php use App\Models\Game;use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pds.css') }}">
</head>

<body>
<main>
    <div>
        <a class="navbar-brand payPlay-logo" href="{{ url('/') }}">PayPlay</a>
        <div class="container my-5 d-flex justify-content-center flex-column flex-lg-row">
            <div class="tab-left col-12 col-lg-6">
                <div class="d-flex justify-content-center">
                    <nav class="bread-crumbs" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('cart') }}" class="text-decoration-none">Cart</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('payment.details') }}" class="text-decoration-none">Details</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('payment.shipping') }}" class="text-decoration-none">Shipping</a></li>
                            <li class="breadcrumb-item active fw-bold text-black" aria-current="page">Payment</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <div class="previous-info">
                        <div class="d-flex my-2">
                            <span class="ms-2 fs-6 fw-bold blue">Contact</span>
                            <span class="ms-5 fs-6">{{session()->get('contact')}}</span>
                        </div>
                        <div class="d-flex my-2">
                            <span class="ms-2 fs-6 fw-bold blue">Ship to&nbsp&nbsp</span>
                            <span class="ms-5 fs-6">{{session()->get('city')}}, {{session()->get('postal_code')}}, {{session()->get('address')}}, {{session()->get('country')}}</span>
                        </div>
                        <div class="d-flex my-2">
                            <span class="ms-2 fs-6 fw-bold blue">Method</span>
                            <span class="ms-5 fs-6">{{session()->get('shipping_type')}}</span>
                        </div>
                    </div>
                    <div>
                        <div class="mt-4">
                            <span class="ms-4 fs-6 fw-bold">Payment Method</span>
                        </div>

                        <div class="px-4 my-4">
                            <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
                                <li class="m-0 w-50 nav-item" role="presentation" >
                                    <button class="m-0 w-50 nav-link active w-100" id="card-tab" data-bs-toggle="tab" data-bs-target="#card" type="button" role="tab" aria-controls="card" aria-selected="true">Credit Card</button>
                                </li>
                                <li class="m-0 w-50 nav-item" role="presentation">
                                    <button class="m-0 w-50 nav-link w-100" id="cash-tab" data-bs-toggle="tab" data-bs-target="#cash" type="button" role="tab" aria-controls="cash" aria-selected="false">Cash</button>
                                </li>
                            </ul>

                            <div class="tab-content mt-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="card" role="tabpanel" aria-labelledby="card-tab">
                                    <div class="d-flex align-items-center mb-2">
                                        <input class="form-info form-control me-2" type="search" placeholder="Card Number" aria-label="Code">
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <input class="form-info form-control me-2" type="search" placeholder="Holder's Name (Optional)" aria-label="Code">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input class="form-info form-control me-2 double-info" type="search" placeholder="Expiration (MM/YY)" aria-label="Code">
                                        <input class="form-info form-control me-2 double-info" type="search" placeholder="CVV" aria-label="Code">
                                    </div>
                                </div>
                                <div class="tab-pane fade p-4" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                                    <span>You have selected to pay in cash. Please have the exact amount ready upon delivery or at the counter. Thank you!</span>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-center mt-3 gap-4">
                            <a href="{{'shipping'}}" class="btn btn-light btn-md text-black double-button">
                                Back to Shipping
                            </a>
                            <a href="{{route('payment.complete')}}" class="btn btn-light btn-md text-black double-button">
                                Pay Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-right col-12 col-lg-6">
                <div class="mb-3 d-flex" style="flex-wrap: nowrap; overflow: visible;">
                    @auth
                        @foreach(Auth::user()->cart->games as $item)
                            <div class="card">
                                <img src="{{ $item->logo }}" class="card-img-top" alt="...">
                            </div>
                        @endforeach
                    @else
                        @foreach(session()->get('cart', []) as $item)
                            <div class="card">
                                <img src="{{ Game::find($item['game_id'])->logo }}" class="card-img-top" alt="...">
                            </div>
                        @endforeach
                    @endauth
                </div>


                <div class="shelf px-4">
                    <div class="d-flex justify-content-between">
                        <span class="ms-4 fs-6 fw-bold">Subtotal</span>
                        <span class=" fs-6 fw-bold">{{$total}} €</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="ms-4 fs-6 fw-bold">Shipping</span>
                        <span class="ms-4 fs-6 fw-bold">{{session()->get('shipping_price')}} €</span>
                    </div>
                </div>
                <div class="shelf d-flex justify-content-between">
                    <span class="ms-3 fs-4 fw-bold">Total</span>
                    <span class="fs-4 fw-bold">{{$total + session()->get('shipping_price')}} €</span>
                </div>
            </div>
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
