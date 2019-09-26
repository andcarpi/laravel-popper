<?php

namespace andcarpi\Popper;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\File;

class Popper
{
    /**
     * Default config values.
     *
     * @var array
     */
    public $defaultconfig = [
        'arrow' => [
            'active' => false,
            'type' => 'sharp',
        ],
        'placement' => [
            'position' => 'top',
            'alignment' => 'center',
        ],
        'theme' => 'dark',
        'trigger' => [
            'mouseenter' => true,
            'focus' => true,
            'click' => false,
        ],
        'size' => 'regular',
        'distance' => 10,
        'animation' => [
            'mode' => 'shift-away',
            'show_duration' => 275,
            'hide_duration' => 250,
        ],
        'delay' => [
            'show' => 0,
            'hide' => 20,
        ],
        'interactive' => false,
    ];

    /*
     * Themes used
     */
    private $themes = [];

    private $themePath;

    /**
     * Configuration options.
     *
     * @var array
     */
    public $config;

    protected $text;

    public function __construct()
    {
        $this->text = '';
        $this->setDefaultConfig();
        $this->themePath = File::isDirectory(config('popper.themes-path')) ?
            config('popper.themes-path') :
            base_path().'/vendor/andcarpi/laravel-popper/resources/css/';
    }

    /**
     * Set the default config based on the config file.
     */
    protected function setDefaultConfig()
    {
        if (File::exists(config_path('popper.php'))) {
            $this->config = config('popper.defaultConfig');
        } else {
            $this->config = $this->defaultconfig;
        }
    }

    /**
     * Checks if config is default.
     * @param string $option1
     * @param string $option2
     * @return bool
     */
    protected function isDefault(string $option1, string $option2 = null)
    {
        if ($option2) {
            return $this->config[$option1][$option2] == $this->defaultconfig[$option1][$option2];
        }

        return $this->config[$option1] == $this->defaultconfig[$option1];
    }

    /**
     * Defines the Tooltip Text.
     * @param string $text
     */
    public function text(string $text)
    {
        $this->text = $text;
    }

    /**
     * Enable arrow on the tooltip pointing to the element.
     *
     * @param string $style
     * @return Popper
     */
    public function arrow($style = 'sharp')
    {
        $this->config['arrow']['active'] = true;
        $this->config['arrow']['type'] = (in_array($style, ['sharp', 'round'])) ? $style : 'sharp';

        return $this;
    }

    /**
     * Modify the default Show and Hide timing.
     *
     * @param int $show
     * @param int $hide
     * @return Popper
     */
    public function delay(int $show = 0, int $hide = 20)
    {
        $this->config['delay']['show'] = $show;
        $this->config['delay']['hide'] = $hide;

        return $this;
    }

    /**
     * Modify the default tooltip distance.
     *
     * @param int $distance
     * @return Popper
     */
    public function distance(int $distance = 10)
    {
        $this->config['distance'] = $distance;

        return $this;
    }

    /**
     * Modify the default tooltip size.
     *
     * @param string $size
     * @return Popper
     */
    public function size(string $size = 'regular')
    {
        $this->config['size'] = (in_array($size, ['small', 'regular', 'large'])) ? $size : 'regular';

        return $this;
    }

    /**
     * Modify the default tooltip theme.
     *
     * @param string $theme
     * @return Popper
     */
    public function theme(string $theme = 'dark')
    {
        $this->config['theme'] = (in_array($theme, ['dark', 'light', 'light-border', 'google', 'translucent', 'danger', 'warning', 'info', 'success'])) ? $theme : 'dark';

        return $this;
    }

    /**
     * Modify the default tooltip placement.
     *
     * @param string $position
     * @param string $alignment
     * @return Popper
     */
    public function placement(string $position = 'top', $alignment = 'center')
    {
        $this->position($position);
        $this->alignment($alignment);

        return $this;
    }

    /**
     * Modify the default tooltip position.
     *
     * @param string $position
     * @return Popper
     */
    public function position(string $position = 'top')
    {
        $this->config['placement']['position'] = (in_array($position, ['top', 'right', 'left', 'bottom'])) ? $position : 'top';

        return $this;
    }

    /**
     * Modify the default tooltip alignment.
     *
     * @param string $alignment
     * @return Popper
     */
    public function alignment(string $alignment = 'center')
    {
        $this->config['placement']['alignment'] = (in_array($alignment, ['center', 'start', 'end'])) ? $alignment : 'center';

        return $this;
    }

    /**
     * Modify the default tooltip animation.
     *
     * @param string $mode
     * @param int $show_duration
     * @param int $hide_duration
     * @return Popper
     */
    public function animate(string $mode = 'shift-away', int $show_duration = 275, int $hide_duration = 250)
    {
        $this->config['animation']['mode'] = (in_array($mode, ['shift-away', 'shift-toward', 'scale', 'fade'])) ? $mode : 'shift-away';
        $this->config['animation']['show_duration'] = $show_duration;
        $this->config['animation']['hide_duration'] = $hide_duration;

        return $this;
    }

    /**
     * Modify the tooltip triggers.
     *
     * @param bool $mouseenter
     * @param bool $focus
     * @param bool $click
     * @return Popper
     */
    public function trigger(bool $mouseenter = true, bool $focus = true, bool $click = false)
    {
        if ($mouseenter or $focus or $click) {
            $this->config['trigger']['mouseenter'] = $mouseenter;
            $this->config['trigger']['focus'] = $focus;
            $this->config['trigger']['click'] = $click;
        }

        return $this;
    }

    /**
     * Modify the tooltip triggers.
     *
     * @param bool $mouseenter
     * @param bool $focus
     * @param bool $click
     * @return Popper
     */
    public function interactive()
    {
        $this->config['interactive'] = true;
        return $this;
    }

    /*
     * Return true if any Popper used a theme
     */
    public function hasThemes()
    {
        return count($this->themes) > 0;
    }

    /*
     * Return css injection for the used themes
     */
    public function injectThemes()
    {
        if ($this->hasThemes()) {
            $scripts = '<script type="text/javascript">';
            foreach ($this->themes as $theme) {
                if (file_exists($this->themePath.$theme.'.css')) {
                    $themecss = trim(File::get($this->themePath.$theme.'.css'));
                    $scripts .= 'injectCSS("'.$themecss.'"); ';
                }
            }
            $scripts .= '</script>';
            return new HtmlString($scripts);
        }
    }

    private function generateOptions()
    {
        $options = '';

        //ARROW
        if ($this->config['arrow']['active']) {
            $options .= ' data-tippy-arrow="true"';
            $options .= $this->isDefault('arrow', 'type') ? '' : ' data-tippy-arrowType="'.$this->config['arrow']['type'].'"';
        }

        //DISTANCE
        $options .= $this->isDefault('distance') ? '' : ' data-tippy-distance="'.$this->config['distance'].'"';

        //SIZE
        $options .= $this->isDefault('size') ? '' : ' data-tippy-size="'.$this->config['size'].'"';

        //THEME
        if (! $this->isDefault('theme')) {
            $options .= ' data-tippy-theme="'.$this->config['theme'].'"';
            if (! in_array($this->config['theme'], $this->themes)) {
                $this->themes[] = $this->config['theme'];
            }
        }

        //PLACEMENT
        if ($this->isDefault('placement', 'position')) {
            $options .= $this->isDefault('placement', 'alignment') ? '' : ' data-tippy-placement="'.$this->config['placement']['position'].'-'.$this->config['placement']['alignment'].'"';
        } else {
            $options .= $this->isDefault('placement', 'alignment') ? ' data-tippy-placement="'.$this->config['placement']['position'].'"' : ' data-tippy-placement="'.$this->config['placement']['position'].'-'.$this->config['placement']['alignment'].'"';
        }

        //TRIGGER
        if (! $this->isDefault('trigger')) {
            $options .= ' data-tippy-trigger="';
            $options .= $this->config['trigger']['mouseenter'] ? 'mouseenter' : '';
            $options .= $this->config['trigger']['focus'] ? ' focus' : '';
            $options .= $this->config['trigger']['click'] ? ' click' : '';
            $options .= '"';
        }

        //DELAY
        if (! $this->isDefault('delay')) {
            $options .= ' data-tippy-delay="';
            if ($this->config['delay']['show'] == $this->config['delay']['hide']) {
                $options .= $this->config['delay']['show'].'"';
            } else {
                $options .= '['.$this->config['delay']['show'].','.$this->config['delay']['hide'].']"';
            }
        }

        //ANIMATION MODE
        if (! $this->isDefault('animation', 'mode')) {
            $options .= ' data-tippy-animation="'.$this->config['animation']['mode'].'"';
        }
        if (! $this->isDefault('animation', 'show_duration') or ! $this->isDefault('animation', 'hide_duration')) {
            $options .= ' data-tippy-duration="['.$this->config['animation']['show_duration'].','.$this->config['animation']['hide_duration'].']"';
        }

        //INTERACTIVITY
        if (! $this->isDefault('interactive')) {
            $options .= ' data-tippy-interactive="true"';
        }

        return $options;
    }

    public function pop(string $text)
    {
        $this->text = $text;
        if (trim($this->text) != '') {
            $tooltip = ' data-tippy="'.$this->text.'"';

            $tooltip .= $this->generateOptions();

            $this->setDefaultConfig();

            return new HtmlString($tooltip);
        }

        return '';
    }

    public function danger(string $text)
    {
        return $this->theme('danger')->pop($text);
    }

    public function warning(string $text)
    {
        return $this->theme('warning')->pop($text);
    }

    public function info(string $text)
    {
        return $this->theme('info')->pop($text);
    }

    public function success(string $text)
    {
        return $this->theme('success')->pop($text);
    }
}
