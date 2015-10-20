<?php
/**
 * File Encryptor.php
 *
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */

namespace DLinsmeyer\VigenereCipher;

/**
 * Class Encryptor
 *
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */
class Encrypter
{
    /**
     * @var array
     */
    private $characterToValueMap;

    /**
     * @var array
     */
    private $valueToCharacterMap;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $keyLength;

    /**
     * Constructor
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = strtoupper($key);
        $this->keyLength = strlen($key);
        $this->valueToCharacterMap = range('A', 'Z');
        $this->characterToValueMap = array_flip($this->valueToCharacterMap);
    }

    /**
     * Returns an encrypted string
     *
     * @param string $unencryptedString
     *
     * @return string
     */
    public function encrypt($unencryptedString)
    {
        $unencryptedStringLength = strlen($unencryptedString);
        $unencryptedString = strtoupper($unencryptedString);
        $unencryptedString = preg_replace('/[^A-Z]/i', '', $unencryptedString);
        $encryptedString = '';

        for ($i = 0; $i < $unencryptedStringLength; $i++) {
            $stringCharacter = $unencryptedString[$i];
            $stringCharacterValue = $this->characterToValueMap[$stringCharacter];

            $correspondingKeyCharacter = $this->key[$i % $this->keyLength];
            $correspondingKeyCharacterValue = $this->characterToValueMap[$correspondingKeyCharacter];

            $combinedCharacterValue = ($stringCharacterValue + $correspondingKeyCharacterValue) % 26;
            $combinedCharacter = $this->valueToCharacterMap[$combinedCharacterValue];

            $encryptedString .= $combinedCharacter;
        }

        return $encryptedString;
    }

    /**
     * Return a decrypted string
     *
     * @param string $encryptedString
     *
     * @return string
     */
    public function decrypt($encryptedString)
    {
        $encryptedStringLength = strlen($encryptedString);
        $decryptedString = '';

        for ($i = 0; $i < $encryptedStringLength; $i++) {
            $stringCharacter = $encryptedString[$i];
            $stringCharacterValue = $this->characterToValueMap[$stringCharacter];

            $keyCharacter = $this->key[$i % $this->keyLength];
            $keyCharacterValue = $this->characterToValueMap[$keyCharacter];

            $decryptedCharacterValue = $stringCharacterValue - $keyCharacterValue;
            if ($decryptedCharacterValue < 0) {
                $decryptedCharacterValue += 26;
            }

            $decryptedCharacter = $this->valueToCharacterMap[$decryptedCharacterValue];

            $decryptedString .= $decryptedCharacter;
        }

        return $decryptedString;
    }
}
