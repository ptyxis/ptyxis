<?php
/***************************************
PtyxisValidation
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

class PtyxisValidation {

    protected $rules;
    protected $errors;

    public function setRules($field, $label, $rules, $errorMsg = null)
    {
        $this->rules[] = array('field' => $field, 'label' => $label, 'rules' => $rules, 'errorMsg' => $errorMsg);
    }

    public function optional($value)
    {
        //optional placeholder
        $msg = "";
        return $msg;
    }

    public function check_unique($value,$arg)
    {
        $msg = "";
        if($arg != 'unique') {
            $msg = 'Field must be unique';
        }
        return $msg;
    }

    public function slug($value)
    {
        $msg = "";
        if (preg_match('/[^a-zA-Z0-9\-]+/', $value)) {
            $msg = 'Slug can only have letters, numbers or dashes';
        }
        return $msg;
    }

    public function valid_date($value,$format)
    {
        $msg = "";
        $example = date($format);
        $testDate = date($format, strtotime($value));
        if ($value != $testDate) {
            $msg = 'Date must be in format ' . $example;
        }
        return $msg;
    }

    public function required($value)
    {
        $msg = "";
        if (empty($value)) {
            $msg = "Is required";
        }
        return $msg;
    }

    protected function valid_email($value)
    {
        $msg = "";
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $msg = "Must be a valid email.";
        }
        return $msg;
    }

    protected function min_length($value,$len)
    {
        $msg = "";
        if (strlen($value) < $len) {
            $msg = "Must be at least $len characters.";
        }
        return $msg;
    }


    protected function matches($value_a,$field_b)
    {
        $msg = "";
        $value_b = (!empty($_REQUEST[$field_b]) ? $_REQUEST[$field_b]:'');
        if ($value_a !== $value_b) {
            $msg = "Fields don't match.";
        }
        return $msg;
    }

    protected function max_length($value,$len)
    {
        $msg = "";
        if (strlen($value) > $len) {
            $msg = "Must not be over $len characters";
        }
        return $msg;
    }

    protected function alpha_numeric($value)
    {
        $msg = "";
        if (!ctype_alnum($value)) {
            $msg = "Must be only numbers and letters";
        }
        return $msg;
    }

    protected function numeric($value)
    {
        $msg = "";
        if (!is_numeric($value)) {
            $msg = "Must be a numeric";
        }
        return $msg;
    }

    public function validate()
    {
        foreach ($this->rules as $entry)
        {
            //get the individual rules
            $rules = explode('|',$entry['rules']);

            //check if these rules are optional
            $isOptional = in_array('optional', $rules);

            foreach ( $rules as $key => $rule) {

                //define if empty
                $value = (!empty($_REQUEST[$entry['field']]) ? $_REQUEST[$entry['field']]:'');

                //check for passed arguments
                if (strpos($rule, '[')){

                    //get the rules parts
                    preg_match('/(.*)\[(.*)\]/', $rule, $matches);

                    $func   = $matches[1];
                    $arg    = $matches[2];

                    if (!empty($func) && !empty($arg)) {
                        $error = $this->{$func}($value,$arg);
                    }

                } else {
                    //standard rule no args
                    $error = $this->{$rule}($value);
                }

                //check if there was an error returned
                if ($error) {

                    //custom error message
                    if ( !empty($entry['errorMsg'])) {
                        //apply custom error message
                        $error = $entry['errorMsg'];
                    }

                    //add current error unless it was optional and no vale provided
                    if (empty($value) && $isOptional) {

                    } else {
                        $this->errors[] = array('label' => $entry['label'], 'error' => $error);
                    }
                }
            }
        }

        //determine if errors where found
        if (!empty($this->errors)) {
            return False;
        } else {
            return True;
        }

    }

    public function getErrors()
    {
        return $this->errors;
    }

}
