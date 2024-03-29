<?php
/**
 * PHPUnit
 *
 * Copyright (c) 2002-2009, Sebastian Bergmann <sb@sebastian-bergmann.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2002-2009 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id: GroupTestSuite.php 4404 2008-12-31 09:27:18Z sb $
 * @link       http://www.phpunit.de/
 * @since      File available since Release 3.3.0
 */

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * We have a TestSuite object A.
 * In TestSuite object A we have Tests tagged with @group.
 * We want a TestSuite object B that contains TestSuite objects C, D, ...
 * for the Tests tagged with @group C, @group D, ...
 * Running the Tests from TestSuite object B results in Tests tagged with both
 * @group C and @group D in TestSuite object A to be run twice .
 *
 * <code>
 * $suite = new PHPUnit_Extensions_GroupTestSuite($A, array('C', 'D'));
 * </code>
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2002-2009 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 3.3.17
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 3.3.0
 */
class PHPUnit_Extensions_GroupTestSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct(PHPUnit_Framework_TestSuite $suite, array $groups)
    {
        $groupSuites = array();
        $name        = $suite->getName();

        foreach ($groups as $group) {
            $groupSuites[$group] = new PHPUnit_Framework_TestSuite($name . ' - ' . $group);
            $this->addTest($groupSuites[$group]);
        }

        $tests = new RecursiveIteratorIterator(
          new PHPUnit_Util_TestSuiteIterator($suite),
          RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($tests as $test) {
            if ($test instanceof PHPUnit_Framework_TestCase) {
                $class  = new ReflectionClass($test);
                $method = $class->getMethod($test->getName(FALSE));

                $testGroups = PHPUnit_Util_Test::getGroups(
                  $method->getDocComment(), PHPUnit_Util_Test::getGroups($class)
                );

                foreach ($groups as $group) {
                    foreach ($testGroups as $testGroup) {
                        if ($group == $testGroup) {
                            $groupSuites[$group]->addTest($test);
                        }
                    }
                }
            }
        }
    }
}
?>
