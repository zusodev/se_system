<?php


namespace App\Modules\WordReport\Plugins;


use App\Models\EmailLog;
use App\Modules\WordReport\ReportRepository;
use Illuminate\Support\Collection;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Shared\Converter;
use stdClass;
use function floor;
use function is_numeric;

class ThirdChapterPlugin extends BasePlugin
{


    public function setChapter(Section $section)
    {
        $this->setSection($section);

        $section->addTitle("第三章 執行結果及分析", 1);
        $allCount = $this->reportDataService->allActionLogCount();

        $this->addTextWithDefaultStyle("本次之社交工程信件，含有測試效果(開啟信件、點擊附件)之 Email，檢測同仁資安 意識，測試同仁 {$allCount->user_count} 位，以下是檢測結果列表。");


        $section->addTextBreak();
        $this->addTextWithDefaultStyle("行為總紀錄如下表：");


        $this->addTableWithDefaultStyle(6000);
        $this->table->addRow();


        $this->addTableHeaderCellTextWithDefaultStyle(2000, '行為');
        $this->addTableHeaderCellTextWithDefaultStyle(2000, '數量');

        $this->addTableHeaderCellTextWithDefaultStyle(2000, '比例');
        /*$table->addCell('2000', StylePlugin::defaultCellHeaderStyle())
            ->addText('行為', ...StylePlugin::defaultCellTextStyle());
        $table->addCell('2000', StylePlugin::defaultCellHeaderStyle())
            ->addText('數量', ...StylePlugin::defaultCellTextStyle());
        $table->addCell('2000', StylePlugin::defaultCellHeaderStyle())
            ->addText('比例', ...StylePlugin::defaultCellTextStyle());*/


        $properties = ReportRepository::REAL_ALL_ACTION_COUNT_COLUMNS;
        $actions = ["開啟信件", "開啟連結", "開啟附件", "提交表單", "沒有異狀"];
        $aggreations = Collection::make();
        foreach ($properties as $key => $property) {
            $percentage = ((int)$allCount->$property) / $allCount->user_count;
            $percentage = floor(($percentage * 100));
            $aggreations[] = [
                "count" => (int)$allCount->$property,
                "action_zh_tw" => $actions[$key],
                "percentage" => $percentage,
            ];
        }


        foreach ($aggreations as $aggreation) {
            $this->table->addRow();

            $this->addTableCellTextWithDefaultStyle(3000, $aggreation["action_zh_tw"]);

            $this->addTableCellTextWithDefaultStyle(3000, $aggreation["count"]);
            $this->addTableCellTextWithDefaultStyle(3000, $aggreation["percentage"] . "%");

        }

        $this->addSecondTitleWithChineseNumber("行為結果概要");

        $categories = $actions;
        $values = $aggreations->pluck("count")
            ->toArray();
        $chart = $section->addChart('column', $categories, $values, [
            'width' => Converter::cmToEmu(16),
            'height' => Converter::cmToEmu(10),
//            'align' => 'right'
        ]);
        // $chart->getStyle()->setWidth(Converter::inchToEmu(2.5))->setHeight(Converter::inchToEmu(2));
//        $chart->getStyle()->setShowGridX(true);
        $chartStyle = $chart->getStyle();
        /*$chartStyle->setValueAxisTitle("測");*/
        /*$chartStyle->setCategoryAxisTitle("測");*/
        $chartStyle->setValueLabelPosition("high");
        $chartStyle->setShowGridY(true);
        $chartStyle->setShowAxisLabels(true);
        /*$chartStyle->setDataLabelOptions([
            'showLegendKey'    => true, //show the cart legend
            'showSerName'      => true, // series name
            'showPercent'      => true,
            'showLeaderLines'  => true,
            'showBubbleSize'   => true,
        ]);*/

        /*$chartStyle->set3d(true);*/


        $this->addTextWithDefaultStyle("總人數：" . $allCount->user_count);
        $this->addTextWithDefaultStyle("開啟信件總人數：" . $allCount->open_count);
        $this->addTextWithDefaultStyle("開啟連結總人數：" . $allCount->open_link_count);
        $this->addTextWithDefaultStyle("開啟附件總人數：" . $allCount->open_attachment_count);
        $this->addTextWithDefaultStyle("提交表單總人數：" . $allCount->post_count);
        $this->addTextWithDefaultStyle("沒有異狀總人數：" . $allCount->none_count);
        $this->addTextWithDefaultStyle("信件開啟率=（開啟人數 / 總人數）x 100%");


        foreach ($aggreations as $key => $aggreation) {
            $this->addTextWithDefaultStyle($aggreation["action_zh_tw"] . "人數：" . $aggreation["count"]);
            $this->addTextWithDefaultStyle($aggreation["action_zh_tw"] . " 百分比: " .
                $aggreation["percentage"] . "% = " .
                $aggreation["count"] . " / " .
                $allCount->user_count
            );

        }

        $this->topTenDepartmentTable($section);

        $this->setAllDepartmentTable($allCount);

        $this->addSecondTitleWithChineseNumber("資安意識高風險名單");

        $this->addTwoActionUsersTable($section);

        $section->addPageBreak();
    }

    /**
     * @param Section $section
     */
    protected function topTenDepartmentTable(Section $section): void
    {
        $actions = ["開啟信件", "開啟連結", "開啟附件", "提交表單"];
        $wheres = [
            [EmailLog::IS_OPEN],
            [EmailLog::IS_OPEN_LINK],
            [EmailLog::IS_OPEN_ATTACHMENT],
            [EmailLog::IS_POST_FROM_WEBSITE],
        ];
        foreach ($actions as $key => $action) {
            $where = $wheres[$key];
            $where[] = true;
            $openCountByDepartments = $this->reportDataService->countActionTopTenGroupByDepartment([$where]);
            if ($openCountByDepartments->isEmpty()) {
                continue;
            }

            $titleCount = $openCountByDepartments->count();
            $titleCount = $titleCount > 10 ? 10 : $titleCount;
            $this->addSecondTitleWithChineseNumber("依照總" . $action . "比例前 {$titleCount} 部門");

            $this->addTableWithDefaultStyle(8000);


            $this->table->addRow();
            $this->addTableHeaderCellTextWithDefaultStyle(4000, '部門');
            $this->addTableHeaderCellTextWithDefaultStyle(4000, $action);


            foreach ($openCountByDepartments as $countByDepartment) {
                $this->table->addRow();
                $this->addTableCellTextWithDefaultStyle(4000, $countByDepartment->department_name);
                $this->addTableCellTextWithDefaultStyle(4000, $countByDepartment->action_count);
            }

            $section->addTextBreak();
        }
    }

    protected function setAllDepartmentTable(stdClass $allCount)
    {
        $departments = $this->reportDataService->getDepartmentActionCount();
        $this->addSecondTitleWithChineseNumber("各部門人數統計表");

        $this->addTableWithDefaultStyle(12000);

        $this->table->addRow();


        $headers = ["部門", "開啟信件", "開啟連結", "開啟附件", "提交表單"];
        foreach ($headers as $header) {
            $this->addTableHeaderCellTextWithDefaultStyle(2400, $header);

        }


        $allProperties = ["name"];
        $allProperties = array_merge($allProperties, ReportRepository::DEPARTMENT_ACTION_COUNT_COLUMNS);
        foreach ($departments as $key => $department) {
            $cellStyle = (bool)($key % 2) ? [] : ['bgColor' => "d9e7f5"];

            $this->table->addRow();

            foreach ($allProperties as $property) {
                if ($property == "name") {
                    $this->table->addCell('2000', $cellStyle)
                        ->addText($department->name, ...StylePlugin::defaultCellTextFontParagraphStyle());
                    continue;
                }


                $percentage = 0;
                if ($department->$property && !empty($allCount->$property) && $allCount->$property) {

                    $department->$property = (int)$department->$property;
                    $allCount->$property = (int)$allCount->$property;

                    $percentage = floor(($department->$property / $allCount->$property) * 10000) / 100;
                }

                $text = $department->$property . "(" . $percentage . "%)";


                $this->table->addCell('2000', $cellStyle)
                    ->addText($text, ...StylePlugin::defaultCellTextFontParagraphStyle());
            }
        }

    }

    /**
     * @param Section $section
     */
    protected function addTwoActionUsersTable(Section $section): void
    {
        $users = $this->reportDataService->twoActionUsers();

        $this->addTextWithDefaultStyle("以下為開啟信件以及開啟連結(或點擊附件或提交表單)名單共 {$users->count()} 位同仁，本次社交工程同時加入開啟秒數 作為資料收集，駭客通常會在寄送的信件當中夾帶惡意程式的圖片、附件、或是超連 結，藉由使用者將附件開啟後達到詐騙或誘拐的目的。 在此次的秒數資料收集當中，若測試者均在 30 秒內即開啟信件且進行其他動作，此狀顯示出測試者警覺性較低，部分測試者因設定內建阻擋開啟時發起的網路連線，而 無連線紀錄存在。 開啟附件之人員仍屬於資安高風險人員，需加強宣導資安意識使用者在使用電子郵件時 應檢查寄件者真偽，包含:名稱及信件地址等、未經查證之訊息，切勿貿然轉寄、不開 啟任何寄件者沒有事先知會的附件等，以免駭客趁機安裝惡意軟體，發生機密資訊遭盜 用竊取、損毀或外流。");
        $this->addListItem(
            $section,
            "符號 - 表示使用者在郵件設定阻擋網路而無法收集其數據",
            StylePlugin::LIST_ITEM_THIRD_STYLE
        );
        $this->addListItem(
            $section,
            "10 秒內開啟信件為極高風險名單",
            StylePlugin::LIST_ITEM_THIRD_STYLE
        );
        $section->addTextBreak();


        $table = $section->addTable(StylePlugin::defaultTableStyle(15000));

        $table->addRow();


        $table->addCell('4000', StylePlugin::defaultCellHeaderStyle())
            ->addText("部門", ...StylePlugin::defaultCellTextStyle());
        $table->addCell('2000', StylePlugin::defaultCellHeaderStyle())
            ->addText("姓名", ...StylePlugin::defaultCellTextStyle());

        $table->addCell('7500', StylePlugin::defaultCellHeaderStyle())
            ->addText("Email", ...StylePlugin::defaultCellTextStyle());
        $table->addCell('1500', StylePlugin::defaultCellHeaderStyle())
            ->addText("秒數", ...StylePlugin::defaultCellTextStyle());

        ['name', 'department_name', 'diff_sec'];

        foreach ($users as $key => $user) {
            $cellStyle = (bool)($key % 2) ? [] : ['bgColor' => "d9e7f5"];

            $table->addRow();
            $table->addCell('2000', $cellStyle)
                ->addText($user->department_name, ...StylePlugin::defaultCellTextFontParagraphStyle());
            $table->addCell('2000', $cellStyle)
                ->addText($user->name, ...StylePlugin::defaultCellTextFontParagraphStyle());
            $table->addCell('2000', $cellStyle)
                ->addText($user->email, ...StylePlugin::defaultCellTextFontParagraphStyle());


            $differenceSeconds = is_numeric($user->diff_sec) ? $user->diff_sec : '-';
            $differenceSeconds = $differenceSeconds <= 0 ? '-' : $user->diff_sec;
            $table->addCell('2000', $cellStyle)
                ->addText($differenceSeconds, ...StylePlugin::defaultCellTextFontParagraphStyle());
        }
    }
}
