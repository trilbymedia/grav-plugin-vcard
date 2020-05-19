<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Plugin\VCard\VCardPerson;

/**
 * Class VCardPlugin
 * @package Grav\Plugin
 */
class VCardPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => [
                ['autoload', 100000], // TODO: Remove when plugin requires Grav >=1.7
                ['onPluginsInitialized', 0]
            ]
        ];
    }

    /**
    * Composer autoload.
    *is
    * @return ClassLoader
    */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        if ($this->grav['uri']->extension() === 'vcf') {
            $this->enable([
                'onTwigInitialized' => [
                    ['onTwigInitialized', 0]
                ],
            ]);

            // Dynamically add custom type
            $this->enableCustomType();
        }
    }

    public function onTwigInitialized()
    {
        $this->grav['twig']->twig()->addFunction(
            new \Twig_SimpleFunction('create_vcard', [$this, 'createVCardFunc'])
        );
    }

    public function createVCardFunc($person = [])
    {
        return new VCardPerson($person);
    }

    protected function enableCustomType()
    {
        // Supported Page types
        $page_types = $this->config->get('system.pages.types');
        if (!in_array('vcf', $page_types)) {
            $page_types[] = 'vcf';
            $this->config->set('system.pages.types', $page_types);
        }

        // Page Media
        $media = $this->config->get('media.types');
        if (!isset($media['vcf'])) {
            $media['vcf'] = ['mime' => 'text/x-vcard', 'type' => 'file'];
            $this->config->set('media.types', $media);
        }
    }
}
