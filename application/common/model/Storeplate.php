<?php
/**
 * 店铺模型管理
 */
namespace app\common\model;

use think\Model;

class Storeplate extends Model {
    public $page_info;
    /**
     * 版式列表
     * @param array $condition
     * @param string $field
     * @param int $page
     * @return array
     */
    public function getStorePlateList($condition, $field = '*', $page = 0) {
        if($page){
            $result = db('storeplate')->field($field)->where($condition)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            return db('storeplate')->field($field)->where($condition)->select();
        }
        
    }
    
    /**
     * 版式详细信息
     * @param array $condition
     * @return array
     */
    public function getStorePlateInfo($condition) {
        return db('storeplate')->where($condition)->find();
    }
    
    public function getStorePlateInfoByID($plate_id, $fields = '*') {
        $info = $this->_rStorePlateCache($plate_id, $fields);
        if (empty($info)) {
            $info = $this->getStorePlateInfo(array('plate_id' => $plate_id));
            $this->_wStorePlateCache($plate_id, $info);
        }
        return $info;
    }
    
    /**
     * 添加版式
     * @param unknown $insert
     * @return boolean
     */
    public function addStorePlate($insert) {
        return db('storeplate')->insert($insert);
    }
    
    /**
     * 更新版式
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editStorePlate($update, $condition) {
        $list = $this->getStorePlateList($condition, 'plate_id');
        if (empty($list)) {
            return true;
        }
        $result = db('storeplate')->where($condition)->update($update);
        if ($result) {
            foreach ($list as $val) {
                $this->_dStorePlateCache($val['plate_id']);
            }
        }
        return $result;
    }
    
    /**
     * 删除版式
     * @param array $condition
     * @return boolean
     */
    public function delStorePlate($condition) {
        $list = $this->getStorePlateList($condition, 'plate_id');
        if (empty($list)) {
            return true;
        }
        $result = db('storeplate')->where($condition)->delete();
        if ($result) {
            foreach ($list as $val) {
                $this->_dStorePlateCache($val['plate_id']);
            }
        }
        return $result;
    }
    
    /**
     * 读取店铺关联板式缓存缓存
     * @param int $plate_id
     * @param string $fields
     * @return array
     */
    private function _rStorePlateCache($plate_id, $fields) {
        return rcache($plate_id, 'store_plate', $fields);
    }
    
    /**
     * 写入店铺关联板式缓存缓存
     * @param int $plate_id
     * @param array $info
     * @return boolean
     */
    private function _wStorePlateCache($plate_id, $info) {
        return wcache($plate_id, $info, 'store_plate');
    }
    
    /**
     * 删除店铺关联板式缓存缓存
     * @param int $plate_id
     * @return boolean
     */
    private function _dStorePlateCache($plate_id) {
        return dcache($plate_id, 'store_plate');
    }
    
}

