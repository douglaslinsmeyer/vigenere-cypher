<?php
/**
 * File MockeryTestCase.php
 *
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */

namespace DLinsmeyer\VigenereCipher\Test;

use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * Class MockeryTestCase
 *
 * @author Douglas Linsmeyer <douglas.linsmeyer@nerdery.com>
 */
class MockeryTestCase extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
    }

    protected function tearDown()
    {
        Mockery::close();
    }
}
