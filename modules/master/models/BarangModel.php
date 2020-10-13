<?php

class BarangModel extends Model{

	public function get_data()
	{
		$sql = "SELECT * FROM `barang` ORDER BY nm_barang asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function get_where($cari)
	{

		if ($cari == '') {
			$sql = "SELECT * FROM `barang` ORDER BY nm_barang asc";
		} else {
			$sql = "SELECT * FROM `barang` WHERE id_barang like '%".$cari."%' OR nm_barang like '%".$cari."%' OR id_barang like '%".$cari."%' ORDER BY nm_barang asc";
		}
		
		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

}