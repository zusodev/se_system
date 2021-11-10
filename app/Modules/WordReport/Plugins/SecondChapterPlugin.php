<?php


namespace App\Modules\WordReport\Plugins;


use PhpOffice\PhpWord\Element\Section;

class SecondChapterPlugin extends BasePlugin
{
    /** @var Section */
    protected $section;

    public function setChapter(Section $section)
    {
        $section->addTitle("第二章 社交工程演練概述", 1);
        $section->addTitle("第一節 目的", 2);
        $text = "為提高公司企業人員警覺性以降低社交工程攻擊風險，特訂定本計畫，以強化人員資安 意識並檢驗機關宣導社交工程防制成效。 現行以「網路釣魚」手法攻擊事件頻傳，以此手法誘騙使用者受騙上當達到目的，一旦 執行信件中的惡意程式，或點選、瀏覽惡意網站，是導致主機感染惡意程式的主要管 道。輕者網頁遭到綁架，重者系統主機遭植入木馬或後門程式，造成機密資料或個人金 融資料外洩，造成嚴重損失。";
        $section->addText($text, ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("透過電子郵件，綑綁或夾帶各種網頁、檔案、程式之連結(通常不會直接“夾帶附件” 或“執行程式”)，可輕易規避防毒軟體或郵件過濾軟體之偵測。此為各類 Spyware 、廣告軟體散佈的方式，不只如此，各種新型態之木馬或後門程式，也利用此方法規避 個人端防毒軟體之偵測。", ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("目前研究顯示，駭客偏好利用此方式滲透單位網路，成功機率高，使用者不易發現，風 險不容輕忽。資安防護除了仰賴各種資安設備、產品的偵測、防禦功能以外，使用者良 好的使用習慣與有效的管理措施，也扮演非常重要的角色。", ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("本測試作業即模擬駭客寄送各種誘騙的測試信件，嘗試以測試信件誘騙受測者並測試受 測者之警覺性，此測試方式可用來瞭解受測者之資安意識的落實狀況，及其對社交工程 、網路釣魚等誘騙攻擊行為的防護與警覺能力。", ...StylePlugin::defaultFontParagraphStyle());


        $section->addTitle("第二節 名詞定義", 2);

        $section->addText("測試效果四種行為:", ...StylePlugin::defaultFontParagraphStyle());

        $this->addListItem(
            $section,
            "開啟信件:屬於收件軟體尚未有安全上設定，駭客將攻擊程式或惡意程式插入附件
並夾帶於電子郵件中，寄發電子郵件給特定的目標，誘騙使用者點選郵件或開啟已 被植入惡意程式之附加檔案，以達到其暗中收集敏感性資料，並取得非法的存取權 限或造成破壞的行為易造成駭客透過惡意 Script 執行攻擊。",
            StylePlugin::LIST_ITEM_FIRST_STYLE
        );

        $this->addListItem(
            $section,
            "開啟連結:信件內的連結所導向的網站，未必是其畫面所顯示的文字所示，駭客常利用此方法誘騙使用者連線至釣魚網站",
            StylePlugin::LIST_ITEM_FIRST_STYLE
        );
        $this->addListItem(
            $section,
            "點擊附件:當各單位收件人開啟郵件或點閱郵件所附連結或檔案時，即留下紀 錄，俾利進行後續各單位惡意郵件開啟率及惡意連結(或檔案)點擊率之統計。點 擊者屬於資安意識薄弱，容易連線至釣魚網站。",
            StylePlugin::LIST_ITEM_FIRST_STYLE
        );
        $this->addListItem(
            $section,
            "提交表單:當使用者誘騙至釣魚網站時，若無資安意識，則較難注意到網址上的域名為錯誤域名，在此情形錯信網站，將個人資訊填寫至表單送出，則會讓駭客輕易取得重要使用者的機密",
            StylePlugin::LIST_ITEM_FIRST_STYLE
        );
        $section->addPageBreak();

        $section->addTitle("第三節 誘騙成功定義", 2);
        $this->addListItem(
            $section,
            "信件開啟信件透過預覽或點開方式開啟，且信件本文內所含檔案亦完成檔案下載之 動作，始認定為誘騙成功。部分收信程式，其預設之安全設定不會自動下載檔案， 即使預覽功能設定為開啟，或是直接打開誘騙信件，因無下載檔案之動作，不會造 成安全漏洞，將不會記錄為誘騙成功。",
            StylePlugin::LIST_ITEM_SECOND_STYLE
        );
        $this->addListItem(
            $section,
            "連結點選受測人員點選信件內文中之連結網址，將被記錄為誘騙成功。若信件包含 多個連結，受測者不論點選幾個，都將只記錄為一次。",
            StylePlugin::LIST_ITEM_SECOND_STYLE
        );
        $this->addListItem(
            $section,
            "Word 夾檔開啟，有如下限制:",
            StylePlugin::LIST_ITEM_SECOND_STYLE
        );

        $secondListPStyle = [
            'space' => [
                'before' => 100,
            ],
        ];
        $section->addListItem(
            "Word 檔案是透過巨集的方式去抓取紀錄，而 Word 預設的安全性是禁止巨集 執行，所以受測者有可能有開啟 Word 的動作，但未執行巨集，行為因不構成資安 漏洞，不列入誘騙成功統計。",
            1,
            StylePlugin::defaultFontStyle(),
            StylePlugin::LIST_ITEM_SECOND_STYLE,
            $secondListPStyle
        );

        $section->addListItem(
            "Word 夾檔開啟僅能依據受測者使用電腦之 Hostname 及登入系統之 Logon Name 進行記錄及統計。",
            1,
            StylePlugin::defaultFontStyle(),
            StylePlugin::LIST_ITEM_SECOND_STYLE,
            $secondListPStyle
        );


        $section->addTitle("第四節 誘騙統計說明", 2);
        $section->addText("誘騙成功人數:", ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("以駭客角度而言，發送眾多誘騙信件，只要有一封誘騙成功，即達到目的，因此只要曾 經開啟過誘騙信件中之任一封者，視為誘騙成功，以受測信箱數為單位，所以同一受測 信箱即使開啟 10 封不同內容之測試信件，但在報告中會紀錄為 1 人。同樣的，只要曾 經點選過誘騙信件中連結之任一封者，亦視為誘騙成功，在報告中會紀錄為 1 人。 誘騙成功率:", ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("以本次測試之全體受測信箱總數為分母，誘騙成功人數為分子，計算得出之百分比即為 受測單位本測試的整體誘騙成功率。", ...StylePlugin::defaultFontParagraphStyle());

        $section->addTitle("第五節 信件開啟及附件點選說明", 2);
        $section->addText("當各單位收件人開啟郵件或點閱郵件所附連結或檔案時，即留下紀錄，俾利進行後續各 單位惡意郵件開啟率及惡意連結(或檔案)點擊率之統計。", ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("測試方式:", ...StylePlugin::defaultFontParagraphStyle());

        $this->addListItem(
            $section,
            "依測試期間內所搜集之數據進行統計與分析作業，統計受引誘而開啟信件或點選信件內網頁連結之數量及比率。",
            StylePlugin::LIST_ITEM_THIRD_STYLE
        );

        $this->addListItem(
            $section,
            "本測試作業不會植入後門程式，不會影響正常公務執行。",
            StylePlugin::LIST_ITEM_THIRD_STYLE
        );

        $this->addListItem(
            $section,
            "本測試作業所寄發的誘騙信件，其寄件人之名稱均經過偽造，目的在於測試受測者
對寄件人名稱是否有足夠的警覺性。",
            StylePlugin::LIST_ITEM_THIRD_STYLE
        );

        $section->addText("信件開啟次數及連結點選次數:", ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("信件開啟次數以及連結點選次數是指針對受測單位發出的所有測試信件中，符合誘騙成 功定義之信件總數。例如:針對 A 客戶 20 個信箱發送了 200 封誘騙信件，其中 30 封 信被開啟且開啟方式符合誘騙成功定義，則該受測單位整體信件開啟數即為 30 封。", ...StylePlugin::defaultFontParagraphStyle());

        $this->addListItem(
            $section,
            "同一信箱內之同一封測試信，即使被重複開啟多次，信件開啟次數將只記錄為一次。",
            StylePlugin::LIST_ITEM_THIRD_STYLE
        );
        $this->addListItem(
            $section,
            "同一信箱內之同一封測試信之連結，即使被重複點選多次，連結點選次數將只記錄為一次。",
            StylePlugin::LIST_ITEM_THIRD_STYLE
        );

        $section->addText("信件開啟率及連結點選率:", ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("信件開啟率及連結點選率是以測試期間發送出的測試信件總數為分母，信件開啟次數與 連結點選次數為分子，分別計算所得之百分比即為受測單位的整體信件開啟率與連結點 選率。", ...StylePlugin::defaultFontParagraphStyle());

        $section->addTitle('第六節 社交工程演練郵件範本', 2);

        $project = $this->reportDataService->getFirstProject();
        $section->addText(
            "執行時間：" . $project->twYYYYMMDD("start_at")
            , ...StylePlugin::defaultFontParagraphStyle()
        );
        $section->addText("發送地址：" . $project->sender_email, ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("發送名稱：" . $project->sender_name, ...StylePlugin::defaultFontParagraphStyle());
        $section->addText("主旨：" . $project->emailTemplate->subject, ...StylePlugin::defaultFontParagraphStyle());
        $section->addPageBreak();
    }
}
