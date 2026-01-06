@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Daftar Pesanan Saya</h1>
            <p class="text-muted small mb-0">Pantau status dan riwayat belanja Anda di sini.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small uppercase">
                        <tr>
                            <th class="ps-4 py-3">No. Order</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Total Tagihan</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                            </td>
                            <td class="text-secondary small">
                                {{ $order->created_at->format('d M Y') }}<br>
                                <span class="text-muted">{{ $order->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending'    => 'bg-warning-subtle text-warning-emphasis border-warning',
                                        'processing' => 'bg-info-subtle text-info-emphasis border-info',
                                        'shipped'    => 'bg-primary-subtle text-primary-emphasis border-primary',
                                        'delivered'  => 'bg-success-subtle text-success-emphasis border-success',
                                        'cancelled'  => 'bg-danger-subtle text-danger-emphasis border-danger'
                                    ][$order->status] ?? 'bg-secondary-subtle text-secondary-emphasis';

                                    $statusLabel = [
                                        'pending'    => 'Menunggu Pembayaran',
                                        'processing' => 'Sedang Diproses',
                                        'shipped'    => 'Dalam Pengiriman',
                                        'delivered'  => 'Pesanan Selesai',
                                        'cancelled'  => 'Dibatalkan'
                                    ][$order->status] ?? ucfirst($order->status);
                                @endphp
                                <span class="badge border px-2 py-1 fw-semibold {{ $statusClass }}" style="font-size: 0.75rem;">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-white border shadow-sm px-3 hover-primary">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="80" class="mb-3 opacity-25" alt="Empty">
                                <p class="text-muted mb-0">Belum ada pesanan yang dilakukan.</p>
                                <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-primary mt-3">Mulai Belanja</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    /* Tambahan style halus untuk interaksi */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: 0.2s;
    }
    .hover-primary:hover {
        background-color: var(--bs-primary) !important;
        color: white !important;
        border-color: var(--bs-primary) !important;
    }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .bg-info-subtle { background-color: #cff4fc; }
    .bg-primary-subtle { background-color: #cfe2ff; }
</style>
@endsection