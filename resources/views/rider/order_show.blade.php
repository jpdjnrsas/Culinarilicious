@extends('layouts.app')

@section('content')

<div class="container">

    <h1>🚴 Order #{{ $order->id }}</h1>

    <div class="card">

        <p><b>Customer:</b> {{ $order->user->name }}</p>
        <p><b>Status:</b> {{ ucfirst($order->status) }}</p>
        <p><b>ETA:</b> {{ $order->eta ?? 'N/A' }}</p>

        <hr>

        <h3>Items</h3>
        <ul>
            @foreach($order->items as $item)
                <li>{{ $item->food->name }} x {{ $item->quantity }}</li>
            @endforeach
        </ul>

        <hr>

        {{-- 🚫 LOCK AFTER DELIVERY --}}
        @if(!in_array($order->status, ['delivered', 'cancelled']))

        <form method="POST" action="/rider/orders/{{ $order->id }}/update" enctype="multipart/form-data">
            @csrf

            <label>Status</label>
            <select name="status" id="statusSelect" required>
                <option value="">Select Status</option>
                <option value="on delivery">On Delivery</option>
                <option value="delivered">Delivered</option>
            </select>

            <input type="text" name="eta" placeholder="ETA (e.g. 15 mins)" style="margin-top:10px;">

            {{-- 📸 PROOF --}}
            <div id="proofContainer" style="display:none; margin-top:10px;">
                <label>Upload Proof (Required)</label>
                <input type="file" id="proofInput" name="proof_image" accept="image/*">

                <div id="previewContainer" style="display:none; margin-top:10px;">
                    <img id="previewImage" style="width:100%; max-width:300px; border-radius:10px;">
                </div>
            </div>

            <button class="btn" style="margin-top:10px;">Update</button>

        </form>

        @else
            <p class="muted">✔ Order completed. No further updates allowed.</p>
        @endif

        <hr>

        {{-- 📸 SHOW PROOF --}}
        @if($order->proof_image)
            <h4>📸 Delivery Proof</h4>
            <img src="{{ asset('storage/' . $order->proof_image) }}"
                 onclick="openModal(this.src)"
                 style="width:100%; max-width:300px; border-radius:12px; cursor:pointer;">
        @endif

    </div>

</div>

{{-- 🔍 MODAL --}}
<div id="imgModal" class="img-modal">
    <span class="close-btn">&times;</span>
    <img id="modalImg" class="modal-img">
</div>

<style>
.img-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.85);
    backdrop-filter: blur(8px);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-img {
    max-width: 90%;
    max-height: 85%;
    border-radius: 14px;
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 35px;
    color: white;
    cursor: pointer;
}
</style>

<script>
const status = document.getElementById('statusSelect');
const proof = document.getElementById('proofContainer');
const input = document.getElementById('proofInput');
const preview = document.getElementById('previewImage');
const previewBox = document.getElementById('previewContainer');

// SHOW PROOF WHEN DELIVERED
if(status){
    status.addEventListener('change', () => {
        if(status.value === 'delivered'){
            proof.style.display = 'block';

            // Only require if no existing image
            if(!document.querySelector('img[src*="storage"]')){
                input.required = true;
            }
        } else {
            proof.style.display = 'none';
            input.required = false;
            previewBox.style.display = 'none';
        }
    });
}

// IMAGE PREVIEW
if(input){
    input.addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            preview.src = URL.createObjectURL(file);
            previewBox.style.display = 'block';
        }
    });
}

// MODAL
const modal = document.getElementById('imgModal');
const modalImg = document.getElementById('modalImg');
const closeBtn = document.querySelector('.close-btn');

function openModal(src){
    modal.style.display = 'flex';
    modalImg.src = src;
}

closeBtn.onclick = () => modal.style.display = 'none';
modal.onclick = e => { if(e.target === modal) modal.style.display = 'none'; };
</script>

@endsection