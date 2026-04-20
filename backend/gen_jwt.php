<?php
$pass = '494363afa72028f7613fe92d758a10dadea9bde92117399aeaf63e45d2376f31';
$key = openssl_pkey_new(['private_key_bits' => 4096, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
openssl_pkey_export($key, $priv, $pass);
file_put_contents(__DIR__ . '/config/jwt/private.pem', $priv);
$pub = openssl_pkey_get_details($key)['key'];
file_put_contents(__DIR__ . '/config/jwt/public.pem', $pub);
echo "JWT keys regenerated OK\n";

// Verify
$test = openssl_pkey_get_private(file_get_contents(__DIR__ . '/config/jwt/private.pem'), $pass);
echo $test ? "Verification: PASS\n" : "Verification: FAIL\n";
