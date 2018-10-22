<?php
	#
	# prefix: $pp_
	# INP: $total, $currentpage, $uri
	#
	if($pp_pt<=11){
		# normal
		for($i=1; $i<=$pp_pt; $i++){
			echo '<a>'.$i.'</a>';
		}
	}else{
		$pp_ls = 1;
		$pp_le = 3;
		$pp_cs = $pp_cp - 2;
		$pp_ce = $pp_cp + 2;
		$pp_rs = $pp_pt - 2;
		$pp_re = $pp_pt;
		$pp_cs = max($pp_le + 1, $pp_cs);
		$pp_ce = min($pp_ce, $pp_rs - 1);
		
		for($i=$pp_ls; $i<=$pp_le; $i++){
			echo '<a>'.$i.'</a>';
		}
		if($pp_cs!=$pp_le+1){
			echo '<a>...</a>';
		}
		for($i=$pp_cs; $i<=$pp_ce; $i++){
			echo '<a>'.$i.'</a>';
		}
		if($pp_ce!=$pp_rs-1){
			echo '<a>...</a>';
		}
		for($i=$pp_rs; $i<=$pp_re; $i++){
			echo '<a>'.$i.'</a>';
		}
	}
?>