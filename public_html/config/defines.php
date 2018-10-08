<?php
define('DATABASE',
	   ['HOST'=>'localhost',
		'USERNAME'=>'root',
		'PASSWORD'=>'nguyenthithuyhang',
		'NAME'=>'ldmsdb',
		'AES_KEY'=>'ottc',
		'PORT'=>'3306'
	   ]
);


define('PRIVILEGES',
	   ['THEM_NGUOI_DUNG' => 1,
		'SUA_NGUOI_DUNG' => 2,
		'XOA_NGUOI_DUNG' => 3, 
		'THEM_NHOM' => 4, 
		'SUA_NHOM' => 5, 
		'XOA_NHOM' => 6, 
		'THEM_DON_VI' => 7, 
		'SUA_DON_VI' => 8, 
		'XOA_DON_VI' => 9, 
		'THEM_LOAI_VAN_BAN'=>10, 
		'SUA_LOAI_VAN_BAN'=>11,
		'XOA_LOAI_VAN_BAN'=>12,
		'THEM_DON_VI_BAN_HANH'=>13,
		'SUA_DON_VI_BAN_HANH'=>14,
		'XOA_DON_VI_BAN_HANH'=>15,
		'THEM_CONG_VAN'=>16,
		'SUA_CONG_VAN'=>17, 
		'XOA_CONG_VAN'=>18, 
		'KIEM_DUYET_CONG_VAN'=>19, 
		'PHE_DUYET_CONG_VAN'=>20
	   ]
);
?>