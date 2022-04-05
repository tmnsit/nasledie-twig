<?
use Bitrix\Main\Application;
use ProjectName\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use ProjectName\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
*/

$twigData = [
    "popupForms" => [
        [
            "title" => "Остались вопросы?",
            "text" => "Оставьте свои контактные данные и мы перезвоним",
            "inputs" => [
                [
                    "required" => true,
                    "placeholder" => "Ваше имя",
                    "type" => "text",
                    "name" => "name"
                ],
                [
                    "required" => true,
                    "placeholder" => "Номер телефона",
                    "type" => "tel",
                    "name" => "tel"
                ],
                [
                    "required" => true,
                    "placeholder" => "Email",
                    "type" => "email",
                    "name" => "email"
                ]
            ],
            "id" => "callback-form",
            "checkbox" => [
                "href" => "/personal-data/"
            ],
            "button" => [
                "type" => "submit",
                "theme" => "black",
                "text" => "Оставить заявку"
            ]
        ],
        [
            "title" => "Принять участие в тендере",
            "text" => "Для внесения вашей компании в базу данных потенциальных подрядчиков, участия в конкурсах и получения Тендерной документации просим Вас заполнить форму, указав запрашиваемую информацию.",
            "inputs" => [
                [
                    "required" => true,
                    "placeholder" => "Наименование компании",
                    "type" => "text",
                    "name" => "name"
                ],
                [
                    "required" => true,
                    "placeholder" => "ИНН",
                    "type" => "text",
                    "name" => "inn"
                ],
                [
                    "required" => true,
                    "placeholder" => "Контактный номер телефона",
                    "type" => "tel",
                    "name" => "contact-tel"
                ],
                [
                    "required" => true,
                    "placeholder" => "Контактное лицо",
                    "type" => "text",
                    "name" => "contact-name"
                ],
                [
                    "required" => true,
                    "placeholder" => "Специализация",
                    "type" => "text",
                    "name" => "specialization"
                ],
                [
                    "required" => false,
                    "type" => "file",
                    "name" => "file",
                    "accept" => ".doc, .docx, .pdf, .png, .xlsx, .xls",
                    "text" => "Прикрепить файл"
                ]
            ],
            "id" => "callback-form-accept",
            "checkbox" => [
                "href" => "/personal-data/",
                "download" => true,
                "target" => "_blank",
                "column" => 2
            ],
            "button" => [
                "type" => "submit",
                "theme" => "black",
                "text" => "Оставить заявку"
            ]
        ],
        [
            "title" => "Пригласить в тендер",
            "text" => "Вы можете пригласить нашу компанию на тендер и/или отправить техническое задание. Заполните необходимые поля и представитель нашей компании свяжется с вами.",
            "inputs" => [
                [
                    "required" => false,
                    "placeholder" => "Наименование компании",
                    "type" => "text",
                    "name" => "name"
                ],
                [
                    "required" => false,
                    "placeholder" => "Контактный номер телефона",
                    "type" => "tel",
                    "name" => "contact-tel"
                ],
                [
                    "required" => false,
                    "placeholder" => "Контактное лицо",
                    "type" => "text",
                    "name" => "contact-name"
                ],
                [
                    "required" => false,
                    "placeholder" => "Необходимая сфера деятельности",
                    "type" => "text",
                    "name" => "field-activity"
                ],
                [
                    "required" => false,
                    "placeholder" => "Город деятельности",
                    "type" => "text",
                    "name" => "city"
                ],
                [
                    "required" => false,
                    "type" => "file",
                    "name" => "file",
                    "accept" => ".doc, .docx, .pdf, .png, .xlsx, .xls",
                    "text" => "Прикрепить файл"
                ]
            ],
            "id" => "callback-form-invite",
            "checkbox" => [
                "href" => "/personal-data/",
                "column" => 2
            ],
            "button" => [
                "type" => "submit",
                "theme" => "black",
                "text" => "Оставить заявку"
            ]
        ],
        [
            "title" => "Ипотека онлайн",
            "text" => "Оставьте свои контактные данные и мы перезвоним",
            "inputs" => [
                [
                    "required" => true,
                    "placeholder" => "Ваше имя",
                    "type" => "text",
                    "name" => "name"
                ],
                [
                    "required" => true,
                    "placeholder" => "Номер телефона",
                    "type" => "tel",
                    "name" => "tel"
                ],
                [
                    "required" => true,
                    "placeholder" => "Email",
                    "type" => "email",
                    "name" => "email"
                ]
            ],
            "id" => "ipoteka-form",
            "checkbox" => [
                "href" => "/personal-data/"
            ],
            "button" => [
                "type" => "submit",
                "theme" => "black",
                "text" => "Подать заявку"
            ]
        ],
        [
            "title" => "Забронировать",
            "text" => "Оставьте свои контактные данные и мы перезвоним",
            "inputs" => [
                [
                    "required" => true,
                    "placeholder" => "Ваше имя",
                    "type" => "text",
                    "name" => "name"
                ],
                [
                    "required" => true,
                    "placeholder" => "Номер телефона",
                    "type" => "tel",
                    "name" => "tel"
                ],
                [
                    "required" => true,
                    "placeholder" => "Email",
                    "type" => "email",
                    "name" => "email"
                ]
            ],
            "id" => "booking-form",
            "checkbox" => [
                "href" => "/personal-data/"
            ],
            "button" => [
                "type" => "submit",
                "theme" => "black",
                "text" => "Оставить заявку"
            ]
        ],
    ]
];


// $data = [
//     "IBLOCK_ID" => 5,
//     "NAME" => "NAME",
//     "PROPERTY_CITY" => "SPEC",
// ];

// $result = \Bitrix\Iblock\Elements\ElementProjectsTable::add(
//     $data
// );

// if ($result->isSuccess())
// {
//     $id = $result->getId();
//     mpr($id, false);
//     \Bitrix\Iblock\Elements\ElementProjectsTable::update($id, $data);
// } else {
//     mpr($result->getErrorMessages(), false);
// }

// $iblock = \Bitrix\Iblock\Iblock::wakeUp(PROJECTS_IBLOCK);
// $elements = \Bitrix\Iblock\ElementTable::getList([
// $elements = \Bitrix\Iblock\Elements\ElementProjectsTable::getList([
// 	'select' => [
//         "IBLOCK_ID", "ID", "NAME", "PREVIEW_PICTURE",
//         "CITY",
//         "YELLOW_NAMEPLATE.ELEMENT",
//         "WHITE_NAMEPLATE.ELEMENT",
//         "MIN_PRICE",
//     ],
// 	'filter' => [
//         // "IBLOCK_ID" => PROJECTS_IBLOCK,
//         // "ID" => 7,
//         // "27" => "Да",
// 	],
// ])->fetchCollection();

// mpr($elements, false);

/*
$iterator = new RecursiveArrayIterator($twigData);

while ($iterator->valid()) {

    if ($iterator->hasChildren()) {
        // print all children
        foreach ($iterator->getChildren() as $key => $value) {
            echo $key . ' : ' . $value . "\n";
        }
    } else {
        echo "No children.\n";
    }

    $iterator->next();
}
*/

// foreach($elements as $element)
// {
//     mpr($element, false);
    
// }

/*
foreach($elements as $element)
{
    mpr($element->getName(), false);
    $twigData["project"]["list"][$key]["title"] = $element->getName();
    mpr($element->getPreviewPicture(), false); // CFile::ResizeImageGet();
    mpr(CFile::ResizeImageGet($element->getPreviewPicture(), array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true), false);

    if (is_object($element->getCity())) {
        mpr($element->getCity()->getValue(), false);
    }
    if (is_object($element->getMinPrice())) {
        mpr($element->getMinPrice()->getValue(), false);
    }
    foreach($element->getYellowNameplate()->getAll() as $value)
    {
        if (is_object($value)) {
            mpr($value->getElement()->getName(), false);
        }
    }
    foreach($element->getWhiteNameplate()->getAll() as $value)
    {
        if (is_object($value)) {
            mpr($value->getElement()->getName(), false);
        }
    }
}
*/

/*
$twigData["project"]["title"] = $arParams["BLOCK_TITLE"];

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => PROJECTS_IBLOCK, "ACTIVE" => "Y", "PROPERTY_TYPE_VALUE" => ["Жилое строительство"], "PROPERTY_SHOW_MAIN_VALUE" => "Да");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, Array("nPageSize"=>$arParams["PAGE_SIZE"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["RES_PREVIEW_PICTURE"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>685, "height"=>404), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arFields["PROPERTIES"] = $ob->GetProperties();
    $projects[] = $arFields;
}
foreach ($projects as $key => $value) {
    $twigData["project"]["list"][$key]["title"] = $value["NAME"];
    $twigData["project"]["list"][$key]["text"] = $value["PREVIEW_TEXT"];
    $twigData["project"]["list"][$key]["img"]["src"] = $value["RES_PREVIEW_PICTURE"]["src"];
    $twigData["project"]["list"][$key]["img"]["alt"] = $value["NAME"];
    $twigData["project"]["list"][$key]["price"] = ($value["PROPERTIES"]["MIN_PRICE"]["VALUE"]) ? "от ".(str_replace(".", ",", $value["PROPERTIES"]["MIN_PRICE"]["VALUE"] / 1000000))." млн. ₽" : "" ;
    $twigData["project"]["list"][$key]["city"] = $value["PROPERTIES"]["CITY"]["VALUE"];

    if ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            $name = $nameplate->fetchObject()->getName();
            $twigData["project"]["list"][$key]["class"][] = $name;
        }
    }
    if ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            $name = $nameplate->fetchObject()->getName();
            $twigData["project"]["list"][$key]["tag"][] = $name;
        }
    }
}
*/

$arResult["TEMPLATE_DATA"] = $twigData;