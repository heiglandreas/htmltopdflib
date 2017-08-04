# Html to PDFlib

An extendable library to convert HTML-Content to text 
usable with textflows of [PDFlib](http://pdflib.com)

## Installation

Install the package via [composer](https://getcomposer.org) like this:

```bash
composer require org_heigl/html-to-pdflib
```

## Usage

In your PHP-Code you can use the package like this:

```php
$converter = new Converter();
$pdflibtext = $converter->convert($htmlcontent);

// $pdflibtext now contains calls to macros.
// The macros themselves need to be prepend to the text though!!
$pdflibtext = '<macro {
    bold {fontname=Helvetica fontsize=12 encoding=winansi}
    bolditalic {fontname=Helvetica fontsize=8 encoding=winansi}
    italic {fontname=Helvetica fontsize=8 encoding=winansi}
}>' . $pdflibtext
```

Currently the following macros are defined:

* bold
* bolditalic
* italic

The following HTML-Tags ar ecurrently supported:

* em
* li
* ol
* p
* strong
* ul

Further Tags can be added. Feel free to fork this repository 
and open a PullRequest for further tags.

## Contributing

Contributions are welcome!

## License

This package is licensed unter the MIT-License.
