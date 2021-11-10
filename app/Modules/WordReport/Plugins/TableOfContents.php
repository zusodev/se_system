<?php


namespace App\Modules\WordReport\Plugins;


use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Image;
use PhpOffice\PhpWord\Style\TOC;

class TableOfContents extends BasePlugin
{

    public function setTableOfContents()
    {
        $section = $this->getPhpWord()->addSection([

        ]);
        $section->addText('報 告 書 目 錄', ['size' => 16, 'color' => '3798fb']);
        $section->addTextBreak(1);
        $styleFont = [
            'size' => 12,
            'bold' => true,
            'spacing' => 50,
        ];
        $styleTOC = [
            'tabLeader' => TOC::TABLEADER_LINE,
            'space' => [
                'before' => 250,
                'after' => 250,
            ],

        ];

        $section->addTOC($styleFont, $styleTOC);
        $section->addPageBreak();
        return $section;
    }

    public function setPageTop(Section $section)
    {
        $header = $section->addHeader();
        $header->addImage($this->getImagePath(self::IMAGE_HEADER), [
            'width' => 520,
            'height' => 65,
            'positioning' => Image::POSITION_ABSOLUTE,
            'posHorizontal' => Image::POSITION_ABSOLUTE,
            'posVertical' => Image::POSITION_ABSOLUTE,
            'marginTop' => -40,
            'wrappingStyle' => 'behind',
        ]);
        return $this;
    }

    public function setPageFooter(Section $section)
    {
        $footer = $section->addFooter();
        $footer->addImage($this->getImagePath(self::IMAGE_FOOTER), [
            'width' => 200,
            'height' => 148,
            'positioning' => Image::POSITION_ABSOLUTE,
            'posHorizontal' => Image::POSITION_ABSOLUTE,
            'posVertical' => Image::POSITION_ABSOLUTE,
            'marginLeft' => 320,
            'marginTop' => -73,
            'wrappingStyle' => 'behind'
        ]);
        $footer->addPreserveText('
         本文件屬' . $this->reportDataService->getFirstCompanyName() . '所有，未經許可不得將全部或部分內容揭露於第三人。  ',
            null,
            ['alignment' => Jc::CENTER]
        );
        $footer->addPreserveText(
            ' 第{PAGE}頁，共{NUMPAGES}頁.',
            null,
            ['alignment' => Jc::CENTER]
        );
        return $section;
    }
}
