<?php


namespace App\Modules\WordReport\Plugins;


use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\NumberFormat;

class StylePlugin extends BasePlugin
{
    const BLUE_COLOR = "3798fb";
    const LIST_ITEM_FIRST_STYLE = "list_item_first_style";
    const LIST_ITEM_SECOND_STYLE = "list_item_second_style";

    const LIST_ITEM_THIRD_STYLE = "list_item_third_style";

    public function setPhpWordGlobalStyle()
    {
        $this->getPhpWord()->setDefaultFontName('Regular');
        $this->getPhpWord()->addTitleStyle(1,
            [
                'size' => 16,
                'color' => self::BLUE_COLOR
            ],
            [
                'space' => [
                    'before' => 200,
                    'after' => 200,
                ],
            ]
        );
        $this->getPhpWord()->addTitleStyle(2,
            [
                'size' => 14,
                'color' => self::BLUE_COLOR
            ],
            [
                'space' => [
                    'before' => 250,
                    'after' => 250,
                ],
                'indentation' => ['left' => 800]
            ]
        );

        $this->addListItemFirstStyle();

        $this->addListItemSecondStyle();

        $this->addListeItemThirdStyle();

        return $this;
    }

    public static function defaultFontStyle()
    {
        return [
            'size' => 12,
            'spacing' => 40
        ];
    }

    public static function defaultParagraphStyle()
    {
        return [
            'space' => [
                'after' => 40,
            ],
            'indentation' => ['left' => 800]
        ];
    }

    public static function defaultFontParagraphStyle(): array
    {
        return [
            self::defaultFontStyle(),
            self::defaultParagraphStyle()
        ];
    }

    public static function defaultCellHeaderStyle()
    {
        return ['valign' => 'center', 'bgColor' => StylePlugin::BLUE_COLOR, 'color' => 'ffffff'];
    }

    public static function defaultTableStyle(int $width)
    {
        return [
            'width' => $width,
            'borderSize' => 6,
            'cellMargin' => 50,
            'alignment' => JcTable::CENTER
        ];
    }

    public static function defaultCellTextStyle()
    {
        return [
            ["color" => 'ffffff', 'bold' => true],
            ['alignment' => 'center'],
        ];
    }

    protected function addListItemFirstStyle(): \PhpOffice\PhpWord\Style\Numbering
    {
        return $this->getPhpWord()->addNumberingStyle(
            self::LIST_ITEM_FIRST_STYLE,
            $this->baseListItemDecimalStyle()
        );
    }

    /**
     * 使用 second 是為了使排列的序號能重零開始
     * @return \PhpOffice\PhpWord\Style\Numbering
     */
    protected function addListItemSecondStyle()
    {
        return $this->getPhpWord()->addNumberingStyle(
            self::LIST_ITEM_SECOND_STYLE,
            $this->baseListItemDecimalStyle()
        );
    }

    protected function addListeItemThirdStyle()
    {

        $this->getPhpWord()->addNumberingStyle(
            self::LIST_ITEM_THIRD_STYLE, [
            'type' => 'multilevel',
            'levels' => [
                [
                    'format' => NumberFormat::BULLET,
                    'text' => '',
                    'alignment' => 'left',
                    'tabPos' => 720,
                    'left' => 1200,
                    'hanging' => 360,
                    'font' => 'Symbol',
                    'hint' => 'default'
                ],
            ]
        ]);
    }

    protected function baseListItemDecimalStyle()
    {
        // format 使用 decimal 會使排序標題為 1, 2 ,3
        return [
            'type' => 'multilevel',
            'levels' => [
                ['format' => NumberFormat::DECIMAL, 'text' => '%1.', 'left' => 1100, 'hanging' => 360, 'tabPos' => 360],
                ['format' => NumberFormat::DECIMAL, 'text' => '(%2).', 'left' => 1500, 'hanging' => 360, 'tabPos' => 720],
            ],
        ];
    }

    public static function defaultCellTextFontParagraphStyle()
    {
        return [
            ['size' => 12],
            ['alignment' => 'center'],
        ];
    }
}
