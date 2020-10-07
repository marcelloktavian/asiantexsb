<?php

class UserModel extends Model{

	public function get_data($user, $pass)
	{
		$sql = "SELECT * FROM `user` us RIGHT JOIN `groups` gr ON gr.id = us.group_id WHERE us.deleted=0 and (us.username='".$user."' and us.password=md5('".$pass."'))";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function get_total()
	{
		$sql = "SELECT count(*) as jumlah FROM `trsalesorder` WHERE deleted=0 and substr(id_trans,4,4) = concat(substr(CURDATE(),3,2),substr(CURDATE(),6,2))";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}
}