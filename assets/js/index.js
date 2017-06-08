var map_canvas = document.getElementById("map_canvas");
var map_context = map_canvas.getContext("2d");

window.onload = function() {
    console.log(map_data);

    init_map();
};

function init_map() {
    // Landscape elements
    draw_landscape();

    // Units
    draw_soldiers();
    draw_vehicles();
    draw_aircrafts();

    // Base
    draw_bases();
}

function draw_landscape() {
    map_context.fillStyle = field_color;
    map_context.fillRect(0, 0, map_data.size_x, map_data.size_y);

    // Lines
    for (var x = 0.5; x <= map_data.size_x; x += 10) {
        map_context.moveTo(x, 0);
        map_context.lineTo(x, map_data.size_y);
    }

    for (var y = 0.5; y <= map_data.size_y; y += 10) {
        map_context.moveTo(0, y);
        map_context.lineTo(map_data.size_x, y);
    }

    map_context.strokeStyle = "#bbb";
    map_context.stroke();

    // Landscape
    map_context.fillStyle = mountain_color;
    for ( var i = 0; i < map_data.mountains.length; i++ ) {
        var mountain = map_data.mountains[i];

        map_context.fillRect(mountain.pos_x, mountain.pos_y, mountain.size_x, mountain.size_y);
    }

    map_context.fillStyle = water_color;
    for ( var i = 0; i < map_data.water.length; i++ ) {
        var water = map_data.water[i];

        map_context.fillRect(water.pos_x, water.pos_y, water.size_x, water.size_y);
    }

    map_context.fillStyle = swamp_color;
    for ( var i = 0; i < map_data.swamps.length; i++ ) {
        var swamp = map_data.swamps[i];

        map_context.fillRect(swamp.pos_x, swamp.pos_y, swamp.size_x, swamp.size_y);
    }
}

function draw_soldiers() {
    for ( var i = 0; i < map_data.soldiers.length; i++ ) {
        var soldier = map_data.soldiers[i];
        var soldier_img = null;

        if ( soldier.type == 'blue' ) {
            if ( soldier.direction == 'left' ) {
                soldier_img =  soldier_blue_left_img;
            } else if ( soldier.direction == 'right' ) {
                soldier_img =  soldier_blue_right_img;
            }
        } else if ( soldier.type == 'red' ) {
            if ( soldier.direction == 'left' ) {
                soldier_img = soldier_red_left_img;
            } else if ( soldier.direction == 'right' ) {
                soldier_img = soldier_red_right_img;
            }
        }

        map_context.drawImage(soldier_img, soldier.pos_x, soldier.pos_y);
    }
}

function draw_vehicles() {
    for ( var i = 0; i < map_data.vehicles.length; i++ ) {
        var vehicle = map_data.vehicles[i];
        var vehicle_img = null;

        if ( vehicle.type == 'blue' ) {
            if ( vehicle.direction == 'left' ) {
                vehicle_img =  vehicle_blue_left_img;
            } else if ( vehicle.direction == 'right' ) {
                vehicle_img =  vehicle_blue_right_img;
            }
        } else if ( vehicle.type == 'red' ) {
            if ( vehicle.direction == 'left' ) {
                vehicle_img = vehicle_red_left_img;
            } else if ( vehicle.direction == 'right' ) {
                vehicle_img = vehicle_red_right_img;
            }
        }

        map_context.drawImage(vehicle_img, vehicle.pos_x, vehicle.pos_y);
    }
}

function draw_aircrafts() {
    for ( var i = 0; i < map_data.aircrafts.length; i++ ) {
        var aircraft = map_data.aircrafts[i];
        var aircraft_img = null;

        if ( aircraft.type == 'blue' ) {
            if ( aircraft.direction == 'left' ) {
                aircraft_img =  aircraft_blue_left_img;
            } else if ( aircraft.direction == 'right' ) {
                aircraft_img =  aircraft_blue_right_img;
            }
        } else if ( aircraft.type == 'red' ) {
            if ( aircraft.direction == 'left' ) {
                aircraft_img = aircraft_red_left_img;
            } else if ( aircraft.direction == 'right' ) {
                aircraft_img = aircraft_red_right_img;
            }
        }

        map_context.drawImage(aircraft_img, aircraft.pos_x, aircraft.pos_y);
    }
}

function draw_bases() {
    var blue_base = map_data.blue_base;
    var red_base = map_data.red_base;

    map_context.beginPath();

    map_context.fillStyle = blue_base_color;
    map_context.fillRect(blue_base.pos_x, blue_base.pos_y, blue_base.size_x, blue_base.size_y);

    for (var x = blue_base.pos_x; x <= blue_base.size_x+blue_base.pos_x; x += 10) {
        map_context.moveTo(x, blue_base.pos_y);
        map_context.lineTo(blue_base.pos_y, x);
    }
    for (var x = blue_base.size_x+blue_base.pos_x; x >= blue_base.pos_x; x -= 10) {
        map_context.moveTo(x, blue_base.size_y+10);
        map_context.lineTo(blue_base.size_y+10, x);
    }


    map_context.fillStyle = red_base_color;
    map_context.fillRect(red_base.pos_x, red_base.pos_y, red_base.size_x, red_base.size_y);

    for (var x = red_base.pos_x, i = 0; x <= red_base.pos_x + red_base.size_x; x += 10, i += 10) {
        map_context.moveTo(x, red_base.pos_y);
        map_context.lineTo(red_base.pos_x, red_base.pos_y+i);
    }

    for (var x = red_base.pos_x+red_base.size_x, i = 0; x >= red_base.pos_x; x -= 10, i -= 10) {
        map_context.moveTo(x, red_base.pos_y+red_base.size_y);
        map_context.lineTo(red_base.pos_x+red_base.size_x, red_base.pos_y+red_base.size_y+i);
    }
    map_context.strokeStyle = "#ccc";
    map_context.stroke();
}