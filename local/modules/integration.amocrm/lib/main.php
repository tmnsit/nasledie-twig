<?

namespace Integration\Amocrm;

use Bitrix\Main\Config\Option;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\Unsorted\FormUnsortedModel;
use AmoCRM\Collections\Leads\Unsorted\FormsUnsortedCollection;
use AmoCRM\Models\Unsorted\FormsMetadata;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\TagModel;
use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessToken;
use AmoCRM\OAuth\AmoCRMOAuth;

class Main
{
    private $clientID;
    private $clientSecret;
    private $redirectUri;
    private $subdomain;
    private $apiClient;

    public function __construct()
    {
        $this->clientID = Option::get("integration.amocrm", "UID");
        $this->clientSecret = Option::get("integration.amocrm", "SECRET_KEY");
        $this->redirectUri = Option::get("integration.amocrm", "REDIRECT_URL");
        $this->subdomain = Option::get("integration.amocrm", "SUBDOMEN");

        // if(isset($_GET["test123"])){
        //     $this->access_token = new AccessToken([
        //         "access_token" => Option::get("integration.amocrm", "ACCESS_TOKEN"),
        //         "refresh_token" => Option::get("integration.amocrm", "REFRESH_TOKEN"),
        //         "expires" => Option::get("integration.amocrm", "EXPIRES"),
        //         "baseDomain" => $this->subdomain
        //     ]);
        // }
        
        $this->apiClient = new AmoCRMApiClient($this->clientID, $this->clientSecret, $this->redirectUri);

        $access_token = $this->getToken();

        if(!$access_token->hasExpired()){
            $access_token = $this->saveToken($access_token);
        }else{
            $access_token = $this->refreshToken($access_token);
        }

        $this->apiClient->setAccessToken($access_token)
                ->setAccountBaseDomain($access_token->getValues()['baseDomain']);
    }

    private function refreshToken($access_token){
        
        $apiOAuth = new \AmoCRM\OAuth\AmoCRMOAuth($this->clientID, $this->clientSecret, $this->redirectUri);
        $access_token_by_refresh = $apiOAuth->getAccessTokenByRefreshToken($access_token);
        $this->saveToken($access_token_by_refresh);
        return $access_token_by_refresh;
    }

    private function getToken(){
        $token = Option::get("integration.amocrm", "ACCESS_TOKEN");
        $tokenRefresh = Option::get("integration.amocrm", "REFRESH_TOKEN");
        $expires = Option::get("integration.amocrm", "EXPIRES");
        $domain = $this->subdomain;

        if (
            isset($token)
            && isset($tokenRefresh)
            && isset($expires)
            && isset($domain)
        ) {
            return new AccessToken([
                'access_token' => $token,
                'refresh_token' => $tokenRefresh,
                'expires' => $expires,
                'baseDomain' => $domain,
            ]);
        } else {
            logFile("Отсутствует одно из полей", "getToken");
            return false;
        }
    }

    private function saveToken($accessToken){
        Option::set("integration.amocrm", "ACCESS_TOKEN", $accessToken->getToken());
        Option::set("integration.amocrm", "REFRESH_TOKEN", $accessToken->getRefreshToken());
        Option::set("integration.amocrm", "EXPIRES", $accessToken->getExpires());
        return $accessToken;
    }

    public function addNewApplication($name, $phone, $email, $formCode, $formName)
    {
        ////добавление нового контакта
        $contact = new ContactModel();
        $contact->setName($name);
        $customFields = new CustomFieldsValuesCollection();
        $phoneField = (new MultitextCustomFieldValuesModel())->setFieldCode('PHONE');
        $phoneField->setValues(
            (new MultitextCustomFieldValueCollection())
                ->add(
                    (new MultitextCustomFieldValueModel())
                        ->setEnum("WORK")
                        ->setValue($phone)
                )
        );
        $customFields->add($phoneField);
        $mailField = (new MultitextCustomFieldValuesModel())->setFieldCode('EMAIL');
        $mailField->setValues(
            (new MultitextCustomFieldValueCollection())
                ->add(
                    (new MultitextCustomFieldValueModel())
                        ->setEnum("WORK")
                        ->setValue($email)
                )
        );
        $customFields->add($mailField);
        $contact->setCustomFieldsValues($customFields);
        try{
            $contactModel = $this->apiClient->contacts()->addOne($contact);
        }catch(AmoCRMApiException $e){
            logFile($e, "exceptionContact");
        }
        
        if($contactModel){
            $contactRes = $contactModel->toArray();
            $contactName = $contactRes["name"];
            $contactId = $contactRes["id"];
    
            //добавление сделки в 1 воронку со статусом "неразобранные"
            $formsUnsortedCollection = new FormsUnsortedCollection();
            $formUnsorted = new FormUnsortedModel();
            $formMetadata = new FormsMetadata();
            $formMetadata
                ->setFormId($formCode) //брать из id формы
                ->setFormName($formName) //брать из названия формы
                ->setFormPage('http://nasledie.vprioritete.net/'); //название сайта
            $unsortedLead = new LeadModel();
            $unsortedLead
                ->setName($contactName) //брать из вышедобавленного контакта $contactName
                ->setTags(
                    (new TagsCollection())
                        ->add(
                            (new TagModel())
                                ->setName($formName) //брать из названия формы
                        )
                )
                ->setCustomFieldsValues(
                    (new CustomFieldsValuesCollection())
                        ->add(
                            (new SelectCustomFieldValuesModel())
                                ->setFieldId(Option::get("integration.amocrm", "ID_ADVERTISING_SOURCE"))
                                ->setValues(
                                    (new SelectCustomFieldValueCollection())
                                        ->add(
                                            (new SelectCustomFieldValueModel())
                                                ->setEnumId(Option::get("integration.amocrm", "ENUM_ID_ADVERTISING_SOURCE"))
                                        )
                                )
                        )
                );
    
            $formUnsorted
                ->setSourceName('test source')
                ->setSourceUid($this->clientID)
                ->setMetadata($formMetadata)
                ->setLead($unsortedLead)
                ->setContacts(
                    (new ContactsCollection())
                        ->add(
                            (new ContactModel())
                                ->setId($contactId) //брать из вышедобавленного контакта $contactId
                        )
                )
                ->setPipelineId(Option::get("integration.amocrm", "ID_PIPELINE"));
    
            $formsUnsortedCollection->add($formUnsorted);
            try {
                $formsUnsortedCollection = $this->apiClient->unsorted()->add($formsUnsortedCollection);
            } catch (AmoCRMApiException $e) {
                logFile($e, "exceptionUnsorted");
            }
        }
    }
}
