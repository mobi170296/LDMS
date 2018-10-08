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
		'THEM_CONG_VAN'=>10, 
		'SUA_CONG_VAN'=>11, 
		'XOA_CONG_VAN'=>12, 
		'KIEM_DUYET_CONG_VAN'=>13, 
		'PHE_DUYET_CONG_VAN'=>14
	   ]
);
?>