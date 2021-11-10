<?php


namespace App\Modules\WordReport;


use App\Modules\WordReport\Plugins\FifthChapterPlugin;
use App\Modules\WordReport\Plugins\FirstChapterPlugin;
use App\Modules\WordReport\Plugins\FourthChapterPlugin;
use App\Modules\WordReport\Plugins\HeaderPlugin;
use App\Modules\WordReport\Plugins\SecondChapterPlugin;
use App\Modules\WordReport\Plugins\StylePlugin;
use App\Modules\WordReport\Plugins\TableOfContents;
use App\Modules\WordReport\Plugins\ThirdChapterPlugin;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Writer\AbstractWriter;
use function storage_path;

class WordReportGenerator
{
    /**
     * @var ReportDataService
     */
    private $reportDataService;
    /**
     * @var StylePlugin
     */
    private $stylePlugin;
    /**
     * @var HeaderPlugin
     */
    private $headerPlugin;
    /**
     * @var TableOfContents
     */
    private $tableOfContentsPlugin;
    /**
     * @var FirstChapterPlugin
     */
    private $firstChapterPlugin;
    /**
     * @var SecondChapterPlugin
     */
    private $secondChapterPlugin;
    /**
     * @var ThirdChapterPlugin
     */
    private $thirdChapterPlugin;
    /**
     * @var FourthChapterPlugin
     */
    private $fourthChapterPlugin;
    /**
     * @var FifthChapterPlugin
     */
    private $fifthChapterPlugin;

    public function __construct(
        ReportDataService $reportDataService,
        StylePlugin $stylePlugin,
        HeaderPlugin $headerPlugin,
        TableOfContents $tableOfContentsPlugin,
        FirstChapterPlugin $firstChapterPlugin,
        SecondChapterPlugin $secondChapterPlugin,
        ThirdChapterPlugin $thirdChapterPlugin,
        FourthChapterPlugin $fourthChapterPlugin,
        FifthChapterPlugin $fifthChapterPlugin
    )
    {

        /*$stylePlugin->setDataSource($this->dataService)
            ->setPhpWordGlobalStyle();

        $this->headerPlugin = $headerPlugin->setDataSource($this->dataService);
        $this->tableOfContentsPlugin = $tableOfContentsPlugin->setDataSource($this->dataService);
        $this->secondChapterPlugin = $secondChapterPlugin->setDataSource($this->dataService);*/

        $this->reportDataService = $reportDataService;
        $this->stylePlugin = $stylePlugin->setPhpWordGlobalStyle();
        $this->headerPlugin = $headerPlugin;
        $this->tableOfContentsPlugin = $tableOfContentsPlugin;
        $this->firstChapterPlugin = $firstChapterPlugin;
        $this->secondChapterPlugin = $secondChapterPlugin;
        $this->thirdChapterPlugin = $thirdChapterPlugin;
        $this->fourthChapterPlugin = $fourthChapterPlugin;
        $this->fifthChapterPlugin = $fifthChapterPlugin;
    }

    public function generate(array $projectIds)
    {
        $this->reportDataService->setData($projectIds);

        $this->headerPlugin->setWordCover();
        $section = $this->tableOfContentsPlugin->setTableOfContents();
        $section = $this->tableOfContentsPlugin->setPageTop($section)
                ->setPageFooter($section);

        $this->firstChapterPlugin->setChapter($section);
        $this->secondChapterPlugin->setChapter($section);
        $this->thirdChapterPlugin->setChapter($section);
        $this->fourthChapterPlugin->setChapter($section);
        $this->fifthChapterPlugin->setChapter($section);

        /** @var AbstractWriter $objWriter */
        $objWriter = IOFactory::createWriter($this->reportDataService->getPhpWord(), 'Word2007');

        Settings::setTempDir("php://memory");
        $objWriter->save($this->wordPath() . "/" . $projectIds[0] . ".docx");
    }

    public function wordPath()
    {
        return storage_path("report/word");
    }
}
