@if (session('success'))
    <div style="color: green; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="color: red; margin-bottom: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <label for="avatar">Pilih Foto Profil Baru:</label>
    <br>
    <input type="file" name="avatar" id="avatar" required>
    
    <br><br>
    
    <button type="submit">Upload & Simpan</button>
</form>

<hr>

<h3>Foto Saat Ini:</h3>
@if(auth()->user()->avatar)
    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" width="150">
@else
    <p>Belum ada foto profil.</p>
@endif