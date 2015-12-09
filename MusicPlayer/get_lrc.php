<?php
header('content-type:text/html;charset=utf-8');
$lrc_file_name = $_GET['name'];
$method = $_GET['method'];

if($method == 'get_lyric_data'){
    // 获取指定歌曲的歌词
    if($lrc_file_name == ''){
        $data = array(
            'state' => 'wrong',
            'message' => 'no lrc filename'
        );
        echo json_encode($data);
    }else{
        $path = 'song/'.$lrc_file_name;
        $path = iconv('utf-8', 'gb2312', $path);    // 转换编码格式, 只针对windows, linux服务器下不用转换
        if(file_exists($path)){
            $file = fopen($path, 'r');
            $lrc_data = '';
            while(!feof($file)){
                $text = fgets($file);
                $text = preg_replace("/\n\r/", '', $text);  // windows下\n\r, linux下\n
                $lrc_data = $lrc_data.$text.',';
            }
            fclose($file);
            $data = array(
                'state' => 'success',
                'message' => 'all have done',
                'lrc' => $lrc_data
            );
            echo json_encode($data);
        }else{
            $data = array(
                'state' => 'success',
                'message' => 'can not open file',
                'lrc' => '暂时没有歌词'
            );
            echo json_encode($data);
        }
    }
}else if($method == 'get_music_list'){
    // 获取歌曲列表
    $dir = './song';
    $handle = opendir($dir);
    $list = array();
    while(($file = readdir($handle))){
        if($file != '.' && $file != '..' && (substr($file, -3) == 'mp3' || substr($file, -3) == 'ogg')){
            // 过滤掉.和..
            $list[] = $file;
        }
    }
    closedir($handle);
    $list_length = count($list);
    $data['state'] = 'success';
    $data['music_list'] = [];
    for($i = 0; $i < $list_length; $i++){
        $list[$i] = iconv('gb2312', 'utf-8', $list[$i]);    // 编码转换
        $data['music_list'][$i] = $list[$i];
    }
    echo json_encode($data);
}else{
    // method 参数错误
    $data = array(
        'state' => 'wrong',
        'message' => 'no such method'
    );
    echo json_encode($data);
}
?>