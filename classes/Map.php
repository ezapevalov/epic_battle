<?php

class Map {
    public $size_x;
    public $size_y;

    public $used_area=[];

    public $blue_base;
    public $red_base;

    public $mountains;
    public $water;
    public $swamps;

    public $soldiers=[];
    public $vehicles=[];
    public $aircrafts=[];

    public $active_unit = Null;

    public function __construct($size_x, $size_y) {
        $this->size_x = $size_x;
        $this->size_y = $size_y;

        $this->init_blue_base();
        $this->init_red_base();

        $this->generate_landscape();
        $this->generate_soldiers();
        $this->generate_vehicles();
    }

    public function generate_landscape() {
        $limit = 10;

        for ( $i = 0; $i < $limit; $i++ ) {
            $this->mountains[] = new LandscapeItem($this);
            $this->water[] = new LandscapeItem($this);
            $this->swamps[] = new LandscapeItem($this);
        }
    }

    public function generate_soldiers() {
        $limit = 15;

        for ( $i = 0; $i < $limit; $i++ ) {
            // Blue soldier
            $soldier = new Soldier($this, 'left');
            $soldier->set_type('blue');
            $soldier->set_direction('right');

            $this->soldiers[] = $soldier;

            // Red soldier
            $soldier = new Soldier($this, 'right');
            $soldier->set_type('red');
            $soldier->set_direction('left');

            $this->soldiers[] = $soldier;
        }
    }

    public function generate_vehicles() {
        $limit = 5;

        for ( $i = 0; $i < $limit; $i++ ) {
            // Blue vehicle
            $vehicle = new Vehicle($this, 'left');
            $vehicle->set_type('blue');
            $vehicle->set_direction('right');

            $this->vehicles[] = $vehicle;

            // Red vehicle
            $vehicle = new Vehicle($this, 'right');
            $vehicle->set_type('red');
            $vehicle->set_direction('left');

            $this->vehicles[] = $vehicle;
        }
    }

    public function check_intersect($item) {
        $first = [
            'pos_x' => $item->pos_x,
            'pos_y' => $item->pos_y,
            'size_x' => $item->size_x,
            'size_y' => $item->size_y,
        ];

        foreach ( $this->used_area as $second ) {
            if ( $first['pos_x'] > ($second['pos_x'] + $second['size_x']) || ($first['pos_x'] + $first['size_x']) < $second['pos_x'] ) {
                continue;
            }
            if ( $first['pos_y'] > ($second['pos_y'] + $second['size_y']) || ($first['pos_y'] + $first['size_y']) < $second['pos_y'] ) {
                continue;
            }
            return true;
        }

        return false;
    }

    private function init_blue_base() {
        /**
         * Init blue-base in top-left corner
         * with two aircrafts to the right.
         *
         * Base area (including aircrafts) will be reserved
         */

        $this->blue_base = new Base($this, 'blue');

        $aircraft_x = $this->blue_base->pos_x + $this->blue_base->size_x + 5;
        $aircraft_y = $this->blue_base->pos_y;

        $first_aircraft = new Aircraft($this, [$aircraft_x, $aircraft_y]);
        $first_aircraft->set_type('blue');
        $first_aircraft->set_direction('right');
        $this->aircrafts[] = $first_aircraft;

        $aircraft_x = $this->blue_base->pos_x + $this->blue_base->size_x + 5;
        $aircraft_y = $this->blue_base->pos_y + 50;

        $second_aircraft = new Aircraft($this, [$aircraft_x, $aircraft_y]);
        $second_aircraft->set_type('blue');
        $second_aircraft->set_direction('right');
        $this->aircrafts[] = $second_aircraft;

        $this->used_area[] = [
            'pos_x' => 0,
            'pos_y' => 0,
            'size_x' => 10 + $this->blue_base->size_x + 5 + $first_aircraft->size_x + 5,
            'size_y' => 10 + $this->blue_base->size_y + 5
        ];
    }

    private function init_red_base() {
        /**
         * Init red-base in bottom-right corner
         * with two aircrafts to the left.
         *
         * Base area (including aircrafts) will be reserved
         */

        $this->red_base = new Base($this, 'red');

        $aircraft_x = $this->red_base->pos_x - 55;
        $aircraft_y = $this->red_base->pos_y;

        $first_aircraft = new Aircraft($this, [$aircraft_x, $aircraft_y]);
        $first_aircraft->set_type('red');
        $first_aircraft->set_direction('left');
        $this->aircrafts[] = $first_aircraft;

        $aircraft_x = $this->red_base->pos_x - 55;
        $aircraft_y = $this->red_base->pos_y + 50;

        $second_aircraft = new Aircraft($this, [$aircraft_x, $aircraft_y]);
        $second_aircraft->set_type('red');
        $second_aircraft->set_direction('left');
        $this->aircrafts[] = $second_aircraft;

        $this->used_area[] = [
            'pos_x' => $first_aircraft->pos_x,
            'pos_y' => $first_aircraft->pos_y,
            'size_x' =>  5 + $first_aircraft->size_x + 5 + $this->red_base->size_x + 10,
            'size_y' =>  5 + $this->red_base->size_y + 10
        ];
    }

    public function detect_unit($x, $y) {
        foreach ( $this->soldiers as &$soldier ) {
            if ( $x >= $soldier->pos_x && $x <= $soldier->pos_x + $soldier->size_x &&
                $y >= $soldier->pos_y && $y <= $soldier->pos_y + $soldier->size_y    ) {

                return $soldier;
            }
        }
        
        foreach ( $this->vehicles as &$vehicle ) {
            if ( $x >= $vehicle->pos_x && $x <= $vehicle->pos_x + $vehicle->size_x &&
                 $y >= $vehicle->pos_y && $y <= $vehicle->pos_y + $vehicle->size_y    ) {
                return $vehicle;
            }
        }
        
        foreach ( $this->aircrafts as &$aircraft ) {
            if ( $x >= $aircraft->pos_x && $x <= $aircraft->pos_x + $aircraft->size_x &&
                 $y >= $aircraft->pos_y && $y <= $aircraft->pos_y + $aircraft->size_y    ) {
                return $aircraft;
            }
        }

        return null;
    }

    public function remove_active_from_units() {
        foreach ( $this->soldiers as &$soldier ) {
            $soldier->active = 0;
        }

        foreach ( $this->vehicles as &$vehicle ) {
            $vehicle->active = 0;
        }

        foreach ( $this->aircrafts as &$aircraft ) {
            $aircraft->active = 0;
        }
    }
}