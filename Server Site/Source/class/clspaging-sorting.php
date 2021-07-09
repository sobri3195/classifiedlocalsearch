<?php
	
		class paging_sorting 
		
		{ 
			public static $order_field;
			public static $order_type;
			public static $current_page;
			public static $record_offset = 0;
			public static $page_size;
			public static $total_records;
			
			public static function set_page_details( $object, $condition='', $order_field = '', $order_type = '', $page_size = 0) {
				$arrecord = array();
				self::$order_field = $order_field;
				if ( isset($_REQUEST['hdnorder_field']) && empty($_REQUEST['hdnorder_field']) == false ) {
					self::$order_field = trim($_REQUEST['hdnorder_field']);
				}
				self::$order_type = $order_type;
				if ( isset($_REQUEST['hdnorder_type']) && empty($_REQUEST['hdnorder_type']) == false ) {
					self::$order_type = trim($_REQUEST['hdnorder_type']);
				}
				self::$current_page = 1;
				if ( isset($_REQUEST['current_page']) && empty($_REQUEST['current_page']) == false ) {
					self::$current_page = intval($_REQUEST['current_page']);
				}
				if ( isset($_REQUEST['current_offset']) && empty($_REQUEST['current_offset']) == false ) {
					self::$record_offset = intval($_REQUEST['current_offset']);					
				}
				self::$page_size = DEFAULT_PAGE_SIZE;
				if ( intval($page_size) > 0 ) {
					self::$page_size = $page_size;	
				}
				$recordset = $object->get_recordset($condition, self::$order_field, self::$order_type, self::$record_offset, self::$page_size);
				if ( $recordset && mysql_num_rows($recordset) ) {
					while ( $record = mysql_fetch_assoc($recordset) ) {
						$arrecord[] = $record;	
					}
				}
				mysql_free_result($recordset);
				$strquery = 'SELECT FOUND_ROWS() total_records';
				$rstotal_records = mysql_query($strquery) or die(mysql_error());
				if ( $rstotal_records && mysql_num_rows($rstotal_records) ) {
					paging_sorting::$total_records = (int) mysql_result($rstotal_records, 0, 'total_records');
				}
				mysql_free_result($rstotal_records);
				return $arrecord;
			}
						
			public static function show_paging_panel ( ) {
				$inttotal_page = ceil(self::$total_records / self::$page_size);
				if($inttotal_page > 1) {
					$intfirst_page = 1;
					$intprevious_page = self::$current_page - 1;
					$intnext_page = self::$current_page + 1;
					$intlast_page = $inttotal_page;
					for ( $intcounter = 0; $intcounter < $inttotal_page; $intcounter++ ) {
						if ( $intcounter == 0 ) { //first page js parameter
							$intfirst_page_js_parameter = ( $intcounter + 1 ) . '|' . ( $intcounter * self::$page_size );
						}
						
						if ( ($intcounter  + 1) == $inttotal_page ) { //last page js parameter
							$intlast_page_js_parameter = ( $intcounter + 1 ) . '|' . ( $intcounter * self::$page_size );
						}
						
						if ( $intcounter == ( self::$current_page -  1 ) ) { //previous page js parameter
							$intprevious_page_js_parameter = ( $intcounter ) . '|' . ( ( $intcounter - 1 ) * self::$page_size );
						}
						
						if ( $intcounter == ( self::$current_page ) ) { //next page js parameter
							$intnext_page_js_parameter = ( $intcounter + 1 ) . '|' . ( ( $intcounter ) * self::$page_size );
						}
					}
?>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td align="left" valign="middle">
<?php
								if ( self::$current_page > 0 && $intfirst_page != self::$current_page ) {
?>
									<a href="javascript:void(0)" onclick="set_current_page('<?php echo $intfirst_page_js_parameter; ?>');"><img src="<?php echo ADMIN_THEME; ?>images/arrow_back_disabled.gif" alt="" /></a>
<?php
								}
								else {
?>
									<img src="<?php echo ADMIN_THEME; ?>images/arrow_back_disabled.gif" alt="" />
<?php
								}
?>
							</td>
							<td align="left" valign="top" width="10">&nbsp;</td>
							<td align="left" valign="middle">
<?php
								if ( self::$current_page > 0 && $intprevious_page > 0 ) {
?>
									<a href="javascript:void(0)" onclick="set_current_page('<?php echo $intprevious_page_js_parameter; ?>');"><img src="<?php echo ADMIN_THEME; ?>images/arrow_first_1_disabled.gif" alt="" /></a>
<?php
								}
								else {
?>
									<img src="<?php echo ADMIN_THEME; ?>images/arrow_first_1_disabled.gif" alt="" />
<?php
								}
?>
							</td>
							<td align="left" valign="top" width="10">&nbsp;</td>
							<td align="left" valign="middle">
<?php
								if ( self::$current_page > 0 ) {
?>								
									<strong>Page <?php echo self::$current_page; ?> of <?php echo $inttotal_page; ?></strong>
<?php
								}
								else {
?>
									<strong>All Records</strong>
<?php
								}
?>
							</td>
							<td align="left" valign="top" width="10">&nbsp;</td>
							<td align="left" valign="middle">
<?php
								if ( self::$current_page > 0 && $intnext_page <= $inttotal_page ) {
?>
								<a href="javascript:void(0)" onclick="set_current_page('<?php echo $intnext_page_js_parameter; ?>'); "><img src="<?php echo ADMIN_THEME; ?>images/arrow_next_disabled.gif" alt="" /></a>
<?php
								}
								else {
?>
									<img src="<?php echo ADMIN_THEME; ?>images/arrow_next_disabled.gif" alt="" />
<?php
								}
?>
							</td>
							<td align="left" valign="top" width="10">&nbsp;</td>
							<td align="left" valign="middle">
<?php
								if ( self::$current_page > 0 && $intlast_page != self::$current_page ) {
?>
								<a href="javascript:void(0)" onclick="set_current_page('<?php echo $intlast_page_js_parameter; ?>');"><img src="<?php echo ADMIN_THEME; ?>images/arrow_last_1_disabled.gif" alt="" /></a>
<?php
								}
								else {
?>
									<img src="<?php echo ADMIN_THEME; ?>images/arrow_last_1_disabled.gif" alt="" />
<?php
								}
?>
							</td>
							<td align="left" valign="top" width="20">&nbsp;</td>
							<td align="left" valign="middle">Go to page:</td>
							<td align="left" valign="top" width="10">&nbsp;</td>
							<td align="left" valign="top">
								<select name="selpage" id="selpage" onchange="set_current_page(this.value);" class="paging-select">
<?php
									for ( $intcounter = 0; $intcounter < $inttotal_page; $intcounter++ ) {
?>
										<option value="<?php echo $intcounter + 1; ?>|<?php echo (int) $intcounter * self::$page_size; ?>" <?php if ( ($intcounter+1) == self::$current_page ) echo 'selected="selected"'; ?>>
											<?php echo $intcounter+1;  ?>
										</option>
<?php
									}
?>
									<!--<option value="all" <?php //if(self::$current_page == -1) echo 'selected="selected"'; ?>>All</option> -->
								</select>
							</td>
						</tr>
					</table>
<?php
				}
			}
			
			public static function show_paging_panel2 ( ) {
				$inttotal_page = ceil(self::$total_records / self::$page_size);
				if($inttotal_page > 1) {
					$intfirst_page = 1;
					$intprevious_page = self::$current_page - 1;
					$intnext_page = self::$current_page + 1;
					$intlast_page = $inttotal_page;
					for ( $intcounter = 0; $intcounter < $inttotal_page; $intcounter++ ) {
						if ( $intcounter == 0 ) { //first page js parameter
							$intfirst_page_js_parameter = ( $intcounter + 1 ) . '|' . ( $intcounter * self::$page_size );
						}
						
						if ( ($intcounter  + 1) == $inttotal_page ) { //last page js parameter
							$intlast_page_js_parameter = ( $intcounter + 1 ) . '|' . ( $intcounter * self::$page_size );
						}
						
						if ( $intcounter == ( self::$current_page -  1 ) ) { //previous page js parameter
							$intprevious_page_js_parameter = ( $intcounter ) . '|' . ( ( $intcounter - 1 ) * self::$page_size );
						}
						
						if ( $intcounter == ( self::$current_page ) ) { //next page js parameter
							$intnext_page_js_parameter = ( $intcounter + 1 ) . '|' . ( ( $intcounter ) * self::$page_size );
						}
					}
?>
					
<?php
								if ( self::$current_page > 0 && $intfirst_page != self::$current_page ) {
?>
									<a href="#" onclick="javascript:set_current_page('<?php echo $intfirst_page_js_parameter; ?>');"><strong>&lt;&lt; First</strong></a>&nbsp;&nbsp;
<?php
								}
								else {
?>
									<strong class="act">&lt;&lt; First</strong>&nbsp;&nbsp;
<?php
								}
?>
							
<?php
								if ( self::$current_page > 0 && $intprevious_page > 0 ) {
?>
									<a href="#" onclick="javascript: set_current_page('<?php echo $intprevious_page_js_parameter; ?>');"><strong>&lt; Previous</strong></a>&nbsp;&nbsp;
<?php
								}
								else {
?>
									<strong class="act">&lt; Previous</strong>&nbsp;&nbsp;
<?php
								}
?>
							
<?php
								if ( self::$current_page > 0 ) {
?>								
									<strong>Page <strong class="act"><?php echo self::$current_page; ?></strong> of <?php echo $inttotal_page; ?></strong>&nbsp;&nbsp;
<?php
								}
								else {
?>
									<strong>All Records</strong>
<?php
								}
?>
							
<?php
								if ( self::$current_page > 0 && $intnext_page <= $inttotal_page ) {
?>
								<a href="#" onclick="javascript: set_current_page('<?php echo $intnext_page_js_parameter; ?>'); "><strong>Next &gt;</strong></a>&nbsp;&nbsp;
<?php
								}
								else {
?>
									<strong class="act">Next &gt;</strong>&nbsp;&nbsp;
<?php
								}
?>
							
<?php
								if ( self::$current_page > 0 && $intlast_page != self::$current_page ) {
?>
								<a href="#" onclick="javascript: set_current_page('<?php echo $intlast_page_js_parameter; ?>');"><strong>Last &gt;&gt;</strong></a>&nbsp;&nbsp;
<?php
								}
								else {
?>
									<strong class="act">Last &gt;&gt;</strong>&nbsp;&nbsp;
<?php
								}
?>
							
<?php
				}
			}
			
			public static function write_paging_sorting_js ( ) {
?>
				<script type="text/javascript" language="javascript">
					function set_current_page ( page_detail ) {
						if ( page_detail != 'all' ) {
							arpage_detail = page_detail.split('|');
							document.getElementById('current_page').value = arpage_detail[0];
							document.getElementById('current_offset').value = arpage_detail[1];
							document.getElementById('frm').submit();
						}
						else {
							document.getElementById('current_page').value = -1;
							document.getElementById('current_offset').value = -1;
							document.getElementById('frm').submit();
						}
					}
					function go_sort ( sort_field, sort_type ) {
						document.getElementById('hdnorder_field').value = sort_field;
						document.getElementById('hdnorder_type').value = sort_type;
						document.getElementById('frm').submit();
					}
				</script>
<?php
			}
			
			public static function order_field ( $order_field ) {
?>
                <a href="#" onclick="javascript:go_sort('<?php echo $order_field; ?>','ASC');">
	                <img src="<?php echo ADMIN_THEME; ?>images/arrow_up_mini.gif" alt="" />
                </a>
                <a href="#" onclick="javascript:go_sort('<?php echo $order_field; ?>','DESC');">
	                <img src="<?php echo ADMIN_THEME; ?>images/arrow_down_mini.gif" alt="" />
                </a>
<?php
			}
						
			public static function show_numeric_paging_panel ( ) {
				$inttotal_page = ceil(self::$total_records / self::$page_size);
				if($inttotal_page > 1) {
?>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td align="left" valign="top">
								Page:
							</td>
							<td align="left" valign="top" width="5"></td>
							<td align="left" valign="top">
								<table cellpadding="0" cellspacing="0" border="0">
<?php
							$strlink = $_SERVER['REQUEST_URI'];
							if ( trim($_SERVER['QUERY_STRING']) == '' ) {
								$strlink .= '?current_page=##current_page##&current_offset=##current_offset##';
							}
							else {
								$strlink .= '&current_page=##current_page##&current_offset=##current_offset##';
							}
							for ( $intcounter = 0; $intcounter < $inttotal_page; $intcounter++ ) {
									if ( $intcounter % 25 == 0 )
									{
?>
										<tr>
<?php
									}
?>
										<td align="left" valign="top" class="paging-cell">
											<a <?php if ( ($intcounter+1) == self::$current_page ) echo 'class="active-page"'; ?> href="<?php echo str_replace('##current_offset##', (int) $intcounter * self::$page_size, str_replace('##current_page##', $intcounter + 1, $strlink)); ?>">
												<?php echo ($intcounter+1);  ?>
											</a>
										</td>
<?php
							}
?>
								</table>
							</td>
						</tr>
					</table>
<?php
				}
			}
			
		}
?>