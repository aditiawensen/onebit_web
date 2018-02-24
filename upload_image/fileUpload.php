<?php
function thumbnail( $img, $source, $dest, $maxw, $maxh ){      
    $jpg = $source.$img;

    if( $jpg ) {
        list( $width, $height  ) = getimagesize( $jpg ); //$type will return the type of the image
        $source = imagecreatefromjpeg( $jpg );

        if( $maxw >= $width && $maxh >= $height ) {
            $ratio = 1;
        }elseif( $width > $height ) {
            $ratio = $maxw / $width;
        }else {
            $ratio = $maxh / $height;
        }

        $thumb_width = round( $width * $ratio ); //get the smaller value from cal # floor()
        $thumb_height = round( $height * $ratio );

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
        imagecopyresampled( $thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height );

        $path = $dest.$img;
        imagejpeg( $thumb, $path, 75 );
    }
    imagedestroy( $thumb );
    imagedestroy( $source );
}

echo $_FILES['image']['name'] . '<br/>';


if (!empty($_FILES['image']['tmp_name'])) {
	makeDirectory();

	$img = $_FILES['image']['name'];

    $directory = 'images/';
	$month = date('Ym');  
    $source = $directory.$month.'/';

    move_uploaded_file($_FILES['image']['tmp_name'], $source.$img);

    $dest100 = $directory.$month.'/compress100/';
    thumbnail($img, $source, $dest100, 100, 100);

    $dest400 = $directory.$month.'/compress400/';
    thumbnail($img, $source, $dest400, 400, 400);

    $dest700 = $directory.$month.'/compress700/';
    thumbnail($img, $source, $dest700, 700, 700);

    $imgname = $img;
    //SQL UPDATE DISINI
}

function makeDirectory(){
    $directory = 'images/';
    $month = date('Ym');
    if (!file_exists($directory.$month)) {
        mkdir($directory.$month, 0777, true);
        if (!file_exists($directory.$month.'/compress100')) {
            mkdir($directory.$month.'/compress100', 0777, true);
        }
        if (!file_exists($directory.$month.'/compress400')) {
            mkdir($directory.$month.'/compress400', 0777, true);
        }
        if (!file_exists($directory.$month.'/compress700')) {
            mkdir($directory.$month.'/compress700', 0777, true);
        }
    }
}
?>