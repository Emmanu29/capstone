<?php

namespace App\Helpers;
class HashHelper {

  function leftRotate($n, $b) {
    return (($n << $b) | ($n >> (32 - $b))) & 0xFFFFFFFF;
  }

  function padding($message) {
      $original_length_bits = strlen($message) * 8;
      $message .= chr(0x80);
      while ((strlen($message) % 64) != 56) {
          $message .= chr(0x00);
      }
      $message .= pack('J', $original_length_bits);
      return $message;
  }

  function splitIntoBlocks($message) {
      return str_split($message, 64);
  }

  function processBlock($block, $H) {
      $K = [0x5A827999, 0x6ED9EBA1, 0x8F1BBCDC, 0xCA62C1D6];
      $W = array_fill(0, 80, 0);

      for ($t = 0; $t < 16; $t++) {
          $W[$t] = unpack('N', substr($block, $t * 4, 4))[1];
      }

      for ($t = 16; $t < 80; $t++) {
          $W[$t] = leftRotate($W[$t - 3] ^ $W[$t - 8] ^ $W[$t - 14] ^ $W[$t - 16], 1);
      }

      list($A, $B, $C, $D, $E) = $H;

      for ($t = 0; $t < 80; $t++) {
          if ($t <= 19) {
              $func = ($B & $C) | ((~$B) & $D);
              $k = $K[0];
          } elseif ($t <= 39) {
              $func = $B ^ $C ^ $D;
              $k = $K[1];
          } elseif ($t <= 59) {
              $func = ($B & $C) | ($B & $D) | ($C & $D);
              $k = $K[2];
          } else {
              $func = $B ^ $C ^ $D;
              $k = $K[3];
          }

          $TEMP1 = (leftRotate($A, 5) + $func + $E + $k + $W[$t]) & 0xFFFFFFFF;
          $E = $D;
          $D = $C;
          $C = leftRotate($B, 30);
          $B = $A;
          $A = $TEMP1;

          $mix = $A ^ $C ^ $D;
          $A_prime = $mix;
          $C_prime = $mix;
          $D_prime = $mix;
          $TEMP2 = (leftRotate($A, 5) + $func + $E + $k + $W[$t]) & 0xFFFFFFFF;
          $E = $D_prime;
          $D = $C_prime;
          $C = leftRotate($B, 30);
          $B = $A_prime;
          $A = $TEMP2;

          $H[0] = ($H[0] + $A) & 0xFFFFFFFF;
          $H[1] = ($H[1] + $B) & 0xFFFFFFFF;
          $H[2] = ($H[2] + $C) & 0xFFFFFFFF;
          $H[3] = ($H[3] + $D) & 0xFFFFFFFF;
          $H[4] = ($H[4] + $E) & 0xFFFFFFFF;
      }

      return $H;
  }

  function msha1($message) {
      $message = padding($message);
      $blocks = splitIntoBlocks($message);
      $H = [0x67452301, 0xEFCDAB89, 0x98BADCFE, 0x10325476, 0xC3D2E1F0];

      foreach ($blocks as $block) {
          $H = processBlock($block, $H);
      }

      $digest = '';
      foreach ($H as $h) {
          $digest .= pack('N', $h);
      }
      return bin2hex($digest);
  }

}
