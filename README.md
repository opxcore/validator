# Validator

Complete description coming soon.

# Rules

## General rules format

Set of rules for data validation must be defined by an array keyed by name of field to validate and containing rules to 
validate this field. Rules for field validation can be defined by string or array. 

Example below shows 'email' field must be present in data, not empty and be valid email format according RFC, 'name' 
field must be string or null if it presents in data, 'password' field must be present, be string with length of six or
more characters and match `password_confirmation` field. 
```
$rules = [
    'email' => 'required|email',
    'name' => 'string|nullable',
    'password' => 'required|string|length:>=6|confirmed',
];
```

### String format

String rules format contains set of rules separated by `'|'` sign. Each rule consists of rule name and parameters 
separated by `':'`. Parameters must be separated by comma `','`.

`'rule_name:parameter,parameter,...|rule_name:parameter,parameter,...'`

Some rules do not require any parameters, so only rule name must be used (actually, all given parameters will be 
ignored, no exceptions will be thrown). Some rules require parameters, but if there are no enough ones 
`OpxCore\Validator\Exceptions\InvalidParametersCountException` exception will be thrown. For required and optional
parameters see description of rules below. 

### Array format

Each array element can be string defining single rule (see above) or instance of `OpxCore\Validator\Interfaces\Rule`.

Example:
```
$rules = [
    'email' => [
        new RequiredRule(),
        new EmailRule(),
    ],
    ...
];
```

So this way you could pass to validator your own rules implementing rule interface.

Optionally, some rules could be created with additionally parameters (see description of rules below). 

For example, `'required_if'` rule could be created with specifying condition for this rule:
```
$requiredWithoutAccount = new ReqiredIfRule(fn()=>!$user->has_account);

$rules = [
    'first_name' => [
        $requiredWithoutAccount,
        'string',
        'length:>2',
    ], 
];    
```


## Considerations
- "empty" means the value is null, an empty string or string with only spaces, an empty array or Countable object or
 file with no file name.
- By default, all validation rules would be passed if fields related to these rules are not present. Another behavior 
noticed in rules description.
- Validation modifiers must be specified first to clearer and easy to read (but not required).

## Modifiers

- TODO `bail` - stop running validation rules for the field under validation after the first validation failure.

- TODO `some` - validation of the field passes if at least one rule passes

- TODO `nullable` - the field under validation may be null.

## Rules

### Common 

`accepted` - must be equal to 'yes', 'on', '1', 1, true, 'true'.

`confirmed` - must have a matching (value and type) {field}_confirmation field when it is present.

`filled` - must not be empty.

`present` - must be present in the input data but can be empty.

`required` - must be present in the input data and not empty.

`required_if:another_field,value` - must be present and not empty if the {another_field} is equal to the value.
    You can specify condition in the constructor (it must be bool or callable returning bool): `$rule = new RequiredIf(fn() => true);`.
    In this case checking of another field would be ignored.
    
`required_unless:another_field,value` - inverse of `required_if`, must be present and not empty if the {another_field} is not equal to the value.

`required_with:foo,bar,...` - must be present and not empty only if any of the other specified fields are present.

`required_with_all:foo,bar,...` - must be present and not empty only if all of the other specified fields are present.

`required_without:foo,bar,...` - must be present and not empty only when any of the other specified fields are not present.

`required_without_all:foo,bar,...` - must be present and not empty only when all of the other specified fields are not present.

- TODO `excluded_if`

- TODO `excluded_unless`

### URL

`active_url` - Checks if url return HTTP 200 response header (uses get_headers()) when it is present.

- TODO `uri:scheme,authority,path,query,fragment` - must be a valid uniform resource identifier (RFC 3986) 

### Type

`array` - must be a PHP array.

`boolean` - must be able to be cast as boolean. Accepted are true, false, 1, 0, "1", and "0".

`date` - must be a valid, non-relative date according to the strtotime() PHP function.

`integer` - must be an integer or a string or numeric value that contains an integer.

`numeric` - must be numeric.

`string` - must be a string.

- TODO `image` - must be an image file (jpeg, png, bmp, gif, svg, or webp)

- TODO `file` - must be a file

- TODO `timezone` - must be a valid timezone identifier according to the timezone_identifiers_list PHP function.

### Format

- TODO `format:alpha,num,dash,underscore,slash` must be entirely:
    alpha - alphabetic characters;
    num - numeric characters;
    dash;
    underscore;
    slash;

- TODO `email` - must be formatted as an e-mail address. By default, the RFCValidation validator is applied, but you can apply other validation styles as well:
    rfc: RFCValidation;
    strict: NoRFCWarningsValidation;
    dns: DNSCheckValidation (require the PHP intl extension);
    spoof: SpoofCheckValidation (require the PHP intl extension);
    filter: use PHP filter_var function.

- TODO `date_format:format` - must match the given format. You should use either date or date_format when validating a field, not both. This validation rule supports all formats supported by PHP DateTime class.

- TODO `json` - must be a valid JSON string.

- TODO `ip:v4,v6` - must be an IP address of v4 or v6 standard (if not specified), v4 or v6 if specified.

- TODO `mimetype:video/avi,video/mpeg,...` - must match one of the given MIME types. See https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types.

- TODO `mimes:mpeg,mpg,avi,...` - must have a MIME type corresponding to one of the listed extensions.
    Even though you only need to specify the extensions, this rule actually validates against the MIME type of the file by 
    reading the file's contents and guessing its MIME type.
    A full listing of MIME types and their corresponding extensions may be found at the following location: https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types

- TODO `uuid` - must be a valid RFC 4122 (version 1, 3, 4, or 5) universally unique identifier (UUID).

- TODO `regex:pattern` - must match the given regular expression.
Internally, this rule uses the PHP preg_match function. The pattern specified should obey the same formatting required by preg_match and thus also include valid delimiters. For example: 'email' => 'regex:/^.+@.+$/i'.
Note: When using the regex / not_regex patterns, it may be necessary to specify rules in an array instead of using pipe delimiters, especially if the regular expression contains a pipe character.

- TODO `not_regex:pattern` - must not match the given regular expression.
Internally, this rule uses the PHP preg_match function. The pattern specified should obey the same formatting required by preg_match and thus also include valid delimiters. For example: 'email' => 'not_regex:/^.+$/i'.
Note: When using the regex / not_regex patterns, it may be necessary to specify rules in an array instead of using pipe delimiters, especially if the regular expression contains a pipe character.

### Size

All size rules has one required parameter and one optional. If only one parameter specified, it would be used for comparision.
Giving a second parameter will define range of values as min and max value.

Examples:
- 'value:10' - value must be equal to 10;
- 'value:>10' - value must be greater than 10;
- 'count:>=3' - items count must be greater or equal to 3;
- 'value:<10' - value must be less than 10;
- 'length:<=8' - string length must be less or equal to 8;
- 'size:100,2000' - file must be not smaller than 100 KiB and not bigger than 2000 KiB;
- 'digits:>2,<4' - number of digits in numeric must be greater than 2 and less than 4;
 
`value:value{,value}` - must be numeric and have value passing rules above.

`count:value{,value}` - must be array or countable and have count of items passing rules above.

`length:value{,value}{,encoding}` - must be string and have count of characters passing rules above. Third parameter can be encoding of string, 'UTF-8' by default.

`size:value{,value}` - must be file and have size in KiB (1024 byte) passing rules above.

- TODO `dimensions` - must be an image file meeting the dimension constraints as specified by the rule's parameters:
    min_width, 
    max_width, 
    min_height, 
    max_height, 
    width, 
    height, 
    ratio (should be represented as width divided by height. This can be specified either by a statement like 3/2 or a float).

### Value

- TODO `starts_with:foo,bar,...`

- TODO `ends_with:foo,bar,...`

- TODO `in:foo,bar,...` - must be included in the given list of values.

- TODO `not_in:foo,bar,...` - must be not included in the given list of values.

### Comparision

- TODO `same:field` - must have a same value than field.

- TODO `diff:field` - must have a different value than field.

- TODO `gt:field` - must be greater than the given field. The two fields must be of the same type.

- TODO `gte:field` - must be greater than or equal to the given field. The two fields must be of the same type.

- TODO `lt:field` - must be less than the given field. The two fields must be of the same type.

- TODO `lte:field` - must be less than or equal to the given field. The two fields must be of the same type.

### Date comparision

- TODO `after:date` - must be a value after a given date. 

- TODO `after_or_equal:date` - must be a value after or equal to the given date. 

- TODO `before:date` - must be a value preceding the given date.

- TODO `before_or_equal:date` - must be a value preceding or equal to the given date.

- TODO `date_equals:date` - must be equal to the given date.

- TODO `after_another:field` - must be a value after a date given in another field. 

- TODO `after_or_equal_another:field` - must be a value after or equal to the date given in another field. 

- TODO `before_another:field` - must be a value preceding the date given in another field.

- TODO `before_or_equal_another:field` - must be a value preceding or equal to the date given in another field.

- TODO `date_equals_another:field` - must be equal to the date given in another field.





