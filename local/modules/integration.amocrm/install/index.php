<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
// use Bitrix\Main\Config\Option;
// use Bitrix\Main\EventManager;
// use Bitrix\Main\Application;
// use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class integration_amocrm extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();

        include_once(__DIR__ . "/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_ID = "integration.amocrm";
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->MODULE_NAME = Loc::getMessage("MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("MODULE_DESCRIPTION");
        $this->PARTNER_NAME = Loc::getMessage("MODULE_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("MODULE_PARTNER_URI");
    }

    function DoInstall()
    {
        ModuleManager::RegisterModule($this->MODULE_ID);
    }

    function DoUninstall()
    {
        ModuleManager::UnRegisterModule($this->MODULE_ID);
    }
}
