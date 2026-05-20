@extends('layouts.app')

@section('content')

<div class="container">

    <div class="create-card">

        <h1 class="page-title">
            🍔 Add New Food
        </h1>

        @if(session('success'))
            <div class="success-box">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST"
              action="/admin/foods"
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label>Food Name</label>
                <input type="text"
                       name="name"
                       required>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number"
                       step="0.01"
                       name="price"
                       required>
            </div>

            <div class="form-group">
                <label>Stock</label>
                <input type="number"
                       name="stock"
                       required>
            </div>

            <div class="form-group">
                <label>Food Image</label>
                <input type="file"
                       name="image"
                       id="imageInput"
                       accept="image/*">
            </div>

            {{-- IMAGE PREVIEW --}}
            <div id="previewBox" style="display:none;">
                <img id="previewImage">
            </div>

            <button type="submit" class="submit-btn">
                ➕ Add Food
            </button>

        </form>

    </div>

</div>

<style>

.container{
    max-width:700px;
    margin:auto;
    padding:40px 20px;
}

.create-card{
    background:white;
    border-radius:25px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.page-title{
    font-size:32px;
    margin-bottom:25px;
    color:#111827;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:700;
    color:#374151;
}

.form-group input{
    width:100%;
    padding:14px;
    border-radius:12px;
    border:1px solid #d1d5db;
    font-size:16px;
}

.submit-btn{
    width:100%;
    border:none;
    padding:16px;
    border-radius:14px;
    background:linear-gradient(135deg,#0f766e,#14b8a6);
    color:white;
    font-size:18px;
    font-weight:700;
    cursor:pointer;
    transition:0.25s;
}

.submit-btn:hover{
    transform:translateY(-2px);
}

#previewBox{
    margin-top:20px;
}

#previewImage{
    width:100%;
    max-height:300px;
    object-fit:cover;
    border-radius:16px;
}

.success-box{
    background:#dcfce7;
    color:#166534;
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
}

</style>

<script>

const imageInput = document.getElementById('imageInput');
const previewBox = document.getElementById('previewBox');
const previewImage = document.getElementById('previewImage');

imageInput.addEventListener('change', function(){

    const file = this.files[0];

    if(file){

        previewImage.src = URL.createObjectURL(file);

        previewBox.style.display = 'block';
    }

});

</script>

@endsection