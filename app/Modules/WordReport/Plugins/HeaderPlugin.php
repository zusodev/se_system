<?php


namespace App\Modules\WordReport\Plugins;


use App\Modules\WordReport\TaiwanNow;
use PhpOffice\PhpWord\Style\Image;

class HeaderPlugin extends BasePlugin
{

    public function setWordCover()
    {
        $section = $this->getPhpWord()->addSection();
        $section->addImage($this->getImagePath(self::IMAGE_COVER_BG),
            [
                'height' => 842,
                'width' => 595,
                'positioning' => Image::POSITION_ABSOLUTE,
                'posHorizontal' => Image::POSITION_ABSOLUTE,
                'posVertical' => Image::POSITION_ABSOLUTE,
                'marginLeft' => -72,
                'marginTop' => -72,
                'wrappingStyle' => 'behind'
            ]
        );
        $style1 = ['size' => 20, 'color' => 'ffffff'];


        $section->addText(TaiwanNow::yearText() . " 年社交工程演練服務", $style1);
        $section->addText(
            $this->reportDataService->getFirstCompanyName() . " " . $this->reportDataService->getFirstProjectName(),
            $style1
        );
        $section->addTextBreak(12);

        $style2 = ['size' => 18, 'color' => 'ffffff'];
        $section->addText("社交工程演練報告書", $style2);
        $section->addTextBreak(25);

        $fstyle3 = ['size' => 14];
        $pStyle = [
            'space' => [
                'before' => 550,
            ],
        ];
        $section->addText('提出單位：如梭世代有限公司', $fstyle3, $pStyle);
        $section->addText(
            "報告產出時間：中華民國 " .
            TaiwanNow::yearText() .
            TaiwanNow::monthText() .
            TaiwanNow::dayText(),
            $fstyle3
        );
        $section->addPageBreak();
        return $section;
    }
}
