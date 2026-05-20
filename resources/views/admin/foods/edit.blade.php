@extends('layouts.app')

@section('content')

<div class="container">

    <h1>✏️ Edit Food</h1>

    <div class="card">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        {{-- UPDATE FORM --}}
        <form method="POST" action="/admin/foods/{{ $food->id }}/update" enctype="multipart/form-data">
            @csrf

            <label>Food Name</label>
            <input type="text" name="name" value="{{ $food->name }}" required>

            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $food->price }}" required>

            <label>Stock</label>
            <input type="number" name="stock" value="{{ $food->stock }}" required>

            {{-- CURRENT IMAGE --}}
            @if($food->image)
                <div style="margin-top:10px;">
                    <p><b>Current Image:</b></p>
                    <img src="{{ asset('storage/'.$food->image) }}" 
                         style="width:150px; border-radius:10px;">
                </div>
            @endif

            {{-- UPLOAD NEW IMAGE --}}
            <div style="margin-top:10px;">
                <label>Change Image</label>
                <input type="file" name="image" id="imageInput" accept="image/*">
            </div>

            {{-- PREVIEW --}}
            <div id="previewContainer" style="margin-top:10px; display:none;">
                <p><b>Preview:</b></p>
                <img id="previewImage" style="width:150px; border-radius:10px;">
            </div>

            <button type="submit" class="btn" style="margin-top:10px;">
                💾 Update Food
            </button>
        </form>

        {{-- DELETE BUTTON (SAFE VERSION) --}}
        <button type="button" class="btn-danger" style="margin-top:10px;" onclick="deleteFood()">
            🗑 Delete Food
        </button>

        {{-- HIDDEN DELETE FORM --}}
        <form id="deleteForm" method="POST" action="/admin/foods/{{ $food->id }}" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

    </div>

</div>

{{-- IMAGE PREVIEW SCRIPT --}}
<script>
const input = document.getElementById('imageInput');
const preview = document.getElementById('previewImage');
const previewBox = document.getElementById('previewContainer');

if(input){
    input.addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            preview.src = URL.createObjectURL(file);
            previewBox.style.display = 'block';
        }
    });
}

// DELETE FUNCTION
function deleteFood(){
    if(confirm('Are you sure you want to delete this food?')){
        document.getElementById('deleteForm').submit();
    }
}
</script>

@endsection