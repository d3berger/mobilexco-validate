# Validate

A sample data validation library. The goal was to create a data validation library as a composer module. This was a test requested by Mobile X Co.

## How to use

The schema is supplied in json format to the parse method. The isValid method is then called which returns a json response. The response will indicate if the data string is valid compared to the schema provided. If there are errors they will be in the response.

use MobileXCo\Validate;

$validate = new Validate();

$validate->parse($schema);

$result = $validate->isValid($data);

## Data types supported

- string (A string)
- int (An integer)
- email (Must be a string. Example "denis@gmail.com")
- date (Must be a string. Example "2014-09-13")

## Extra constraints

Elements can be marked as required by adding the required parameter. Type string and int can have a min and max lengths.

## Examples

### Schema

```
{
    "id": {
        "type": "int",
        "required": true
    },
    "name": {
        "type": "string",
        "min": 5,
        "max": 30,
        "required": true
    },
    "description": {
        "type": "string",
        "max": 50
    },
    "price": {
        "type": "int",
        "min": 1
    },
    "orderOn": {
        "type": "date"
    },
    "address": {
        "type":"email"
    }
}
```

### Test

Testing with PHPUnit can be found under test folder

#### Examples

```
{
    "id": 25,
    "description": "Blue car."
}
```

isValid -> false, error: [name is required]

```
{
    "id": 21,
    "name": "Red car"
}
```

isValid -> true, error: []

