<?php

use MobileXCo\Validate;

/**
 * Validate Test
 * 
 * Class used for testing Validate
 * 
 */ 
class ValidateTest extends PHPUnit_Framework_TestCase
{
    public function testValidInt()
    {
        // Arrange
        $schema = '{"id":{"type":"int"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"id":3}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testInvalidInt()
    {
        // Arrange
        $schema = '{"id":{"type":"int"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"id":"3"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testValidString()
    {
        // Arrange
        $schema = '{"name":{"type":"string"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"name":"Denis"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testInvalidString()
    {
        // Arrange
        $schema = '{"name":{"type":"string"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"name":4}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testValidDate()
    {
        // Arrange
        $schema = '{"startDate":{"type":"date"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"startDate":"2014-10-31"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testInvalidDate()
    {
        // Arrange
        $schema = '{"startDate":{"type":"date"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"startDate":2014}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testValidEmail()
    {
        // Arrange
        $schema = '{"emailAddress":{"type":"email"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"emailAddress":"denis.bergeron@gmail.com"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testInvalidEmail()
    {
        // Arrange
        $schema = '{"emailAddress":{"type":"email"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"emailAddress":"denis.bergerongmailcom"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testStringGreaterThanMin()
    {
        // Arrange
        $schema = '{"name":{"type":"string","min":3}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"name":"Denis"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testStringLessThanMin()
    {
        // Arrange
        $schema = '{"name":{"type":"string","min":8}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"name":"Denis"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testStringLessThanMax()
    {
        // Arrange
        $schema = '{"name":{"type":"string","max":10}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"name":"Denis"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testStringGreaterThanMax()
    {
        // Arrange
        $schema = '{"name":{"type":"string","max":3}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"name":"Denis"}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testIntGreaterThanMin()
    {
        // Arrange
        $schema = '{"age":{"type":"int","min":3}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"age":5}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testIntLessThanMin()
    {
        // Arrange
        $schema = '{"age":{"type":"int","min":3}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"age":1}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testIntLessThanMax()
    {
        // Arrange
        $schema = '{"age":{"type":"int","max":10}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"age":5}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testIntGreaterThanMax()
    {
        // Arrange
        $schema = '{"age":{"type":"int","max":5}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"age":10}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
    
    public function testRequired()
    {
        // Arrange
        $schema = '{"description":{"type":"string","required":"true"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"description":"A red car."}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertTrue($valid->valid);
    }
    
    public function testRequiredMissing()
    {
        // Arrange
        $schema = '{"description":{"type":"string","required":"true"}}';
        $validate = new Validate();
        $validate->parse($schema);

        // Act
        $data = '{"id":9}';
        $reply = $validate->isValid($data);
        $valid = json_decode($reply);

        // Assert
        $this->assertFalse($valid->valid);
    }
}
