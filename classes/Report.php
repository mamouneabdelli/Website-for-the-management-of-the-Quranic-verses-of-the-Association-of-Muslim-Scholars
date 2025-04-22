<?php 

interface Report {
    function sendReport($title,$content,$groupId,$senderId);
}