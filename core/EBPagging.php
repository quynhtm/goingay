<?php
class EBPagging{
	
	static function pagingSE(&$limit = false, $totalitem, $itemperpage, $numpageshow = 10, $page_name = 'page_no', $show_total_item = false,$itemname='',$page_label = '', $mod = false){		
		$st = '';
		$totalpage = ceil($totalitem / $itemperpage);
		if ($totalpage < 2){
			if($show_total_item){
				return '<b>Tổng số '.$totalitem.'</b> '.$itemname;
			}
			return;
		}

		if (Url::get($page_name)){
			$currentpage= Url::get($page_name);
		}
		else{
			$currentpage= 1;
		}

		$currentpage=round($currentpage);
		if($currentpage<=0 ||$currentpage>$totalpage)
		{
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>($numpageshow/2)){
			$startpage = $currentpage-floor($numpageshow/2);
			if($totalpage-$startpage<$numpageshow){
				$startpage=$totalpage-$numpageshow+1;
			}
		}
		else{
			$startpage=1;
		}
		if($startpage<1){
			$startpage=1;
		}

		$page = Url::get('page');
		$url_path = Url::build_all(array($page_name));
		$prefix = ($page == "") ? '?' : '&';
		

		//Trang hien thoi
		$st .= ''.($show_total_item?'<b>Tổng số '.$totalitem.' '.$itemname.'</b> | ':'').''.$page_label.' ';
		//Link den trang truoc
		if($currentpage>1){
			$st .= '<a href="'.$url_path.$prefix.$page_name.'='.($currentpage-1).'" class="pgPrev">';
			$st .= 'Trước</a> &nbsp;&nbsp;&nbsp;';
		}

		//Danh sach cac trang
		$st .= '';

		if($startpage>1){
			//$st .= '<a href="'.$url_path.'&'.$page_name.'='.$currentpage.'" id="pgNext">';
			$st .= '<a  href="'.$url_path.'">1</a>&nbsp;&nbsp;&nbsp;';
			if($startpage>2){
				$st .= '<strong>...</strong>';//
			}
		}

		for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++){
			if($i!=$startpage){
				$st .= '';//
			}
			if($i==$currentpage){
				if($i>1)
				{
					$st .='';
				}
				$st .= '<a href="javascript:void(0)" class="current-page" id="pgCurrent">'.$i.'</a> &nbsp;&nbsp;&nbsp;';
			}
			else{
				if($i>1)
				{
					$st .='';
				}
				$st .= '<a  href="'.$url_path.$prefix.$page_name.'='.$i.'">'.$i.'</a>&nbsp;&nbsp;&nbsp;';
			}
		}

		if($i==$totalpage){
			$st .= '<a  href="'.$url_path.$prefix.$page_name.'='.$totalpage.'">'.$totalpage.'</a> ';
		}
		else
		if($i<$totalpage){
			$st .= '<strong>...</strong><a  href="'.$url_path.$prefix.$page_name.'='.$totalpage.'">'.$totalpage.'</a> ';
		}
		$st .= '';
		//Trang sau
		if($currentpage<$totalpage){
			$st .= '<a  href="'.$url_path.$prefix.$page_name.'='.($currentpage+1).'" class="pgPrev">';
			$st .= 'Sau</a>';
		}

		$st .= '';

		return $st;
	}

	static function paging(&$limit=false,$totalitem,$itemperpage, $numpageshow=10, $page_name='page_no',$show_total_item=false,$itemname='',$page_label='',$mod=false){
		$totalpage = ceil($totalitem/$itemperpage);
		if ($totalpage<2){
			return;
		}
		if (Url::get($page_name)){
			$currentpage= Url::get($page_name);
		}
		else{
			$currentpage= 1;
		}

		$currentpage=round($currentpage);
		if($currentpage<=0 ||$currentpage>$totalpage){
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>($numpageshow/2)){
			$startpage = $currentpage-floor($numpageshow/2);
			if($totalpage-$startpage<$numpageshow)
			{
				$startpage=$totalpage-$numpageshow+1;
			}
		}
		else{
			$startpage=1;
		}
		if($startpage<1){
			$startpage=1;
		}

		$url_path = Url::build_all(array($page_name)).'&'.$page_name.'=';

		//Link den trang truoc
		if($currentpage>1){
			$st = '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'">
						<div class="pag_left_pre">
							<div class="pag_right_pre">
								<a href=\''.$url_path.($currentpage-1).'\'>Trước</a>
							</div>
						</div>
					</div>';
		}
		else{
			$st = '<div class="pag_bg_dis floatLeft ">
			<div class="pag_left_pre_dis">
				<div class="pag_right_pre_dis">	
					Trước
				</div>
			</div>
			 
			 </div>';
		}
		//Danh sach cac trang
		if($startpage>1){
			$st .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.'1">1</a>
								</div>
							</div>
						</div>
					';
			if($startpage>2){
				//$st .= '<div class="floatLeft marginLeft5" style="border:1px solid #f00"><strong>...</strong></div>';
				
				$st .= '<div class="floatLeft  pag_bg">
							<div class="pag_left">
								<div class="pag_right_dot">
									...
								</div>
							</div>
						</div>';
			}
		}

		for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++){
			/*if($i!=$startpage){$st .= '';}*/
			if($i==$currentpage){
				/*if($i>1){$st .='';}*/
				$st .= '<div class="floatLeft  pag_bg_hover">
							<div class="pag_left">
								<div class="pag_right">
									<a href="javascript:void(0);">'.$i.'</a>
								</div>
							</div>
						</div>';
			}
			else{
				/*if($i>1){$st .='';}*/
				$st .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.$i.'">'.$i.'</a>
								</div>
							</div>
						</div>';
			}
		}
		if($i==$totalpage){
			$st .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.$totalpage.'">'.$totalpage.'</a>
								</div>
							</div>
						</div>';
			
		}
		elseif($i<$totalpage){
			$st .= '<div class="floatLeft  pag_bg">
							<div class="pag_left">
								<div class="pag_right_dot">
									...
								</div>
							</div>
						</div>
					<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.$totalpage.'">'.$totalpage.'</a>
								</div>
							</div>
						</div>';
		}
		//Trang sau
		if($currentpage<$totalpage){
			$st .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'">
			<div class="pag_left_next">
				<div class="pag_right_next">	
					<a href=\''.$url_path.($currentpage+1).'\'>Sau</a>
				</div>
			</div>
			</div>';
		}
		else{
			$st .= '<div class="pag_bg_dis floatLeft ">
						<div class="pag_left_next_dis">
							<div class="pag_right_next_dis">	
								Sau
							</div>
						</div>
			 </div>';
		}

		return $st;
	}

	static function paging_next(&$limit=false,$itemperpage,$page_next=true,$page_name='page_no'){
		if (Url::get($page_name)){
			$currentpage= (int)Url::get($page_name,0);
		}
		else{
			$currentpage= 1;
		}

		if($currentpage<=0){
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.($itemperpage+1);

		$url_path = Url::build_all(array($page_name)).'&'.$page_name.'=';

		//Link den trang truoc
		if($currentpage>1){
			$st = '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'">
						<div class="pag_left_pre">
							<div class="pag_right_pre">
								<a href=\''.$url_path.($currentpage-1).'\'>Trước</a>
							</div>
						</div>
					</div>';
		}
		else{
			$st = '<div class="pag_bg_dis floatLeft ">
			<div class="pag_left_pre_dis">
				<div class="pag_right_pre_dis">	
					Trước
				</div>
			</div>
			 
			 </div>';
		}
		
		//Trang sau
		if($page_next){
			$st .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'">
			<div class="pag_left_next">
				<div class="pag_right_next">	
					<a href=\''.$url_path.($currentpage+1).'\'>Sau</a>
				</div>
			</div>
			</div>';
		}
		else{
			$st .= '<div class="pag_bg_dis floatLeft ">
						<div class="pag_left_next_dis">
							<div class="pag_right_next_dis">	
								Sau
							</div>
						</div>
			 </div>';
		}

		return $st;
	}

	static function paging_new(&$limit=false,$totalitem,$itemperpage, $page_name='page_no',$url_new='',$show_total_item=false,$itemname='',$page_label='',$mod=false){
		$totalpage = ceil($totalitem/$itemperpage);
		if ($totalpage<2){
			return;
		}

		if (Url::get($page_name)){
			$currentpage= Url::get($page_name);
		}
		else{
			$currentpage= 1;
		}

		$currentpage=round($currentpage);
		if($currentpage<=0 ||$currentpage>$totalpage){
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>3){
			$startpage = $currentpage-3;
			
			if($totalpage-$startpage<7){
				$startpage=$totalpage-7+1;
			}
		}
		else{
			$startpage=1;
		}
		if($startpage<1){
			$startpage=1;
		}

		/*$startpage = $currentpage-3;
			
		if($totalpage-$startpage<7){
			$startpage=$totalpage-7+1;
		}*/
		
		if($url_new){
			$url_path = $url_new.'&'.$page_name.'=';
		}
		else{
			$url_path = Url::build_all(array($page_name)).'&'.$page_name.'=';
		}

		//Link den trang truoc
		if($currentpage>1){
			$paging_str = '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'">
						<div class="pag_left_pre">
							<div class="pag_right_pre">
								<a href=\''.$url_path.($currentpage-1).'\'>Trước</a>
							</div>
						</div>
					</div>';
		}
		else{
			$paging_str = '<div class="pag_bg_dis floatLeft ">
			<div class="pag_left_pre_dis">
				<div class="pag_right_pre_dis">	
					Trước
				</div>
			</div>
			 
			 </div>';
		}
		
		//Danh sach cac trang
		
		if($startpage>1){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.'1">1</a>
								</div>
							</div>
						</div>';
		}
		if($startpage>2){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.'2">2</a>
								</div>
							</div>
						</div>';
		}
		if($startpage>3){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.'3">3</a>
								</div>
							</div>
						</div>';
		}
		
		if($startpage>4){
			$paging_str .= '<div class="floatLeft  pag_bg">
						<div class="pag_left">
							<div class="pag_right_dot">
								...
							</div>
						</div>
					</div>';
		}
			
			
		
		for($i=$startpage; $i<=$startpage+6 && $i<=$totalpage; $i++){
			//if($i>=1 && (($currentpage==1 && $i<4) || $currentpage>1))
			{
				if($i==$currentpage){
					$paging_str .= '<div class="floatLeft pag_bg_hover pag_bg_current">
								<div class="pag_left">
									<div class="pag_right">
										<a href="javascript:void(0);">'.$i.'</a>
									</div>
								</div>
							</div>';
				}
				else{
					$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
								<div class="pag_left">
									<div class="pag_right">
										<a  href="'.$url_path.$i.'">'.$i.'</a>
									</div>
								</div>
							</div>';
				}
			}
		}
		
		if($i<=8 && $totalpage>=8){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
								<div class="pag_left">
									<div class="pag_right">
										<a  href="'.$url_path.'8">8</a>
									</div>
								</div>
							</div>';
			$i++;
		}
		
		if($i<=9 && $totalpage>=9){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.'9">9</a>
								</div>
							</div>
						</div>';
			$i++;
		}
		
		if($i<=10 && $totalpage>=10){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.'10">10</a>
								</div>
							</div>
						</div>';
			$i++;
		}
		
		if($i==$totalpage){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.$totalpage.'">'.$totalpage.'</a>
								</div>
							</div>
						</div>';
			
		}
		elseif($i<$totalpage){
			$paging_str .= '<div class="floatLeft  pag_bg">
							<div class="pag_left">
								<div class="pag_right_dot">
									...
								</div>
							</div>
						</div>';
		}
		
		//Trang sau
		if($currentpage<$totalpage){
			$paging_str .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'">
			<div class="pag_left_next">
				<div class="pag_right_next">	
					<a href=\''.$url_path.($currentpage+1).'\'>Sau</a>
				</div>
			</div>
			</div>';
		}
		else{
			$paging_str .= '<div class="pag_bg_dis floatLeft ">
						<div class="pag_left_next_dis">
							<div class="pag_right_next_dis">	
								Sau
							</div>
						</div>
			 		</div>';
		}

		return $paging_str;
	}

    static function paging_list(&$limit=false,$itemperpage, $page_name='page_no',$url_path=''){
		$currentpage = (int)Url::get($page_name);

		if($currentpage<=0){
			$currentpage = 1;
		}
        elseif($currentpage>200){
           $currentpage = 200;
        }

        if($currentpage<=6){
            $totalpage = 11;
        }
        else{
            $totalpage = ($currentpage + 4)<200?($currentpage + 4):200;
        }

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>3){
			$startpage = $currentpage-3;

			if($totalpage-$startpage<7){
				$startpage = $totalpage-7+1;
			}
		}
		else{
			$startpage=1;
		}

		if($startpage<1){
			$startpage=1;
		}

		if($url_path==''){
			$url_path = Url::build_all(array($page_name));
		}

		//Link den trang truoc
		if($currentpage>1){
			$paging_str = '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'">
						<div class="pag_left_pre">
							<div class="pag_right_pre">
								<a href=\''.$url_path.($currentpage>2?'&'.$page_name.'='.($currentpage-1):'').'\'>Trước</a>
							</div>
						</div>
					</div>';
		}
		else{
			$paging_str = '<div class="pag_bg_dis floatLeft ">
			<div class="pag_left_pre_dis">
				<div class="pag_right_pre_dis">
					Trước
				</div>
			</div>

			 </div>';
		}

		//Danh sach cac trang

        $i = 1;
        while($i<=4){
            if($startpage>$i){
                if($i < 4){
                    $paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
                                <div class="pag_left">
                                    <div class="pag_right">
                                        <a  href="'.$url_path.( $i>1 ?'&'.$page_name.'='.$i : '').'">'.$i.'</a>
                                    </div>
                                </div>
                            </div>';
                }
                else{
                      $paging_str .= '<div class="floatLeft  pag_bg">
                            <div class="pag_left">
                                <div class="pag_right_dot">
                                    ...
                                </div>
                            </div>
                        </div>';
                }
            }
            $i++;
        }

        for($i=$startpage; $i<=$startpage+6 && $i<= $totalpage; $i++){
            if($i==$currentpage){
                $paging_str .= '<div class="floatLeft pag_bg_hover pag_bg_current">
                            <div class="pag_left">
                                <div class="pag_right">
                                    <a href="'.$url_path.( $i>1 ?'&'.$page_name.'='.$i : '').'">'.$i.'</a>
                                </div>
                            </div>
                        </div>';
            }
            else{
                $paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
                            <div class="pag_left">
                                <div class="pag_right">
                                    <a  href="'.$url_path.( $i>1 ?'&'.$page_name.'='.$i : '').'">'.$i.'</a>
                                </div>
                            </div>
                        </div>';
            }
		}
         
        $j = 8;
        while($j <= 10){
            if($i <= $j && $i <= 10){
                $paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
								<div class="pag_left">
									<div class="pag_right">
										<a  href="'.$url_path.'&'.$page_name.'='.$j.'">'.$j.'</a>
									</div>
								</div>
							</div>';
                if($i < 10){
                    $i++;
                }
            }
            $j++;
        }
       
		if($i > 201){
			$paging_str .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="'.$url_path.'&'.$page_name.'=200">200</a>
								</div>
							</div>
						</div>';
		}
		elseif($i < 201){
			$paging_str .= '<div class="floatLeft  pag_bg">
							<div class="pag_left">
								<div class="pag_right_dot">
									...
								</div>
							</div>
						</div>';
		}

		//Trang sau
		if($currentpage < 200){
			$paging_str .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'">
			<div class="pag_left_next">
				<div class="pag_right_next">
					<a href=\''.$url_path.'&'.$page_name.'='.($currentpage+1).'\'>Sau</a>
				</div>
			</div>
			</div>';
		}
		else{
			$paging_str .= '<div class="pag_bg_dis floatLeft ">
						<div class="pag_left_next_dis">
							<div class="pag_right_next_dis">
								Sau
							</div>
						</div>
			 		</div>';
		}

		return $paging_str;
	}
	static function bm_paging_list(&$limit=false,$itemperpage, $page_name='page_no',$url_path=''){
		$currentpage = (int)Url::get($page_name);

		if($currentpage<=0){
			$currentpage = 1;
		}
        elseif($currentpage>200){
           $currentpage = 200;
        }

        if($currentpage<=6){
            $totalpage = 11;
        }
        else{
            $totalpage = ($currentpage + 4)<200?($currentpage + 4):200;
        }

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>3){
			$startpage = $currentpage-3;

			if($totalpage-$startpage<7){
				$startpage = $totalpage-7+1;
			}
		}
		else{
			$startpage=1;
		}

		if($startpage<1){
			$startpage=1;
		}

		if($url_path==''){
			$url_path = Url::build_all(array($page_name));
		}

		//Link den trang truoc
		if($currentpage>1){
			$paging_str = '<a class="page_item page_prev" href=\''.$url_path.($currentpage>2?'&'.$page_name.'='.($currentpage-1):'').'\'></a>';
		}
		else{
			$paging_str = '<a class="page_item page_prev" href="javascript:void(0)"></a>';
		}

		//Danh sach cac trang

        $i = 1;
        while($i<=4){
            if($startpage>$i){
                if($i < 4){
                    $paging_str .= '<a class="page_item" href="'.$url_path.( $i>1 ?'&'.$page_name.'='.$i : '').'">'.$i.'</a>';
                }
                else{
                      $paging_str .= '<a class="page_item" href="javascript:void(0)">...</a>';
                }
            }
            $i++;
        }

        for($i=$startpage; $i<=$startpage+6 && $i<= $totalpage; $i++){
            if($i==$currentpage){
                $paging_str .= '<a class="page_item" href="'.$url_path.( $i>1 ?'&'.$page_name.'='.$i : '').'">'.$i.'</a>';
            }
            else{
                $paging_str .= '<a class="page_item" href="'.$url_path.( $i>1 ?'&'.$page_name.'='.$i : '').'">'.$i.'</a>';
            }
		}
         
        $j = 8;
        while($j <= 10){
            if($i <= $j && $i <= 10){
                $paging_str .= '<a class="page_item" href="'.$url_path.'&'.$page_name.'='.$j.'">'.$j.'</a>';
                if($i < 10){
                    $i++;
                }
            }
            $j++;
        }
       
		if($i > 201){
			$paging_str .= '<a class="page_item" href="'.$url_path.'&'.$page_name.'=200">200</a>';
		}
		elseif($i < 201){
			$paging_str .= '<a class="page_item" href="javascript:void(0)">...</a>';
		}

		//Trang sau
		if($currentpage < 200){
			$paging_str .= '<a class="page_item page_next" href=\''.$url_path.'&'.$page_name.'='.($currentpage+1).'\'></a>';
		}
		else{
			$paging_str .= '<a href="javascript:void(0)" class="page_item page_next"></a>';
		}

		return $paging_str;
	}

	static function AjaxPaging(&$limit='',$totalitem, $itemperpage, $numpageshow=10, $page_name='page_no',$page_label='Trang',$show_total_item=false,$itemname='mục',$url_path='',$div_id='',$show_list_page=false){
		$st = '';
		$totalpage = ceil($totalitem/$itemperpage);
		if ($totalpage<2){
			return;
		}

		if (Url::get($page_name)){
			$currentpage= Url::get($page_name);
		}
		else{
			$currentpage= 1;
		}

		$currentpage=round($currentpage);
		if($currentpage<=0 ||$currentpage>$totalpage){
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.$itemperpage;

		if($currentpage>($numpageshow/2)){
			$startpage = $currentpage-floor($numpageshow/2);
			if($totalpage-$startpage<$numpageshow){
				$startpage=$totalpage-$numpageshow+1;
			}
		}
		else{
			$startpage=1;
		}
		if($startpage<1){
			$startpage=1;
		}

		if($url_path!='')
		$url_path.='&'.$page_name.'=';
		else
		$url_path='?'.$page_name.'=';
		
		//Trang hien thoi
		$st .= ''.($show_total_item?'T&#7893;ng c&#243; '.$totalitem.' '.$itemname.' | ':'').''.$page_label.' ';
		
		if($show_list_page){
			//Link den trang truoc
			if($currentpage>1){

			
				$st .= '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'" onclick="ajax_paging(\''.$url_path.($currentpage-1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
						<div class="pag_left_pre">
							<div class="pag_right_pre">
								<a href=\'javascript:void(0)\'>Trước</a>
							</div>
						</div>
					</div>';
			}
			else{
				$st .= '<div class="pag_bg_dis floatLeft ">
			<div class="pag_left_pre_dis">
				<div class="pag_right_pre_dis">	
					Trước
				</div>
			</div>
			 
			 </div>';
			}
			//Danh sach cac trang
			if($startpage>1){

				$st .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'"  onclick = "ajax_paging(\''.$url_path.'1\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
							<div class="pag_left">
								<div class="pag_right">
									<a href="javascript:void(0);">1</a>
								</div>
							</div>
						</div>';
				
				
				if($startpage>2){
					$st .= '<div class="floatLeft  pag_bg">
							<div class="pag_left">
								<div class="pag_right_dot">
									...
								</div>
							</div>
						</div>';
				}
			}
	
			for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++){
				/*if($i!=$startpage){$st .= '';}*/
				if($i==$currentpage){
					/*if($i>1){$st .='';}*/
					
					$st .= '<div class="floatLeft  pag_bg_hover">
							<div class="pag_left">
								<div class="pag_right">
									<a href="javascript:void(0);">'.$i.'</a>
								</div>
							</div>
						</div>';
				}
				else{
					/*if($i>1){$st .='';}*/
					$st .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'" onclick = "ajax_paging(\''.$url_path.$i.'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
							<div class="pag_left">
								<div class="pag_right">
									<a href="javascript:void(0);" >'.$i.'</a>
								</div>
							</div>
						</div>';
				}
			}
			if($i==$totalpage){
				
				$st .= '<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'" onclick = "ajax_paging(\''.$url_path.$totalpage.'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="javascript:void(0);" >'.$totalpage.'</a>
								</div>
							</div>
						</div>';
				
			}
			elseif($i<$totalpage){
				$st .= '<div class="floatLeft  pag_bg">
							<div class="pag_left">
								<div class="pag_right_dot">
									...
								</div>
							</div>
						</div>
						
						
						<div class="floatLeft  pag_bg" onmouseover="javascript:this.className=\'floatLeft  pag_bg_hover\'" onmouseout="javascript:this.className=\'floatLeft  pag_bg\'" onclick = "ajax_paging(\''.$url_path.$totalpage.'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
							<div class="pag_left">
								<div class="pag_right">
									<a  href="javascript:void(0);" >'.$totalpage.'</a>
								</div>
							</div>
						</div>
						
						';
				
			}
			//Trang sau
			if($currentpage<$totalpage){
				
				$st .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'" onclick="ajax_paging(\''.$url_path.($currentpage+1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
			<div class="pag_left_next">
				<div class="pag_right_next">	
					<a href="javascript:void(0);">Sau</a>
				</div>
			</div>
			</div>';
				
			}
			else{
				$st .= '<div class="pag_bg_dis floatLeft ">
						<div class="pag_left_next_dis">
							<div class="pag_right_next_dis">	
								Sau
							</div>
						</div>
			 </div>';
			}
		}
		else{// neu khong co list so
			//Link den trang truoc
			if($currentpage>1){

			
				$st .= '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'" onclick="ajax_paging(\''.$url_path.($currentpage-1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
						<div class="pag_left_pre">
							<div class="pag_right_pre">
								<a href=\'javascript:void(0)\'>Trước</a>
							</div>
						</div>
					</div>';
			}
			else{
				$st .= '<div class="pag_bg_dis floatLeft ">
			<div class="pag_left_pre_dis">
				<div class="pag_right_pre_dis">	
					Trước
				</div>
			</div>
			 
			 </div>';
			}
			//Trang sau
			if($currentpage<$totalpage){
				
				$st .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'" onclick="ajax_paging(\''.$url_path.($currentpage+1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
			<div class="pag_left_next">
				<div class="pag_right_next">	
					<a href="javascript:void(0);">Sau</a>
				</div>
			</div>
			</div>';
				
			}
			else{
				$st .= '<div class="pag_bg_dis floatLeft ">
						<div class="pag_left_next_dis">
							<div class="pag_right_next_dis">	
								Sau
							</div>
						</div>
			 </div>';
			}
		}
		return $st;
	}

	static function AjaxPagingNext(&$limit='',$itemperpage,$next_page=false, $page_name='page_no',$url_path='',$div_id=''){
		$st = '';
		
		if (Url::get($page_name)){
			$currentpage= (int)Url::get($page_name);
		}
		else{
			$currentpage= 1;
		}

		if($currentpage<=0){
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.($itemperpage+1);

		if($url_path!='')
			$url_path.='&'.$page_name.'=';
		else
			$url_path='?'.$page_name.'=';
		
		//Link den trang truoc
		if($currentpage>1){
			$st .= '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'" onclick="ajax_paging(\''.$url_path.($currentpage-1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
					<div class="pag_left_pre">
						<div class="pag_right_pre">
							<a href=\'javascript:void(0)\'>Trước</a>
						</div>
					</div>
				</div>';
		}
		else{
			$st .= '<div class="pag_bg_dis floatLeft ">
					<div class="pag_left_pre_dis">
						<div class="pag_right_pre_dis">	
							Trước
						</div>
					</div>
					 
					 </div>';
		}
		
		//Trang sau
		if($next_page){
			$st .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'" onclick="ajax_paging(\''.$url_path.($currentpage+1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
					<div class="pag_left_next">
						<div class="pag_right_next">	
							<a href="javascript:void(0);">Sau</a>
						</div>
					</div>
					</div>';
			
		}
		else{
			$st .= '<div class="pag_bg_dis floatLeft ">
					<div class="pag_left_next_dis">
						<div class="pag_right_next_dis">	
							Sau
						</div>
					</div>
		 </div>';
		}
		return $st;
	}
	static function fb_pagging(&$limit='',$itemperpage,$next_page=false, $page_name='page_no',$url_path='',$div_id=''){
		$st = '';
		
		if (Url::get($page_name)){
			$currentpage= (int)Url::get($page_name);
		}
		else{
			$currentpage= 1;
		}

		if($currentpage<=0){
			$currentpage=1;
		}

		$limit=' LIMIT '.(($currentpage-1)*$itemperpage).','.($itemperpage+1);

		if($url_path!='')
			$url_path.='&'.$page_name.'=';
		else
			$url_path='?'.$page_name.'=';
		
		//Link den trang truoc
		if($currentpage>1){
			$st .= '<div class="pag_bg floatLeft" onmouseout="this.className=\'pag_bg floatLeft\'" onmouseover="this.className=\'pag_bg_hover floatLeft\'" onclick="fb_paging(\''.$url_path.($currentpage-1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
					<div class="pag_left_pre">
						<div class="pag_right_pre">
							<a href=\'javascript:void(0)\'>Trước</a>
						</div>
					</div>
				</div>';
		}
		else{
			$st .= '<div class="pag_bg_dis floatLeft ">
					<div class="pag_left_pre_dis">
						<div class="pag_right_pre_dis">	
							Trước
						</div>
					</div>
					 
					 </div>';
		}
		
		//Trang sau
		if($next_page){
			$st .= '<div class="pag_bg floatLeft " onmouseout="this.className=\'pag_bg floatLeft \'" onmouseover="this.className=\'pag_bg_hover floatLeft \'" onclick="fb_paging(\''.$url_path.($currentpage+1).'\',\''.$div_id.'\',\''.$url_path.$currentpage.'\'); return false;">
					<div class="pag_left_next">
						<div class="pag_right_next">	
							<a href="javascript:void(0);">Sau</a>
						</div>
					</div>
					</div>';
			
		}
		else{
			$st .= '<div class="pag_bg_dis floatLeft ">
					<div class="pag_left_next_dis">
						<div class="pag_right_next_dis">	
							Sau
						</div>
					</div>
		 </div>';
		}
		return $st;
	}
}
?>