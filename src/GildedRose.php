<?php

namespace Runroom\GildedRose;

class GildedRose {

    private array $items;

    function __construct($items) 
    {
        $this->items = $items;
    }

    function update_quality() 
    {
        foreach ($this->items as $item):
            if ($item->name != 'Aged Brie' && $item->name != 'Backstage passes to a TAFKAL80ETC concert'):
                if ($item->quality > 0 && $item->name != 'Sulfuras, Hand of Ragnaros'):
                    $item->quality = $item->quality - 1;
                endif;
            else: 
                if ($item->quality < 50):
                    $item->quality = $item->quality + 1;
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert'):
                        $item->sell_in < 11 ?  $item->quality = $item->quality + 1 : $item->quality;
                        $item->sell_in < 6 ?  $item->quality = $item->quality + 1 : $item->quality;
                    endif;
                endif;
            endif;

            $item->sell_in = $item->name != 'Sulfuras, Hand of Ragnaros' ?  $item->sell_in - 1 : $item->sell_in;

            if ($item->sell_in < 0):
                if ($item->name != 'Aged Brie'):
                    if ($item->name != 'Backstage passes to a TAFKAL80ETC concert'):
                        if ($item->quality > 0):
                            $item->name != 'Sulfuras, Hand of Ragnaros' ? $item->quality = $item->quality - 1 : $item->quality;
                        endif;
                    else:
                        $item->quality = $item->quality - $item->quality;
                    endif;
                else:
                    $item->quality = ($item->quality < 50) ? $item->quality + 1 : $item->quality;
                endif;
            endif;
        endforeach;
    }
}