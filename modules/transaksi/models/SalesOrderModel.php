<?php

class SalesOrderModel extends Model{

	public function get_data()
	{
		$sql = "SELECT * FROM `trbelipesan` tso INNER JOIN `tblsupplier` ts ON tso.`id_supplier`=ts.`id` where tso.deleted=0 and tso.state=0 ORDER BY SUBSTRING(tso.`id_trans`,4,2) ASC, SUBSTRING(tso.`id_trans`,6,2) ASC";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getCustomer()
	{
		$sql = "SELECT * FROM `tblsupplier` WHERE `namaperusahaan`<>'' order by namaperusahaan asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function deleteData($id)
	{
		$query = $this->db->update('trbelipesan', array('deleted' => '1'), array('id_trans' => $id));
		return $query;
	}

	public function postingData($id)
	{
		$query = $this->db->update('trbelipesan', array('state' => '1'), array('id_trans' => $id));
		return $query;
	}

	public function completebarang($title){
		$sql = "SELECT * FROM `barang` WHERE `id_barang` like '%".$title."%' order by id_barang asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}
}