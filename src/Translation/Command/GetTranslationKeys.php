<?php namespace Anomaly\TranslatorModule\Translation\Command;

use Anomaly\Streams\Platform\Addon\Addon;
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
     * The addon.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * The locale.
     *
     * @var string
     */
    protected $locale;

    /**
     * Create a new GetTranslationKeys instance.
     *
     * @param Addon  $addon
     * @param string $locale
     */
    public function __construct(Addon $addon, $locale)
    {
        $this->addon  = $addon;
        $this->locale = $locale;
    }

    /**
     * Handle the command.
     *
     * @param Filesystem $files
     * @return array
     */
    public function handle(Filesystem $files)
    {
        $directory = $this->addon->getPath('resources/lang/' . $this->locale);

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
