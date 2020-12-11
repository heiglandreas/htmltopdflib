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
}>' . $pdflibtext;
```

Alternatively – to get full flexibility – you can create the Converter with your own ConverterList like this:

```php
use Org_Heigl\HtmlToPdflib\Converter;
use Org_Heigl\HtmlToPdflib\ConverterList;
use Org_Heigl\HtmlToPdflib\Converter\Em;
use Org_Heigl\HtmlToPdflib\Converter\Li;
use Org_Heigl\HtmlToPdflib\Converter\Ol;
use Org_Heigl\HtmlToPdflib\Converter\P;
use Org_Heigl\HtmlToPdflib\Converter\Strong;
use Org_Heigl\HtmlToPdflib\Converter\Ul;
use Org_Heigl\HtmlToPdflib\Factory;

$converter = new Converter(Factory::fromConverterList(ConverterList::createViaReflection([
    'em' => Em::class,
    'li' => Li::class,
    'ol' => Ol::class,
    'p' => P::class,
    'strong' => Strong::class,
    'ul' => Ul::class,
])));
```

This allows you to also add your own Converter-implementations as long as they implement the ConvertertInterface.

Currently the following macros are defined:

* bold
* bolditalic
* italic

The following HTML-Tags are currently supported:

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
