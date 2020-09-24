<?php

class SalesOrderModel extends Model{

	public function get_data()
	{
		$sql = "SELECT * FROM `trsalesorder` tso INNER JOIN `tblsupplier` ts ON tso.`id_supplier`=ts.`id` where tso.deleted=0 and tso.state=0 ORDER BY SUBSTRING(tso.`id_trans`,4,2) ASC, SUBSTRING(tso.`id_trans`,6,2) ASC";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function get_barang($id)
	{
		$sql = "SELECT * FROM `barang` WHERE id_barang='".$id."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getID($id)
	{
		$sql = "SELECT det.*, brg.nm_barang, det.id_jenis as id_jns, jb.nm_jenis AS jns FROM `trsalesorder_detail` det INNER JOIN barang brg on brg.kode_brg=det.kode_brg INNER JOIN jenis_barang jb ON jb.id_jenis=det.id_jenis WHERE det.id_trans='".$id."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getCustEdit($id)
	{
		$sql = "SELECT * FROM `trsalesorder` tso INNER JOIN `tblsupplier` ts ON ts.id = tso.`id_supplier` WHERE tso.`id_trans`='".$id."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getJenisEdit($id)
	{
		$sql = "SELECT det.*, jb.nm_jenis FROM trsalesorder_detail det INNER JOIN `jenis_barang` jb ON jb.id_jenis = det.id_jenis WHERE tso.`id_trans`='".$id."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getCustomer()
	{
		$sql = "SELECT * FROM `tblsupplier` WHERE `namaperusahaan`<>'' order by namaperusahaan asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getJenis()
	{
		$sql = "SELECT * FROM `jenis_barang` order by nm_jenis asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function deleteData($id)
	{
		$query = $this->db->update('trsalesorder', array('deleted' => '1'), array('id_trans' => $id));
		return $query;
	}

	public function postingData($id)
	{
		$query = $this->db->update('trsalesorder', array('state' => '1'), array('id_trans' => $id));
		return $query;
	}

	public function completebarang($title){
		$sql = "SELECT * FROM `barang` WHERE kode_brg='".$title."' OR `id_barang` like '%".$title."%' order by id_barang asc";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function saveMaster($data)
	{
		$query = $this->db->insert('trsalesorder', $data);
		return $query;
	}

	public function updateMaster($data, $where)
	{
		$query = $this->db->update('trsalesorder', $data, array('id_trans' => $where));
		return $query;
	}

	public function saveDetail($data)
	{
		$query = $this->db->insert('trsalesorder_detail', $data);
		return $query;
	}

	public function updateDetail($data, $where)
	{
		$query = $this->db->update('trsalesorder_detail', $data, array('id_detail' => $where));
		return $query;
	}

	public function deleteDetail($iddet)
	{
		$query = $this->db->delete('trsalesorder_detail', array('id_detail' => $iddet));
		return $query;
	}

	public function getBarang($kode)
	{
		$sql = "SELECT * FROM `barang` WHERE kode_brg='".$kode."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function kodeoto()
	{
		$jum = "SELECT * from trsalesorder";
		$this->db->query($jum);

		if ($this->db->execute()->numrows() > 0) {
			//kode awal
			$sql = "SELECT CONCAT('PMB', SUBSTRING(YEAR(CURRENT_DATE),3,2), IF(MONTH(CURRENT_DATE)<10, CONCAT('0',MONTH(CURRENT_DATE)), 
			MONTH(CURRENT_DATE)), 
			(CASE WHEN LENGTH(IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1)) = '1' 
			THEN CONCAT('000', IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1)) 
			WHEN LENGTH(IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1)) = '2' 
			THEN CONCAT('00', IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1)) 
			WHEN LENGTH(IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1)) = '3' 
			THEN CONCAT('0', IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1)) 
			WHEN LENGTH(IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1)) = '4' 
			THEN IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1) END)) AS awal ,
			IFNULL(MAX(SUBSTRING(id_trans, 8, 4))+1, 1) AS id 
			FROM trsalesorder
			WHERE (SUBSTRING(id_trans,4,2)=SUBSTRING(YEAR(CURRENT_DATE),3,2)) AND (SUBSTRING(id_trans,6,2)=MONTH(CURRENT_DATE))";
		} else {
			//kode lanjut
			$sql = "SELECT concat('PMB',SUBSTRING(CURRENT_DATE,3,2), SUBSTRING(CURRENT_DATE,6,2),'0001') as awal";
		}
		
		$this->db->query($sql);
		return $this->db->execute()->toObject();
	}
}