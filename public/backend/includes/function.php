<?php
function uploadImageUser($photo)
{
    $photoName = $photo["name"];
    $photoLocation = $photo["tmp_name"];
    $newPhotoName = rand() . time() . uniqid() . $photoName;

    $serverPath = $_SERVER['DOCUMENT_ROOT'] . "/fullstackProject/public/backend/img/avatar/";


    $finalPath = $serverPath . $newPhotoName;
    $url = "/fullstackProject/public/backend/img/avatar/" . $newPhotoName;

    if (move_uploaded_file($photoLocation, $finalPath)) {
        return $url;
    } else {
        return false;
    }
}
function uploadImageCourse($photo)
{
    $photoName = $photo["name"];
    $photoLocation = $photo["tmp_name"];
    $newPhotoName = rand() . time() . uniqid() . $photoName;

    $serverPath = $_SERVER['DOCUMENT_ROOT'] . "/fullstackProject/public/backend/img/imgCourses/";


    $finalPath = $serverPath . $newPhotoName;
    $url = "/fullstackProject/public/backend/img/imgCourses/" . $newPhotoName;

    if (move_uploaded_file($photoLocation, $finalPath)) {
        return $url;
    } else {
        return false;
    }
}
function uploadImageStudent($photo)
{
    $photoName = $photo["name"];
    $photoLocation = $photo["tmp_name"];
    $newPhotoName = rand() . time() . uniqid() . $photoName;

    $serverPath = $_SERVER['DOCUMENT_ROOT'] . "/fullstackProject/public/frontend/img/avatar/";


    $finalPath = $serverPath . $newPhotoName;
    $url = "/fullstackProject/public/frontend/img/avatar/" . $newPhotoName;

    if (move_uploaded_file($photoLocation, $finalPath)) {
        return $url;
    } else {
        return false;
    }
}
