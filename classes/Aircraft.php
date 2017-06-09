<?php

class Aircraft extends Unit {
    public function __construct(Map &$map, $coordinates=null) {
        $this->hp = 150;
        $this->size_x = 50; // due to img
        $this->size_y = 50; // due to img
        $this->forbidden_landscapes = [];

        $this->init_start_position($map, $coordinates);
    }

    protected function init_start_position(Map &$map, $coordinates=null) {
        if ( is_array($coordinates) ) {
            $this->pos_x = $coordinates[0];
            $this->pos_y = $coordinates[1];
        } else {
            $this->pos_x = rand(50, $map->size_x-50);
            $this->pos_y = rand(50, $map->size_y-50);
        }
    }

    public function move_to($x, $y) {

    }

    public function attack(Unit $unit) {
//        $this->move_to($unit);
    }
}