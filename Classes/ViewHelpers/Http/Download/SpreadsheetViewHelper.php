<?php
namespace Dagou\PhpSpreadsheet\ViewHelpers\Http\Download;

use Dagou\DagouFluid\ViewHelpers\Http\DownloadViewHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SpreadsheetViewHelper extends AbstractViewHelper {
    const DEFAULT_WRITER = IOFactory::READER_XLSX;

    protected static array $writers = [
        IOFactory::WRITER_CSV => 'csv',
        IOFactory::WRITER_HTML => 'html',
        IOFactory::WRITER_ODS => 'ods',
        IOFactory::READER_XLS => 'xls',
        IOFactory::READER_XLSX => 'xlsx',
        'Dompdf' => 'pdf',
        'Mpdf' => 'pdf',
        'Tcpdf' => 'pdf',
    ];
    protected static array $mimeTypes = [
        'csv' => 'text/csv',
        'html' => 'text/html',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'pdf' => 'application/pdf',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    public function initializeArguments() {
        $this->registerArgument('spreadsheet', Spreadsheet::class, 'Spreadsheet instance');
        $this->registerArgument('writer', 'string', 'Writer type', FALSE, self::DEFAULT_WRITER);
    }

    /**
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function render(): string {
        $writerType = $this->getWriterType();

        $this->viewHelperVariableContainer->add(
            DownloadViewHelper::class,
            'filename',
            ($this->viewHelperVariableContainer->get(DownloadViewHelper::class, 'filename') ?: 'Document')
                .'.'.self::$writers[$writerType]
        );
        $this->viewHelperVariableContainer->add(DownloadViewHelper::class, 'mimeType', self::$mimeTypes[self::$writers[$writerType]]);

        $tempFilename = tempnam(sys_get_temp_dir(), 'PhpSpreadsheet');

        IOFactory::createWriter($this->arguments['spreadsheet'] ?? $this->renderChildren(), $writerType)
            ->save($tempFilename);

        $content = file_get_contents($tempFilename);

        @unlink($tempFilename);

        return $content;
    }

    /**
     * @return string
     */
    protected function getWriterType(): string {
        return in_array($this->arguments['writer'], array_keys(self::$writers)) ? $this->arguments['writer'] : self::DEFAULT_WRITER;
    }
}