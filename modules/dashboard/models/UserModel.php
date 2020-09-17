<?php

class UserModel extends Model{

	public function get_data($user, $pass)
	{
		$sql = "SELECT * FROM `user` us RIGHT JOIN `groups` gr ON gr.id = us.group_id WHERE us.deleted=0 and (us.username='".$user."' and us.password=md5('".$pass."'))";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	// public function get_menu($group)
	// {
	// 	$sql="SELECT m.*,COALESCE(ga.policy,'') as ga_policy FROM menu m LEFT JOIN group_access ga ON m.menu_id = ga.menu_id AND ga.group_id ='".$group."' WHERE m.hide = 0 ORDER BY m.menu_id";
	// }
}