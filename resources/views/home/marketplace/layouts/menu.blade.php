<style>
    .sticky-sidebar {
        position: sticky;
        top: 10px;
        /* Jarak dari atas */
        height: fit-content;
        /* Sesuai kontennya */
    }
</style>

<div class="col-lg-4 sticky-sidebar">
    <div class="card">
        <ul class="list-group">
            <li class="list-group-item">
                <h4>Menu Marketplace</h4>
            </li>
            <a href="/marketplace/produk-saya"
                class="list-group-item list-group-item-action {{ Request::is('marketplace/produk-saya') ? 'active' : '' }}">
                Produk saya
            </a>
            <a href="/marketplace/jual"
                class="list-group-item list-group-item-action {{ Request::is('marketplace/jual') ? 'active' : '' }}">
                Jual produk
            </a>
        </ul>
    </div>
</div>
