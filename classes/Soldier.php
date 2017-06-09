<?php

class Soldier extends Unit {
    public $map_side; // generation area (left side or right side)

    public function __construct(Map &$map, $map_side) {
        $this->hp = 50;
        $this->size_x = 30; // due to img
        $this->size_y = 30; // due to img
        $this->map_side = $map_side;
        $this->forbidden_landscapes = ['swamp'];

        $this->init_start_position($map);

        $counter = 0;
        while ( $map->check_intersect($this) ) {
            $this->init_start_position($map);
            $counter += 1;

            if ( $counter > 100 ) {
                throw new Exception("Can't find place for soldier");
            }
        }

        $map->used_area[] = [
            'pos_x' => $this->pos_x,
            'pos_y' => $this->pos_y,
            'size_x' => $this->size_x,
            'size_y' => $this->size_y
        ];
    }

    protected function init_start_position(Map &$map, $coordinates=null) {
        if ( is_array($coordinates) ) {
            $this->pos_x = $coordinates[0];
            $this->pos_y = $coordinates[1];
        } else {
            if ( $this->map_side == 'left' ) {
                $this->pos_x = rand(0, $map->size_x/2);
                $this->pos_y = rand(0, $map->size_y-$this->size_y);
            } else if ( $this->map_side == 'right' ) {
                $this->pos_x = rand($map->size_x/2, $map->size_x-$this->size_x);
                $this->pos_y = rand(0, $map->size_y-$this->size_y);
            }

        }
    }

    public function move_to($x, $y) {
        $new_x = $x - $this->size_x/2 - 7;
        $new_y = $y - $this->size_y/2 - 5;

        $this->direction = $new_x > $this->pos_x ? 'right' : 'left';

        $this->pos_x = $new_x;
        $this->pos_y = $new_y;
    }

    public function attack(Unit $unit) {
//        $this->move_to($x, $y);
    }
}