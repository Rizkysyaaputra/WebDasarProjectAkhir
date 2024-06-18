<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kriptografi Cipher</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <style>
        /* Gaya untuk header */
        header {
            background-color:#0056b3;
            color: white;
            padding:35px 0;
            text-align: left;
            margin-bottom: 20px;
            
        }
        header h1 {
            margin: 0;
            margin-left: 50px; /* Sesuaikan nilai ini sesuai kebutuhan Anda */
        }
    </style>
    <script>
        function updateForm() {
            const cipherType = document.getElementById('cipher_type').value;
            document.getElementById('shift_group').style.display = cipherType === 'caesar' ? 'block' : 'none';
            document.getElementById('key_group').style.display = cipherType === 'vigenere' ? 'block' : 'none';
            document.getElementById('affine_a_group').style.display = cipherType === 'affine' ? 'block' : 'none';
            document.getElementById('affine_b_group').style.display = cipherType === 'affine' ? 'block' : 'none';
        }
    </script>
</head>
<body onload="updateForm()">
    <header>
        <h1>KELOMPOK D</h1>
        <h1>SI F1</h1>
    </header>
    <div class="container">
        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('encrypt') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="cipher_type">Select Cipher Type:</label>
                <select name="cipher_type" id="cipher_type" onchange="updateForm()">
                    <option value="caesar" {{ old('cipher_type') == 'caesar' ? 'selected' : '' }}>Caesar Cipher</option>
                    <option value="vigenere" {{ old('cipher_type') == 'vigenere' ? 'selected' : '' }}>Vigenère Cipher</option>
                    <option value="affine" {{ old('cipher_type') == 'affine' ? 'selected' : '' }}>Affine Cipher</option>
                </select>
            </div>

            <div id="shift_group" class="form-group">
                <label for="shift">Shift (for Caesar Cipher):</label>
                <input type="number" name="shift" id="shift" value="{{ old('shift') }}">
            </div>

            <div id="key_group" class="form-group">
                <label for="key">Key (for Vigenère Cipher):</label>
                <input type="text" name="key" id="key" value="{{ old('key') }}">
            </div>

            <div id="affine_a_group" class="form-group">
                <label for="affine_a">Affine Cipher - Value A:</label>
                <input type="number" name="affine_a" id="affine_a" value="{{ old('affine_a') }}">
            </div>

            <div id="affine_b_group" class="form-group">
                <label for="affine_b">Affine Cipher - Value B:</label>
                <input type="number" name="affine_b" id="affine_b" value="{{ old('affine_b') }}">
            </div>

            <div class="form-group">
                <label for="plaintext">Plaintext:</label>
                <textarea name="plaintext" id="plaintext" rows="4">{{ old('plaintext') }}</textarea>
            </div>

            <button type="submit">Encrypt</button>
        </form>

        @isset($ciphertext)
            <div class="result-group">
                <h2>Encrypted Text</h2>
                <textarea rows="4" readonly>{{ $ciphertext }}</textarea>
            </div>
        @endisset

        @isset($binaryCiphertext)
            <div class="result-group">
                <h2>Binary Encrypted Text</h2>
                <textarea rows="4" readonly>{{ $binaryCiphertext }}</textarea>
            </div>
        @endisset
    </div>
</body>
</html>
