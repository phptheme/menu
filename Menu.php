<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Menu;

use PhpTheme\HtmlHelper\HtmlHelper;

class Menu extends \PhpTheme\Tag\Tag
{

    const MENU_ITEM = MenuItem::class;

    public $tag = 'ul';

    public $items = [];

    public $itemOptions = [];

    public $renderEmpty = false;

    protected $_items;

    protected function createItem($options = [])
    {
        if ($this->itemIsActive($options))
        {
            $options['active'] = true;
        }

        $options = HtmlHelper::mergeOptions($this->itemOptions, $options);

        $class = static::MENU_ITEM;

        return new $class($options);
    }

    protected function itemIsActive($item)
    {
        if (array_key_exists('active', $item))
        {
            return $item['active'];
        }

        if (array_key_exists('items', $item))
        {
            foreach($item['items'] as $k => $v)
            {
                if ($this->itemIsActive($v))
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function getItems()
    {
        if ($this->_items !== null)
        {
            return $this->_items;
        }

        $this->_items = [];

        foreach($this->items as $key => $options)
        {
            $this->_items[$key] = $this->createItem($options);
        }

        return $this->_items;
    }

    public function getContent()
    {
        $items = $this->getItems();

        $content = '';

        foreach($items as $item)
        {
            $content .= $item->toString();
        }

        return $content;
    }

}