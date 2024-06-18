<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CipherController extends Controller
{
    public function encrypt(Request $request)
    {
        $request->validate([
            'cipher_type' => 'required',
            'plaintext' => 'required',
        ]);

        $cipherType = $request->input('cipher_type');
        $plaintext = $request->input('plaintext');

        $ciphertext = '';
        $binaryCiphertext = '';

        if ($cipherType == 'caesar') {
            $shift = intval($request->input('shift'));
            $ciphertext = $this->caesarCipher($plaintext, $shift);
            $binaryCiphertext = $this->stringToBinaryString($ciphertext);
        } elseif ($cipherType == 'vigenere') {
            $key = $request->input('key');
            $ciphertext = $this->vigenereCipher($plaintext, $key);
            $binaryCiphertext = $this->stringToBinaryString($ciphertext);
        } elseif ($cipherType == 'affine') {
            $a = intval($request->input('affine_a'));
            $b = intval($request->input('affine_b'));
            $ciphertext = $this->affineCipher($plaintext, $a, $b);
            $binaryCiphertext = $this->stringToBinaryString($ciphertext);
        }

        return view('cipher', compact('ciphertext', 'binaryCiphertext'));
    }

    private function caesarCipher($text, $shift)
    {
        $result = '';
        $shift = $shift % 26;

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];

            if (ctype_upper($char)) {
                $result .= chr((ord($char) + $shift - 65) % 26 + 65);
            } elseif (ctype_lower($char)) {
                $result .= chr((ord($char) + $shift - 97) % 26 + 97);
            } else {
                $result .= $char;
            }
        }

        return $result;
    }

    private function vigenereCipher($text, $key)
    {
        $key = strtolower($key);
        $keyLength = strlen($key);
        $keyAsInts = array_map('ord', str_split($key));
        $result = '';
        $nonAlphaCharCount = 0;

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];

            if (ctype_alpha($char)) {
                $isUpper = ctype_upper($char);
                $offset = $isUpper ? 65 : 97;
                $keyIndex = ($i - $nonAlphaCharCount) % $keyLength;
                $shift = $keyAsInts[$keyIndex] - 97;
                $result .= chr((ord($char) + $shift - $offset) % 26 + $offset);
            } else {
                $result .= $char;
                $nonAlphaCharCount++;
            }
        }

        return $result;
    }

    private function affineCipher($text, $a, $b)
    {
        $result = '';
        $modulus = 26;

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];

            if (ctype_alpha($char)) {
                $isUpper = ctype_upper($char);
                $offset = $isUpper ? 65 : 97;
                $x = ord($char) - $offset;
                $result .= chr(($a * $x + $b) % $modulus + $offset);
            } else {
                $result .= $char;
            }
        }

        return $result;
    }

    private function stringToBinaryString($str)
    {
        $binaryString = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $binaryString .= str_pad(decbin(ord($str[$i])), 8, '0', STR_PAD_LEFT) . ' ';
        }
        return trim($binaryString);
    }
}
