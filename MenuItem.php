<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Menu;

use PhpTheme\Link\Link;
use PhpTheme\HtmlHelper\HtmlHelper;

class MenuItem extends \PhpTheme\Widget\Widget
{

    const MENU = Menu::class;

    const LINK = Link::class;

    public $active; //is active

    public $icon;

    public $iconTemplate;

    public $tag = 'li';

    public $activeAttributes = [];

    public $url;

    public $label;

    public $activeTag;

    // link

    public $defaultLinkAttributes = [];

    public $linkAttributes = [];

    public $linkTag = 'a';

    public $activeLinkAttributes = [];

    public $activeLinkTag;

    // submenu

    public $submenuOptions = [];

    public $items = [];

    protected $_submenu;

    protected $_link;

    public function getLink()
    {
        if ($this->_link !== null)
        {
            return $this->_link;
        }

        $this->_link = $this->createLink();

        return $this->_link;
    }

    protected function createLink(array $options = [])
    {
        $linkOptions = [
            'url' => $this->url,
            'label' => $this->label,
            'tag' => $this->linkTag
        ];

        if ($this->icon)
        {
            $linkOptions['icon'] = $this->icon;
        }

        if ($this->iconTemplate)
        {
            $linkOptions['iconTemplate'] = $this->iconTemplate;
        }

        $attributes = HtmlHelper::mergeAttributes($this->defaultLinkAttributes, $this->linkAttributes);

        $linkOptions = HtmlHelper::mergeOptions($linkOptions, ['attributes' => $attributes]);

        if ($this->active)
        {
            $linkOptions = HtmlHelper::mergeOptions($linkOptions, ['attributes' => $this->activeLinkAttributes]);

            if ($this->activeLinkTag)
            {
                $linkOptions['tag'] = $this->activeLinkTag;
            }
        }

        $linkOptions = HtmlHelper::mergeOptions($linkOptions, $options);

        $class = static::LINK;

        return new $class($linkOptions);
    }

    protected function createSubmenu(array $options = [])
    {
        $options = HtmlHelper::mergeOptions($this->submenuOptions, $options);

        $class = static::MENU;

        return new $class($options);
    }

    public function getSubmenu()
    {
        if ($this->_submenu !== null)
        {
            return $this->_submenu;
        }

        if ($this->items)
        {
            $this->_submenu = $this->createSubmenu(['items' => $this->items]);
        }

        return $this->_submenu;
    }

    public function getContent()
    {
        $content = '';

        $content .= $this->getLink()->toString();

        $submenu = $this->getSubmenu();

        if ($submenu)
        {
            $content .= $submenu->toString();
        }

        return $content;
    }

    public function toString() : string
    {
        if ($this->active)
        {
            $this->attributes = HtmlHelper::mergeAttributes($this->attributes, $this->activeAttributes);

            if ($this->activeTag)
            {
                $this->tag = $this->activeTag;
            }
        }

        return parent::toString();
    }    

}