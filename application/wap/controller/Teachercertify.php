<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 20:12
 */

namespace app\wap\controller;


class Teachercertify extends MobileMember
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    //教师认证
    public function index(){
        $member_id = intval(input('post.member_id'));
        if(empty($member_id)){
            output_error('会员id不能为空');
        }
        $memberInfo = db("member")->where(array('member_id'=>$member_id))->find();
        if(empty($memberInfo)){
            output_error('无此会员');
        }
        $data = array();
        $data['member_id'] = $member_id;
        $data['member_mobile'] = $memberInfo['member_mobile'];
        $data['provinceid'] = trim(input('post.provinceid'));
        $data['cityid'] = trim(input('post.cityid'));
        $data['areaid'] = trim(input('post.areaid'));
        $data['region'] = input('post.region');
        $data['username'] = input('post.username');
        $data['phone'] = !empty(input('post.phone'))?input('post.phone'):"";
        $data['idcard'] = !empty(input('post.idcard'))?input('post.idcard'):"";
        $data['status'] = 1;
        $data['createtime'] = time();

        if (empty($data['username'])) output_error('姓名不能为空');
//        if (empty($data['phone'])) output_error('手机号不能为空');
        if (empty($_FILES['idcard_front']['name'])) output_error('身份证正面图不能为空');
        if (empty($_FILES['idcard_back']['name'])) output_error('身份证反面图不能为空');
        if (empty($_FILES['certificate_front']['name'])) output_error('资格证不能为空');
//        if (empty($_FILES['certificate_back']['name'])) output_error('资格证反面图');

        //身份证正面图
        if($_FILES['idcard_front']['name']){
            $data['cardimg'] = "home/idcard/idcardz_".date("YmdHis",time())."_".time().".png";
        }
        //身份证反面图
        if($_FILES['idcard_back']['name']){
            $data['cardimg_fan'] = "home/idcard/idcardf_".date("YmdHis",time())."_".time().".png";
        }
        //资格证正面图
        if($_FILES['certificate_front']['name']){
            $data['certificate'] = "home/teacher/teacherz_".date("YmdHis",time())."_".time().".png";
        }
        //资格证反面图
//        if($_FILES['certificate_back']['name']){
//            $data['certificate_fan'] = "home/teacher/".date("YmdHis",time())."_".time().".png";
//        }
        //print_r($_FILES);die;
        $this->image($data,$_FILES);
        $teachercertify_model = model('Teachercertify');
        $id = input('post.id');
        if($id){
            $info =db('teachercertify')->where(array('member_id'=>$member_id,'id'=>$id))->find();
            if(empty($info)){
                output_error('member_id和id不匹配');
            }
            $result = $teachercertify_model->teacher_update($data,array('id'=>$id));
        }else{
            $result = $teachercertify_model->teacher_add($data);
        }
        if($result){
            output_data($data);
        }else{
            output_error('提交失败');
        }

    }

    //教师认证信息展示
    public function info(){
        $member_id = intval(input('post.member_id'));
        if(empty($member_id)){
            output_error('会员id不能为空');
        }
        $teachchild = model('Teachercertify');
        $teachinfo = db('teachercertify')->where(array('member_id'=>$member_id))->order('id',desc)->limit(1)->find();
        $path = "http://".$_SERVER['HTTP_HOST']."/uploads/";
        if(empty($teachinfo['provinceid'])){
            $member_info = db('member')->where(array('member_id'=>$member_id))->find();
            $teachinfo['provinceid'] = !empty($member_info['member_provinceid'])?$member_info['member_provinceid']:0;
            $teachinfo['provincename'] = "";
            $teachinfo['cityid'] = !empty($member_info['member_cityid'])?$member_info['member_cityid']:0;
            $teachinfo['cityname'] = "";
            $teachinfo['areaid'] = !empty($member_info['member_areaid'])?$member_info['member_areaid']:0;
            $teachinfo['areaname'] = "";
            $teachinfo['status'] = 0;
            $teachinfo['id'] = 0;
            $teachinfo['member_id'] = 0;
            $teachinfo['member_mobile'] = "";
            $teachinfo['username'] = "";
            $teachinfo['idcard'] = "";
            $teachinfo['phone'] = "";
            $teachinfo['sex'] = "";
            $teachinfo['birthday'] = "";
            $teachinfo['region'] = "";
            $teachinfo['cardimg'] = "";
            $teachinfo['cardimg_fan'] = "";
            $teachinfo['certificate'] = "";
            $teachinfo['certificate_fan'] = "";
            $teachinfo['createtime'] = "";
            $teachinfo['job'] = "";
            $teachinfo['email'] = "";
            $teachinfo['address'] = "";
            $teachinfo['failreason'] = "";
            $teachinfo['affiliat'] = "";
            $teachinfo['desc'] = "";
            $teachinfo['option_id'] = 0;
            $teachinfo['option_time'] = "";
        }
        if(!empty($teachinfo['provinceid'])){
            $parent = db('area')->field("area_name")->where(array('area_id'=>$teachinfo['provinceid']))->find();
            $teachinfo['provincename'] = $parent['area_name'];
        }
        if(!empty($teachinfo['cityid'])){
            $child = db('area')->field("area_name")->where(array('area_id'=>$teachinfo['cityid']))->find();
            $teachinfo['cityname'] = $child['area_name'];
        }
        if(!empty($teachinfo['areaid'])){
            $child3 = db('area')->field("area_name")->where(array('area_id'=>$teachinfo['areaid']))->find();
            $teachinfo['areaname'] = $child3['area_name'];
        }
        if(!empty($teachinfo['createtime'])){
            $teachinfo['createtime'] = date("H:i",$teachinfo['createtime']);
        }
        if(!empty($teachinfo['option_time'])){
            $teachinfo['option_time'] = date("H:i",$teachinfo['option_time']);
        }
        if(!empty($teachinfo['cardimg'])){
            $teachinfo['cardimg'] = $path.$teachinfo['cardimg'];
        }
        if(!empty($teachinfo['cardimg_fan'])){
            $teachinfo['cardimg_fan'] = $path.$teachinfo['cardimg_fan'];
        }
        if(!empty($teachinfo['certificate'])){
            $teachinfo['certificate'] = $path.$teachinfo['certificate'];
        }
        //地区范围
//        $parent = db('area')->field("area_id,area_parent_id,area_name,area_deep")->where(array('area_deep'=>1))->select();
//        $child = db('area')->field("area_id,area_parent_id,area_name,area_deep")->where(array('area_deep'=>2))->select();
//        $child3 = db('area')->field("area_id,area_parent_id,area_name,area_deep")->where(array('area_deep'=>3))->select();
//        foreach($parent as $key=>$val){
//            foreach($child as $k=>$v){
//                if($v['area_parent_id']==$val['area_id']){
//                    $parent[$key]['childTwo'][] = $v;
//                }
//            }
//        }
//        foreach($parent as $key=>$item){
//            foreach($item['childTwo'] as $k2=>$v2){
//                foreach($child3 as $k3=>$v3){
//                    if($v3['area_parent_id']==$v2['area_id']){
//                        $item['childTwo'][$k2]['childThree'][] = $v3;
//                    }
//                }
//            }
//            $parent[$key]['childTwo'] = $item['childTwo'];
//        }
        //$teachinfo['area'] = $parent;
        $teachinfo = !empty($teachinfo)?[$teachinfo]:$teachinfo;
        output_data($teachinfo);
    }

    /*
     * 上传图片
     * */
    public function image($picture,$type){
        //上传路径
        $uploadimg_path = substr(str_replace("\\","/",$_SERVER['SCRIPT_FILENAME']),'0','-9')."uploads/";
        //检查是否有该文件夹，如果没有就创建
        if(!is_dir($uploadimg_path."home/idcard/")){
            mkdir($uploadimg_path."home/idcard/",0777,true);
        }
        if(!is_dir($uploadimg_path."home/teacher/")){
            mkdir($uploadimg_path."home/teacher/",0777,true);
        }
        //允许上传的文件格式
        $tp = array("image/gif","image/jpeg","image/jpg","image/png","image/*");
        //检查身份证是否在允许上传的类型
        if(!in_array($type["idcard_front"]["type"],$tp) || !in_array($type["idcard_back"]["type"],$tp))
        {
            output_error('身份证格式不正确,请检查是否符合 gif，jpeg，jpg，png');
        }
        //检查资格证是否在允许上传的类型
        if(!in_array($type["certificate_front"]["type"],$tp))
        {
            output_error('资格证格式不正确,请检查是否符合 gif，jpeg，jpg，png');
        }

        if(!empty($type['idcard_front']['name'])){
            move_uploaded_file($type['idcard_front']["tmp_name"], $uploadimg_path . $picture['cardimg']);
        }
        if(!empty($type['idcard_back']['name'])){
            move_uploaded_file($type['idcard_back']["tmp_name"], $uploadimg_path . $picture['cardimg_fan']);
        }
        if(!empty($type['certificate_front']['name'])){
            move_uploaded_file($type['certificate_front']["tmp_name"], $uploadimg_path . $picture['certificate']);
        }
    }

}