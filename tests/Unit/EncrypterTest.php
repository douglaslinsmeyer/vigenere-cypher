<?php
/**
 * File EncryptionTest.php
 *
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */

namespace DLinsmeyer\VigenereCipher\Test\Unit;

use DLinsmeyer\VigenereCipher\Encrypter;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * Class EncryptionTest
 *
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */
class EncrypterTest extends MockeryTestCase
{
    const KEY = 'HI';

    /**
     * @var Encrypter
     */
    private $encrypter;

    public function setup()
    {
        parent::setup();

        $this->encrypter = new Encrypter(self::KEY);
    }

    /**
     * Test two-way encryption
     *
     * @dataProvider stringProvider
     * @param string $string
     *
     * @return void
     */
    public function testCanEncrypt($string)
    {
        $encryptedString = $this->encrypter->encrypt($string);
        $decryptedString = $this->encrypter->decrypt($encryptedString);

        $this->assertEquals($string, $decryptedString);
    }

    /**
     * Data provider for encryption test
     *
     * @return array
     */
    public function stringProvider()
    {
        return [
            ['ABCDEFGHIJKLMNOPQRSTUVWXYZ'],
            ['ZYXWVUTSRQPONMLKJIHGFEDCBA'],
            ['HELLOWORLD'],
            ['THECAKEISALIE'],
        ];
    }
}
