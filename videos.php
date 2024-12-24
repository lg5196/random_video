<?php
// 定义视频文件夹路径
$videoFolder = "videos/";

// 用于存储所有视频文件路径的数组
$videoFiles = [];

// 递归函数，用于遍历文件夹及其子文件夹中的视频文件
function getVideoFiles($folder) {
    global $videoFiles;
    $files = glob($folder. '*');
    foreach ($files as $file) {
        if (is_dir($file)) {
            getVideoFiles($file. '/');
        } elseif (pathinfo($file, PATHINFO_EXTENSION) ==='mp4') {
            $videoFiles[] = $file;
        }
    }
}

// 开始遍历视频文件夹及其子文件夹
getVideoFiles($videoFolder);

// 随机选择一个视频
if (!empty($videoFiles)) {
    $randomVideo = $videoFiles[array_rand($videoFiles)];

    // 设置下载头信息
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'. basename($randomVideo). '"');
    header('Content-Length: '. filesize($randomVideo));

    // 输出视频文件内容
    readfile($randomVideo);
} else {
    echo "指定文件夹及其子文件夹中没有找到视频文件。";
}
?>