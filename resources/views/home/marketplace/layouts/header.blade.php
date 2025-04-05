<!-- Start Header Area -->
<header class="header navbar-area">

    <!-- End Topbar -->
    <!-- Start Header Middle -->
    <div class="header-middle">
        <div class="container">
            <div class="row align-items-center d-flex justify-content-between">
                {{-- <div class="col-lg-3 col-md-3 col-7">
                    <!-- Start Header Logo -->
                    <a class="navbar-brand" href="index.html">
                        <img src="assets2/images/logo/logo.svg" alt="Logo" />
                    </a>
                    <!-- End Header Logo -->
                </div> --}}
                <div class="col-lg-5 col-md-7 d-xs-none">
                    <!-- Start Main Menu Search -->
                    <div class="main-menu-search">
                        <!-- navbar search start -->
                        <form action="{{ route('produk.cari') }}" method="GET" class="navbar-search search-style-5">
                            <div class="search-input">
                                <input type="text" name="q" value="{{ request('q') }}"
                                    placeholder="Cari produk..." />
                            </div>
                            <div class="search-btn">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </div>
                        </form>
                        <!-- navbar search Ends -->
                    </div>
                    <!-- End Main Menu Search -->
                </div>

                <div class="col-lg-4 col-md-2 col-5 d-flex justify-content-end">
                    <div class="middle-right-area">

                        <div class="navbar-cart">
                            <div class="wishlist">
                                <a href="/marketplace/jual">
                                    <i class="bi bi-plus-circle-dotted"></i>
                                </a>
                            </div>
                            <div class="cart-items">
                                @php
                                    $cart = session('cart', []);
                                    $totalItems = count($cart);
                                @endphp

                                <a href="javascript:void(0)" class="main-btn">
                                    <i class="lni lni-cart"></i>
                                    <span id="total-items">{{ $totalItems }}</span>
                                </a>

                                <!-- Shopping Item -->
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span id="cart-count">{{ $totalItems }} Items</span>
                                        <a href="{{ route('produk.index') }}">View Cart</a>
                                    </div>

                                    <ul class="shopping-list" id="cart-items">

                                        @foreach ($cart as $id => $item)
                                            <li id="cart-item-{{ $id }}">
                                                <a href="javascript:void(0)" class="remove" title="Remove this item"
                                                    onclick="removeFromCart({{ $item['id'] }})">
                                                    <i class="lni lni-close"></i>
                                                </a>
                                                <div class="cart-img-head">


                                                    <a class="cart-img"
                                                        href="{{ route('produk.show', $item['slug']) }}">
                                                        @php
                                                            $gambarArray = json_decode($item['gambar'], true);
                                                            $gambarPath =
                                                                !empty($gambarArray) && isset($gambarArray[0])
                                                                    ? 'storage/' . ltrim($gambarArray[0], '/')
                                                                    : 'images/default.png';
                                                        @endphp

                                                        <img src="{{ asset($gambarPath) }}"
                                                            alt="{{ $item['judul'] }}" />


                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h4>
                                                        <a
                                                            href="{{ route('produk.show', $item['slug']) }}">{{ $item['judul'] }}</a>
                                                    </h4>
                                                    <p class="quantity">
                                                        {{ $item['quantity'] }}x - <span class="amount">Rp
                                                            {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                                    </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <script>
                                let cartData = @json(session('cart', [])); // Inisialisasi dari session Laravel
                            </script>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Middle -->

</header>
<!-- End Header Area -->

<script>
    let cartData = @json(session('cart', [])); // Inisialisasi dari session Laravel
    console.log("Cart Data dari Laravel Session:", cartData);
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function updateCart() {
        fetch("/cart/data")
            .then(response => response.json())
            .then(cart => {
                const cartList = document.getElementById("cart-items");
                const totalItems = document.getElementById("total-items");
                const cartCount = document.getElementById("cart-count");

                if (!cartList) return;

                cartList.innerHTML = "";
                let totalItemCount = 0;

                function truncate(text, maxLength) {
                    return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
                }

                cart.forEach(item => {
                    totalItemCount += item.quantity;

                    let gambarPath = item.gambar ? `/storage/${JSON.parse(item.gambar)[0]}` :
                        '/images/default.png';
                    let judul = truncate(item.judul, 50);

                    let li = document.createElement("li");
                    li.innerHTML = `
                    <a href="javascript:void(0)" class="remove" title="Remove this item" onclick="removeFromCart(${item.id})">
                        <i class="lni lni-close"></i>
                    </a>
                    <div class="cart-img-head">
                        <a class="cart-img" href="/produk/${item.slug}">
                            <img src="${gambarPath}" alt="${judul}" />
                        </a>
                    </div>
                    <div class="content">
                        <h4><a href="/produk/${item.slug}">${judul}</a></h4>
                        <p class="quantity">${item.quantity}x - <span class="amount">Rp ${new Intl.NumberFormat("id-ID").format(item.harga)}</span></p>
                    </div>
                `;
                    cartList.appendChild(li);
                });

                totalItems.textContent = totalItemCount;
                cartCount.textContent = `${totalItemCount} Items`;
            })
            .catch(error => {
                console.error("Gagal memuat data keranjang:", error);
            });
    }


    function removeFromCart(id) {
        fetch(`/cart/remove/${id}`, {
                method: 'POST', // Karena rute hanya mendukung POST
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error("Gagal menghapus item");
                return response.json();
            })
            .then(data => {
                console.log("Item dihapus:", data);
                updateCart();
            })
            .catch(error => {
                console.error("Error saat menghapus:", error);
            });
    }

    document.addEventListener("DOMContentLoaded", function() {


        updateCart(); // Load awal
    });
</script>
