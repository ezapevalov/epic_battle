<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="icon" type="image/png" href="/favicon.png" />

    <title>Epic battle</title>

    <link href="/assets/css/index.css" rel="stylesheet">
</head>

<body>

<canvas id="map_canvas" width="<?=$map->size_x?>" height="<?=$map->size_y?>"></canvas>

<script>
    var map_data = <?=json_encode($map)?>;
</script>
<script src="/assets/js/images.js"></script>
<script src="/assets/js/index.js"></script>

</body>
</html>