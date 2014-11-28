<?php

namespace MobileXCo;

/**
 * Validate
 * 
 * Data validation library
 * 
 * Can validate the following types:
 * string
 * integer
 * email
 * date
 * 
 * Elements can be marked as required
 * 
 * Type string and int can have a min and max length
 * 
 */ 
class Validate
{
    private $schema;
    private $types = array('string', 'int', 'email', 'date');
    private $required = array();

    /**
     * Parse
     * 
     * Used to load the schema
     * 
     * @param $schema A json string
     */ 
    public function parse($schema)
    {
        $dataArray = json_decode($schema);
        if ($dataArray) {
            foreach ($dataArray as $key => $value) {
                // All values must have a type
                if (empty($value->type)) {
                    throw new Exception("Invalid property $key. No type specified.");
                }
                // Type must be in the list
                if (!in_array($value->type, $this->types)) {
                    throw new Exception("Invalid property $key. Type must be one of: " . 
                        implode(',', $this->types));
                }
                // Add required values
                if (isset($value->required)) {
                    $this->required[] = $key;
                }
            }
        } else {
            throw new Exception("Schema invalid: " . $schema);
        }
        $this->schema = $dataArray;
    }

    /**
     * Is Valid
     * 
     * Used to validate the schema
     * 
     * @param $data A json string
     * @return A json string
     */ 
    public function isValid($data)
    {
        $valid = true;
        $error = array();
        if (!empty($data)) {
            $dataArray = json_decode($data);
            if ($dataArray) {
                // Check required elements
                foreach($this->required as $required) {
                    if (empty($dataArray->$required)) {
                        $valid = false;
                        $error[] = "$required is required.";
                    }
                }
                // Check element values
                foreach ($dataArray as $key => $value) {
                    if (isset($this->schema->$key)) {
                        // Validate type
                        $type = $this->schema->$key->type;
                        switch ($type) {
                            case 'string':
                                if (!$this->isString($value)) {
                                    $valid = false;
                                    $error[] = "$key is invalid. Must be a string.";
                                }
                                break;
                            case 'int':
                                if (!$this->isInt($value)) {
                                    $valid = false;
                                    $error[] = "$key is invalid. Must be an integer.";
                                }
                                break;
                            case 'email':
                                if (!$this->isEmail($value)) {
                                    $valid = false;
                                    $error[] = "$key is invalid. Must be an email in format john@yahoo.com.";
                                }
                                break;
                            case 'date':
                                if (!$this->isDate($value)) {
                                    $valid = false;
                                    $error[] = "$key is invalid. Must be a date in format 2014-11-22.";
                                }
                                break;
                        }
                        // Validate minimum
                        if (isset($this->schema->$key->min)) {
                            $min = $this->schema->$key->min;
                            if (!$this->checkMin($value, $min)) {
                                $valid = false;
                                $error[] = "$key is invalid. Value must be greater than or equal to the minimum: $min";
                            }
                        }
                        // Validate maximum
                        if (isset($this->schema->$key->max)) {
                            $max = $this->schema->$key->max;
                            if (!$this->checkMax($value, $max)) {
                                $valid = false;
                                $error[] = "$key is invalid. Value must be less than or equal to the maximum: $max";
                            }
                        }
                    }
                }
            } else {
                $valid = false;
                $error[] = "Data invalid: $data";
            }
        } else {
            $valid = false;
            $error[] = "Data is empty.";
        }
        return json_encode(array('valid' => $valid, 'error' => $error));
    }

    /**
     * Is Email
     * 
     * Validate email
     * 
     * @param string $email
     * @return boolean
     */ 
    private function isEmail($email) {
        $valid = false;
        if (preg_match('/^[\w\.]+@[\w\.]+\.\w+$/', $email)) {
            $valid = true;
        }
        return $valid;
    }

    /**
     * Is String
     * 
     * Validate string
     * 
     * @param string $string
     * @return boolean
     */
    private function isString($string) {
        return is_string($string);
    }

    /**
     * Check Min
     * 
     * Validate minimum length of int or string
     * 
     * @param string|int $value
     * @param int $min
     * @return boolean
     */
    private function checkMin($value, $min) {
        $valid = false;
        if ($this->isString($value)) {
            if (strlen($value) >= $min) {
                $valid = true;
            }   
        } elseif ($value >= $min) {
            $valid = true;
        }
        return $valid;
    }
    
    /**
     * Check Max
     * 
     * Validate maximum length of int or string
     * 
     * @param string|int $value
     * @param int $min
     * @return boolean
     */
    private function checkMax($value, $max) {
        $valid = false;
        if ($this->isString($value)) {
            if (strlen($value) <= $max) {
                $valid = true;
            }
        } elseif ($this->isInt($value)) {
            if ($value <= $max) {
                $valid = true;
            }
        }
        return $valid;
    }

    /**
     * Is Date
     * 
     * Validate date
     * 
     * @param string $date
     * @return boolean
     */
    private function isDate($date) {
        $valid = false;
        if (preg_match('/^\d\d\d\d\-\d\d\-\d\d$/', $date)) {
            $valid = true;
        }
        return $valid;
    }

    /**
     * Is Int
     * 
     * Validate integer
     * 
     * @param integer $int
     * @return boolean
     */
    private function isInt($int) {
        return is_int($int);
    }
}
