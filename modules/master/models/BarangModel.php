<?php

class BarangModel extends Model{

	public function get_data()
	{
		$sql = "SELECT * FROM `barang` ORDER BY nm_barang asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

}