@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold text-teal-700 mb-6">✏️ Edit Food</h1>

<form method="POST" action="/foods/{{ $food->id }}" class="space-y-4">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $food->name }}"
           class="w-full border p-3 rounded-lg">

    <textarea name="description"
              class="w-full border p-3 rounded-lg">{{ $food->description }}</textarea>

    <input type="number" name="price" value="{{ $food->price }}"
           class="w-full border p-3 rounded-lg">

    <input type="number" name="stock" value="{{ $food->stock }}"
           class="w-full border p-3 rounded-lg">

    <button class="bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-500">
        Update
    </button>
</form>

@endsection