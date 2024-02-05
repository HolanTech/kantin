@extends('layouts.master')
@section('title', 'Order')
@section('content')
    <style>
        .card {
            border-top-left-radius: 30px;
            border-bottom-right-radius: 20px;
        }

        .card-header {
            position: fixed;
            margin-top: -30px;
            width: 100%;
            z-index: 1000;
            background-color: rgb(0, 225, 255);
        }

        .nav-item.search-box {
            width: 100%;
            display: flex;
            align-items: center;
        }

        .search-input {
            border: none;
            border-bottom: 1px solid #ced4da;
            outline: none;
        }

        .nav-tabs .nav-item {
            margin-right: 10px;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-link.active:hover,
        .nav-tabs .nav-link.active:focus {
            color: #00f1e9 !important;
            background-color: #007bff !important;
            border-color: #007bff !important;
        }

        .card-equal-height {
            display: flex;
            flex-wrap: wrap;
        }

        .card-equal-height .card {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }

        .card-img-top {
            width: 100% !important;
            height: 150px !important;
            object-fit: cover !important;
        }

        .card-menu {
            margin-top: 30px;
            background-color: #04b7db;
        }

        .card-body {
            margin-top: 25px;
            height: 75px;
            margin-bottom: 2px;
        }

        .btn-quantity {
            width: 30px;
            height: 30px;
            line-height: 20px;
        }

        .status-badge {
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .card-title {
            margin-top: -40px;
            font-size: 14px;
            font-weight: bold;
        }

        .card-text {
            margin-top: -10px;
            font-size: 12px;
        }

        .item-price {
            margin-top: -20px;
        }

        .col-4 {
            margin-top: -5px;
        }

        .floating-action-btn {
            position: fixed;
            bottom: 100px;
            right: 20px;
            z-index: 5000;
        }

        body {
            margin-bottom: 50%;
            background-color: #c7ebf3;
        }
    </style>
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs">
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
        <button class="btn btn-primary" onclick="showOrderModal()">Order</button>
    </div>

    <div id="orderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Input untuk ID RFID -->
                    <div class="form-group">
                        <label for="rfidInput">Tempelkan Kartu RFID:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="rfidInput" placeholder="ID RFID" />
                        </div>
                        <small id="rfidHelp" class="form-text text-muted">Pindai kartu RFID Anda untuk mendapatkan
                            ID.</small>
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
                    <p>Saldo saat ini : Rp <span id="currentSaldo">0</span></p>
                    <p id="totalPriceText">Harga Total: Rp <span id="totalPrice">0</span></p>
                    <p>Sisa saldo: Rp <span id="remainingSaldo">0</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="next()">Next</button>
                </div>
            </div>
        </div>
    </div>
    <div id="orderModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Tempat untuk menampilkan saldo jika RFID terdaftar -->
                    <div id="saldoContainer" style="display: block;">
                        <p id="saldoText">Saldo Tersedia: Rp <span id="saldoAmount">0</span></p>
                    </div>

                    <!-- List Order -->
                    <ul id="orderModalItemList" class="list-unstyled">
                        <!-- Rincian pesanan akan ditampilkan di sini -->
                    </ul>
                    <hr>
                    <p id="totalItemsText">Total Items: <span id="totalItems">0</span></p>
                    <p>Saldo saat ini : Rp <span id="currentSaldo">0</span></p>
                    <p id="totalPriceText">Harga Total: Rp <span id="totalPrice">0</span></p>
                    <p>Sisa saldo: Rp <span id="remainingSaldo">0</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="submitOrder()">Sumbit</button>
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
            $(document).ready(function() {
                // Callback yang dipanggil saat RFID berhasil dibaca
                function onRFIDRead(rfidData) {
                    // Simpan ID RFID ke dalam input
                    $('#rfidInput').val(rfidData);

                    // Lakukan permintaan AJAX untuk memeriksa apakah RFID terdaftar dan dapatkan saldo
                    $.ajax({
                        url: '/api/check-rfid',
                        method: 'POST',
                        data: {
                            rfidData: rfidData
                        },
                        success: function(response) {
                            if (response.registered) {
                                // RFID terdaftar, tampilkan saldo
                                $('#saldoAmount').text(response.saldo);
                                $('#saldoContainer').show();
                            } else {
                                // RFID tidak terdaftar, sembunyikan saldo
                                $('#saldoContainer').hide();
                            }
                        },
                        error: function(error) {
                            console.error('Gagal memeriksa RFID:', error);
                        }
                    });
                }

                // Kode untuk menghubungkan pembaca RFID dan memanggil onRFIDRead
                // ...

                // Callback yang dipanggil saat tombol "Submit Order" ditekan
                window.submitOrder = function() {
                    // Lakukan logika penyimpanan order dan pembaruan saldo
                    // ...

                    // Setelah penyimpanan order, perbarui tampilan modal
                    showOrderModal();

                    // Reset data keranjang belanja
                    resetCartData();
                };

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

                cartItemsList.innerHTML = ''; // Menghapus item-item sebelumnya dalam daftar

                Object.keys(quantities).forEach(function(key) {
                    if (quantities[key] > 0) {
                        totalItems++;
                        const [type, id] = key.split('-');
                        const itemName = document.getElementById(`name-${type}-${id}`).textContent;
                        const itemPrice = quantities[key] * parseFloat(document.getElementById(
                            `price-${type}-${id}`).dataset.price);

                        totalPrice += itemPrice;

                        const listItem = document.createElement('li');
                        listItem.textContent =
                            `${itemName}: ${quantities[key]} pcs x Rp ${parseFloat(document.getElementById(`price-${type}-${id}`).dataset.price).toFixed(2)} = Rp ${itemPrice.toFixed(2)}`;
                        cartItemsList.appendChild(listItem);
                    }
                });

                totalItemsElement.textContent = `Jumlah Jenis Orderan: ${totalItems}`;
                totalPriceElement.textContent = `Total Harga: Rp ${totalPrice.toFixed(2)}`;
                showOrderModal();
            }

            function showOrderModal() {

                const orderModalItemList = document.getElementById('orderModalItemList');
                const totalItemsElement = document.getElementById('totalItems');
                const totalPriceElement = document.getElementById('totalPrice');
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
                            `<strong>${itemName}:</strong> ${quantity}x Rp ${itemPrice.toFixed(2)} = Rp ${(itemPrice * quantity).toFixed(2)}`;
                        orderModalItemList.appendChild(listItem);
                    }
                });

                totalItemsElement.textContent = totalQuantity;
                totalPriceElement.textContent = totalPrice.toFixed(2);

                // Memperbarui modal
                $('#orderModal').modal('show');
            }

            function saveOrder() {
                // Tambahkan logika penyimpanan order di sini sesuai kebutuhan
                // Misalnya, Anda dapat mengirim data pesanan ke server atau menyimpan ke database
                // Setelah menyimpan, Anda dapat menutup modal dan melakukan reset data
                $('#orderModal').modal('hide');
                resetCartData();
            }
            $('#orderModal').on('shown.bs.modal', function() {
                document.querySelectorAll('#orderModal .btn-quantity').forEach(function(btnQuantity) {
                    btnQuantity.addEventListener('click', function() {
                        updateQuantity(btnQuantity.id, btnQuantity.textContent === '+' ? 1 :
                            -1);
                    });
                });
            });
            $('#orderModal .btn-primary').on('click', function() {
                // Tambahkan logika penyimpanan order di sini jika diperlukan
                $('#orderModal').modal('hide');
                resetCartData();
            });
            $('#orderModal .btn-secondary').on('click', function() {
                $('#orderModal').modal('hide');
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
    </script>
    <script>
        // Fungsi untuk menampilkan saldo, harga total, dan sisa saldo

        // Callback yang dipanggil saat RFID berhasil dibaca
        function onRFIDRead(rfidData) {
            // Simpan ID RFID ke dalam input
            $('#rfidInput').val(rfidData);

            // Lakukan permintaan AJAX untuk memeriksa apakah RFID terdaftar dan dapatkan saldo
            $.ajax({
                url: '/api/check-rfid',
                method: 'POST',
                data: {
                    rfidData: rfidData
                },
                success: function(response) {
                    if (response.registered) {
                        // RFID terdaftar, tampilkan saldo
                        $('#saldoAmount').text(response.saldo);
                        $('#saldoContainer').show();
                        // Also, show the modal after updating saldo
                        $('#orderModal').modal('show');
                    } else {
                        // RFID tidak terdaftar, sembunyikan saldo
                        $('#saldoContainer').hide();
                    }
                },
                error: function(error) {
                    console.error('Gagal memeriksa RFID:', error);
                }
            });
        }

        function updateSaldoInfo(saldo, totalPrice) {
            const currentSaldo = parseFloat(document.getElementById('saldoAmount').innerText);
            const remainingSaldo = currentSaldo - totalPrice;

            document.getElementById('currentSaldo').innerText = currentSaldo.toFixed(2);
            document.getElementById('remainingSaldo').innerText = remainingSaldo.toFixed(2);
        }
    </script>
@endpush
