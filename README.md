# VCard Plugin

The **VCard** Plugin is an extension for [Grav CMS](http://github.com/getgrav/grav). Generates dynamic VCards.  Generally used via Twig templates in your theme. 

## Installation

Installing the VCard plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

### GPM Installation (Preferred)

To install the plugin via the [GPM](http://learn.getgrav.org/advanced/grav-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install vcard

This will install the VCard plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/vcard`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `vcard`. You can find these files on [GitHub](https://github.com/trilbymedia/grav-plugin-vcard) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/vcard
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com/trilbymedia/grav-plugin-vcard/blob/master/blueprints.yaml).

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/vcard/vcard.yaml` to `user/config/plugins/vcard.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the Admin Plugin, a file with your configuration named `vcard.yaml` will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage

After installing the plugin you can use it via a Twig template or in your own custom code directly.

> IMPORTANT: You must add the `vcf` type to the list of valid page types in **System Configuration** -> **Pages** section.

In this example, the page expects a parameter of 'name' in order to know which user to display the vcard for.

In a company directory you would then setup a link such as:

```twig
<a href="{{ url('/contact.vcf/name:' ~ user.name|url_encode) }}"><i class="fa fa-address-card-o"></i> VCard</a>
```

An example Twig template is provided as `templates/contact.vcf.twig`:

```twig
{% set name = uri.param('name') %}
{% set team = page.header.team %}
{% for contact in team if contact.name == name %}
    {% set contact_image = contact.image %}
    {% set contact_photo = page.media[contact_image].url ?: page.media['default.png'].url %}
    {% set details = {name: contact.name, email: contact.email, title: contact.designation ~ ' ' ~ contact.department, office_phone: contact.phone, photo: url(contact_photo, true)} %}
    {% set vcard = create_vcard(details) %}
    {{- vcard.generate -}}
{% endfor %}
```

You should copy this file and modify it as you see fit.

> NOTE: See the `classes/VCardPerson.php` for current list of supported features

## Credits

This plugin is built on top of https://github.com/jeroendesloovere/vcard VCard library.

## To Do

- [ ] Add more VCard properties to the `VCardPerson` class
- [ ] Investigate issue with `vcf` page type not being auto-added
- [ ] Make a generic example that works out-of-the-box


