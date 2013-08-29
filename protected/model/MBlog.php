<?php
class MBlog
{
	public static function getBlogList(){
		$db = getDbh();
		return $db->select('select * from blog order by id desc limit 10');
	}

	public static function getBlog($id){
		$db = getDbh();
		return $db->selectRow('select id,title,content,record_time from blog where id=:id',array(
			':id'=>$id
		));
	}

	public static function addBlogT($title,$content){
		$db = getDbh();
		$db->begin();
		$db->execute('insert into blog(title,content,record_time) values(:title,:content,:record_time)',array(
			':title'=>$title,
			':content'=>$content,
			':record_time'=>getTime()
		));
		$id = $db->lastInsertId();
		$db->commit();
		return array($id);
	}

	public static function editBlogT($id,$title,$content){
		$db = getDbh();
		$db->begin();
		$db->execute('update blog set title=:title,content=:content where id=:id',array(
			':id'=>$id,
			':title'=>$title,
			':content'=>$content
		));
		$db->commit();
	}

	public static function getNewBlogs($id){
		$db = getDbh();
		return $db->select('select id,title,content,record_time from blog where id>:id order by id desc limit 10',array(
			':id'=>$id
		));
	}

	public static function getMoreBlogs($id){
		$db = getDbh();
		return $db->select('select id,title,content,record_time from blog where id<:id order by id desc limit 10',array(
			':id'=>$id
		));
	}
}