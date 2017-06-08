<?php

abstract class Unit {
    public $hp;
    public $pos_x;
    public $pos_y;
    public $size_x;
    public $size_y;
    public $type; // blue, red
    public $direction; // left, right
    public $forbidden_landscapes;

    abstract protected function init_start_position(Map &$map, $coordinates=null);
    abstract protected function move_to(Unit $unit);
    abstract public function attack(Unit $unit);

    public function set_type($type) {
        $this->type = $type;
    }

    public function set_direction($direction) {
        $this->direction = $direction;
    }
}