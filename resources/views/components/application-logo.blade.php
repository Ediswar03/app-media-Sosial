<img
    src="{{ file_exists(public_path('storage/logo/2.jpg')) 
            ? asset('storage/logo/2.jpg') 
            : asset('images/default-2.jpg') }}"
    {{ $attributes->merge(['class' => 'h-9 w-auto']) }}
    alt="App Logo"
>