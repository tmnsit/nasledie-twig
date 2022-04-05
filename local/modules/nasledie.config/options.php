<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\HtmlFilter;

defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'nasledie.config');

if (!$USER->isAdmin()) {
    $APPLICATION->authForm('Nope');
}

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

Loc::loadMessages($context->getServer()->getDocumentRoot()."/bitrix/modules/main/options.php");
Loc::loadMessages(__FILE__);

$tabControl = new CAdminTabControl("tabControl", array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("MAIN_TAB_SET"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_SET"),
    ),
));

$logo_header_file = Option::get(ADMIN_MODULE_NAME, "logo_header");
$logo_footer_file = Option::get(ADMIN_MODULE_NAME, "logo_footer");
$logo_header_mobile_file = Option::get(ADMIN_MODULE_NAME, "logo_header_mobile");
$presentation_file = Option::get(ADMIN_MODULE_NAME, "presentation");


if ((!empty($save) || !empty($restore)) && $request->isPost() && check_bitrix_sessid()) {
    if (!empty($restore)) {
        Option::delete(ADMIN_MODULE_NAME);
        CAdminMessage::showMessage(array(
            "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_RESTORED"),
            "TYPE" => "OK",
        ));
    } elseif ($request->getPost('max_image_size') && ($request->getPost('max_image_size') > 0) && ($request->getPost('max_image_size') < 100000)) {
        Option::set(
            ADMIN_MODULE_NAME,
            "max_image_size",
            $request->getPost('max_image_size')
        );
        CAdminMessage::showMessage(array(
            "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_SAVED"),
            "TYPE" => "OK",
        ));
    }  else {
        CAdminMessage::showMessage(Loc::getMessage("REFERENCES_INVALID_VALUE"));
    }

    if ($request->getFile("logo_header") && $request->getFile("logo_header")["name"] != "") {
        $load_logo_header_file = $request->getFile("logo_header");
        $new_logo_header_file = CFile::SaveFile($load_logo_header_file, "iblock");
        Option::set(
            ADMIN_MODULE_NAME,
            "logo_header",
            $new_logo_header_file
        );
        if ($new_logo_header_file) {
            CFile::Delete($logo_header_file);
        }
        $logo_header_file = $new_logo_header_file;
    }
    if ($request->getPost("logo_header_del") == "Y") {
        CFile::Delete($logo_header_file);
        Option::set(
            ADMIN_MODULE_NAME,
            "logo_header",
            ""
        );
    }

    if ($request->getFile("logo_footer") && $request->getFile("logo_footer")["name"] != "") {
        $load_logo_footer_file = $request->getFile("logo_footer");
        $new_logo_footer_file = CFile::SaveFile($load_logo_footer_file, "iblock");
        Option::set(
            ADMIN_MODULE_NAME,
            "logo_footer",
            $new_logo_footer_file
        );
        if ($new_logo_footer_file) {
            CFile::Delete($logo_footer_file);
        }
        $logo_footer_file = $new_logo_footer_file;
    }
    if ($request->getPost("logo_footer_del") == "Y") {
        CFile::Delete($logo_footer_file);
        Option::set(
            ADMIN_MODULE_NAME,
            "logo_footer",
            ""
        );
    }

    if ($request->getFile("logo_header_mobile") && $request->getFile("logo_header_mobile")["name"] != "") {
        $load_logo_header_mobile_file = $request->getFile("logo_header_mobile");
        $new_logo_header_mobile_file = CFile::SaveFile($load_logo_header_mobile_file, "iblock");
        Option::set(
            ADMIN_MODULE_NAME,
            "logo_header_mobile",
            $new_logo_header_mobile_file
        );
        if ($new_logo_header_mobile_file) {
            CFile::Delete($logo_header_mobile_file);
        }
        $logo_header_mobile_file = $new_logo_header_mobile_file;
    }
    if ($request->getPost("logo_header_mobile_del") == "Y") {
        CFile::Delete($logo_header_mobile_file);
        Option::set(
            ADMIN_MODULE_NAME,
            "logo_header_mobile",
            ""
        );
    }

    if ($request->getFile("presentation") && $request->getFile("presentation")["name"] != "") {
        $load_presentation_file = $request->getFile("presentation");
        $new_presentation_file = CFile::SaveFile($load_presentation_file, "iblock");
        Option::set(
            ADMIN_MODULE_NAME,
            "presentation",
            $new_presentation_file
        );
        if ($new_presentation_file) {
            CFile::Delete($presentation_file);
        }
        $presentation_file = $new_presentation_file;
    }
    if ($request->getPost("presentation_del") == "Y") {
        CFile::Delete($presentation_file);
        Option::set(
            ADMIN_MODULE_NAME,
            "presentation",
            ""
        );
    }

    if ($request->getPost('header_phone')) {
        Option::set(
            ADMIN_MODULE_NAME,
            "header_phone",
            $request->getPost('header_phone')
        );
    }
    if ($request->getPost('footer_phone')) {
        Option::set(
            ADMIN_MODULE_NAME,
            "footer_phone",
            $request->getPost('footer_phone')
        );
    }
    if ($request->getPost('footer_email')) {
        Option::set(
            ADMIN_MODULE_NAME,
            "footer_email",
            $request->getPost('footer_email')
        );
    }
    if ($request->getPost('footer_address')) {
        Option::set(
            ADMIN_MODULE_NAME,
            "footer_address",
            $request->getPost('footer_address')
        );
    }
    if ($request->getPost('timetable')) {
        Option::set(
            ADMIN_MODULE_NAME,
            "timetable",
            $request->getPost('timetable')
        );
    }
    if ($request->getPost('personal_data_link')) {
        Option::set(
            ADMIN_MODULE_NAME,
            "personal_data_link",
            $request->getPost('personal_data_link')
        );
    }
    if ($request->getPost('arragment_link')) {
        Option::set(
            ADMIN_MODULE_NAME,
            "arragment_link",
            $request->getPost('arragment_link')
        );
    }
    
}


$tabControl->begin();
?>

<form method="post" action="<?=sprintf('%s?mid=%s&lang=%s', $request->getRequestedPage(), urlencode($mid), LANGUAGE_ID)?>" enctype="multipart/form-data">
    <?php
    echo bitrix_sessid_post();
    $tabControl->beginNextTab();
    ?>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("REFERENCES_MAX_IMAGE_SIZE") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   maxlength="5"
                   name="max_image_size"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "max_image_size", 500));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("LOGO_HEADER") ?>:</label>
        </td>
        <td width="60%">
            <?
            echo CFile::InputFile("logo_header", 20, $logo_header_file);
            if (strlen($logo_header_file)>0):
                ?><br><?echo CFile::ShowImage($logo_header_file, 200, 200, "border=0", "", true);?><hr><?
            endif;
            ?>
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("LOGO_FOOTER") ?>:</label>
        </td>
        <td width="60%">
            <?
            echo CFile::InputFile("logo_footer", 20, $logo_footer_file);
            if (strlen($logo_footer_file)>0):
                ?><br><?echo CFile::ShowImage($logo_footer_file, 200, 200, "border=0", "", true);?><hr><?
            endif;
            ?>
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("LOGO_HEADER_MOBILE") ?>:</label>
        </td>
        <td width="60%">
            <?
            echo CFile::InputFile("logo_header_mobile", 20, $logo_header_mobile_file);
            if (strlen($logo_header_mobile_file)>0):
                ?><br><?echo CFile::ShowImage($logo_header_mobile_file, 200, 200, "border=0", "", true);?><hr><?
            endif;
            ?>
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("HEADER_PHONE") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="header_phone"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "header_phone"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("FOOTER_PHONE") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="footer_phone"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "footer_phone"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("FOOTER_EMAIL") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="footer_email"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "footer_email"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("FOOTER_ADDRESS") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="footer_address"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "footer_address"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("TIMETABLE") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="timetable"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "timetable"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("PERSONAL_DATA_LINK") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="personal_data_link"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "personal_data_link"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("ARRAGMENT_LINK") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="arragment_link"
                   value="<?=HtmlFilter::encode(Option::get(ADMIN_MODULE_NAME, "arragment_link"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("PRESENTATION") ?>:</label>
        </td>
        <td width="60%">
            <?
            echo CFile::InputFile("presentation", 20, $presentation_file);
            if (strlen($presentation_file)>0):
                ?><br><?echo CFile::ShowImage($presentation_file, 200, 200, "border=0", "", true);?><hr><?
            endif;
            ?>
        </td>
    </tr>


    <?php
    $tabControl->buttons();
    ?>
    <input type="submit"
           name="save"
           value="<?=Loc::getMessage("MAIN_SAVE") ?>"
           title="<?=Loc::getMessage("MAIN_OPT_SAVE_TITLE") ?>"
           class="adm-btn-save"
           />
    <input type="submit"
           name="restore"
           title="<?=Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>"
           onclick="return confirm('<?= AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING")) ?>')"
           value="<?=Loc::getMessage("MAIN_RESTORE_DEFAULTS") ?>"
           />
    <?php
    $tabControl->end();
    ?>
</form>
