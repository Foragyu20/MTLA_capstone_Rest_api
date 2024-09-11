<?php

header('Content-Type: audio/mp3');

$file_name = 'audio/' . $_GET['file_name'];

if (file_exists($file_name)) {
    // Set the desired bit rate (in this case, 320Kbps constant bit rate)
    $desiredBitRate = '320k';

    // Specify the path to the FFmpeg executable
    $ffmpegPath = 'D:/xampp/htdocs/api/ffmpeg/ffmpeg.exe';

    // Build the FFmpeg command to transcode the audio
    $ffmpegCommand = "$ffmpegPath -i \"$file_name\" -b:a $desiredBitRate -f mp3 -";

    // Execute FFmpeg and stream the transcoded audio
    $audioStream = popen($ffmpegCommand, 'r');

    while (!feof($audioStream)) {
        echo fread($audioStream, 1024);
        ob_flush();
        flush();
    }

    pclose($audioStream);
} else {
    // Handle file not found error
    http_response_code(404);
    echo 'File not found';
}
?>
