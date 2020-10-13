<?php

class LapSalesOrderModel extends Model{

	public function get_data($mulai, $sampai)
	{
		$sql = "SELECT * FROM `trsalesorder` tso INNER JOIN `tblsupplier` ts ON tso.`id_supplier`=ts.`id` where (tso.deleted=0 and tso.state=0) and tso.`tgl_trans` BETWEEN '".$mulai."-01 00:00:00' and '".$sampai."-31 23:59:59' ORDER BY SUBSTRING(tso.`id_trans`,4,2) ASC, SUBSTRING(tso.`id_trans`,6,2) ASC, SUBSTRING(tso.`id_trans`,8,4) ASC";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getID($id)
	{
		$sql="SELECT det.*, DATE_FORMAT(so.tgl_trans, '%d %M %Y') as tgl_trans, cus.namaperusahaan, so.totalqty, brg.nm_barang, det.id_jenis as id_jns, jb.nm_jenis AS jns FROM `trsalesorder_detail` det INNER JOIN barang brg on brg.kode_brg=det.kode_brg INNER JOIN jenis_barang jb ON jb.id_jenis=det.id_jenis inner JOIN trsalesorder so ON det.id_trans = so.id_trans inner join tblsupplier cus ON cus.id = so.id_supplier WHERE det.id_trans='".$id."' ORDER BY brg.nm_barang ASC";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function getdet($mulai, $sampai)
	{
		$sql = "SELECT det.*, DATE_FORMAT(so.tgl_trans, '%d %M %Y') as tgl_trans, cus.namaperusahaan, so.totalqty, brg.nm_barang, det.id_jenis as id_jns, jb.nm_jenis AS jns FROM `trsalesorder_detail` det INNER JOIN barang brg on brg.kode_brg=det.kode_brg INNER JOIN jenis_barang jb ON jb.id_jenis=det.id_jenis inner JOIN trsalesorder so ON det.id_trans = so.id_trans inner join tblsupplier cus ON cus.id = so.id_supplier where (so.deleted=0 and so.state=0) and so.`tgl_trans` BETWEEN '".$mulai."-01 00:00:00' and '".$sampai."-31 23:59:59'  ORDER BY SUBSTRING(so.`id_trans`,4,2) ASC, SUBSTRING(so.`id_trans`,6,2) ASC, SUBSTRING(so.`id_trans`,8,4) ASC";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}

	public function countdet($mulai, $sampai)
	{
		$sql = "SELECT sum(det.qty) as total FROM `trsalesorder_detail` det INNER JOIN barang brg on brg.kode_brg=det.kode_brg INNER JOIN jenis_barang jb ON jb.id_jenis=det.id_jenis inner JOIN trsalesorder so ON det.id_trans = so.id_trans inner join tblsupplier cus ON cus.id = so.id_supplier where (so.deleted=0 and so.state=0) and so.`tgl_trans` BETWEEN '".$mulai."-01 00:00:00' and '".$sampai."-31 23:59:59'";

		$this->db->query($sql);

		return $this->db->execute()->toObject();
	}
}