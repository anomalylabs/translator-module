<?php namespace Anomaly\TranslatorModule\Addon\Table;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\TranslatorModule\Translation\Command\GetTranslationKeys;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Translation\Translator;

/**
 * Class AddonTableColumns
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Addon\Table
 */
class AddonTableColumns
{

    use DispatchesJobs;

    /**
     * Handle the command.
     *
     * @param AddonTableBuilder $builder
     */
    public function handle(AddonTableBuilder $builder, Translator $translator, Repository $config)
    {
        $builder->setColumns(
            [
                [
                    'heading' => 'module::field.addon.name',
                    'wrapper' => '<strong>{value.title}</strong><br><small class="text-muted">{value.description}</small>',
                    'value'   => [
                        'title'       => 'entry.title',
                        'description' => 'entry.description',
                    ],
                ],
                [
                    'heading' => 'Completion',
                    'value'   => function (Addon $entry) use ($config, $translator) {

                        $en = count(
                            array_flatten($this->dispatch(new GetTranslationKeys($entry->getNamespace(), 'en')))
                        );

                        $locales = [];

                        foreach ($config->get('streams::locales.enabled') as $locale) {

                            if ($locale == 'en') {
                                continue;
                            }

                            $locales[$locale] = count(
                                array_flatten($this->dispatch(new GetTranslationKeys($entry->getNamespace(), $locale)))
                            );
                        }

                        return implode(
                            ' ',
                            array_map(
                                function ($locale) use ($locales, $en) {

                                    $count   = $locales[$locale];
                                    $percent = $count / $en;

                                    if ($percent > 1) {
                                        $class = 'default';
                                    } elseif ($percent == 0) {
                                        $class = 'danger';
                                    } elseif ($percent == 1) {
                                        $class = 'success';
                                    } elseif ($percent < 0.70) {
                                        $class = 'warning';
                                    } else {
                                        $class = 'info';
                                    }

                                    return '<span class="tag tag-' . $class . '"> ' . $locale . ' ' . $count . '/' . $en . '</span>';
                                },
                                array_keys($locales)
                            )
                        );
                    },

                ],
            ]
        );
    }
}
