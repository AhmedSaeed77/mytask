<?php


 function saveimage($image,$path)
 {
    $file = $image;
    $filename = $file->getClientOriginalName();
    $file->move($path,$filename);
    return $filename;
 }


