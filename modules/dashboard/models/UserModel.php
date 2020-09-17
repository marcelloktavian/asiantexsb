<?php

class UserModel extends Model{

	public function get_data($user, $pass)
	{
		$sql = "SELECT * FROM `user` us RIGHT JOIN `groups` gr ON gr.id = us.group_id WHERE us.deleted=0 and (us.username='".$user."' and us.password=md5('".$pass."'))";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}
}