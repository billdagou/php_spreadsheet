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
        'Dompdf' => 'pdf',
        IOFactory::WRITER_HTML => 'html',
        'Mpdf' => 'pdf',
        IOFactory::WRITER_ODS => 'ods',
        'Tcpdf' => 'pdf',
        IOFactory::READER_XLS => 'xls',
        IOFactory::READER_XLSX => 'xlsx',
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