<?php

class BarangModel extends Model{

	public function get_data()
	{
		$sql = "SELECT * FROM `barang` ORDER BY nm_barang asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function get_data_post()
	{
		$sql = "SELECT * FROM `temp_barang` ORDER BY nm_barang asc";

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

	public function get_num_where($cari)
	{
		$sql = "SELECT count(*) as jml FROM `temp_barang` WHERE kode_brg = '".$cari."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function get_num_where_id($cari)
	{
		$sql = "SELECT count(*) as jml FROM `barang` WHERE kode_brg = '".$cari."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function importdata($query)
	{
		$this->db->query($query);

		return $this->db->execute();
	}

	public function truncateTemp()
	{
		$sql ="TRUNCATE TABLE temp_barang";
		$this->db->query($sql);

		return $this->db->execute();
	}
}