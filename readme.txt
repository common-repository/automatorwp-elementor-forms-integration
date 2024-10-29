=== AutomatorWP - Elementor integration ===
Contributors: automatorwp, rubengc, eneribs
Tags: contact, form, forms, automatorwp, submission
Requires at least: 4.4
Tested up to: 5.9
Stable tag: 1.0.6
License: GNU AGPLv3
License URI: http://www.gnu.org/licenses/agpl-3.0.html

Connect AutomatorWP with Elementor

== Description ==

> **Important:** Now all free integrations are included in [AutomatorWP](https://wordpress.org/plugins/automatorwp/ "AutomatorWP") so you no longer need to install them one by one!
>
> We will continue working to improve AutomatorWP and make it easier, faster and more accessible to everyone.

[Elementor](https://wordpress.org/plugins/elementor/ "Elementor") is a website builder that delivers high-end page designs and advanced capabilities, never before seen on WordPress.

[Elementor Forms](https://elementor.com/widgets/form-widget/) is a flexible drag and drop form builder with full design control included on [Elementor Pro](https://elementor.com/).

This plugin automatically connects [AutomatorWP](https://wordpress.org/plugins/automatorwp/ "AutomatorWP") with Elementor adding new triggers that you can use to connect with other plugins and automate workflows letting you save time and get focused on your most important work.

= Triggers =

* User submits any/specific form.

= Anonymous Triggers =

* Guest submits any/specific form.

= Tags =

* Field value tag to use any form field submitted value on actions.

= Pro version =

[Pro version](https://automatorwp.com/add-ons/elementor-forms/ "AutomatorWP - Elementor Forms") available that let's you expand the integration between AutomatorWP and Elementor Forms bringing you more ways to automatize your website forms.

= What is AutomatorWP? =

AutomatorWP is an automator plugin that lets you connect your WordPress plugins together and add automation to unlimited workflows.

You can automate anything including sales, marketing, administrative tasks, learning and any other kind of processes you want letting you save time and get focused on your most important work.

= More integrations =

WordPress.org is home to some amazing integrations for AutomatorWP, including:

* [WooCommerce](https://wordpress.org/plugins/automatorwp-woocommerce-integration/)
* [LearnDash](https://wordpress.org/plugins/automatorwp-learndash-integration/)
* [BuddyBoss](https://wordpress.org/plugins/automatorwp-buddyboss-integration/)
* [WP Fusion](https://wordpress.org/plugins/automatorwp-wp-fusion-integration/)
* [MemberPress](https://wordpress.org/plugins/automatorwp-memberpress-integration/)

== Installation ==

= From WordPress backend =

1. Navigate to Plugins -> Add new.
2. Click the button "Upload Plugin" next to "Add plugins" title.
3. Upload the downloaded zip file and activate it.

= Direct upload =

1. Upload the downloaded zip file into your `wp-content/plugins/` folder.
2. Unzip the uploaded zip file.
3. Navigate to Plugins menu on your WordPress admin area.
4. Activate this plugin.

== Frequently Asked Questions ==

= How to handle values of fields with multiples inputs? =

Here is a quick explanation about how to meet the fields handled in a submission:

1) Create a test automation with the trigger "User submits any/specific form".
2) Save and activate the automation.
3) Submit the form to force AutomatorWP handle it.
4) Go to AutomatorWP > Logs > Check the trigger entry for the "User submits any/specific form".
5) On this entry, you will find the section "Fields Submitted" on the "Log Data" box.
6) Here you are able to see all the fields and sub-fields handled.
7) Copy the field or sub-field identifier to use it on the AutomatorWP "form_field" tag to use the field value on the AutomatorWP actions.

== Screenshots ==

== Changelog ==

= 1.0.6 =

* **Improvements**
* Prevent use of undefined constant

= 1.0.5 =

* **Improvements**
* Renamed "Elementor Forms" to "Elementor".

= 1.0.4 =

* **Bug Fixes**
* Fixed typo on main file name.

= 1.0.3 =

* **Improvements**
* Improved fields value handling for fields with multiples options.

= 1.0.2 =

* **New Features**
* Added support for nested fields (requires AutomatorWP 1.4.4).

= 1.0.1 =

* **New Features**
* Added support to anonymous automations.
* New anonymous trigger: Guest submits any/specific form.

= 1.0.0 =

* Initial release.
