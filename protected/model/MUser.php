<?php
class MUser
{
	public static function getBlogList(){
		$db = getDbh();
		return $db->select('select * from blog order by id desc limit 10');
	}

	public static function getBlog($id){
		$db = getDbh();
		return $db->selectRow('select * from blog where id=:id',array(
			':id'=>$id
		));
	}

	public static function addBlog(){
		$db = getDbh();
		$db->begin();
		return $db->execute('insert into blog(title,content,record_time) values("test1",:record_time,:record_time)',array(
			':record_time'=>getTime()
		));
		$db->commit();
	}
}