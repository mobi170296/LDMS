<?php
define('DATABASE',
	   ['HOST'=>'localhost',
		'USERNAME'=>'root',
		'PASSWORD'=>'nguyenthithuyhang',
		'DB_NAME'=>'ldmsdb',
		'AES_KEY'=>'ottc',
		'PORT'=>3306
	   ]
);

define('PRIVILEGES',
	   ['THEM_NGUOI_DUNG' => 1,
		'SUA_NGUOI_DUNG' => 2,
		'XOA_NGUOI_DUNG' => 3, 
		
		'THEM_NHOM' => 4, 
		'SUA_NHOM' => 5, 
		'XOA_NHOM' => 6, 
		
		'CAP_QUYEN_NGUOI_DUNG'=>7,
		'CAP_QUYEN_NHOM'=>8,
		
		'THEM_DON_VI' => 9, 
		'SUA_DON_VI' => 10, 
		'XOA_DON_VI' => 11, 
		
		'THEM_LOAI_VAN_BAN'=>12, 
		'SUA_LOAI_VAN_BAN'=>13,
		'XOA_LOAI_VAN_BAN'=>14,
		
		'THEM_DON_VI_BAN_HANH'=>15,
		'SUA_DON_VI_BAN_HANH'=>16,
		'XOA_DON_VI_BAN_HANH'=>17,
		
		'THEM_CONG_VAN_DEN'=>18,
		'SUA_CONG_VAN_DEN'=>19, 
		'XOA_CONG_VAN_DEN'=>20,
		
		'KIEM_DUYET_CONG_VAN_DEN'=>21, 
		'PHE_DUYET_CONG_VAN_DEN'=>22
	   ]
);

define('PRIVILEGE_LABELS',
	   [1 => 'Thêm người dùng',
		'Sửa thông tin người dùng',
		'Xóa thông tin người dùng',
		'Thêm nhóm',
		'Sửa nhóm',
		'Xóa nhóm',
		'Cấp quyền cho người dùng',
		'Cấp quyền cho nhóm',
		'Thêm Khoa - Đơn Vị',
		'Sửa thông tin Khoa - Đơn vị',
		'Xóa thông tin Khoa - Đơn vị',
		'Thêm loại văn bản',
		'Sửa thông tin loại văn bản',
		'Xóa loại văn bản',
		'Thêm đơn vị ban hành',
		'Sửa thông tin đơn vị ban hành',
		'Xóa thông tin đơn vị ban hành',
		'Thêm công văn đến',
		'Sửa thông tin công văn đến',
		'Xóa công văn đến',
		'Kiểm duyệt công văn đến',
		'Phê duyệt công văn đến'
	   ]
);

define('LEGALDOCUMENT_STATUS',
	  [
		  'DA_NHAP' => 1,
		  'DOI_KIEM_DUYET' => 2,
		  'DA_KIEM_DUYET' => 3,
		  'DOI_PHE_DUYET' => 4,
		  'DA_PHE_DUYET' => 5
	  ]
	  );
?>