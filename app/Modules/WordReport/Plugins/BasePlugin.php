<?php


namespace App\Modules\WordReport\Plugins;


use App\Modules\WordReport\ReportDataService;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\PhpWord;
use function storage_path;

class BasePlugin
{
    /**
     * @var ReportDataService
     */
    public $reportDataService;

    const IMAGE_COVER_BG = "cover_bg.png";
    const IMAGE_FOOTER = "footer.png";
    const IMAGE_HEADER = "header.png";
    const IMAGE_LOGO = "logo.jpg";

    protected $secondTitleCount = 0;

    /** @var Section|null */
    protected $section = null;

    /** @var Table|null  */
    protected $table = null;

    public function __construct(ReportDataService $reportDataService)
    {
        $this->reportDataService = $reportDataService;
    }

    public function getPhpWord()
    {
        return $this->reportDataService->getPhpWord();
    }

    public function setSection(Section $section)
    {
        $this->section = $section;
    }

    public function addTextWithDefaultStyle(string $text)
    {
        return $this->section->addText($text, ...StylePlugin::defaultFontParagraphStyle());
    }

    protected function getImagePath(string $fileName)
    {
        return storage_path('report/image/' . $fileName);
    }

    protected function addSecondTitleWithChineseNumber(string $title)
    {
        $this->secondTitleCount++;
        $titleNum = "" ;
        switch ($this->secondTitleCount) {
            case 1:
                $titleNum = "一";
                break;
            case 2:
                $titleNum = "二";
                break;
            case 3:
                $titleNum = "三";
                break;
            case 4:
                $titleNum = "四";
                break;
            case 5:
                $titleNum = "五";
                break;
            case 6:
                $titleNum = "六";
                break;
            case 7:
                $titleNum = "七";
                break;
            case 8:
                $titleNum = "八";
                break;
            case 9:
                $titleNum = "九";
                break;
            case 10:
                $titleNum = "十";
                break;
            case 11:
                $titleNum = "十一";
                break;
        }
        return $this->section->addTitle("第" . $titleNum . "節 " . $title, 2);
    }

    protected function addListItem(Section $section, string $text, string $listStyle)
    {
        $section->addListItem(
            $text,
            0,
            StylePlugin::defaultFontStyle(),
            $listStyle
        );
    }

    protected function addBoldTextDefaultStyle(string $text)
    {
        $fStyle = StylePlugin::defaultFontStyle();
        $fStyle['bold'] = true;
        $this->section->addText(
            $text,
            $fStyle,
            StylePlugin::defaultParagraphStyle()
        );
    }

    protected function addTableWithDefaultStyle(int $width)
    {
        $this->table = $this->section->addTable(
            StylePlugin::defaultTableStyle($width)
        );
        return $this->table;
    }

    protected function addTableHeaderCellTextWithDefaultStyle(int $width, string $text)
    {
        return $this->table->addCell($width, StylePlugin::defaultCellHeaderStyle())
            ->addText($text, ...StylePlugin::defaultCellTextStyle());
    }

    protected function addTableCellTextWithDefaultStyle(int $width, string $text)
    {
        return $this->table->addCell($width)
            ->addText($text, ...StylePlugin::defaultCellTextFontParagraphStyle());
    }
}
