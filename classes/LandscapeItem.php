<?php

class LandscapeItem {
    public $pos_x;
    public $pos_y;
    public $size_x;
    public $size_y;

    public function __construct(Map &$map) {
        $this->init_coordinates($map);

        $counter = 0;
        while ( $map->check_intersect($this) ) {
            $this->init_coordinates($map);
            $counter += 1;

            if ( $counter > 100 ) {
                throw new Exception("Can't find place for landscape");
            }
        }

        $map->used_area[] = [
            'pos_x' => $this->pos_x,
            'pos_y' => $this->pos_y,
            'size_x' => $this->size_x,
            'size_y' => $this->size_y
        ];
    }

    public function init_coordinates(Map &$map) {
        $this->pos_x = rand(0, $map->size_x);
        $this->pos_y = rand(0, $map->size_y);
        $this->size_x = rand(50, 200);
        $this->size_y = rand(50, 200);
    }
}