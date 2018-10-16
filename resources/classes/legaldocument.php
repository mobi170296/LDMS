<?php
	require_once __DIR__.'/legaldocumentinfo.php';
	class LegalDocument{
		private $dbcon;
		public function __construct($dbcon){
			$this->dbcon = $dbcon;
		}
		public function getDBConnection(){
			return $this->dbcon;
		}
		public function getLegalDocumentByID($id){
			$result = $this->dbcon->lockRow('SELECT * FROM congvanden WHERE id='.$id);
			if($result->num_rows){
				$doc = $result->fetch_assoc();
				$docinfo = new LegalDocumentInfo(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
				foreach($doc as $k => $v){
					$docinfo->$k = $v;
				}
				return $docinfo;
			}else{
				throw new NotExistedLegalDocument('Không tồn tại công văn này');
			}
		}
	}
?>