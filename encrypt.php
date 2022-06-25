<?php
  function encrypt($message, $encryption_key){
      $key = hex2bin($encryption_key);
      $nonceSize = openssl_cipher_iv_length('aes-256-ctr');
      $nonce = openssl_random_pseudo_bytes($nonceSize);
      $ciphertext = openssl_encrypt(
          $message, 
          'aes-256-ctr', 
          $key,
          OPENSSL_RAW_DATA,
          $nonce
      );
        return base64_encode($nonce.$ciphertext);
    }
    ?>