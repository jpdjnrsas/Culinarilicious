@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold text-teal-700 mb-6">➕ Add Food</h1>

<form method="POST" action="/foods" class="space-y-4">
    @csrf

    <input type="text" name="name" placeholder="Food name"
           class="w-full border p-3 rounded-lg">

    <textarea name="description" placeholder="Description"
              class="w-full border p-3 rounded-lg"></textarea>

    <input type="number" name="price" placeholder="Price"
           class="w-full border p-3 rounded-lg">

    <input type="number" name="stock" placeholder="Stock"
           class="w-full border p-3 rounded-lg">

    <button class="bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-500">
        Save
    </button>
</form>

@endsection