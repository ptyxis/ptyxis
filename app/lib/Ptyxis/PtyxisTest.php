<?php
/***************************************
PtyxisTest
Copyright (C) 2015 Mark Kestler ptyxis.cthonic.com


GNU General Public License, version 2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License version 2
as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
****************************************/

class PtyxisTest {

  protected $tests;
  protected $results;

  protected $blackList = array('runTests','displayResults');

    public function runTests()
    {
        $this->tests = get_class_methods($this);

        //build a list of tests and results
        foreach ($this->tests as $test) {
            if (!in_array($test,$this->blackList)) {
                $this->results[$test] = $this->{$test}();
            }
        }

        $this->displayResults();
    }

    protected function displayResults()
    {
        $passTotal = 0;
        $failTotal = 0;
        echo '<strong>'.get_class($this) . '</strong><br />--------------------<br />';
        foreach($this->results as $testName => $testResult) {
            ( $testResult == True ? $passTotal++ : $failTotal++ );
            echo ( $testResult == True ? '<span style="font-weight:bold;color:green;">Success</span>':'<span style="font-weight:bold;color:red;">Fail</span>' ) . ' - ' .$testName . '<br />';
        }
        echo '------------------------ <br />';
        echo 'Pass: ' . $passTotal . '<br />';
        echo 'Fail: ' . $failTotal . '<br />';
        echo ' ------------------------ <br />';
        echo ( $failTotal == 0 ? '<span style="font-weight:bold;color:green;">Success</span>':'<span style="font-weight:bold;color:red;">Fail</span>' );
        echo '<br /><br />';
    }


}
