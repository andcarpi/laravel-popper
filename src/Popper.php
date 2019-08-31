<?php

namespace andcarpi\Popper;

use Illuminate\Support\HtmlString;

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
    ];

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
    }

    /**
     * Set the default config based on the config file.
     */
    protected function setDefaultConfig()
    {
        if (file_exists(config_path('popper.php'))) {
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
        $this->config['theme'] = (in_array($theme, ['dark', 'light', 'light-border', 'google'])) ? $theme : 'dark';

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
        $this->config['placement']['show_duration'] = $show_duration;
        $this->config['placement']['hide_duration'] = $hide_duration;

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

    public function pop(string $text)
    {
        $this->text = $text;
        if (trim($this->text) != '') {
            $tooltip = ' data-tippy="'.$this->text.'"';

            if ($this->config['arrow']['active']) {
                $tooltip .= ' data-tippy-arrow="true"';
                $tooltip .= $this->isDefault('arrow', 'type') ? '' : ' data-tippy-arrowType="'.$this->config['arrow']['type'].'"';
            }
            $tooltip .= $this->isDefault('distance') ? '' : ' data-tippy-distance="'.$this->config['distance'].'"';
            $tooltip .= $this->isDefault('size') ? '' : ' data-tippy-size="'.$this->config['size'].'"';
            $tooltip .= $this->isDefault('theme') ? '' : ' data-tippy-theme="'.$this->config['theme'].'"';

            //PLACEMENT
            if ($this->isDefault('placement', 'position')) {
                $tooltip .= $this->isDefault('placement', 'alignment') ? '' : ' data-tippy-placement="'.$this->config['placement']['position'].'-'.$this->config['placement']['alignment'].'"';
            } else {
                $tooltip .= $this->isDefault('placement', 'alignment') ? ' data-tippy-placement="'.$this->config['placement']['position'].'"' : ' data-tippy-placement="'.$this->config['placement']['position'].'-'.$this->config['placement']['alignment'].'"';
            }

            //TRIGGER
            if (! $this->isDefault('trigger')) {
                $tooltip .= ' data-tippy-trigger="';
                $tooltip .= $this->config['trigger']['mouseenter'] ? 'mouseenter' : '';
                $tooltip .= $this->config['trigger']['focus'] ? ' focus' : '';
                $tooltip .= $this->config['trigger']['click'] ? ' click' : '';
                $tooltip .= '"';
            }

            //DELAY
            if (! $this->isDefault('delay')) {
                $tooltip .= ' data-tippy-delay="';
                if ($this->config['delay']['show'] == $this->config['delay']['hide']) {
                    $tooltip .= $this->config['delay']['show'].'"';
                } else {
                    $tooltip .= '['.$this->config['delay']['show'].','.$this->config['delay']['hide'].']"';
                }
            }
            $this->setDefaultConfig();
            return new HtmlString($tooltip);
        }

        return '';
    }
}
