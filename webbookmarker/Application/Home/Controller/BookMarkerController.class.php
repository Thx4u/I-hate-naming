<?php
namespace Home\Controller;
use Think\Controller;
require_once 'simple_html_dom.php';

class BookMarkerController extends Controller {
	/**
	 * 默认控制器
	 */
    public function index(){
        echo "BookMarker";
    }
	
    /**
     * 消息模板
     * @var string
     * @author lishengcn.cn
     */
    private $msgTpl = '{"code": %s, "content": %s}';
    
    /**
     * 生成消息模板
     * @param integer $code
     * @param string $content
     * @return string 
     * @author lishengcn.cn
     */
    private function CreateMsg($code, $content) {
    	$result = sprintf($this->msgTpl, $code, $content);
    	return $result;
    }
    
    /**
     * 格式化icon的url
     * @param string $href
     * @param string $iconUrl
     * @return string
     * @author lishengcn.cn
     */
    private function FormatIcon($href, $iconUrl){
    	if(!strstr($iconUrl, "http") && $iconUrl != null) {
    		return $href . $iconUrl;
    	} elseif ($iconUrl == null) {
    		$iconUrl = "http://su.bdimg.com/icon/6000.png";
    		return $iconUrl;
    	} else {
    		return $iconUrl;
    	}
    }
    
    /**
     * 获取网址的title和icon
     * @param string $url
     * @return array 
     * @author lishengcn.cn
     */
    private function GetMarker($title, $url) {
    	if (!$html = file_get_html($url)) {
    		return false;
    	} else {
    		if ($title == ''){
    			$data['title'] = $html->find('title', 0)->plaintext;
    		} else {
    			$data['title'] = $title;
    		}
    		$data['href'] = $url;
    		if ($icon = $html->find('link[rel=shortcut icon]', 0)->href) {
    			$data['icon'] = $icon;
    		} elseif ($icon = $html->find('link[rel=shortcut icon]', 0)->href) {
    			$data['icon'] = $icon;
    		}
    		return $data;
    	}
    }
    
    /**
     * 添加书签
     * @param string $url
     * @author lishengcn.cn
     */
    public function Add($title, $url) {
    	if ($data = $this->GetMarker($title, $url)) {
    		$data['icon'] = $this->FormatIcon($data['href'], $data['icon']);
    		$marker = D('Marker');
    		$data['id'] = null;
    		$marker->create($data);
    		$data['id'] = $marker->add($data);
    		$data = json_encode($data);
    		echo $this->CreateMsg(1, $data);
    	} else {
    		echo $this->CreateMsg(0, '"获取url失败"');
    	}
    }
    
    /**
     * 删除书签
     * @param integer $id
     */
    public function Del($id) {
    	$marker = D('Marker');
    	$condition['id'] = $id;
    	if ($marker->where($condition)->delete() != 0) {
    		echo $this->CreateMsg(1, '"删除书签成功"');
    	} else {
    		echo $this->CreateMsg(0, '"删除书签失败"');
    	}
    }
    
    /**
     * 模糊查询书签
     * @param string $keyworld
     */
    public function Search($keyworld) {
    	$marker = D('Marker');
    	$condition['title'] = array('like', "%{$keyworld}%");
    	if ($data = $marker->where($condition)->select()) {
    		$data = json_encode($data);
    		echo $this->CreateMsg(1, $data);
    	} else {
    		echo $this->CreateMsg(0, '"没有找到相关信息"');
    	}
    }
    
    /**
     * 修改书签
     * @param integer $id
     * @param string $title
     * @param string $href
     */
    public function Alter($id, $title, $href) {
    	$marker = D('Marker');
    	$data['id'] = $id;
    	$data['title'] = $title;
    	$data['href'] = $href;
    	print_r($data);
    	$marker->create($data);
    	$marker->save($data);  	
    }
    
    public function ShowAll() {
    	$marker = D('Marker');
    	echo json_encode($marker->select());
    }
}









