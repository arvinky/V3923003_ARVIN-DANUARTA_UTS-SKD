<?php  
// Fungsi untuk mengenkripsi/dekripsi huruf tunggal menggunakan Caesar Cipher
function cipher($char, $key){
    if (ctype_alpha($char)) { // Jika karakter adalah huruf
        $base = ord(ctype_upper($char) ? 'A' : 'a'); // Tentukan base A/a untuk huruf besar/kecil
        $new_char = ord($char);
        $shifted = fmod($new_char + $key - $base, 26); // Shift dengan Caesar
        return chr($shifted + $base); // Kembalikan karakter setelah enkripsi/dekripsi
    } else {
        return $char; // Jika bukan huruf, kembalikan karakter asli
    }
} 

// Fungsi untuk mengenkripsi teks dengan Caesar Cipher
function enkripsi_caesar($input, $key){
    $output = "";
    foreach(str_split($input) as $char){
        $output .= cipher($char, $key); // Panggil fungsi cipher untuk setiap karakter
    }
    return $output;
}

// Fungsi untuk mendekripsi teks dengan Caesar Cipher
function dekripsi_caesar($input, $key){
    return enkripsi_caesar($input, 26 - $key); // Dekripsi adalah enkripsi dengan kunci terbalik
}

// Fungsi untuk mengenkripsi teks dengan Vigenère Cipher
function vigenere_encrypt($plaintext, $key) {
    $ciphertext = "";
    $key = strtoupper($key); // Pastikan kunci dalam huruf besar
    $key_len = strlen($key);
    $key_index = 0;

    foreach (str_split($plaintext) as $char) {
        if (ctype_alpha($char)) {
            $shift = ord($key[$key_index % $key_len]) - ord('A'); // Tentukan pergeseran dari kunci
            if (ctype_lower($char)) {
                $ciphertext .= chr(((ord($char) - ord('a') + $shift) % 26) + ord('a')); // Enkripsi huruf kecil
            } else {
                $ciphertext .= chr(((ord($char) - ord('A') + $shift) % 26) + ord('A')); // Enkripsi huruf besar
            }
            $key_index++; // Geser index kunci
        } else {
            $ciphertext .= $char; // Jika bukan huruf, tetap masukkan karakter asli
        }
    }
    return $ciphertext;
}

// Fungsi untuk mendekripsi teks dengan Vigenère Cipher
function vigenere_decrypt($ciphertext, $key) {
    $plaintext = "";
    $key = strtoupper($key);
    $key_len = strlen($key);
    $key_index = 0;

    foreach (str_split($ciphertext) as $char) {
        if (ctype_alpha($char)) {
            $shift = ord($key[$key_index % $key_len]) - ord('A');
            if (ctype_lower($char)) {
                $plaintext .= chr(((ord($char) - ord('a') - $shift + 26) % 26) + ord('a'));
            } else {
                $plaintext .= chr(((ord($char) - ord('A') - $shift + 26) % 26) + ord('A'));
            }
            $key_index++;
        } else {
            $plaintext .= $char;
        }
    }
    return $plaintext;
}

// Fungsi gabungan enkripsi Caesar dan Vigenère
function enkripsi_combination($input, $caesar_key, $vigenere_key) {
    $caesar_encrypted = enkripsi_caesar($input, $caesar_key); // Enkripsi dengan Caesar
    return vigenere_encrypt($caesar_encrypted, $vigenere_key); // Lanjut dengan Vigenère
}

// Fungsi gabungan dekripsi Vigenère dan Caesar
function dekripsi_combination($input, $caesar_key, $vigenere_key) {
    $vigenere_decrypted = vigenere_decrypt($input, $vigenere_key); // Dekripsi dengan Vigenère
    return dekripsi_caesar($vigenere_decrypted, $caesar_key); // Lanjut dengan Caesar
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enkripsi & Dekripsi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>Enkripsi & Dekripsi</h1>
        <form method="post">
            <input type="text" name="plain" placeholder="Masukkan kalimat" required />
            <input type="number" name="caesar_key" placeholder="Masukkan kunci Caesar (0-25)" min="0" max="25" required />
            <input type="text" name="vigenere_key" placeholder="Masukkan kunci Vigenère" required />
            <button type="submit" name="enkripsi">Enkripsi</button>
            <button type="submit" name="dekripsi">Dekripsi</button>
            <textarea readonly placeholder="Hasil"><?php  
                if (isset($_POST["enkripsi"])) { 
                    echo enkripsi_combination($_POST["plain"], $_POST["caesar_key"], $_POST["vigenere_key"]);
                } else if (isset($_POST["dekripsi"])) {
                    echo dekripsi_combination($_POST["plain"], $_POST["caesar_key"], $_POST["vigenere_key"]);
                }
            ?></textarea>
        </form>
        <div>
            <span>ARVIN DANUARTA</span>
        </div>
    </div>
</body>
</html>
