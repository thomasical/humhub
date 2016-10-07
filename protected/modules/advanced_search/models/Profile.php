<?php

namespace app\modules\advanced_search\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $title
 * @property string $gender
 * @property string $street
 * @property string $zip
 * @property string $city
 * @property string $country
 * @property string $state
 * @property integer $birthday_hide_year
 * @property string $birthday
 * @property string $about
 * @property string $phone_private
 * @property string $phone_work
 * @property string $mobile
 * @property string $fax
 * @property string $im_skype
 * @property string $im_msn
 * @property string $im_xmpp
 * @property string $url
 * @property string $url_facebook
 * @property string $url_linkedin
 * @property string $url_xing
 * @property string $url_youtube
 * @property string $url_vimeo
 * @property string $url_flickr
 * @property string $url_myspace
 * @property string $url_googleplus
 * @property string $url_twitter
 * @property string $how_started
 * @property integer $date_hide_year
 * @property string $date
 * @property string $career_role
 * @property string $getting_started
 * @property string $traits_skills_strengths
 * @property string $field_changing
 * @property string $employer_current
 * @property string $additional_information
 * @property string $professional_organizations
 * @property string $where_else
 * @property string $learn_more
 * @property string $other_tasks
 * @property string $best_advice
 * @property string $military_background
 * @property string $military_career
 * @property string $what_else
 * @property string $help_you
 * @property string $email_linkedin
 * @property string $newfield
 * @property string $multi_select
 * @property string $shop_item
 * @property string $new_field
 * @property string $ss
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'birthday_hide_year', 'date_hide_year'], 'integer'],
            [['birthday', 'date'], 'safe'],
            [['about', 'how_started', 'career_role', 'getting_started', 'traits_skills_strengths', 'field_changing', 'additional_information', 'professional_organizations', 'where_else', 'learn_more', 'other_tasks', 'best_advice', 'military_background', 'military_career', 'what_else', 'help_you', 'multi_select', 'shop_item', 'new_field', 'ss'], 'string'],
            [['firstname', 'lastname', 'title', 'gender', 'street', 'zip', 'city', 'country', 'state', 'phone_private', 'phone_work', 'mobile', 'fax', 'im_skype', 'im_msn', 'im_xmpp', 'url', 'url_facebook', 'url_linkedin', 'url_xing', 'url_youtube', 'url_vimeo', 'url_flickr', 'url_myspace', 'url_googleplus', 'url_twitter', 'employer_current', 'newfield'], 'string', 'max' => 255],
            [['email_linkedin'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'title' => 'Title',
            'gender' => 'Gender',
            'street' => 'Street',
            'zip' => 'Zip',
            'city' => 'City',
            'country' => 'Country',
            'state' => 'State',
            'birthday_hide_year' => 'Birthday Hide Year',
            'birthday' => 'Birthday',
            'about' => 'About',
            'phone_private' => 'Phone Private',
            'phone_work' => 'Phone Work',
            'mobile' => 'Mobile',
            'fax' => 'Fax',
            'im_skype' => 'Im Skype',
            'im_msn' => 'Im Msn',
            'im_xmpp' => 'Im Xmpp',
            'url' => 'Url',
            'url_facebook' => 'Url Facebook',
            'url_linkedin' => 'Url Linkedin',
            'url_xing' => 'Url Xing',
            'url_youtube' => 'Url Youtube',
            'url_vimeo' => 'Url Vimeo',
            'url_flickr' => 'Url Flickr',
            'url_myspace' => 'Url Myspace',
            'url_googleplus' => 'Url Googleplus',
            'url_twitter' => 'Url Twitter',
            'how_started' => 'How Started',
            'date_hide_year' => 'Date Hide Year',
            'date' => 'Date',
            'career_role' => 'Career Role',
            'getting_started' => 'Getting Started',
            'traits_skills_strengths' => 'Traits Skills Strengths',
            'field_changing' => 'Field Changing',
            'employer_current' => 'Employer Current',
            'additional_information' => 'Additional Information',
            'professional_organizations' => 'Professional Organizations',
            'where_else' => 'Where Else',
            'learn_more' => 'Learn More',
            'other_tasks' => 'Other Tasks',
            'best_advice' => 'Best Advice',
            'military_background' => 'Military Background',
            'military_career' => 'Military Career',
            'what_else' => 'What Else',
            'help_you' => 'Help You',
            'email_linkedin' => 'Email Linkedin',
            'newfield' => 'Newfield',
            'multi_select' => 'Multi Select',
            'shop_item' => 'Shop Item',
            'new_field' => 'New Field',
            'ss' => 'Ss',
        ];
    }
}
