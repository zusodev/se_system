<?php


namespace App\Modules\WordReport\Plugins;


use PhpOffice\PhpWord\Element\Section;

class FourthChapterPlugin extends BasePlugin
{

    public function setChapter(Section $section)
    {
        $section->addTitle("第四章 資安建議", 1);

        $suggestions =[
            "安裝防毒軟體，並確實更新病毒碼",
            "關閉郵件自動下載圖片及其他功能",
            "純文字模式開啟信件，及取消預覽功能",
            "設定垃圾郵件過濾機制",
            "查看郵件來源是否正常",
            "審慎注意郵件中網址的正確性，避免直接點選 l 標題或內容是否與本身業務相關",
            "無關公務之郵件避免開啟與點閱",
            "透過電話向對方確認郵件內容",
            "與公務無關者，應立即刪除",
            "分析及辨別寄件者名稱、郵件網址真偽",
        ] ;
        foreach ($suggestions as $suggestion){
            $this->addListItem($section, $suggestion, StylePlugin::LIST_ITEM_THIRD_STYLE);

        }
        $section->addPageBreak();
    }
}
