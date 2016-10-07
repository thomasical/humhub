Llinkedin HumHub Module
===========================

The Llinkedin humhub Module allows the administrator to authenticate the users with their linkedin profile. Admin can change the content of the login page through the settings option. Authenticating with linked in account, admin gets all data from the user’s linked in account and saves the content in humhub profile under the category career information. Admin has a ON/OFF button to enable and disable the  feature to Extract information from LinkedIn.
Llinkedin module has two parts.

	1. Llinkedin Module
	2. LI Theme.

## Installation steps

	- Download Module
	- Put it into protected/modules/
	- Enable module under Admin -> Modules
	- Enable pretty Url
	- Install Extension redactor for Yii2 Framework.

	Redactor installation steps:

	o The preferred way to install this extension is through composer.
	o Either run
		 composer.phar require --prefer-dist yiidoc/yii2-redactor"*"
	  or
		 "yiidoc/yii2-redactor": "*"
	  to the require section of your composer.json.

	- Activate LI_Theme

Setting Client id and Client Secret
===============================

	1. Log in at https://www.linkedin.com/developer/apps  using your  Linkedin's «login» and «password».
	2. Press  “Create application”
	3. Fill out all  fields and press  ”Submit”
	4. Default Application Permissions — select all checkboxes
	5. In  Authorized Redirect URLs enter: http://<yourdomain>/index.php/llinkedin/llinkedin    then press Add
	6. In Default "Accept" Redirect URL and Default "Cancel" Redirect URL enter http://<yourdomain>/index.php/llinkedin/llinkedin then press Update
	7. Save fields definition Client ID and Client Secret
	8. Copy and paste the client ID and Client Secret to linkedin setting (from administration menu select “sign in with linked in”).
	9. Copy and paste the ‘Your Callback URL’ to ‘Callback URL’
	10.Then click save button



Admin login secret url
===============================

		<your domain>/index.php/llinkedin/llinkedin/admin-login


	example:     http://abc.com/index.php/llinkedin/llinkedin/admin-login

