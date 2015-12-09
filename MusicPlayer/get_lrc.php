<?php
header('content-type:text/html;charset=utf-8');
$lrc_file_name = $_GET['name'];
$method = $_GET['method'];

if($method == 'get_lyric_data'){
    if($lrc_file_name == ''){
        $data = array(
            'state' => 'wrong',
            'message' => 'no lrc filename'
        );
        echo json_encode($data);
    }else{
        $path = 'song/'.$lrc_file_name;
        if(file_exists($path)){
            $file = fopen($path, 'r');
            $lrc_data = '';
            while(!feof($file)){
                $text = fgets($file);
                $text = preg_replace("/\n\r/", '', $text);
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
    $dir = './song';
    $handle = opendir($dir);
    $list = array();
    while(false !== ($file = readdir($handle))){
        if($file != '.' 
            && $file != '..' 
            && (substr($file, -4) == 'song' || substr($file, -4) == 'ogg')){
            $list[] = $file;
        }
    }
    closedir($handle);
    $list_length = count($list);
    $data['state'] = 'success';
    $data['music_list'] = [];
    for($i = 0; $i < $list_length; $i++){
        $data['music_list'][$i] = $list[$i];
    }
    echo json_encode($data);
}else{
    $data = array(
        'state' => 'wrong',
        'message' => 'no such method'
    );
    echo json_encode($data);
}
?>