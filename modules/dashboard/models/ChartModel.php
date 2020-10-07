<?php

class ChartModel extends Model{

    public function getChart(){
        $sql = "SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='01'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='02'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='03'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='04'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='05'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='06'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='07'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='08'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='09'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='10'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='11'
        UNION ALL
        SELECT SUM(totalqty) AS totalbulan FROM trsalesorder WHERE deleted = 0 and SUBSTRING(tgl_trans,1,4) = SUBSTRING(NOW(),1,4) AND SUBSTRING(tgl_trans,6,2)='12'";

		$this->db->query($sql);

		return $this->db->execute()->toArray();
    }
}