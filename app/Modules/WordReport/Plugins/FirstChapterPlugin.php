<?php


namespace App\Modules\WordReport\Plugins;


use PhpOffice\PhpWord\Element\Section;
use function str_replace;

class FirstChapterPlugin extends BasePlugin
{
    public  function setChapter(Section $section)
    {
        $section->addTitle("第一章 保密宣言", 1);

        $str = "本文件中含有{{客戶名稱}}、如梭世代有限公司之營業機密資訊，僅供{{客戶名稱}}、如梭世代有限公司進行網路安全風險管理方案評估使用，任何閱讀此文件者已同意將本文 件內容保密，未同時得到{{客戶名稱}}、如梭世代有限公司書面同意，嚴禁拷貝、洩漏 或散佈本文件之任何部分內容。";
        $str = str_replace("{{客戶名稱}}", $this->reportDataService->getFirstCompanyName(), $str);
        $section->addText($str, ...StylePlugin::defaultFontParagraphStyle());

        $str = "如果您並非本文件之收件者，請注意任何洩漏、拷貝或是散佈本文件內容之行為已構成 觸法，並已涉及{{客戶名稱}}、如梭世代有限公司之商業機密及營運損害，{{客戶名稱}}、如梭世代有限公司有權追訴您的法律責任。";
        $str = str_replace("{{客戶名稱}}", $this->reportDataService->getFirstCompanyName(), $str);
        $section->addText($str, ...StylePlugin::defaultFontParagraphStyle());

        $section->addPageBreak();
    }
}
