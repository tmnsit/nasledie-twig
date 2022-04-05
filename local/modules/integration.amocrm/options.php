<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\HtmlFilter;
use Bitrix\Report\VisualConstructor\Fields\Html;

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



if ((!empty($save) || !empty($restore)) && $request->isPost() && check_bitrix_sessid()) {
    if (!empty($restore)) {
        Option::delete("integration.amocrm");
        CAdminMessage::showMessage(array(
            "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_RESTORED"),
            "TYPE" => "OK",
        ));
    } elseif ($request->isPost()) {
        CAdminMessage::showMessage(array(
            "MESSAGE" => Loc::getMessage("REFERENCES_OPTIONS_SAVED"),
            "TYPE" => "OK",
        ));
    }  else {
        CAdminMessage::showMessage(Loc::getMessage("REFERENCES_INVALID_VALUE"));
    }
    
    if ($request->getPost('UID')) {
        Option::set(
            "integration.amocrm",
            "UID",
            $request->getPost('UID')
        );
    }
    if ($request->getPost('SECRET_KEY')) {
        Option::set(
            "integration.amocrm",
            "SECRET_KEY",
            $request->getPost('SECRET_KEY')
        );
    }
    if ($request->getPost('REDIRECT_URL')) {
        Option::set(
            "integration.amocrm",
            "REDIRECT_URL",
            $request->getPost('REDIRECT_URL')
        );
    }
    if ($request->getPost('SUBDOMEN')) {
        Option::set(
            "integration.amocrm",
            "SUBDOMEN",
            $request->getPost('SUBDOMEN')
        );
    }
    if ($request->getPost('ACCESS_TOKEN')) {
        Option::set(
            "integration.amocrm",
            "ACCESS_TOKEN",
            $request->getPost('ACCESS_TOKEN')
        );
    }
    if ($request->getPost('REFRESH_TOKEN')) {
        Option::set(
            "integration.amocrm",
            "REFRESH_TOKEN",
            $request->getPost('REFRESH_TOKEN')
        );
    }
    if ($request->getPost('EXPIRES')) {
        Option::set(
            "integration.amocrm",
            "EXPIRES",
            $request->getPost('EXPIRES')
        );
    }
    if ($request->getPost('ID_ADVERTISING_SOURCE')) {
        Option::set(
            "integration.amocrm",
            "ID_ADVERTISING_SOURCE",
            $request->getPost('ID_ADVERTISING_SOURCE')
        );
    }
    if ($request->getPost('ENUM_ID_ADVERTISING_SOURCE')) {
        Option::set(
            "integration.amocrm",
            "ENUM_ID_ADVERTISING_SOURCE",
            $request->getPost('ENUM_ID_ADVERTISING_SOURCE')
        );
    }
    if ($request->getPost('ID_PIPELINE')) {
        Option::set(
            "integration.amocrm",
            "ID_PIPELINE",
            $request->getPost('ID_PIPELINE')
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
            <label for="max_image_size"><?=Loc::getMessage("UID") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="UID"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "UID"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for=""><?=Loc::getMessage("SECRET_KEY")?>:</label>
        </td>
        <td>
            <input type="text"
                    size = "50"
                    name = "SECRET_KEY"
                    value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "SECRET_KEY"));?>"
                    />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("REDIRECT_URL") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="REDIRECT_URL"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "REDIRECT_URL"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("SUBDOMEN") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="SUBDOMEN"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "SUBDOMEN"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("ACCESS_TOKEN") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="ACCESS_TOKEN"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "ACCESS_TOKEN"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("REFRESH_TOKEN") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="REFRESH_TOKEN"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "REFRESH_TOKEN"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("EXPIRES") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="EXPIRES"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "EXPIRES"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("ID_ADVERTISING_SOURCE") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="ID_ADVERTISING_SOURCE"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "ID_ADVERTISING_SOURCE"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("ENUM_ID_ADVERTISING_SOURCE") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="ENUM_ID_ADVERTISING_SOURCE"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "ENUM_ID_ADVERTISING_SOURCE"));?>"
                   />
        </td>
    </tr>
    <tr>
        <td width="40%">
            <label for="max_image_size"><?=Loc::getMessage("ID_PIPELINE") ?>:</label>
        </td>
        <td width="60%">
            <input type="text"
                   size="50"
                   name="ID_PIPELINE"
                   value="<?=HtmlFilter::encode(Option::get("integration.amocrm", "ID_PIPELINE"));?>"
                   />
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
