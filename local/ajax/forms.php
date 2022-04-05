<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

// }
// $fileds = [];
// $post = $request->getPostList()->toArray();
// foreach ($post as $key => $value) {
//     $fileds[$key] => $value;
// }




$PROP["FORM_NAME"] = $request->getPost("form-title");
$PROP["FORM_CODE"] = $request->getPost("form-id");

switch ($PROP["FORM_CODE"]) {
    case "callback-form":
        $messageId = "86";
        $IBLOCK_ID = FORMMAINBANNER_IBLOCK;

        if ($request->getPost("name")) {
            $PROP["NAME"] = $request->getPost("name");
        }
        if ($request->getPost("tel")) {
            $PROP["TEL"] = $request->getPost("tel");
        }
        if ($request->getPost("email")) {
            $PROP["EMAIL"] = $request->getPost("email");
        }
        break;

    case "callback-form-invite":
        $messageId = "87";
        $IBLOCK_ID = FORMINVITETENDER_IBLOCK;
        
        if ($request->getPost("name")) {
            $PROP["COMPANY_NAME"] = $request->getPost("name");
        }
        if ($request->getPost("contact-tel")) {
            $PROP["CONTACT_TEL"] = $request->getPost("contact-tel");
        }
        if ($request->getPost("contact-name")) {
            $PROP["CONTACT_NAME"] = $request->getPost("contact-name");
        }
        if ($request->getPost("field-activity")) {
            $PROP["FILED_ACTIVITY"] = $request->getPost("field-activity");
        }
        if ($request->getPost("city")) {
            $PROP["CITY"] = $request->getPost("city");
        }
        break;

    case "callback-form-accept":
        $messageId = "88";
        $IBLOCK_ID = FORMACCEPTTENDER_IBLOCK;

        if ($request->getPost("name")) {
            $PROP["COMPANY_NAME"] = $request->getPost("name");
        }
        if ($request->getPost("inn")) {
            $PROP["INN"] = $request->getPost("inn");
        }
        if ($request->getPost("contact-tel")) {
            $PROP["TEL"] = $request->getPost("contact-tel");
        }
        if ($request->getPost("contact-name")) {
            $PROP["CONTACT_NAME"] = $request->getPost("contact-name");
        }
        if ($request->getPost("specialization")) {
            $PROP["SPECIALIZATION"] = $request->getPost("specialization");
        }
        break;

    case "footer-form":
        $messageId = "89";
        $IBLOCK_ID = FORMMAINFOOTER_IBLOCK;

        if ($request->getPost("name")) {
            $PROP["NAME"] = $request->getPost("name");
        }
        if ($request->getPost("tel")) {
            $PROP["TEL"] = $request->getPost("tel");
        }
        if ($request->getPost("email")) {
            $PROP["EMAIL"] = $request->getPost("email");
        }
        break;
    case "ipoteka-form":
        $messageId = "89";
        $IBLOCK_ID = IPOTEKAONLINE_IBLOCK;

        if ($request->getPost("name")) {
            $PROP["NAME"] = $request->getPost("name");
        }
        if ($request->getPost("tel")) {
            $PROP["TEL"] = $request->getPost("tel");
        }
        if ($request->getPost("email")) {
            $PROP["EMAIL"] = $request->getPost("email");
        }
        if ($request->getPost("data")) {
            $PROP["DATA"] = $request->getPost("data");
        }
        break;

    case "booking-form":
        $messageId = "91";
        $IBLOCK_ID = BOOKINGFORM_IBLOCK;

        if ($request->getPost("name")) {
            $PROP["NAME"] = $request->getPost("name");
        }
        if ($request->getPost("tel")) {
            $PROP["TEL"] = $request->getPost("tel");
        }
        if ($request->getPost("email")) {
            $PROP["EMAIL"] = $request->getPost("email");
        }
        break;

    case "calc-form":
        $messageId = "92";
        $IBLOCK_ID = CACLFORM_IBLOCK;

        if ($request->getPost("name")) {
            $PROP["NAME"] = $request->getPost("name");
        }
        if ($request->getPost("tel")) {
            $PROP["TEL"] = $request->getPost("tel");
        }
        if ($request->getPost("email")) {
            $PROP["EMAIL"] = $request->getPost("email");
        }
        break;
}
$PROP["IBLOCK_ID"] = $IBLOCK_ID;

if ($request->getFile('file')) {
    $file = $request->getFile('file');
    $newsFile = CFile::SaveFile($file, "iblock");
    $PROP["FILE"] = CFile::MakeFileArray($newsFile);
}

$arLoadFormArray = [
    "IBLOCK_ID" => $IBLOCK_ID,
    "PROPERTY_VALUES" => $PROP,
    "NAME" => "Заявка от ".date("d-m-Y"),
];

$el = new CIBlockElement;

$post = $request->getPostList();
if($NEW_ID = $el->Add($arLoadFormArray)) {
    $arSendFileds = $PROP;

    \Bitrix\Main\Mail\Event::send([
        "EVENT_NAME" => "CUSTOM_FORMS",
        'MESSAGE_ID' => $messageId,
        "LID" => "s1", 
        "C_FIELDS" => $arSendFileds,
        "FILE" => array($newsFile),

    ]);

    $response = [
        "status" => "ok",
        "id" => $NEW_ID,
        "post" => $request->getPostList()->toArray(),
        "load" => $arLoadFormArray,
        "file" => $request->getFile('file'),
    ];

} else {
    $response = [
        "status" => "error",
        "msg" => $el->LAST_ERROR,
        "post" => $request->getPostList()->toArray(),
        "load" => $arLoadFormArray,
        "file" => $request->getFile('file'),
    ];
}

$strJson = \Bitrix\Main\Web\Json::encode($response);

echo $strJson;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
