<?php

namespace modules\llinkedin\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\HttpException;
use humhub\models\Setting;
use yii\filters\AccessControl;
use humhub\components\Controller;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Profile;
use yii\db\mssql\PDO;
use app\modules\llinkedin\models\LlinkedinLoginpageContent;

class LlinkedinController extends Controller {

    public $enableCsrfValidation = false;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['setup'],
                'rules' => [
                    [
                        'actions' => ['setup'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return Yii::$app->user->isAdmin();
                }
                    ],
                ],
            ],
        ];
    }


    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        require_once('config.php');


        if ($config['Client_ID'] === '' || $config['Client_Secret'] === '') {
            echo 'You need a API Key and Secret Key to test the sample code. Get one from <a href="https://www.linkedin.com/secure/developer">https://www.linkedin.com/secure/developer</a>';
            exit;
        }
        if (isset($_GET['code'])) {
            $url = 'https://www.linkedin.com/uas/oauth2/accessToken';
            $param = 'grant_type=authorization_code&code=' . $_GET['code'] . '&redirect_uri=' . $config['callback_url'] . '&client_id=' . $config['Client_ID'] . '&client_secret=' . $config['Client_Secret'];
            $return = (json_decode($this->post_curl($url, $param), true));
            if (isset($return['error'])) {
                echo 'Some error occured<br><br>' . $return['error_description'] . '<br><br>Please Try again.';
            } else {
                $url = 'https://api.linkedin.com/v1/people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address,maiden-name,current-share,num-connections,specialties,summary,picture-url,formatted-name,phonetic-first-name,phonetic-last-name,formatted-phonetic-name,num-connections-capped,site-standard-profile-request)?format=json&oauth2_access_token=' . $return['access_token'];
                $User = json_decode($this->post_curl($url));
                $id = isset($User->id) ? $User->id : '';
                $firstName = isset($User->firstName) ? $User->firstName : '';
                $lastName = isset($User->lastName) ? $User->lastName : '';
                $emailAddress = isset($User->emailAddress) ? $User->emailAddress : '';
                $headline = isset($User->headline) ? $User->headline : '';
                $pictureUrls = isset($User->pictureUrls->values[0]) ? $User->pictureUrls->values[0] : '';
                $location = isset($User->location->name) ? $User->location->name : '';
                $positionstitle = isset($User->positions->values[0]->title) ? $User->positions->values[0]->title : '';
                $publicProfileUrl = isset($User->publicProfileUrl) ? $User->publicProfileUrl : '';
                $maidenname = isset($User->maidenName) ? $User->maidenName : '';
                $industry = isset($User->industry) ? $User->industry : '';
                $currentShare = isset($User->currentShare->comment) ? $User->currentShare->comment : '';
                $numConnections = isset($User->numConnections) ? $User->numConnections : '';
                $specialties = isset($User->specialties) ? $User->specialties : '';
                $summary = isset($User->summary) ? $User->summary : '';
                $countrycode = isset($User->location->country->code) ? $User->location->country->code : '';
                $country = !empty($countrycode) ? $this->code_to_country($countrycode) : '';
                $positions = isset($User->positions->values[0]->title) ? $User->positions->values[0]->title : '';
                $pictureurl = '';
                $formatedname = isset($User->formattedName) ? $User->formattedName : '';
                $phoneticfirstname = isset($User->phoneticFirstName) ? $User->phoneticFirstName : '';
                $phoneticlastname = isset($User->phoneticLastName) ? $User->phoneticLastName : '';
                $formatedphoneticname = isset($User->formattedPhoneticName) ? $User->formattedPhoneticName : '';
                $numConnectionscapped = isset($User->numConnectionsCapped) ? $User->numConnectionsCapped : '';
                $sitestdprofilerequest = isset($User->siteStandardProfileRequest->url) ? $User->siteStandardProfileRequest->url : '';
                $company_position = isset($User->positions->values[0]->company->name) ? $User->positions->values[0]->company->name : '';
                $api_standard_profile_request = isset($User->apiStandardProfileRequest) ? $User->apiStandardProfileRequest : '';
                $company_position_type = isset($User->positions->values[0]->company->type) ? $User->positions->values[0]->company->type : '';
                $company_position_industry = isset($User->positions->values[0]->company->industry) ? $User->positions->values[0]->company->industry : '';
                $company_position_ticker = isset($User->positions->values[0]->company->ticker) ? $User->positions->values[0]->company->ticker : '';
                $positions_id = isset($User->positions->values[0]->id) ? $User->positions->values[0]->id : '';
                $public_profile_url = isset($User->publicProfileUrl) ? $User->publicProfileUrl : '';
                $monthName = '';
                $year = '';
                if (isset($User->positions->values[0]->startDate->month)) {
                    $monthNum = $User->positions->values[0]->startDate->month;
                    $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                }
                if (isset($User->positions->values[0]->startDate->year)) {
                    $year = $User->positions->values[0]->startDate->year;
                }
                $startdate_position = $monthName . ' ' . $year;
                $monthName = '';
                $year = '';
                if (isset($User->positions->values[0]->endDate->month)) {
                    $monthNum = $User->positions->values[0]->endDate->month;
                    $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                }
                if (isset($User->positions->values[0]->endDate->year)) {
                    $year = $User->positions->values[0]->endDate->year;
                }
                $enddate_position = $monthName . ' ' . $year;
                $is_current = isset($User->positions->values[0]->isCurrent) ? $User->positions->values[0]->isCurrent : '';
                $summary_position = isset($User->positions->values[0]->summary) ? $User->positions->values[0]->summary : '';
                if (isset($User->pictureUrl)) {
                    $pictureurl = $User->pictureUrl;
                    $extract = file_get_contents($pictureurl);
                } else {
                    $extract = '';
                }
                if (!empty($pictureUrls)) {
                    $extract_pictureurls = file_get_contents($pictureUrls);
                } else {
                    $extract_pictureurls = '';
                }
                $baseroot = Yii::$app->basePath . '/../uploads/profile_image/';
                //exit;
                //--------------------------------------------------------------------------------
                if (isset($id) and $id != '') {
                    $muser = \humhub\modules\user\models\User::find()->where(['linkedin_id' => $id])->one();
                    if (isset($muser->id)) {
                        Yii::$app->user->switchIdentity($muser);
                        //return $this->redirect(Yii::$app->user->getIdentity()->getUrl());
                        return $this->goBack();
                    } else {     //-----------------NEW USER ------------------------
                        $m2user = \humhub\modules\user\models\User::find()->where(['email' => $emailAddress])->one();
                        $userModel = new User();
                        $userModel->username = $emailAddress;
                        $userModel->linkedin_id = $id;
                        if (isset($m2user->email) and $m2user->email != '') {
                            $userModel->email = $id . 'myhost.con';
                        } else {
                            $userModel->email = $emailAddress;
                        }
                        $check_settings = Yii::$app->db->createCommand("select * from `setting` where name='extract_linkedin_data' and module_id='llinkedin' and value=1")->execute();
                        if ($check_settings) {

                            $col_names = array();
                            $columns = Yii::$app->db->createCommand("SHOW COLUMNS FROM `profile`")->queryAll();
                            foreach ($columns as $key => $value) {
                                $col_names[] = $value['Field'];
                            }

                            if ($userModel->save(false)) {

                                if ($extract) {
                                    $basepath = $baseroot . $userModel->guid . '.jpg';
                                    file_put_contents($basepath, $extract);
                                }
                                if ($extract_pictureurls) {
                                    $basepath = $baseroot . $userModel->guid . '_original.jpg';
                                    file_put_contents($basepath, $extract);
                                }
                                //escaping special char
                                $summary = str_replace("'", "''", $summary);
                                $maidenname = str_replace("'", "''", $maidenname);
                                $industry = str_replace("'", "''", $industry);
                                $summary_position = str_replace("'", "''", $summary_position);
                                $company_position = str_replace("'", "''", $company_position);
                                $phoneticfirstname = str_replace("'", "''", $phoneticfirstname);
                                $phoneticlastname = str_replace("'", "''", $phoneticlastname);
                                $formatedphoneticname = str_replace("'", "''", $formatedphoneticname);
                                $firstName = str_replace("'", "''", $firstName);
                                $lastName = str_replace("'", "''", $lastName);
                                $currentShare = str_replace("'", "''", $currentShare);
                                $numConnections = str_replace("'", "''", $numConnections);
                                $specialties = str_replace("'", "''", $specialties);
                                $positions = str_replace("'", "''", $positions);
                                $location = str_replace("'", "''", $location);
                                $country = str_replace("'", "''", $country);
                                $formatedname = str_replace("'", "''", $formatedname);
                                $numConnectionscapped = str_replace("'", "''", $numConnectionscapped);
                                $sitestdprofilerequest = str_replace("'", "''", $sitestdprofilerequest);
                                $startdate_position = str_replace("'", "''", $startdate_position);
                                $enddate_position = str_replace("'", "''", $enddate_position);
                                $is_current = str_replace("'", "''", $is_current);
                                $summary = strip_tags(stripslashes($summary));
                                $summary = str_replace('\\', '', $summary);
                                $maidenname = strip_tags(stripslashes($maidenname));
                                $maidenname = str_replace('\\', '', $maidenname);
                                $summary_position = strip_tags(stripslashes($summary_position));
                                $summary_position = str_replace('\\', '', $summary_position);
                                $company_position = strip_tags(stripslashes($company_position));
                                $company_position = str_replace('\\', '', $company_position);
                                $phoneticfirstname = strip_tags(stripslashes($phoneticfirstname));
                                $phoneticfirstname = str_replace('\\', '', $phoneticfirstname);
                                $phoneticlastname = strip_tags(stripslashes($phoneticlastname));
                                $phoneticlastname = str_replace('\\', '', $phoneticlastname);
                                $formatedphoneticname = strip_tags(stripslashes($formatedphoneticname));
                                $formatedphoneticname = str_replace('\\', '', $formatedphoneticname);
                                $firstName = strip_tags(stripslashes($firstName));
                                $firstName = str_replace('\\', '', $firstName);
                                $lastName = strip_tags(stripslashes($lastName));
                                $lastName = str_replace('\\', '', $lastName);
                                $currentShare = strip_tags(stripslashes($currentShare));
                                $currentShare = str_replace('\\', '', $currentShare);
                                $numConnections = strip_tags(stripslashes($numConnections));
                                $currentShare = str_replace('\\', '', $numConnections);
                                $specialties = strip_tags(stripslashes($specialties));
                                $currentShare = str_replace('\\', '', $specialties);
                                $positions = strip_tags(stripslashes($positions));
                                $positions = str_replace('\\', '', $positions);
                                $location = strip_tags(stripslashes($location));
                                $location = str_replace('\\', '', $location);
                                $country = strip_tags(stripslashes($country));
                                $country = str_replace('\\', '', $country);
                                $formatedname = strip_tags(stripslashes($formatedname));
                                $formatedname = str_replace('\\', '', $formatedname);
                                $numConnectionscapped = strip_tags(stripslashes($numConnectionscapped));
                                $numConnectionscapped = str_replace('\\', '', $numConnectionscapped);
                                $sitestdprofilerequest = strip_tags(stripslashes($sitestdprofilerequest));
                                $sitestdprofilerequest = str_replace('\\', '', $sitestdprofilerequest);
                                $startdate_position = strip_tags(stripslashes($startdate_position));
                                $startdate_position = str_replace('\\', '', $startdate_position);
                                $enddate_position = strip_tags(stripslashes($enddate_position));
                                $enddate_position = str_replace('\\', '', $enddate_position);
                                $is_current = strip_tags(stripslashes($is_current));
                                $is_current = str_replace('\\', '', $is_current);
                                $api_standard_profile_request = strip_tags(stripslashes($api_standard_profile_request));
                                $api_standard_profile_request = str_replace('\\', '', $api_standard_profile_request);
                                $company_position_type = strip_tags(stripslashes($company_position_type));
                                $company_position_type = str_replace('\\', '', $company_position_type);
                                $company_position_industry = strip_tags(stripslashes($company_position_industry));
                                $company_position_industry = str_replace('\\', '', $company_position_industry);
                                $company_position_ticker = strip_tags(stripslashes($company_position_ticker));
                                $company_position_ticker = str_replace('\\', '', $company_position_ticker);
                                $positions_id = strip_tags(stripslashes($positions_id));
                                $positions_id = str_replace('\\', '', $positions_id);
                                $public_profile_url = strip_tags(stripslashes($public_profile_url));
                                $public_profile_url = str_replace('\\', '', $public_profile_url);

                                //saving to db
                                $result = \Yii::$app->db->createCommand("INSERT INTO `profile`(user_id, firstname, lastname, email_linkedin, url_linkedin, headline, maiden_name, industry, current_share, num_connections, specialties,summary,positions,location,country,formatted_name,phonetic_first_name,phonetic_last_name,formatted_phonetic_name,num_connections_capped,site_standard_profile_request,company,position_startdate,position_enddate,is_current,position_summary,api_standard_profile,company_position_type,company_position_industry,company_position_ticker,positions_id,public_profile_url,linkedin_id,email_address) VALUES ($userModel->id, '$firstName', '$lastName', '$emailAddress', '$publicProfileUrl','$headline','$maidenname', '$industry', '$currentShare','$numConnections','$specialties','$summary','$positions','$location','$country','$formatedname','$phoneticfirstname','$phoneticlastname','$formatedphoneticname','$numConnectionscapped','$sitestdprofilerequest','$company_position','$startdate_position','$enddate_position','$is_current','$summary_position','$api_standard_profile_request','$company_position_type','$company_position_industry','$company_position_ticker','$positions_id','$public_profile_url','$id','$emailAddress')")->execute();


                                if ($result) {
                                    Yii::$app->user->switchIdentity($userModel);
                                    return $this->redirect(Yii::$app->user->getIdentity()->getUrl());
                                } else {
                
                                }
                            } else {
                                
                            }
                        } else {

                            if ($userModel->save(false)) {
                                $mprofile = new Profile();
                                $mprofile->user_id = $userModel->id;
                                $mprofile->firstname = $firstName;
                                $mprofile->lastname = $lastName;
                                $mprofile->email_linkedin = $emailAddress;
                                $mprofile->url_linkedin = $publicProfileUrl;

                                if ($mprofile->save(false)) {


                                    Yii::$app->user->switchIdentity($userModel);
                                    return $this->redirect(Yii::$app->user->getIdentity()->getUrl());
                                }
                            }
                        }
                    }
                }
                //--------------------------------------------------------------------------------
            }
        } elseif (isset($_GET['error'])) {
            echo 'Some error occured<br><br>' . $_GET['error_description'] . '<br><br>Please Try again.';
            $this->redirect(array('//user/auth/login'));
        } else {
            $Lurl = 'https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=' . $config['Client_ID'] . '&redirect_uri=' . $config['callback_url'] . '&state=98765EeFWf45A53sdfKef4233&scope=r_basicprofile r_emailaddress';
            $this->redirect($Lurl);
        }
    }

    public function post_curl($url, $param = "") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($param != "")
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function actionSetup() {
        $this->subLayout = '@admin/views/layouts/main';
        $langingpage_content = LlinkedinLoginpageContent::find()->one();
        return $this->render('setup',['langingpage_content' => $langingpage_content]);
    }

    public function actionSaves() {
        $url = Yii::$app->request->get('url', '');
        $client_id = Yii::$app->request->get('client_id', '');
        $client_secret = Yii::$app->request->get('client_secret', '');

        $ll = \modules\llinkedin\models\Llinkedin::find()->where(['var' => 'setup'])->one();

        $ll->url = $url;
        $ll->client_id = $client_id;
        $ll->client_secret = $client_secret;
        $ll->save();
    }

    /**
     * Renders current setting in db for extracting data from linkedin
     * @return string
     */
    public function actionExtractData() {
        $show_status = Setting::find()->select(['value'])->where(['module_id' => 'llinkedin', 'name' => 'extract_linkedin_data'])->one();
        echo $show_status->value;
    }

    /**
     * Change setting to extract data from linkedin
     * @return string
     */
    public function actionChangeSetting() {

        if (Yii::$app->request->post('status_val') == 'yes') {
            $status_val = 1;
        } else {
            $status_val = 0;
        }
        Yii::$app->db->createCommand()->update('setting', ['value' => $status_val], ['module_id' => 'llinkedin', 'name' => 'extract_linkedin_data'])->execute();
    }

    public function code_to_country($code) {

        $code = strtoupper($code);

        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands (Malvinas)',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France, French Republic',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands the',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal, Portuguese Republic',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia (Slovak Republic)',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland, Swiss Confederation',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States of America',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );

        if (!$countryList[$code])
            return $code;
        else
            return $countryList[$code];
    }

    public function actionLoginContentSave() {
        $content = Yii::$app->request->post('value');
        $model = LlinkedinLoginpageContent::findOne(1);
        $model->content = $content;
        $model->updated_at = 1;
        $model->save();
    }
    
    public function actionAdminLogin() {

        return $this->render('adminlogin');
    }

}
