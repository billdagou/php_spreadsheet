# TYPO3 Extension: PhpSpreadsheet

EXT:php_spreadsheet provides a ViewHelper to generate the Spreadsheet file with [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) library.

**The extension version only matches the PhpSpreadsheet library version, it doesn't mean anything else.**

## How to use it

First of all, you need to install [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) via [Composer](https://getcomposer.org/) under `EXT:php_spreadsheet/Resources/Private/PhpSpreadsheet/`.

    cd typo3conf/ext/php_spreadsheet/Resources/Private/PhpSpreadsheet/
    composer install --no-dev --prefer-dist

After that, you can use the viewhelper to generate the Spreadsheet file and download it.

    <df:http.download>
        <phpspreadsheet:http.download.spreadsheet>...</phpspreadsheet:http.download.spreadsheet>
    </df:http.download>

#### Attributes

- `spreadsheet` ([Spreadsheet](https://github.com/PHPOffice/PhpSpreadsheet/blob/master/src/PhpSpreadsheet/Spreadsheet.php)) Spreadsheet instance.
- `writer` (string) Writer type, `Csv`, `Dompdf`, `Html`, `Mpdf`, `Ods`, `Tcpdf`, `Xls`, `Xlsx`. Default `Xlsx`.