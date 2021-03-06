Strillone
=========

Strillone is a news aggregator relaying on TTS system Festival to allow blind
people to listen to everyday's news with their pc or tablet or smartphone.

Strillone/Paperboy (in italian language it means `paperboy`, `newspaper
seller`) is an "on demand" newspapers for visually impaired users or blind
users.

It has been realized as a web application (HTML5, CSS3, JQuery, PHP) and
they are accessible from a standard web browser.

So far we are using the [Festival][] open source project as text-to-speech
engine. Our intent is to improve Strillone with a better quality voices and we
have realized a plugin architecture to allow the integration of different TTS
engines.

[Festival]: http://www.cstr.ed.ac.uk/projects/festival/

Contributing
============

Strillone is an open source, community-driven project. If you'd like to
contribute, please follow the guidelines in the next sections.

1. Coding Style
---------------

When contributing code to Strillone, you must follow its coding standards.
To make a long story short, here is the golden rule: Imitate the existing
Strillone code.

Remember that the main advantage of standards is that every piece of code
looks and feels familiar, it's not about this or that being more readable.

Strillone follows the standards defined in the [PSR-0][], [PSR-1][] and
[PSR-2][] documents.

[PSR-0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md

Since a picture - or some code - is worth a thousand words, here's a short
example containing most features described below:

```php
<?php

/*
 * This file is part of the Strillone package.
 *
 * (c) Informatici Senza Frontiere Onlus <http://informaticisenzafrontiere.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vendor\Package;

use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

/**
 * Coding standards demonstration.
 */
class FooBar
{
    const SOME_CONST = 157;

    private $fooBar;

    /**
     * @param string $a Some argument description
     * @param string $b Some argument description
     * @param array $c
     *
     * @return string|null Transformed input
     */
    public function sampleFunction($a, $b = null, $c = array())
    {
        if ($a === $b) {
            bar();
        } elseif ($a > $b) {
            $foo->fooBar($arg1);
        } else {
            BazClass::bar($arg2, $arg3);
        }
        
        // some code
        
        return $dummy;
    }
}
```

### 1.1 Indenting and Line Length

Code must use an indent of 4 spaces, with no tabs. Using only spaces, and not
mixing spaces with tabs, helps to avoid problems with diffs, patches, history,
and annotations. The use of spaces also makes it easy to insert fine-grained
sub-indentation for inter-line alignment.

Here is an example of rules that will set up VIM editor:

```
set expandtab
set shiftwidth=4
set softtabstop=4
set tabstop=4
```

It is recommended to keep each line under 80 characters for better code
readability. However, longer lines are acceptable in some circumstances. The
maximum length of any line of PHP code is 120 characters.

### 1.2 File Formatting

- All PHP files must use the Unix LF (linefeed) line ending.

> Note: Line termination follows the Unix text file convention. Lines must
end with a single linefeed (LF) character. Do not use carriage returns (CR)
as is the convention in Apple OS's  or the carriage return - linefeed
combination (CRLF) as is standard for the Windows OS.

- All PHP files must end with a single blank line.
- The closing `?>` tag must be omitted from files containing only PHP code.

> Note: For files that contain only PHP code, the closing tag ("?>") is
never permitted. It is not required by PHP, and omitting it prevents the
accidental injection of trailing white space into the response.

### 1.3 Structure

- Add a single space after each comma delimiter;
- Add a single space around operators (`==`, `&&`, ...);
- Add a comma after each array item in a multi-line array, even after the
  last one;
- Add a blank line before return statements, unless the return is alone inside
  a statement-group (like an if statement);
- Use braces to indicate control structure body regardless of the number of
  statements it contains;
- Opening braces for classes must go on the next line, and closing braces must
  go on the next line after the body;
- Opening braces for methods must go on the next line, and closing braces must
  go on the next line after the body;
- Opening braces for control structures must go on the same line, and closing
  braces must go on the next line after the body;
- Opening parentheses for control structures must not have a space after them,
  and closing parentheses for control structures must not have a space before;
- Define one class per file;
- Declare class properties before methods;
- Declare public methods first, then protected ones and finally private ones;
- Use parentheses when instantiating classes regardless of the number of
  arguments the constructor has.

### 1.4 Naming Conventions

- Use StudlyCaps for class names;
- Use camelCase, not underscores, for variable, function and method names,
  arguments;
- Use underscores for option names and parameter names;
- Use namespaces for all classes;
- Use upper case with underscore separators for class constants;
- Use alphanumeric characters and underscores for file names;
- Don't forget to look at the more verbose Conventions document for more
  subjective naming considerations.

Report Issue/Bugs
=================
Whenever you find a bug in Strillone, we kindly ask you to report it. It helps
us make a better Strillone.

Before submitting a bug:
- Double-check the official documentation to see if you're not misusing the
  application;
- Ask for assistance if you're not sure if your issue is really a bug.

If your problem definitely looks like a bug, report it using the official bug
[tracker][] and follow some basic rules:
- Use the title field to clearly describe the issue;
- Describe the steps needed to reproduce the bug with short examples;
- Give as much detail as possible about your environment (OS, PHP version,
  Strillone version, ...);
- (optional) Attach a patch.

[tracker]: https://github.com/informatici/strillone/issues

Copyright and License
=====================
Strillone is released under the GPL license, and the license block has to be
present at the top of every PHP file, before the namespace.

Copyright© 2012,2013 Informatici Senza Frontiere Onlus
http://www.informaticisenzafrontiere.org

You can redistribute it and/or modify it under the terms of the GNU General
Public License as published by the Free Software Foundation, either version
3 of the License, or (at your option) any later version.

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

Strillone is distributed in the hope that it will be useful and is provided
"AS IS", but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.

You should have received a copy of the GNU General Public License along with
"Strillone". If not, see <http://www.gnu.org/licenses/>.

