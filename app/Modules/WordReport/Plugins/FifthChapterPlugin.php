<?php


namespace App\Modules\WordReport\Plugins;


use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Style\Image;

class FifthChapterPlugin extends BasePlugin
{
    public function setChapter(Section $section)
    {
        $this->setSection($section);
        $section->addTitle("第五章 附件 – 信件防範措施");

        $this->addBoldTextDefaultStyle("取消自動下載圖片、關閉預覽、純文字讀取模式功能設定：");

        $this->addTextWithDefaultStyle("Webmail 設定:登入 Webmail→喜好設定→郵件→取消勾選在 HTML 電子郵件中自 動顯示圖片→儲存。");

        $imageStyle = [
            'width' => 400,
            'height' => 300,

            'posHorizontal' => Image::POSITION_ABSOLUTE,


            'marginLeft' => 40,
        ];
        $section->addImage($this->getImagePath("5-1.png"), $imageStyle);
        $section->addPageBreak();

        $this->addTextWithDefaultStyle("關閉預覽：檢視→關閉閱讀窗格");
        $section->addImage($this->getImagePath("5-2.png"), $imageStyle);
        $section->addImage($this->getImagePath("5-3.png"), $imageStyle);
        $section->addPageBreak();

        $this->addBoldTextDefaultStyle("Gmail設定：");

        $this->addTextWithDefaultStyle("登入Gmail→設定→一般設定→外部內容→顯示外部內容時，必須先詢問我→儲存變更。");
        $section->addImage($this->getImagePath("5-4.png"), $imageStyle);
        $section->addImage($this->getImagePath("5-5.png"), $imageStyle);
        $section->addPageBreak();

        $this->addBoldTextDefaultStyle("Office Outlook2010關閉預覽圖片：");

        $this->addTextWithDefaultStyle("檔案→資訊→選項→信任中心→信任中心設定→自動下載→不自動下載HTML電子郵件訊息或RSS項目中的圖片→確定→確定。");
        $section->addImage($this->getImagePath("5-6.png"), $imageStyle);
        $section->addImage($this->getImagePath("5-7.png"), $imageStyle);
        $section->addPageBreak();
        $section->addImage($this->getImagePath("5-8.png"), $imageStyle);
        $section->addImage($this->getImagePath("5-9.png"), $imageStyle);
        $section->addPageBreak();


        $this->addBoldTextDefaultStyle("Office Outlook2010關閉讀取窗格：");

        $this->addTextWithDefaultStyle("收件匣→檢視→讀取窗格→關閉。(刪除的郵件、垃圾郵件、寄件備份按以上步驟設定關閉讀取窗格)");

        $section->addImage($this->getImagePath("5-10.png"), $imageStyle);

        $this->addTextWithDefaultStyle("Outlook2003設定純文字讀取模式");
        $section->addImage($this->getImagePath("5-11.png"), $imageStyle);
        $section->addPageBreak();

        $this->addTextWithDefaultStyle("Outlook2007設定純文字讀取模式");
        $section->addImage($this->getImagePath("5-12.png"), $imageStyle);

        $this->addTextWithDefaultStyle("Outlook2010設定純文字讀取模式");
        $section->addImage($this->getImagePath("5-13.png"), $imageStyle);
        $section->addTextBreak(2);
        $this->addTextWithDefaultStyle("=以下空白=");
    }
}
