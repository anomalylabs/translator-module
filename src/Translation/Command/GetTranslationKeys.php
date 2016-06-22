<?php namespace Anomaly\TranslatorModule\Translation\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class GetTranslationKeys
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Translation\Command
 */
class GetTranslationKeys implements SelfHandling
{

    /**
     * The source to translate.
     *
     * @var mixed
     */
    protected $source;

    /**
     * The locale.
     *
     * @var string
     */
    protected $locale;

    /**
     * Create a new GetTranslationKeys instance.
     *
     * @param mixed  $source
     * @param string $locale
     */
    public function __construct($source, $locale)
    {
        $this->source = $source;
        $this->locale = $locale;
    }

    /**
     * Handle the command.
     *
     * @param Filesystem      $files
     * @param AddonCollection $addons
     * @return array
     */
    public function handle(Filesystem $files, AddonCollection $addons)
    {
        $addon = $addons->get($this->source);

        if ($addon) {
            $directory = $addon->getPath('resources/lang/' . $this->locale);
        } else {
            $directory = base_path('vendor/anomaly/streams-platform/resources/lang/' . $this->locale);
        }

        if (!is_dir($directory)) {
            return [];
        }

        $keys = [];

        /* @var SplFileInfo $file */
        foreach ($files->allFiles($directory) as $file) {
            $keys[trim(
                str_replace($directory, '', $file->getRealPath()),
                DIRECTORY_SEPARATOR
            )] = require $file->getRealPath();
        }

        return $keys;
    }
}
