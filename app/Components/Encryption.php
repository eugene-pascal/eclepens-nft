<?php

namespace App\Components;

class Encryption
{
    /**
     * @const
     */
    const SECRET_KEY = 'app@code.lp_77';

    /**
     *  Encode a string
     * @param  string $value
     * @param  string $skey
     * @return string
     */
    public static function encode($value = '', $skey = '')
    {
        if (empty($value)) {
            return false;
        }

        if (empty($skey)) {
            $skey = self::SECRET_KEY;
        }

        if( strlen($skey) < 16 )
            $skey = str_pad($skey, 16, "\0");
        else if( strlen($skey) < 24 ) {
            $skey = str_pad($skey, 24, "\0");
        } else if( strlen($skey) < 32 ) {
            $skey = str_pad($skey, 32, "\0");
        } elseif( strlen($skey) > 32 ) {
            $skey = substr($skey, 0, 32);
        }

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $cryptvalue = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $value, MCRYPT_MODE_ECB, $iv);

        return trim(self::safe_b64encode($cryptvalue));
    }

    /**
     * Base 64 encode a string and prepare the encoded value to be encrypted
     * @param  string $string
     * @return string
     */
    private static function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    /**
     * Decode a string
     * @param  string $value
     * @return string
     */
    public static function decode($value = '', $skey = '')
    {
        if (empty($value)) {
            return false;
        }
        if (empty($skey)) {
            $skey = self::SECRET_KEY;
        }
        if( strlen($skey) < 16 )
            $skey = str_pad($skey, 16, "\0");
        else if( strlen($skey) < 24 ) {
            $skey = str_pad($skey, 24, "\0");
        } else if( strlen($skey) < 32 ) {
            $skey = str_pad($skey, 32, "\0");
        } elseif( strlen($skey) > 32 ) {
            $skey = substr($skey, 0, 32);
        }

        $cryptvalue = self::safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decryptvalue = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $cryptvalue, MCRYPT_MODE_ECB, $iv);

        return trim($decryptvalue);
    }

    /**
     * Base 64 decode a string and prepare the encoded value to be decrypted
     * @param  string $string
     * @return string
     */
    private static function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}