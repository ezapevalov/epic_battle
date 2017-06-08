<?php

class Base {
    public $pos_x;
    public $pos_y;
    public $size_x;
    public $size_y;

    public function __construct(Map &$map, $type) {
        $this->size_x = 100;
        $this->size_y = 100;

        if ( $type == 'blue' ) {
            $this->pos_x = 10;
            $this->pos_y = 10;
        } else if ( $type == 'red' ) {
            $this->pos_x = $map->size_x - 110;
            $this->pos_y = $map->size_y - 110;
        } else {
            throw new Exception("Unknown Base-type");
        }
    }
}