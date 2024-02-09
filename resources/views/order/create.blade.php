@extends('layouts.master')

@section('title', 'Order')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/order.css') }}">

    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs justify-content-between">
                <div class="d-flex">
                    <li class="nav-item">
                        <a class="nav-link {{ session('active_tab') === 'all' ? 'active' : '' }}" href="#all"
                            onclick="showTab('all')">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ session('active_tab') === 'foods' ? 'active' : '' }}" href="#foods"
                            onclick="showTab('foods')">Foods</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ session('active_tab') === 'drinks' ? 'active' : '' }}" href="#drinks"
                            onclick="showTab('drinks')">Drinks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ session('active_tab') === 'snacks' ? 'active' : '' }}" href="#snacks"
                            onclick="showTab('snacks')">Snacks</a>
                    </li>
                </div>
                <li class="nav-item">
                    <form method="post" action="{{ route('admin.user.checksaldo') }}" id="checkSaldoForm"
                        class="form-inline">
                        @csrf
                        <div class="input-group">
                            <input type="password" class="form-control" name="rfidInputCheck" autofocus
                                placeholder="ID RFID" required />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Cek Saldo</button>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="card-menu text-center">
        <div id="all" class="tab-content">
            <div id="foods" class="row tab-content card-equal-height">
                @foreach ($foods as $food)
                    <div class="col-6">
                        <div class="card d-flex flex-column">
                            <img class="card-img-top" src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" id="name-food-{{ $food->id }}">{{ $food->name }}</h5>
                                <p class="card-text">{{ Str::limit($food->description, 100) }}</p>
                                <div data-price="{{ $food->price }}" id="price-food-{{ $food->id }}"
                                    class="food-price item-price">
                                    {{ number_format($food->price, 2, '.', '') }}
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <span class="btn btn-danger btn-quantity btn-sm"
                                            id="btn-min-food-{{ $food->id }}">-</span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span class="quantity-label" id="quantity-food-{{ $food->id }}">0</span>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="btn btn-success btn-quantity btn-sm"
                                            id="btn-plus-food-{{ $food->id }}">+</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="drinks" class="row tab-content card-equal-height">
                @foreach ($drinks as $drink)
                    <div class="col-6">
                        <div class="card d-flex flex-column">
                            <img class="card-img-top" src="{{ Storage::url($drink->image) }}" alt="{{ $drink->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" id="name-drink-{{ $drink->id }}">{{ $drink->name }}</h5>
                                <p class="card-text">{{ Str::limit($drink->description, 100) }}</p>
                                <div data-price="{{ $drink->price }}" id="price-drink-{{ $drink->id }}"
                                    class="drink-price item-price">
                                    {{ number_format($drink->price, 2, '.', '') }}
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <span class="btn btn-danger btn-quantity btn-sm"
                                            id="btn-min-drink-{{ $drink->id }}">-</span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span class="quantity-label" id="quantity-drink-{{ $drink->id }}">0</span>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="btn btn-success btn-quantity btn-sm"
                                            id="btn-plus-drink-{{ $drink->id }}">+</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="snacks" class="row tab-content card-equal-height">
                @foreach ($snacks as $snack)
                    <div class="col-6">
                        <div class="card d-flex flex-column">
                            <img class="card-img-top" src="{{ Storage::url($snack->image) }}" alt="{{ $snack->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" id="name-snack-{{ $snack->id }}">{{ $snack->name }}</h5>
                                <p class="card-text">{{ Str::limit($snack->description, 100) }}</p>
                                <div data-price="{{ $snack->price }}" id="price-snack-{{ $snack->id }}"
                                    class="snack-price item-price">
                                    {{ number_format($snack->price, 2, '.', '') }}
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <span class="btn btn-danger btn-quantity btn-sm"
                                            id="btn-min-snack-{{ $snack->id }}">-</span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span class="quantity-label" id="quantity-snack-{{ $snack->id }}">0</span>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="btn btn-success btn-quantity btn-sm"
                                            id="btn-plus-snack-{{ $snack->id }}">+</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="orderBtn" class="floating-action-btn" style="display: none;">

        <button class="btn btn-primary" style="font-size: 25px;" onclick="showOrderModal()"> <i
                class="fas fa-shopping-cart"></i><br>
            Order</button>
    </div>

    <div id="orderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Order</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" action="{{ route('order.store') }}" method="POST">
                        <!-- Input untuk ID RFID -->
                        <div class="form-group">
                            {{-- <label for="rfidInput">Tempelkan Kartu RFID:</label> --}}
                            <small id="rfidHelp" class="form-text text-muted">Pindai kartu RFID Anda dan Masukkan
                                Password untuk Melanjutkan Pembayaran.</small>
                            <div class="input-group">
                                <input type="password" class="form-control" id="rfidInput" name="rfidInput" autofocus
                                    placeholder="Tempelkan RFID anda" required />
                                <input type="password" class="form-control" id="password" name="password" autofocus
                                    placeholder="Masukkan Password" required />
                            </div>

                        </div>

                        <!-- Tempat untuk menampilkan saldo jika RFID terdaftar -->
                        <div id="saldoContainer" style="display: none;">
                            <p id="saldoText">Saldo Tersedia: Rp <span id="saldoAmount">0</span></p>
                        </div>

                        <!-- List Order -->
                        <ul id="orderModalItemList" class="list-unstyled">
                            <!-- Rincian pesanan akan ditampilkan di sini -->
                        </ul>
                        <hr>
                        <p id="totalItemsText">Total Items: <span id="totalItems">0</span></p>
                        <p id="totalPriceText">Harga Total: Rp <span id="totalPrice">0</span></p>


                        @csrf <!-- Pastikan CSRF token ada untuk Laravel -->
                        <input type="hidden" id="hiddenTotalItems" name="totalItems" value="">
                        <input type="hidden" id="hiddenTotalPrice" name="totalPrice" value="">
                        <input type="hidden" id="hiddenOrderDetails" name="orderDetails" value="">
                        <br><small>Note : Periksa Kembali Pesanan, Setelah pembayran berhasil .pesanan tidak dapat
                            dibatalakan.</small><br>
                        <button type="button" class="btn btn-secondary" style="width: 48%;"
                            data-bs-dismiss="modal">Tembah
                            Menu</button>
                        <button type="submit" class="btn btn-primary" style="width: 48%;">Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orderBtn button').on('click', function() {
                showOrderModal();
            });

            let quantities = {};
            const btnMin = document.querySelectorAll('.btn-danger');
            const btnPlus = document.querySelectorAll('.btn-success');
            const btnSaveCart = document.getElementById('btn-save-cart');
            const totalItemsElement = document.getElementById('total-items');
            const totalPriceElement = document.getElementById('total-price');
            const cartItemsList = document.getElementById('cart-items-list');
            const tabs = document.querySelectorAll('.nav-tabs .nav-link');

            btnMin.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    updateQuantity(btn.id, -1);
                });
            });

            btnPlus.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    updateQuantity(btn.id, 1);
                });
            });

            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    showTab(tab);
                });
            });

            function updateQuantity(btnId, change) {
                const itemId = btnId.split('-')[3];
                const itemType = btnId.split('-')[2];
                const key = `${itemType}-${itemId}`;
                quantities[key] = (quantities[key] || 0) + change;
                quantities[key] = Math.max(quantities[key], 0);

                document.getElementById(`quantity-${itemType}-${itemId}`).textContent = quantities[key];

                updateOrderButtonDisplay();
            }

            function updateOrderButtonDisplay() {
                let totalQuantity = 0;
                for (let key in quantities) {
                    totalQuantity += quantities[key];
                }
                const orderBtn = document.getElementById('orderBtn');
                if (totalQuantity > 0) {
                    orderBtn.style.display = 'block';
                } else {
                    orderBtn.style.display = 'none';
                }
                updateCartView();
            }

            function updateCartView() {
                let totalItems = 0;
                let totalPrice = 0;
                let itemsDetail = [];

                cartItemsList.innerHTML = ''; // Menghapus item-item sebelumnya dalam daftar

                Object.keys(quantities).forEach(function(key) {
                    if (quantities[key] > 0) {
                        totalItems += quantities[key];
                        const [type, id] = key.split('-');
                        const itemName = document.getElementById(`name-${type}-${id}`).textContent;
                        const itemPrice = quantities[key] * parseFloat(document.getElementById(
                            `price-${type}-${id}`).dataset.price);

                        totalPrice += itemPrice;

                        itemsDetail.push({
                            name: itemName,
                            quantity: quantities[key],
                            pricePerItem: parseFloat(document.getElementById(`price-${type}-${id}`)
                                .dataset.price),
                            totalPrice: itemPrice
                        });

                        const listItem = document.createElement('li');
                        listItem.textContent =
                            `${itemName}: ${quantities[key]} pcs x Rp ${parseFloat(document.getElementById(`price-${type}-${id}`).dataset.price).toFixed(2)} = Rp ${itemPrice.toFixed(2)}`;
                        cartItemsList.appendChild(listItem);
                    }
                });

                // Simpan detail order sebagai JSON string dalam input hidden
                document.getElementById('hiddenTotalItems').value = totalItems;
                document.getElementById('hiddenTotalPrice').value = totalPrice;
                // Contoh untuk menyimpan detail order, gantikan dengan input hidden yang sesuai
                // Pastikan Anda memiliki input hidden untuk menyimpan data JSON
                document.getElementById('yourHiddenInputForOrderDetails').value = JSON.stringify(itemsDetail);

                totalItemsElement.textContent = `Jumlah Jenis Orderan: ${totalItems}`;
                totalPriceElement.textContent = `Total Harga: Rp ${totalPrice.toFixed(2)}`;
                showOrderModal();
            }



            function showOrderModal() {
                const orderModalItemList = document.getElementById('orderModalItemList');
                const totalItemsElement = document.getElementById(
                    'totalItems'); // Pastikan ID sesuai dengan markup HTML Anda
                const totalPriceElement = document.getElementById(
                    'totalPrice'); // Pastikan ID sesuai dengan markup HTML Anda
                orderModalItemList.innerHTML = '';

                let totalQuantity = 0;
                let totalPrice = 0;

                // Memasukkan nilai ke dalam modal
                Object.keys(quantities).forEach(function(key) {
                    const [type, id] = key.split('-');
                    const itemName = document.getElementById(`name-${type}-${id}`).textContent;
                    const itemPrice = parseFloat(document.getElementById(`price-${type}-${id}`).dataset
                        .price);
                    const quantity = quantities[key];

                    if (quantity > 0) {
                        totalQuantity += quantity;
                        totalPrice += itemPrice * quantity;

                        const listItem = document.createElement('li');
                        listItem.innerHTML =
                            `<strong>${itemName}:</strong> ${quantity}x Rp ${itemPrice.toFixed(0)} = Rp ${(itemPrice * quantity).toFixed(0)}__`;
                        orderModalItemList.appendChild(listItem);
                    }
                });

                // Memperbarui total item dan harga pada modal
                totalItemsElement.textContent = `Total Item: ${totalQuantity}`;
                totalPriceElement.textContent = `Total Harga: Rp ${totalPrice.toFixed(2)}`;

                // Tampilkan modal
                $('#orderModal').modal('show');
            }


            $('#orderModal').on('shown.bs.modal', function() {
                document.querySelectorAll('#orderModal .btn-quantity').forEach(function(btnQuantity) {
                    btnQuantity.addEventListener('click', function() {
                        updateQuantity(btnQuantity.id, btnQuantity.textContent === '+' ? 1 :
                            -1);
                    });
                });
            });

            function showTab(tab) {
                tabs.forEach(function(t) {
                    t.classList.remove('active');
                });

                tab.classList.add('active');

                const tabId = tab.getAttribute('href').substring(1);

                document.querySelectorAll('.tab-content .row').forEach(function(tabContent) {
                    const isActiveTab = tabId === 'all' || tabContent.id === tabId;
                    tabContent.style.display = isActiveTab ? 'flex' : 'none';
                    if (isActiveTab) {
                        showQuantityButtons(tabId);
                    } else {
                        hideQuantityButtons(tabContent.id);
                    }
                });

                if (tabId === 'all') {
                    showAllTabs();
                } else {
                    hideOtherTabs(tabId);
                }

                searchItems();
            }

            function showAllTabs() {
                document.querySelectorAll('.tab-content .row').forEach(function(tabContent) {
                    tabContent.style.display = 'flex';
                    showQuantityButtons(tabContent.id);
                });
            }

            function hideOtherTabs(activeTabId) {
                document.querySelectorAll('.tab-content .row').forEach(function(tabContent) {
                    const tabId = tabContent.id;
                    if (tabId !== activeTabId) {
                        tabContent.style.display = 'none';
                        hideQuantityButtons(tabId);
                    }
                });
            }

            function hideQuantityButtons(tabId) {
                document.querySelectorAll(`#${tabId} .btn-quantity`).forEach(function(btnQuantity) {
                    btnQuantity.style.display = 'none';
                });
            }

            function showQuantityButtons(tabId) {
                document.querySelectorAll(`#${tabId} .btn-quantity`).forEach(function(btnQuantity) {
                    btnQuantity.style.display = 'inline-block';
                });
            }
        });

        $('#orderForm').on('submit', function(event) {
            updateFormValues(); // Memastikan nilai terbaru diset ke input tersembunyi sebelum submit
        });

        function updateFormValues() {
            // Misalkan `totalItems`, `totalPrice`, dan `orderDetails` dihitung di sini
            // Contoh sederhana, sesuaikan dengan logika aplikasi Anda
            var totalItems = document.getElementById('totalItems').textContent.split(': ')[1];
            var totalPrice = document.getElementById('totalPrice').textContent.split(': Rp ')[1];
            var orderDetails = document.getElementById('orderModalItemList').textContent;

            document.getElementById('hiddenTotalItems').value = totalItems;
            document.getElementById('hiddenTotalPrice').value = totalPrice;
            document.getElementById('hiddenOrderDetails').value = JSON.stringify(orderDetails);


        }
    </script>
    <script>
        $(document).ready(function() {
            $('#checkSaldoForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: form.attr('action'), // Menggunakan action dari form itu sendiri
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Saldo Anda',
                                text: 'Rp ' + response.saldo,
                                icon: 'info'
                            }).then((result) => {
                                // Setelah pengguna klik 'OK', bersihkan inputan
                                if (result.value) {
                                    $('input[name="rfidInputCheck"]').val('');
                                    $('input[name="rfidInputCheck"]')
                                        .focus(); // Opsional, untuk fokus kembali ke inputan
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tangani jika terjadi error pada request
                        Swal.fire('Error!', 'Terjadi kesalahan, silakan coba lagi.', 'error');
                    }
                });
            });
        });


        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
@endpush
