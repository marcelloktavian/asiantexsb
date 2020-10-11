<?php

class LapSalesOrderModel extends Model{

	public function get_data()
	{
		$sql = "SELECT * FROM `trsalesorder` tso INNER JOIN `tblsupplier` ts ON tso.`id_supplier`=ts.`id` where tso.deleted=0 and tso.state=0 ORDER BY SUBSTRING(tso.`id_trans`,4,2) DESC, SUBSTRING(tso.`id_trans`,6,2) DESC, SUBSTRING(tso.`id_trans`,8,4) DESC";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getID($id)
	{
		$sql = "SELECT det.*, brg.nm_barang, det.id_jenis as id_jns, jb.nm_jenis AS jns FROM `trsalesorder_detail` det INNER JOIN barang brg on brg.kode_brg=det.kode_brg INNER JOIN jenis_barang jb ON jb.id_jenis=det.id_jenis WHERE det.id_trans='".$id."'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}
}