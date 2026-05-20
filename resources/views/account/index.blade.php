@extends('layouts.app')

@section('content')

<h1>👤 My Account</h1>

{{-- SUCCESS --}}
@if(session('success'))
<div class="card" style="background:#dcfce7; color:#166534;">
    {{ session('success') }}
</div>
@endif

<div class="grid">

    {{-- PROFILE --}}
    <div class="card">

        <h3>📝 Profile Information</h3>

        <form method="POST" action="/account/update" enctype="multipart/form-data">
            @csrf

            {{-- PROFILE IMAGE --}}
            <div style="text-align:center; margin-bottom:15px;">
                <img id="profilePreview"
                    src="{{ auth()->user()->profile_image 
                        ? asset('storage/'.auth()->user()->profile_image) 
                        : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}"
                    style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #ddd;">

                <input type="file" name="profile_image" id="profileInput" accept="image/*" style="display:none;">
                <p class="muted">Click image to change</p>
            </div>

            <label>Name</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" required>

            <button style="margin-top:10px;">Update Profile</button>
        </form>

    </div>

    {{-- PASSWORD --}}
    <div class="card">

        <h3>🔒 Change Password</h3>

        <form method="POST" action="/account/password">
            @csrf

            <label>New Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>

            <button style="margin-top:10px;">Update Password</button>
        </form>

    </div>

</div>

<style>
input {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
</style>

<script>
const preview = document.getElementById('profilePreview');
const input = document.getElementById('profileInput');

// click image
preview.addEventListener('click', () => input.click());

// preview image
input.addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        preview.src = URL.createObjectURL(file);
    }
});
</script>

@endsection