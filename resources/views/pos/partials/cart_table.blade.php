<div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
    <table class="table table-striped table-sm mb-0">
        <thead>
            <tr>
                <th>Produk</th>
                <th width="100">Harga</th>
                <th width="90">Qty</th>
                <th width="110">Subtotal</th>
                <th width="40"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($cart as $item)
            <tr>
                <td>
                    <strong>{{ $item->barang->nama_barang ?? $item->barcode }}</strong><br>
                    <small class="text-muted">{{ $item->barcode }} ({{ $item->satuan }})</small>
                </td>
                <td>Rp {{ rupiah($item->harga) }}</td>
                <td>
                    <input type="number" min="1" max="{{ $item->barang->stok ?? 9999 }}" 
                           class="form-control form-control-sm text-center cart-qty-input" 
                           data-id="{{ $item->id }}" 
                           value="{{ $item->jumlah }}">
                </td>
                <td class="font-weight-bold">Rp {{ rupiah($item->harga_total) }}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-delete-cart" data-id="{{ $item->id }}" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-muted">
                    <i class="fas fa-shopping-basket fa-2x mb-2 d-block text-muted"></i>
                    Keranjang masih kosong. Silakan scan barcode atau pilih barang di samping.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="p-3 bg-light border-top">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="text-muted">Total Jumlah Item:</span>
        <span class="font-weight-bold">{{ $cart->sum('jumlah') }}</span>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark">Total Pembayaran:</h5>
        <h4 class="mb-0 text-primary font-weight-bold" id="total-cart-display">Rp {{ rupiah($total) }}</h4>
    </div>
</div>
<input type="hidden" id="raw-cart-total" value="{{ $total }}">
