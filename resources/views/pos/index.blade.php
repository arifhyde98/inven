@extends('layouts.app')

@section('title', 'Kasir / Point of Sale (POS)')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Kasir POS</div>
@endsection

@section('content')
<div class="row">
    <!-- Kolom Kiri: Scan & Daftar Produk -->
    <div class="col-lg-7 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4><i class="fas fa-barcode mr-1"></i> Scan Barcode atau Cari Barang</h4>
                @if(auth()->user()->isSuperAdmin())
                <div class="card-header-action">
                    <form method="GET" action="{{ route('pos.index') }}" class="form-inline">
                        <select name="cabang_id" class="form-control form-control-sm" onchange="this.form.submit()">
                            @foreach($cabangs as $cb)
                                <option value="{{ $cb->id }}" {{ $cabangId == $cb->id ? 'selected' : '' }}>{{ $cb->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @endif
            </div>
            <div class="card-body">
                <!-- Barcode Scan Form -->
                <form id="form-scan-barcode" class="mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                        </div>
                        <input type="text" id="barcode-input" class="form-control form-control-lg" placeholder="Scan Barcode atau ketik Barcode lalu Enter..." autofocus autocomplete="off">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Masukkan</button>
                        </div>
                    </div>
                </form>

                <!-- Search Input -->
                <div class="form-group mb-3">
                    <input type="text" id="product-search" class="form-control" placeholder="Cari nama barang di cabang ini...">
                </div>

                <!-- Product Cards / Table -->
                <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                    <table class="table table-hover table-sm" id="table-products">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $b)
                            <tr class="product-row" data-name="{{ strtolower($b->nama_barang) }}" data-barcode="{{ $b->barcode }}">
                                <td>
                                    <strong>{{ $b->nama_barang }}</strong><br>
                                    <small class="text-muted">{{ $b->barcode }}</small>
                                </td>
                                <td><span class="badge badge-light">{{ $b->kategori }}</span></td>
                                <td class="font-weight-bold text-primary">Rp {{ rupiah($b->harga_jual) }}</td>
                                <td>
                                    <span class="badge badge-{{ $b->stok > 5 ? 'success' : ($b->stok > 0 ? 'warning' : 'danger') }}">
                                        {{ $b->stok }} {{ $b->satuan }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-product" 
                                            data-id="{{ $b->id }}" 
                                            data-stok="{{ $b->stok }}"
                                            {{ $b->stok < 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus"></i> Tambah
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada produk tersedia di cabang ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Keranjang Kasir & Pembayaran -->
    <div class="col-lg-5 col-md-12">
        <div class="card card-hero">
            <div class="card-header" style="padding: 15px 25px;">
                <div class="card-icon">
                    <i class="fas fa-cash-register"></i>
                </div>
                <h4>Keranjang Kasir</h4>
                <div class="card-description">ID Pembelian: <strong>{{ $idPembelian }}</strong></div>
            </div>
            <div class="card-body p-0">
                <div id="cart-container">
                    @include('pos.partials.cart_table')
                </div>

                <div class="p-3">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" id="btn-clear-cart" class="btn btn-outline-danger btn-block" {{ $cart->isEmpty() ? 'disabled' : '' }}>
                                <i class="fas fa-trash"></i> Kosongkan
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" id="btn-open-checkout" class="btn btn-success btn-block font-weight-bold" {{ $cart->isEmpty() ? 'disabled' : '' }}>
                                <i class="fas fa-check-circle"></i> Bayar (F9)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Checkout -->
<div class="modal fade" id="modal-checkout" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-checkout">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white"><i class="fas fa-cash-register mr-1"></i> Pembayaran Transaksi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_pembelian" value="{{ $idPembelian }}">
                    <input type="hidden" name="cabang_id" value="{{ $cabangId }}">

                    <div class="alert alert-light border text-center mb-3">
                        <span class="text-muted d-block small">TOTAL TAGIHAN</span>
                        <h2 class="text-primary font-weight-bold mb-0" id="modal-tagihan-text">Rp {{ rupiah($total) }}</h2>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-600">Metode Pembayaran</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="metode" value="tunai" class="selectgroup-input" checked id="radio-tunai">
                                <span class="selectgroup-button"><i class="fas fa-money-bill mr-1"></i> Tunai (Cash)</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="metode" value="cicilan" class="selectgroup-input" id="radio-cicilan">
                                <span class="selectgroup-button"><i class="fas fa-hand-holding-usd mr-1"></i> Cicilan / Hutang</span>
                            </label>
                        </div>
                    </div>

                    <!-- Customer selection for cicilan -->
                    <div class="form-group mb-3" id="group-customer" style="display: none;">
                        <label class="font-weight-600">Pilih Pelanggan <span class="text-danger">*</span></label>
                        <select name="id_user" id="select-customer" class="form-control">
                            <option value="">-- Pilih Pelanggan Terdaftar --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id_user }}">{{ $c->nama_user }} ({{ $c->tlp_user ?? '-' }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pelanggan belum ada? Tambahkan di menu Pelanggan Tetap.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-600" id="label-uang">Uang Diterima (Rp)</label>
                        <input type="number" name="uang_saya" id="uang-input" class="form-control form-control-lg" placeholder="Masukkan jumlah uang" required min="0">
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-quick-money mr-1" data-val="pas">Uang Pas</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-quick-money mr-1" data-val="10000">10.000</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-quick-money mr-1" data-val="20000">20.000</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-quick-money mr-1" data-val="50000">50.000</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-quick-money" data-val="100000">100.000</button>
                        </div>
                    </div>

                    <div class="alert alert-secondary mb-0" id="box-kembalian">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-600" id="label-kembalian">Kembalian:</span>
                            <h4 class="mb-0 text-success font-weight-bold" id="kembalian-text">Rp 0</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="btn-submit-checkout" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-check mr-1"></i> Selesaikan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function reloadCart() {
            $.get("{{ route('pos.cart.table') }}", function(html) {
                $('#cart-container').html(html);
                var total = parseInt($('#raw-cart-total').val()) || 0;
                $('#modal-tagihan-text').text($('#total-cart-display').text());
                if (total > 0) {
                    $('#btn-clear-cart, #btn-open-checkout').removeAttr('disabled');
                } else {
                    $('#btn-clear-cart, #btn-open-checkout').attr('disabled', 'disabled');
                }
            });
        }

        // Barcode Scan Submit
        $('#form-scan-barcode').on('submit', function(e) {
            e.preventDefault();
            var code = $('#barcode-input').val().trim();
            if (!code) return;

            $.post("{{ route('pos.scan') }}", {
                barcode: code,
                cabang_id: "{{ $cabangId }}"
            }, function(res) {
                iziToast.success({ title: 'OK', message: res.message, position: 'topRight' });
                $('#barcode-input').val('').focus();
                reloadCart();
            }).fail(function(err) {
                var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Gagal scan barcode';
                iziToast.error({ title: 'Gagal', message: msg, position: 'topRight' });
                $('#barcode-input').select();
            });
        });

        // Search Filter
        $('#product-search').on('keyup', function() {
            var val = $(this).val().toLowerCase();
            $('.product-row').each(function() {
                var name = $(this).data('name');
                var code = $(this).data('barcode');
                if (name.indexOf(val) > -1 || (code && code.toString().indexOf(val) > -1)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Add Product Button
        $(document).on('click', '.btn-add-product', function() {
            var id = $(this).data('id');
            $.post("{{ route('pos.cart.add') }}", {
                id_barang: id,
                jumlah: 1,
                cabang_id: "{{ $cabangId }}"
            }, function(res) {
                iziToast.success({ title: 'OK', message: res.message, position: 'topRight' });
                reloadCart();
            }).fail(function(err) {
                var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Gagal tambah barang';
                iziToast.error({ title: 'Gagal', message: msg, position: 'topRight' });
            });
        });

        // Change Qty in Cart
        $(document).on('change', '.cart-qty-input', function() {
            var id = $(this).data('id');
            var qty = $(this).val();
            $.ajax({
                url: "/pos/cart/" + id,
                type: 'PUT',
                data: { jumlah: qty },
                success: function(res) {
                    reloadCart();
                },
                error: function(err) {
                    var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Gagal update qty';
                    iziToast.error({ title: 'Gagal', message: msg, position: 'topRight' });
                    reloadCart();
                }
            });
        });

        // Delete Item from Cart
        $(document).on('click', '.btn-delete-cart', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "/pos/cart/" + id,
                type: 'DELETE',
                success: function() {
                    reloadCart();
                }
            });
        });

        // Clear Cart
        $('#btn-clear-cart').on('click', function() {
            if (!confirm('Yakin ingin mengosongkan keranjang kasir?')) return;
            $.ajax({
                url: "{{ route('pos.cart.clear') }}",
                type: 'DELETE',
                success: function() {
                    reloadCart();
                }
            });
        });

        // Open Checkout Modal
        $('#btn-open-checkout').on('click', function() {
            var total = parseInt($('#raw-cart-total').val()) || 0;
            if (total <= 0) return;
            $('#modal-checkout').modal('show');
            $('#uang-input').val('').focus();
            calculateKembalian();
        });

        // Keyboard Shortcut F9 to open checkout
        $(document).on('keydown', function(e) {
            if (e.key === 'F9') {
                e.preventDefault();
                $('#btn-open-checkout').click();
            }
        });

        // Payment Method Switcher
        $('input[name="metode"]').on('change', function() {
            if ($('#radio-cicilan').is(':checked')) {
                $('#group-customer').slideDown();
                $('#label-uang').text('Uang Muka / Bayar Sekarang (Rp)');
                $('#label-kembalian').text('Sisa Hutang:');
            } else {
                $('#group-customer').slideUp();
                $('#label-uang').text('Uang Diterima (Rp)');
                $('#label-kembalian').text('Kembalian:');
            }
            calculateKembalian();
        });

        function calculateKembalian() {
            var total = parseInt($('#raw-cart-total').val()) || 0;
            var bayar = parseInt($('#uang-input').val()) || 0;
            var isCicilan = $('#radio-cicilan').is(':checked');

            if (isCicilan) {
                var sisaHutang = Math.max(0, total - bayar);
                $('#kembalian-text').text('Rp ' + sisaHutang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            } else {
                var kembalian = Math.max(0, bayar - total);
                $('#kembalian-text').text('Rp ' + kembalian.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            }
        }

        $('#uang-input').on('keyup change', calculateKembalian);

        $('.btn-quick-money').on('click', function() {
            var val = $(this).data('val');
            var total = parseInt($('#raw-cart-total').val()) || 0;
            if (val === 'pas') {
                $('#uang-input').val(total);
            } else {
                $('#uang-input').val(val);
            }
            calculateKembalian();
        });

        // Submit Checkout Form
        $('#form-checkout').on('submit', function(e) {
            e.preventDefault();
            var total = parseInt($('#raw-cart-total').val()) || 0;
            var bayar = parseInt($('#uang-input').val()) || 0;
            var isCicilan = $('#radio-cicilan').is(':checked');

            if (!isCicilan && bayar < total) {
                iziToast.warning({ title: 'Uang Kurang', message: 'Jumlah pembayaran tunai kurang dari total tagihan!', position: 'topCenter' });
                return;
            }

            if (isCicilan && !$('#select-customer').val()) {
                iziToast.warning({ title: 'Pelanggan Wajib', message: 'Pilih data pelanggan untuk transaksi cicilan/piutang!', position: 'topCenter' });
                return;
            }

            $('#btn-submit-checkout').attr('disabled', 'disabled').html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');

            $.ajax({
                url: "{{ route('pos.checkout') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    $('#modal-checkout').modal('hide');
                    iziToast.success({ title: 'Berhasil', message: res.message, position: 'topCenter' });
                    // Open receipt in new tab
                    window.open(res.redirect_url, '_blank');
                    // Reload page for next transaction
                    setTimeout(function() {
                        window.location.reload();
                    }, 1200);
                },
                error: function(err) {
                    $('#btn-submit-checkout').removeAttr('disabled').html('<i class="fas fa-check mr-1"></i> Selesaikan Transaksi');
                    var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Gagal menyelesaikan checkout';
                    iziToast.error({ title: 'Gagal', message: msg, position: 'topRight' });
                }
            });
        });
    });
</script>
@endpush
