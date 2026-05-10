@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">

    <!-- Title -->
    <h1 class="text-center text-3xl font-bold mb-8 text-gray-800">
        الأقسام
    </h1>

    <!-- Empty state -->
    @if($categories->count() == 0)
        <div class="text-center text-gray-500 mt-10">
            لا توجد أقسام حالياً
        </div>
    @else

    <!-- Categories Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">

        @foreach($categories as $cat)

            <a href="/category/{{ $cat->id }}"
               class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">

                <!-- Image -->
                <div class="overflow-hidden">
                    <img src="{{ asset('storage/'.$cat->image) }}"
                         class="h-40 w-full object-cover group-hover:scale-110 transition duration-300">
                </div>

                <!-- Name -->
                <div class="p-3 text-center">
                    <h2 class="font-bold text-gray-800 group-hover:text-blue-600">
                        {{ $cat->name }}
                    </h2>
                </div>

            </a>

        @endforeach

    </div>

    @endif

</div>

@endsection