<?php

if (! function_exists('encryption')) {
    function encryption($data = [])
    {
        $key = base64_decode(str_replace('base64:', '', config('app.key')));
        // Ensure the key is 32 bytes for AES-256
        if (strlen($key) !== 32) {
            throw new \Exception('Invalid encryption key length. It must be 32 bytes for AES-256.');
        }
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc')); // 16 bytes IV

        $plaintext = json_encode($data);
        $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

        // IMPORTANT:
        // use OPENSSL_RAW_DATA to get raw binary ciphertext instead of base64

        // Then base64 encode ciphertext for transport (to match JS decrypt base64)
        $ciphertext_base64 = base64_encode($ciphertext);

        return [
            'data' => $ciphertext_base64,
            'iv' => base64_encode($iv),
        ];
    }
}

if (! function_exists('decryption')) {
    function decryption($data = '', $iv = '', $key = null)
    {
        $key = $key ?? base64_decode(str_replace('base64:', '', config('app.key')));
        $iv = base64_decode($iv);
        $ciphertext = base64_decode($data);

        $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

        return json_decode($plaintext, true);
    }
}