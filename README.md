 [1. Project Description](#project-description)
 
 [2. Installation](#installation)
 
 [3. Usage](#usage)
 
 [4. License](#license)
 
# Project Description

This PHP 8.0 package determines if a PHP variable of data type 'string' matches one of Germany mobile operators commercial mobile phone number formats.

It takes into account the fact that when dialed, a german mobile phone number can either include  the country code ("0049" ,  "+49") or exclude it.

Germany mobile operators numbering system (Source: German government):

[Overview](https://www.bundesnetzagentur.de/SharedDocs/Downloads/EN/Areas/Telecommunications/Companies/NumberManagement/MobileServices/Mobileservicees_Numbering%20Plan_2017.pdf?__blob=publicationFile&v=2)

My own breakdown as tables (all Excel files):

[Mobile phone numbers (no country code) - DE.xlsm](https://docs.google.com/spreadsheets/d/1v4xwM2N9_sU1WjnWR92lNwZ0194n7JbP)

[Mobile phone numbers starting with 0049 - DE.xlsm](https://docs.google.com/spreadsheets/d/1kQx08kl3vDK3yEOZ-0UXloed2gtLwfv0)

[Mobile phone numbers starting with +49 - DE.xlsm](https://docs.google.com/spreadsheets/d/16we9BrmhX77vPK1FoRr3ImWut35KLSt4)

Breakdown of the numbering system:

note: NDC = "National Destination Code"

<b>1. Format without the country code = 0 + NDC + [ X<sub>1</sub>,X<sub>2</sub>, ... ,X<sub>s</sub>] </b>, X<sub>1**≤**j<**≤**s</sub> = 0,1,2...9

Minimum total digits count: 10

Maximum total digits count: 11

<b>2. Format with country code ''0049 " = 0049 + NDC + [ X<sub>1</sub>,X<sub>2</sub>, ... ,X<sub>s</sub>] </b>, X<sub>1**≤**j<**≤**s</sub> = 0,1,2...9

Minimum total digits count: 14

Minimum total digits count: 15

<b>3. Format with country code ''+49 " = +49 + NDC + [ X<sub>1</sub>,X<sub>2</sub>, ... ,X<sub>s</sub>] </b>, X<sub>1**≤**j<**≤**s</sub> = 0,1,2...9

Minimum total characters count: 13

Minimum total characters count: 14

# Installation

Use composer to install the package: `composer require KB-WEB-DEVELOPMENT/german-mobile-checker`

Install the dependencies: `composer install` 

You can run the Pest tests in the 'tests' directory with the command: `./vendor/bin/pest`


# Usage

In your examples\index.php file: 

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Kbarut\Telecommunication\MobileChecker;

$mobileNumber = '015203917791';

$mobileChecker = new MobileChecker();

$res = $mobileChecker->validate($mobileNumber);

 ```

# License 

The MIT License (MIT)

Copyright (c) <2025> Kâmi Barut-Wanayo

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
