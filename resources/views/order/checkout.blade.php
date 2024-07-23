<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-iB_7a28v9vWO89fZ"></script>

    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body>
<div class="container p-5 mx-auto my-10 p-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Pemesanan</h1>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-700">Informasi Pembeli</h2>
        <div class="mt-4 text-gray-600">
            <p class="mb-2"><span class="font-bold">Nama:</span> {{ $order->user_name }}</p>
            <p class="mb-2"><span class="font-bold">Nomor HP:</span> {{ $order->user_phone }}</p>
            <p class="mb-2"><span class="font-bold">Alamat:</span> {{ $order->user_address }}</p>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-700">Informasi Pemesanan</h2>
        <div class="mt-4 text-gray-600">
            <p class="mb-2"><span class="font-bold">Nama Barang:</span> {{ $order->product_name }}</p>
            <p class="mb-2"><span class="font-bold">Order ID:</span> {{ $order->id }}</p>
            <p class="mb-2"><span class="font-bold">Tanggal Order:</span> {{ $order->created_at }}</p>
            <p class="mb-2"><span class="font-bold">Status:</span> <span class="text-green-500">{{ $order->status }}</span></p>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-700">Informasi Pembayaran</h2>
        <div class="mt-4 text-gray-600">
            <p class="mb-2"><span class="font-bold">Total:</span> Rp {{ number_format($order->total) }}</p>
        </div>
    </div>

    <div class="flex justify-start mt-5">
        <button
            id="pay-button"
            class="bg-blue-500 text-white py-2 px-6 rounded-full shadow-md transition duration-300 ease-in-out">
            Bayar Sekarang
        </button>
    </div>
</div>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{$order->snap_token}}');
    });
</script>
</body>
</html>
