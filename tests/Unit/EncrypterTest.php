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
     * Test two-way encryption with valid strings
     *
     * @dataProvider validStringProvider
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
     * Test handling of invalid strings
     *
     * @dataProvider invalidStringProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage This encryption library only supports uppercase alphabetic characters.
     * @param string $string
     *
     * @return void
     */
    public function testCannotEncrypt($string)
    {
        $this->encrypter->encrypt($string);
    }

    /**
     * Valid data provider for encryption test
     *
     * @return array
     */
    public function validStringProvider()
    {
        return [
            ['ABCDEFGHIJKLMNOPQRSTUVWXYZ'],
            ['ZYXWVUTSRQPONMLKJIHGFEDCBA'],
            ['HELLOWORLD'],
            ['THECAKEISALIE'],
        ];
    }

    /**
     * Invalid data provider for encryption test
     *
     * @return array
     */
    public function invalidStringProvider()
    {
        return [
            ['123'],
            ['ABC!'],
            ['abcABC'],
            ['ABC123'],
        ];
    }
}
