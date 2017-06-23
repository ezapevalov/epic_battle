var map_canvas = document.getElementById("map_canvas");
var map_context = map_canvas.getContext("2d");

var motion_timer;
var motion_done_interval = 100;

window.onload = function() {
    console.log(map_data);

    draw_map();

    map_canvas.onclick = function (event) {
        var data = {
            action: 'click',
            x: event.x,
            y: event.y
        };

        $.post('/', data, function (response) {
            response = JSON.parse(response);

            map_data = response.map;
            draw_map();
        });

    };

    map_canvas.onmousemove = function (event) {
        if ( map_data.active_unit != null ) {
            map_data.motion_line = {
                pos_x : event.clientX,
                pos_y : event.clientY,
                available: 1
            };

            draw_map();

            clearTimeout(motion_timer);
            motion_timer = setTimeout(check_unit_path, motion_done_interval);
        }
    }
};

function check_unit_path() {
    var data = {
        action: 'move',
        x: map_data.motion_line.pos_x,
        y: map_data.motion_line.pos_y
    };

    $.post('/', data, function (response) {
        response = JSON.parse(response);

        map_data = response.map;
        draw_map();
    });
}

function draw_map() {
    map_context.clearRect(0, 0, map_canvas.width, map_canvas.height);

    // Landscape elements
    draw_landscape();

    // Base
    draw_bases();

    // Units
    draw_soldiers();
    draw_vehicles();
    draw_aircrafts();

    draw_motion_line();
}

function draw_motion_line() {
    if ( map_data.active_unit != null && map_data.motion_line != null ) {
        var from_x = map_data.active_unit.pos_x + map_data.active_unit.size_x / 2;
        var from_y = map_data.active_unit.pos_y + map_data.active_unit.size_y / 2;
        var to_x = map_data.motion_line.pos_x;
        var to_y = map_data.motion_line.pos_y;
        var color = map_data.motion_line.available == 1 ? "#07C908" : "#C90B12";

        map_context.beginPath();

        map_context.moveTo(from_x, from_y);
        map_context.lineTo(to_x, to_y);

        map_context.strokeStyle = color;
        map_context.stroke();
    }
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
        var soldier_img = 'soldier_' + soldier.type + '_' + soldier.direction;

        if ( soldier.active == 1 ) {
            soldier_img += '_active';
        }

        soldier_img += '_img';

        map_context.drawImage(window[soldier_img], soldier.pos_x, soldier.pos_y);
    }
}

function draw_vehicles() {
    for ( var i = 0; i < map_data.vehicles.length; i++ ) {
        var vehicle = map_data.vehicles[i];
        var vehicle_img = 'vehicle_' + vehicle.type + '_' + vehicle.direction;

        if ( vehicle.active == 1 ) {
            vehicle_img += '_active';
        }

        vehicle_img += '_img';

        map_context.drawImage(window[vehicle_img], vehicle.pos_x, vehicle.pos_y);
    }
}

function draw_aircrafts() {
    for ( var i = 0; i < map_data.aircrafts.length; i++ ) {
        var aircraft = map_data.aircrafts[i];
        var aircraft_img = 'aircraft_' + aircraft.type + '_' + aircraft.direction;

        if ( aircraft.active == 1 ) {
            aircraft_img += '_active';
        }

        aircraft_img += '_img';

        map_context.drawImage(window[aircraft_img], aircraft.pos_x, aircraft.pos_y);
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