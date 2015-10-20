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
    private $characterToValueMap = [
        'A' => 0,
        'B' => 1,
        'C' => 2,
        'D' => 3,
        'E' => 4,
        'F' => 5,
        'G' => 6,
        'H' => 7,
        'I' => 8,
        'J' => 9,
        'K' => 10,
        'L' => 11,
        'M' => 12,
        'N' => 13,
        'O' => 14,
        'P' => 15,
        'Q' => 16,
        'R' => 17,
        'S' => 18,
        'T' => 19,
        'U' => 20,
        'V' => 21,
        'W' => 22,
        'X' => 23,
        'Y' => 24,
        'Z' => 25,
    ];

    /**
     * @var array
     */
    private $valueToCharacterMap = [
        0 => 'A',
        1 => 'B',
        2 => 'C',
        3 => 'D',
        4 => 'E',
        5 => 'F',
        6 => 'G',
        7 => 'H',
        8 => 'I',
        9 => 'J',
        10 => 'K',
        11 => 'L',
        12 => 'M',
        13 => 'N',
        14 => 'O',
        15 => 'P',
        16 => 'Q',
        17 => 'R',
        18 => 'S',
        19 => 'T',
        20 => 'U',
        21 => 'V',
        22 => 'W',
        23 => 'X',
        24 => 'Y',
        25 => 'Z',
    ];

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
        $this->assertValidString($unencryptedString);

        $unencryptedStringLength = strlen($unencryptedString);
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
        $this->assertValidString($encryptedString);

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

    /**
     * Assert string passed to encrypter is valid
     *
     * @param string $string
     *
     * @throws \InvalidArgumentException if string is not valid
     * @return void
     */
    private function assertValidString($string)
    {
        $sanitizedString = preg_replace('/[^A-Z]/', '', $string);
        if (strlen($sanitizedString) < strlen($string)) {
            throw new \InvalidArgumentException('This encryption library only supports uppercase alphabetic characters.');
        }
    }
}
