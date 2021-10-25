<?php 
session_start(); 
header("Access-Control-Allow-Origin: *");
include_once("PEAR/Mail.php");
include_once("PEAR/mime.php");
include_once("config/data.config.php");
include_once("$LIB_DIR/class.database.php");
include_once("$LIB_DIR/data.constant.php");
include_once("$LIB_DIR/functions.library.php"); 

unset($_SESSION['fb_event_name']);
unset($_SESSION['fb_trading2']);
unset($_SESSION['fb_event_id2']);


// print_r($_SERVER);

// echo $SITE_URL;

// echo $LIB_DIR;
//This one is removed from the top of this page :: 15-07-2014
/*<script type="text/javascript" src="jslib/jquery.jcarousel.min"></script>
<!-- jCarousel skin stylesheet-->
<link rel="stylesheet" type="text/css" href="css/skin.css" />*/

$db=new DbConnect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME, $DB_REPORT_ERROR, $DB_PERSISTENT_CONN);
$db->open() or die($db->error());
$db1=new DbConnect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME, $DB_REPORT_ERROR, $DB_PERSISTENT_CONN);
$db1->open() or die($db1->error());
$TAP_MESSAGE = get_Tap_Message($db,15);
display_message();
display_tips_message();

$FILTER_CMS = getfootercms($db);
global $PROMPT,$login_menu,$captcha_valied,$FRONT_END_IMG,$banner3,$edd,$img,$top_recom_image,$top_recom,$banner_top_recom,$top_recom,$div_recom,$banner_top,$active ,$div_hot_tickets,$div_just_annun,$div_also_on_sale,$div_sub_category,$div_subcategory_sports,$serchtotal_get,$counter_value,$rec_counter_value,$res_div_also_on_sale,$div_recom,$div_recom1,$index_check,$tab_total_tickets_msg,$logfb;
$div_recom='';
$div_recom1='';
$res_div_also_on_sale='';
$counter_value=0;
$rec_counter_value=0;
$id_tap = 22;
getmeta_desc($db,$id_tap);
$TAP_MESSAGE = get_Tap_Message($db,$id_tap);

$ser_parts = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 

$ser_parts_1 = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$parts=explode('/', $ser_parts_1);

$sub_str_slash = substr_count($ser_parts_1,"/");


$parts=explode('/', $_SERVER["SERVER_NAME"]);
if($parts[0]!='localhost' && $parts[0]!="192.168.0.65")
{

if($sub_str_slash <= 2){

require("controller/sub_url_verify.php"); 

}else{
// echo $sub_str_slash; 

}

}else{
// echo $sub_str_slash; 

}


include("controller/login.php");
//include("controller/login_fb1.php");


/*code for header css
*/
$serchtotal_get="";
/*code for banner start*/
$curdt = date('Y-m-d H:i:s');
//echo "select * from ".TK_EVENTS." where featured='1' and status='Approve' and private_event !=0 and '".$curdt."' between date(event_on_sale) AND //date(event_close_sale) order by approve_date desc limit 0,10";


/*$banner_query=mysql_query("select tk.*, tsu.*, tk.seller_id as seller_id1 from ".TK_EVENTS." tk, tk_seller_users tsu where tk.seller_id=tsu.id AND tk.featured='1' and tk.status in ('Approve','Rawap') and tk.private_event !=0 and tsu.featrd_img_optn='Yes' and now() >=event_on_sale AND now() <=event_close_sale order by approve_date desc limit 0,10");*/

$banner_query=mysql_query("select tk.* from ".TK_EVENTS." tk, tk_seller_users tsu where tk.seller_id=tsu.id AND tk.featured='1' and tk.status in ('Approve','Rawap','halted') and tk.private_event !=0 and tsu.featrd_img_optn='Yes' and now() >=event_on_sale AND now() <=event_close_sale order by approve_date desc limit 0,10");

// echo "select tk.* from ".TK_EVENTS." tk, tk_seller_users tsu where tk.seller_id=tsu.id AND tk.featured='1' and tk.status in ('Approve','Rawap','halted') and tk.private_event !=0 and tsu.featrd_img_optn='Yes' and now() >=event_on_sale AND now() <=event_close_sale order by approve_date desc limit 0,10";
// exit;

$bann_image=$SITE_URL."/kroppr/kropped";
$numcat = mysql_num_rows($banner_query);
// echo $numcat;
// exit;
$banner43 .="<div class=\"quake-slider\">";
if($numcat >=1)
 {
 $banner3 .="<div id=\"slider1_container\" style=\"position: relative; top: 0px; left: 0px; width: 540px; height: 320px; overflow: hidden; margin:0 auto;\">
<!-- Loading Screen -->
        <div u=\"loading\" style=\"position: absolute; top: 0px; left: 0px;\">
            <div style=\"filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;\">
            </div>
            <div style=\"position: absolute; display: block; background: url(__SITE_URL__/images/frontend/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;\">
            </div>
        </div>
		 <!-- Slides Container -->
		
        <div u=\"slides\" style=\"cursor: move; position: absolute; left: 0px; top: 0px; width: 540px; height: 320px; overflow: hidden;\">
           ";
           //echo "<pre>";print_r(mysql_fetch_array($banner_query));echo '</pre>';
		  //style=\"cursor: move; position: absolute; left: 0px; top: 0px; width:540px; height: 320px; overflow: hidden;\"
	while($banner_featured_rows=mysql_fetch_array($banner_query))
	{
   		$img  = $banner_featured_rows['featured_img'];
   		//echo $img;
   		$banner_event_name=$banner_featured_rows['event_name'];
   		$desc= str_replace("<br />","</p><p>",strip_tags($banner_featured_rows['event_description'], '<p><br />')); 
    	$cousub = substr_count($banner_featured_rows['event_description'],"<p>"); 
     	$sql_price = "SELECT * FROM `event_ticket_type` WHERE `event_id` ='".$banner_featured_rows['id']."' ORDER BY `ticket_price` ASC LIMIT 0 , 1";
		$event_ticket_type=mysql_query($sql_price);
		$event_price=mysql_fetch_array($event_ticket_type);
		$price_tick=AmountFormat($event_price['ticket_price']);
		$event_sellerid = base64_encode($banner_featured_rows['seller_id']);
		$event_category_nm = strtolower(str_replace(" ","_",$event_category[0]));
		$e_nm = strtolower(str_replace(" ","_",$event_name));
   		$cat_explode=explode('@',$banner_featured_rows['event_category']);
		$event_sellerid = base64_encode($banner_featured_rows['seller_id']);
		$event_category_nm = strtolower(str_replace(" ","_",$cat_explode[0]));
		$e_nm = strtolower(str_replace(" ","_",$banner_featured_rows['event_name']));
		$sql_trf = "select `trading_name` from tk_seller_users where id=".$banner_featured_rows['seller_id']."";
		$teadingnmf=mysql_query($sql_trf);
		$teadingnm_resultf=mysql_fetch_array($teadingnmf);
		$hot_trading_namef=strtolower(str_replace(" ","_",$teadingnm_resultf['trading_name']));
		$li_seller_id_url = base64_encode($banner_featured_rows['seller_id']);
		$li_event_id_url = base64_encode($banner_featured_rows['id']);
		$li_event_nm_url=strtolower(preg_replace('/[^a-zA-Z0-9]/s', '_', $banner_featured_rows['event_name']));
		$event_url=$SITE_URL."/".$li_seller_id_url."/".$li_event_id_url."/".$li_event_nm_url;
		$resize_url = $SITE_URL."/resize.php";
		$sss = "";
		if($cousub >1)
		{
 			$strs = explode('<p>',$desc);
 			$c = count($strs);
			if(strlen($strs[1])>=100)
	 		{		 
		 		$chars = 170;  
				$mytext = substr($strs[1],0,$chars);  
				$mytext = substr($mytext,0,strrpos($mytext,' '));  
		    	$sss = $mytext;
	 		}
	 		else
	 		{
		  		for($i=1;$i<=2;$i++)
 				{
					if($i==2)
					{
						$chars = 88;  
						$mytext = substr($strs[$i],0,$chars);  
						$mytext = substr($mytext,0,strrpos($mytext,' '));  
						$sss.=str_replace("</p>","<br />",$mytext);
					}
					else
					{
						$sss.=str_replace("</p>","<br />",$strs[$i]);
					}
 				}
	 		}
			 $banner_event_desc=$sss;
		}
		else
		{
	 		//$desdiss=substr($desc,0,188);
		    //$lastSpacePosition = strrpos($desdiss," ");
			//$banner_event_desc =substr($desdiss,0,$lastSpacePosition);
			$chars = 170;  
			$mytext = substr($desc,0,$chars);  
			$mytext = substr($mytext,0,strrpos($mytext,' '));  
			$banner_event_desc = $mytext;  
	 	}
		
		// echo "$SITE_URL/kroppr/kropped/$img";
//  		$banner1 = "<a href=\"$event_url\" style=\"color:#fff;text-decoration:none;\"> <img alt='$banner_event_name' title='$banner_event_name' src=\"$resize_url?src=../kroppr/kropped/$img&h=300&w=540\" height='100%' width='100%'  alt=\"img\" /></a>";
		
		$banner3.=" <a href='".$event_url."' style=\"position:relative; display:block; padding:0; margin:0; float:left; height:100%; width:100%; z-index:100;\"><div>
                <img u=\"image\" src=\"$SITE_URL/kroppr/kropped/$img\" />
				<div class=\"banner_description\"><p>$banner_event_name (&pound;$price_tick)</p> $banner_event_desc</div></a>
            </div>";
  
}
// style=\"float:left; width:100%; padding:0; margin:0;\"

$banner3.=" </div>
		 <div u=\"navigator\" class=\"jssorb05\" style=\"position: absolute; bottom: 16px; right: 6px;\">
            <!-- bullet navigator item prototype -->
            <div u=\"prototype\" style=\"position: absolute; width: 16px; height: 16px;\"></div>
        </div>
        <!-- Bullet Navigator Skin End -->
        
        <!-- Arrow Left -->
		<div class=\"jssora_main\">
        <span u=\"arrowleft\" class=\"jssora12l\" style=\"width: 50px; height: 100%; top: 0px; left: 0px;\">
        </span>
        <!-- Arrow Right -->
        <span u=\"arrowright\" class=\"jssora12r\" style=\"width: 50px; height: 100%; top: 0px; right: 0px\">
        </span>
		</div>
        <!-- Arrow Navigator Skin Endd -->
       
    </div>";
$banner43 .="</div>";
}
else
{
	$banner3 = "<img alt='Coming Soon' title='Coming Soon' src=\"$SITE_URL/images/frontend/index-lading.png\" border=\"0\">";
}
//echo "select * from ".TK_EVENTS." where featured='1' and status='Approve'";
/*code for banner end*/

/*code for top recommendation images start
*/
$curdt = date('Y-m-d H:i:s');
//echo "select * from ".TK_EVENTS." where top_recom_events='1' and status in ('Approve','Rawap') and private_event !=0 and  now() >=event_on_sale AND now() <=event_close_sale"; exit;
$top_recom_query=mysql_query("select * from ".TK_EVENTS." where top_recom_events='1' and status in ('Approve','Approve_f_img','Rawap','halted') and private_event !=0 and  now() >=event_on_sale AND now() <=event_close_sale");
 $top_recom_image=$SITE_URL."/kroppr/kropped";
  $toprecat = mysql_num_rows($top_recom_query);
if($toprecat >=1)
{
/*Pavan Added slider-*/
 $div_recom.="<input type='hidden' id='rec_counter_value' name='rec_counter_value' value='$toprecat'/>";
 $div_recom .='<div  id="mycarousel" class="jcarousel-skin-tango">
      	<ul>';
		//$t=1;
		while($top_recom_rows=mysql_fetch_array($top_recom_query))
		{
			$top_rec = explode("@",$top_recom_rows['big_image']);
		    $top_recom  = $top_rec[0];
   			$top_recom__array=$top_recom_rows['event_name'];
			// if(strlen($top_recom__array)>15){
			// $title=substr($top_recom__array,0,14);
			// $title=$title."...";
			//	}
			//	else{
			//	$title=$top_recom__array;}
			$title=$top_recom__array;
            $top_recom_ven_name=$top_recom_rows['venue_name'];
        	$top_recom_ven_id=$top_recom_rows['venueids'];
   			$top_recom_desc=substr($top_recom_rows['event_description'],0,70);
   			$top_recom_event_date=$top_recom_rows['event_st_datetime'];
   		    $att=mysql_query("select * from tk_seller_page where id='".$top_recom_ven_id."'");
   			$att_name=mysql_fetch_assoc($att);
   			$att_city=$att_name['city'];
      		$top_recom_ven_name=$att_name['page_name'];
      		$tic_dis = mysql_query("SELECT * FROM `event_ticket_type` WHERE `event_id` = '".$top_recom_rows['id']."' AND IF( `ticket_quantity` != `ticket_sold` , 1, 0 ) =1 ORDER BY `event_ticket_type`.`ticket_price` ASC LIMIT 0 , 1");
			$tic_dis_pr=mysql_fetch_assoc($tic_dis);
			$tic_dis_pr_name=$tic_dis_pr['ticket_price'];
			$event_pricenumrow=mysql_num_rows($tic_dis);
			if($event_pricenumrow == "0")
			{
				$sql_pr1 = "SELECT * FROM `event_ticket_type` WHERE `event_id` = '".$also_on_sale_rows['id']."' ORDER BY `event_ticket_type`.`ticket_price` ASC
LIMIT 0 , 1";
				$event_ticket_type1=mysql_query($sql_pr1);
				$event_price1=mysql_fetch_array($event_ticket_type1);
				$tic_dis_pr_name=$event_price1['ticket_price'];
			}
			else
			{
				$tic_dis_pr_name=$event_price['ticket_price'];
			}

$tic_dis_pr_name1="&pound;".number_format($tic_dis_pr_name, 2, '.', '');
//toprecommondation price


$sql_price_top =mysql_query("SELECT *
FROM `event_ticket_type`
WHERE `event_id` ='".$top_recom_rows['id']."' 
ORDER BY `ticket_price` ASC
LIMIT 0 , 1");


$toprecom_min_price=mysql_fetch_array($sql_price_top);



$min_price_recom=$toprecom_min_price['ticket_price'];


$min_price_toprecom="&pound;".number_format($min_price_recom, 2, '.', '');

   
   
   $cat_explode=explode('@',$top_recom_rows['event_category']);
		$event_sellerid = base64_encode($top_recom_rows['seller_id']);
$event_category_nm = strtolower(str_replace(" ","_",$cat_explode[0]));
$e_nm = strtolower(str_replace(" ","_",$top_recom_rows['event_name']));

$sql_trt = "select `trading_name` from tk_seller_users where id=".$top_recom_rows['seller_id']."";
$teadingnmt=mysql_query($sql_trt);
$teadingnm_resultt=mysql_fetch_array($teadingnmt);
$hot_trading_namet=strtolower(str_replace(" ","_",$att_name['page_name']));


$hot_tickets_arrayt=strtolower(str_replace(" ","_",$top_recom_rows['event_url']));
$event_url=$SITE_URL."/category/".$event_category_nm."/".$e_nm."/".$event_sellerid;
   
   
  $date_format_source = 'Y-m-d';
  $date_format_destiny = 'd/m/Y';
  $con_from_date =func_date_conversion( $date_format_source, $date_format_destiny,$top_recom_event_date); 
  $top_recom_on_event=explode("-",$con_from_date);
$resize_url = $SITE_URL."/resize.php";

$al_rec = explode("@",$top_recom_rows['big_image']);
$eve_main_img = $top_recom_rows['main_thumb_image'];
$sale_on_imge  = $al_rec[$top_recom_rows['select_bigimg']];
$li_seller_id_url = base64_encode($top_recom_rows['seller_id']);
$li_event_id_url = base64_encode($top_recom_rows['id']);

$li_event_nm_url=strtolower(preg_replace('/[^a-zA-Z0-9]/s', '_', $top_recom_rows['event_name']));

$event_url=$SITE_URL."/".$li_seller_id_url."/".$li_event_id_url."/".$li_event_nm_url;

	if($eve_main_img != '')
    {
		$banner_top_recom ="<a href=\"$event_url\"><img alt='$title' title='$title' src=\"$SITE_URL/kroppr/kropped/$eve_main_img\" height=\"110\" width=\"146\" border=\"0\" alt=\"dfc\"/></a>";
	}
	else
	{
		$banner_top_recom ="<a href=\"$event_url\"><img alt='$title' title='$title' src=\"$SITE_URL/kroppr/kropped/$al_rec[0]\" height=\"110\" width=\"146\" border=\"0\" alt=\"dfc\"/></a>";
	}

// echo "$SITE_URL/kroppr/kropped/$sale_on_imge";
// echo $event_url;
// echo $findbim['find'];


/*$findbim =  mysql_fetch_array(mysql_query("SELECT FIND_IN_SET( '".$top_recom_rows['select_bigimg']."', `bigimagecroppno`) as find
FROM `tk_events`
WHERE id=".$top_recom_rows['id'].""));
if($findbim['find'] == "0")
{
	 $banner_top_recom ="<a href=\"$event_url\"><img alt='$title' title='$title' src=\"$SITE_URL/kroppr/kropped/$sale_on_imge\" height=\"110\" width=\"146\" border=\"0\" alt=\"df\"/></a>";
}
else
{
	 $banner_top_recom ="<a href=\"$event_url\"><img alt='$title' title='$title' src=\"$SITE_URL/kroppr/kropped/$sale_on_imge\" height=\"110\" width=\"146\" border=\"0\" alt=\"dfc\"/></a>";
}*/
  
  /* <img src=\"$resize_url?src=users/create_event/uploads/$top_recom&h=110&w=146\"  />*/
  
  $div_recom .="<li>
            <div class=\"mosaic-block2  cover\">
            <div class=\"mosaic-overlay\"> $banner_top_recom</div>
            <a href=\"$event_url\" class=\"mosaic-backdrop\" style=\"text-decoration:none;\">
                <div class=\"details\">
				   <div style=\"height:64px;overflow:hidden;\">
                	  <div class=\"sales_header_1\" id=\"just_div_val_$rec_counter_value\">
					  	<h1 id=\"just_header_text_$rec_counter_value\">$title</h1></div>
					  <div class=\"sales_discription\" id=\"just_venu_div_$rec_counter_value\">
					  	<h1 id=\"just_venu_text_$rec_counter_value\">At $top_recom_ven_name in $att_city</h1></div>
					</div>
					  <div class=\"sales_discription\">
 						 <span style='width:68px; float:left; text-align:left;'><u>$top_recom_on_event[0]</u></span> 
						 <span style='width:50px; float:right; text-align:right;'>$min_price_toprecom </span>
   
  </tr>
</table></div>
					
                </div>
            </a>
        </div></li>";
		
		$div_recom1 .=" 
			<li>
			<div>
            <div> $banner_top_recom</div>
            <a href=\"$event_url\"  style=\"text-decoration:none;\" class=\"also_sale_det\">
                <div class=\"details\">
				   <div style=\"height:64px;overflow:hidden;\">
                	  <div class=\"sales_header_1\" id=\"just_div_val_$rec_counter_value\">
					  	<h1 id=\"just_header_text_$rec_counter_value\">$title</h1></div>
					  <div class=\"sales_discription\" id=\"just_venu_div_$rec_counter_value\">
					  	<h1 id=\"just_venu_text_$rec_counter_value\">At $top_recom_ven_name in $att_city</h1></div>
					</div>
					  <div class=\"sales_discription\">
 						 <span style='width:68px; float:left; text-align:left;'><u>$top_recom_on_event[0]</u></span> 
						 <span style='width:50px; float:right; text-align:right;'>$min_price_toprecom </span>
   
  </tr>
</table></div>
					
                </div>

					
              
            </a>
			</div>
        </li>";
	$div_recom .="	<script>
  var lines_count=0;
   function just_nthLine_$rec_counter_value() 
   {
	var words = $('#just_header_text_$rec_counter_value').text().split(' ');
    var cache = words[0]; //because we miss the first word as we need to detect the height.
    var lines = [];
	var lin=0;
    $('#just_div_val_$rec_counter_value').append('<h1 id=\"sample5\">' + words[0] + '</h1>');
	var size = $('#sample5').height();
    var newSize = size;
	for (var i = 1; i < words.length; i++)
	{
       var sampleText = $('#sample5').html();
	   cache = cache + ' ' + words[i];
	   marker = [i];
	   $('#sample5').html(sampleText + ' ' + words[i]);
       var newSize = $('#sample5').height();
		if (size !== newSize) 
		{
        	cache = cache.substring(0, cache.length - (words[i].length + 1));
            lines.push(cache);
            cache = words[i];
            size = $('#sample5').height();
	    }
    }
    lines.push(cache);
    cache = '';
	cache1='';
	lines_count=lines.length;
	if(lines_count>=2)
	{
		lin=2;
		l2=0;
	}
	else
	{
    	if(lines.length>2)
		{
			lin=2;
			l2=1;
		}
		else
		{
			lin=lines.length;
			l2=1;
		}
	}
	for (var i = 0; i < lin; i++) 
	{ 
		var words_count = lines[i].split('');
		//alert(words_count);
		if(i==1)
		{	
			if(lines.length>=lin)
			{
			  
				cache1 = cache1 + ' <span class=\"line-' + [i] + '\">';
		   		for(var j=0; j<=15;j++)
		   		{
					if( words_count[j]!=undefined)
			 			cache1 = cache1 + words_count[j];
		   		}
				if((words_count.length>15) || (lines.length>lin))
			    {
		   			cache1 = cache1 +  '...</span>';
			  	}
				else
				{
					cache1 = cache1 +  '</span>';				
				}
			}
			else
			{
				cache1 = cache1 + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
			}
		}
		else
		    cache = cache + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
    }
	cache=cache+cache1;
	
    $('#sample5').remove();
    cache = cache.substring(1);
    $('#just_header_text_$rec_counter_value').html(cache);
	if(lines.length>=lin)
	{
	  if((words_count.length>15) || (lines.length>=lin))
	  {
		var  cont_width    = $('#just_header_text_$rec_counter_value').width();
   		var  txt           = cache1;
   		var one_line      = $('<span class=\"stretch_it\">' + txt + '</span>');
    	var nb_char       = txt.length;
    	var spacing       = cont_width/nb_char,
    	txt_width;    
    	$('#just_header_text_$rec_counter_value .line-1').html(one_line);	
    	txt_width = one_line.width();
		
    	if (txt_width < cont_width)
		{
			//if(txt_width<110)
		//	{
			//	txt_width=parseInt(txt_width)+parseInt(10);
			//}
			
        	var  char_width     = txt_width/nb_char,
        	ltr_spacing    = spacing - char_width + (spacing - char_width)/nb_char ; 
  			$('#just_header_text_$rec_counter_value .line-1').css({'letter-spacing': ltr_spacing});
    	} 
		else if (txt_width == cont_width)
		{
        	$('#just_header_text_$rec_counter_value .line-1').css({'letter-spacing': '0.8px'});
    	} 
		else
		{
			//one_line.contents().unwrap();
        	$('#just_header_text_$rec_counter_value .line-1').css({'text-align': 'justify'});
    	}
	  }
	}
	}	
	function just_venu_nthLine_$rec_counter_value() 
	{
	var words = $('#just_venu_text_$rec_counter_value').text().split(' ');
    var venu_cache = words[0];
	var l1=0;
	var lin=0;
    var lines = [];
    $('#just_venu_text_$rec_counter_value').append('<h1 id=\"sample5\">' + words[0] + '</h1>');
	var size = $('#sample5').height();
    var newSize = size;
	for (var i = 1; i < words.length; i++)
	{
       var sampleText = $('#sample5').html();
	   venu_cache = venu_cache + ' ' + words[i];
	   marker = [i];
	   $('#sample5').html(sampleText + ' ' + words[i]);
       var newSize = $('#sample5').height();
		if (size !== newSize) 
		{
        	venu_cache = venu_cache.substring(0, venu_cache.length - (words[i].length + 1));
            lines.push(venu_cache);
            venu_cache = words[i];
            size = $('#sample5').height();
	    }
    }
    lines.push(venu_cache);
    venu_cache = '';
	venu_cache1='';
	if(lines_count>=2)
	{
		lin=1;
		l1=0;
	}
	else
	{
    	if(lines.length>2)
		{
			lin=2;
			l1=1;
		}
		else
		{
			l1=1;
			lin=lines.length;
		}
	}
	for (var i = 0; i < lin; i++) 
	{ 
		var words_count = lines[i].split('');
		if(i==l1)
		{
			if(lines.length>=lin) 
			{
				venu_cache1 = venu_cache1 + ' <span class=\"line-' + [i] + '\">';
		   		for(var j=0; j<=15;j++)
		   		{
					if(words_count[j]!=undefined)
			 		     venu_cache1 = venu_cache1 + words_count[j];
		   		}				
				if((words_count.length>15) || (lines.length>=lin))
			    {
		   			venu_cache1 = venu_cache1 +  '...</span>';
			  	}
				else
				{
					venu_cache1 = venu_cache1 +  '</span>';			
				}
			}
			else
			{
				venu_cache1 = venu_cache1 + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
			}
		
		}
		else
		    venu_cache = venu_cache + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
    }
	venu_cache=venu_cache+venu_cache1;
    $('#sample5').remove();
    venu_cache = venu_cache.substring(1);
    $('#just_venu_text_$rec_counter_value').html(venu_cache);
	if(lines.length>=lin)
	{
	   if((words_count.length>15) || (lines.length>lin))
	   {
		var  cont_width    = $('#just_venu_text_$rec_counter_value').width();
   		var  txt           = venu_cache1;
   		var one_line      = $('<span class=\"stretch_it\">' + txt + '</span>');
		
    	var nb_char       = txt.length;
    	var spacing       = cont_width/nb_char,
    	txt_width;    
    	$('#just_venu_text_$rec_counter_value .line-'+l1).html(one_line);	
    	txt_width = one_line.width();
    	if (txt_width <cont_width)
		{
			//if(txt_width<100)
			//{
				//txt_width=parseInt(txt_width)+parseInt(30);
			//}
        	var  char_width     = txt_width/nb_char,
        	ltr_spacing    = spacing - char_width + (spacing - char_width)/nb_char ; 
  			$('#just_venu_text_$rec_counter_value .line-'+l1).css({'letter-spacing': ltr_spacing});
    	} 
		else if (txt_width == cont_width)
		{
        	$('#just_venu_text_$rec_counter_value .line-'+l1).css({'letter-spacing': '0.8px'});
    	} 
		else
		{
			//one_line.contents().unwrap();
        	$('#just_header_text_$rec_counter_value .line-1').css({'text-align': 'justify'});
    	}
		}
	}
 }
  </script>
		
      ";
	  //$t++;
	  $rec_counter_value++;
}
		$div_recom .='</ul></div>';					  
		
		
}
else
{
$div_recom .=' <div class="top_rec_events"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody><tr>
    <td width="10%" valign="middle" align="left"><div class="recommended_coming-arrow" style="margin-right:10px;"><a href="#"><img width="31" height="31" border="0" src="'.$SITE_URL.'/images/arrow-forword.png"></a></div></td>
    <td width="60%" valign="middle" align="center"><div class="recommended_coming-soon">
                                	<ul>
                                    	<li><img src="'.$SITE_URL.'/images/frontend/recommend-coming-soon.png"  title="coming soon" alt="Coming soon"></li>
                                        <li><img src="'.$SITE_URL.'/images/frontend/recommend-coming-soon4.png" title="coming soon" alt="Coming soon"></li>
                                        <li><img src="'.$SITE_URL.'/images/frontend/recommend-coming-soon3.png" title="coming soon" alt="Coming soon"></li>
                                    </ul>

                                </div></td>
    <td width="10%" valign="middle" align="right"><div class="recommended_coming-arrow"><a href="#"><img width="31" height="31" border="0" src="'.$SITE_URL.'/images/arrow-next.png"></a></div></td>
  </tr>
</tbody></table></div>';

$div_recom1 .=' <div class="top_rec_events"><div class="recommended_coming-soon">
                                	<ul>
                                    	<li><img src="'.$SITE_URL.'/images/frontend/recommend-coming-soon.png"  title="coming soon" alt="Coming soon"></li>
                                        <li><img src="'.$SITE_URL.'/images/frontend/recommend-coming-soon4.png" title="coming soon" alt="Coming soon"></li>
                                        <li><img src="'.$SITE_URL.'/images/frontend/recommend-coming-soon3.png" title="coming soon" alt="Coming soon"></li>
                                    </ul>

                                </div></td>
</div>';
}		
 
//echo "select * from ".TK_EVENTS." where featured='0' and top_recom_events='1' and status='Approve'";
//echo "<pre>";print_r($div_recom);exit;
/*code for top recommendation images start
*/


/*hot tickets start
*/
/*
$hot_tickets_query=mysql_query("select * from ".TK_EVENTS." where  hot_tickets='1' and status='Approve' and private_event !=0 order by sold_ticket desc limit 0,4");

 $hottikrow = mysql_num_rows($hot_tickets_query);
if($hottikrow >=1)
{
while($hot_ticket_rows=mysql_fetch_array($hot_tickets_query)){
$hot_tickets_array=strtolower(str_replace(" ","_",$hot_ticket_rows['event_url']));
$hot_tickets_desc=$hot_ticket_rows['event_description'];
 $desc_h= strip_tags($hot_tickets_desc); 
  $hot_event_desc=substr($desc_h,0,80);
$hot_tickets_category=strtolower(str_replace(" ","_",$hot_ticket_rows['event_category']));
$hot_tickets_head=$hot_ticket_rows['event_name'];
$seller_id=base64_encode($hot_ticket_rows['seller_id']);
 $sql_tr = "select `trading_name` from tk_seller_users where id=".$hot_ticket_rows['seller_id']."";
$teadingnm=mysql_query($sql_tr);
$teadingnm_result=mysql_fetch_array($teadingnm);
$hot_trading_name=strtolower(str_replace(" ","_",$teadingnm_result['trading_name']));

$event_st_datetime=$hot_ticket_rows['event_st_datetime'];
$date_format_source = 'Y-m-d';
$date_format_destiny = 'd-M-Y';
$con_from_date =func_date_conversion($date_format_source, $date_format_destiny,$event_st_datetime); 

$event_date=explode("-",$con_from_date);
//echo "<pre>";print_r($event_date);exit;
$div_hot_tickets .="
<div class=\"ticket_box\">
<div class=\"hotticket_box\">
<div class=\"hotticket_left_crnr sprite date_left\"></div>
<div class=\"hotticket_list_box\">
<table width=\"340\" border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td width=\"54\" align=\"left\" valign=\"top\"><div class=\"date_box sprite date_box_bg\"><table width=\"75%\" border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td align=\"center\" valign=\"middle\" class=\"hotticket_date\">$event_date[0]</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"middle\" class=\"hotticket_month\">$event_date[1]</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"middle\" class=\"hotticket_year\">$event_date[2]</td>
  </tr>
</table></div></td>
    <td width=\"243\" align=\"left\" valign=\"top\"><div>$hot_tickets_head<br />
<span class=\"hotticket_list_cnt\">$hot_event_desc</span></div></td>
    <td width=\"43\" align=\"left\" valign=\"bottom\"><div class=\"events_btn\"><a href=\"$SITE_URL/$hot_trading_name/$hot_tickets_array\" title=\"Find Tickets\" class=\"tooltip\"></a></div></td>
  </tr>
  <tr>
    <td colspan=\"3\" align=\"left\" valign=\"middle\"><div class=\"hotticket_devider\"></div></td>
    </tr>
</table></div></div><div class=\"clr\"></div>                                          
                                          </div>";
}
}
else
{
$div_hot_tickets .='<div class="hotticket_box">
                                            	<div class="hotticket_left_crnr sprite date_left"></div>
                                                <div class="hotticket_list_box"><table width="340" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td width="54" align="left" valign="top"><div class="date_box sprite date_box_bg"><table width="75%" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td height="8" align="center" valign="middle" class="hotticket_date"></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="hotticket_month"><img src="'.$SITE_URL.'/images/frontend/heart-icon.png" width="26" height="23"></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="hotticket_year">Date</td>
  </tr>
</table></div></td>
    <td width="243" align="left" valign="top">
    <span class="hotticket_coming-soon">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam mauris odio,</span></td>
    <td width="43" align="left" valign="bottom"><a href="#"><img src="'.$SITE_URL.'/images/frontend/tickets_go_disable.png" width="32" height="30" border="0"></a></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="middle"><div class="hotticket_devider"></div></td>
    </tr>
</table>
</div>
                                            </div>';
}

*/
/*hot tickets end
*/

/*just announced start
*/
//echo "Fdfr";
$curdt = date('Y-m-d');
//echo "select * from ".TK_EVENTS." where status in ('Approve','Rawap')  and private_event !=0 AND  now()>=event_on_sale AND now()<=event_close_sale and just_announced='0' order by approve_date desc limit 0,4";
$just_announ_query=mysql_query("select * from ".TK_EVENTS." where status in ('Approve','Approve_f_img','Rawap','halted')  and private_event !=0 AND  now() >=event_on_sale AND now() <=event_close_sale and just_announced='0' order by approve_date desc limit 0,4");
$hottikrow = mysql_num_rows($just_announ_query);
if($hottikrow >=1)
{
while($just_announ_rows=mysql_fetch_array($just_announ_query)){
$just_announ_name=$just_announ_rows['event_name'];

$just_announ_name_url=strtolower(str_replace(" ","_",$just_announ_rows['event_url']));
 $desc_h= strip_tags($just_announ_rows['event_description']); 
  $just_announ_desc=substr($desc_h,0,80);
   $sql_tr = "select `trading_name` from tk_seller_users where id=".$just_announ_rows['seller_id']."";
$teadingnm=mysql_query($sql_tr);
$teadingnm_result=mysql_fetch_array($teadingnm);
$just_trading_name=strtolower(str_replace(" ","_",$teadingnm_result['trading_name']));

$just_announ_start_date=$just_announ_rows['event_st_datetime'];
$just_event_category=strtolower($just_announ_rows['event_category']);
$just_event_category_url=strtolower(str_replace("@","",$just_announ_rows['event_category']));
$just_seller_id=base64_encode($just_announ_rows['seller_id']);
$date_format_source = 'Y-m-d';
$date_format_destiny = 'd-M-Y';
$con_from_date =func_date_conversion( $date_format_source, $date_format_destiny,$just_announ_start_date); 
$event_start_dtetime=explode("-",$con_from_date);
//echo "<pre>";print_r($event_start_dtetime);exit;

$li_seller_id_url = base64_encode($just_announ_rows['seller_id']);
$li_event_id_url = base64_encode($just_announ_rows['id']);
//$li_event_nm_url=strtolower(str_replace(" ","_",$just_announ_rows['event_name']));
$li_event_nm_url=strtolower(preg_replace('/[^a-zA-Z0-9]/s', '_', $just_announ_rows['event_name']));
$event_url=$SITE_URL."/".$li_seller_id_url."/".$li_event_id_url."/".$li_event_nm_url;
$div_just_annun .="<div class=\"ticket_box\">
                                        	<div class=\"hotticket_box\">
                                            	<div class=\"hotticket_left_crnr sprite date_left\">sddssddssd</div>
                                                <div class=\"hotticket_list_box\"><table width=\"340\" border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td width=\"54\" align=\"left\" valign=\"top\"><div class=\"date_box sprite date_box_bg\"><table width=\"75%\" border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td align=\"center\" valign=\"middle\" class=\"hotticket_date\">$event_start_dtetime[0]</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"middle\" class=\"hotticket_month\">$event_start_dtetime[1]</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"middle\" class=\"hotticket_year\">$event_start_dtetime[2]</td>
  </tr>
</table></div></td>
    <td width=\"243\" align=\"left\" valign=\"top\">$just_announ_name<br>
    <span class=\"hotticket_list_cnt\">$just_announ_desc </span></td>
    <td width=\"43\" align=\"left\" valign=\"bottom\"><div class=\"events_btn\"><a href=\"$event_url\" title=\"Find Tickets\" class=\"tooltip\"></a></div></td>
  </tr>
  <tr>
    <td colspan=\"3\" align=\"left\" valign=\"middle\"><div class=\"hotticket_devider\"></div></td>
    </tr>
</table>
</div>
                                            </div>
                                            <div class=\"clr\"></div>
                                           
                                            
                                            
                                            
                                          
                                            
                                            </div>";

}
}
else
{
$div_just_annun .='<div class="hotticket_box">
                       <div class="hotticket_left_crnr sprite date_left"></div>
                          <div class="hotticket_list_box">
						  	<table width="340" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td width="54" align="left" valign="top"><div class="date_box sprite date_box_bg"><table width="75%" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td height="8" align="center" valign="middle" class="hotticket_date"></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="hotticket_month"><img src="'.$SITE_URL.'/images/frontend/heart-icon.png" width="26" height="23"></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="hotticket_year">Date</td>
  </tr>
</table></div></td>
    <td width="243" align="left" valign="top">
    <span class="hotticket_coming-soon">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam mauris odio,</span></td>
    <td width="43" align="left" valign="bottom"><a href="#"><img src="'.$SITE_URL.'/images/frontend/tickets_go_disable.png" width="32" height="30" border="0"></a></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="middle"><div class="hotticket_devider"></div></td>
    </tr>
</table>
</div>
                                            </div>';
}
/*just announced end
*/

/*also on sale start
*/
$curdt = date('Y-m-d H:i:s');
//echo "select * from ".TK_EVENTS." where featured!=1 and  now() >=event_on_sale AND now() <=event_close_sale AND  top_recom_events!=1  and status in('Approve','Rawap') and private_event !=0 and also='1' order by rand() limit 0,6 ";exit;
$also_on_sale_query=mysql_query("select * from ".TK_EVENTS." where featured!=1 and  now() >=event_on_sale AND now() <=event_close_sale AND  top_recom_events!=1  and status in('Approve','Approve_f_img','Rawap','halted') and private_event !=0 and also='1' order by rand() limit 0,6 ");
$also_on_sale_image=$SITE_URL."/kroppr/kropped";
$c = 0;
$toprecat = mysql_num_rows($also_on_sale_query);
if($toprecat >=1)
{

$div_also_on_sale.=" <input type='hidden' id='counter_value' name='counter_value' value='$toprecat'/>";
while($also_on_sale_rows=mysql_fetch_array($also_on_sale_query)){

$al_rec = explode("@",$also_on_sale_rows['big_image']);
    $sale_on_imge  = $al_rec[$also_on_sale_rows['select_bigimg']];
   
   


$also_on_sale_array=$also_on_sale_rows['event_name'];
//if(strlen($also_on_sale_array)>15){
//    $title=substr($also_on_sale_array,0,14);
//	$title=$title."...";
//	}
//	else{
//	$title=$also_on_sale_array;}
$title=$also_on_sale_array;

$also_ven_name=$also_on_sale_rows['venue_name'];
$also_ven_id=$also_on_sale_rows['venueids'];

$also_on_sale_desc=substr($also_on_sale_rows['event_description'],0,50);
$also_on_sale_date=$also_on_sale_rows['event_st_datetime'];

 $att=mysql_query("select * from tk_seller_page where id='".$also_ven_id."'");
   $att_name=mysql_fetch_assoc($att);
   $att_city=$att_name['city'];
   $also_ven_name=$att_name['page_name'];



$date_format_source = 'Y-m-d';
$date_format_destiny = 'd/m/Y';
$con_from_date =func_date_conversion( $date_format_source, $date_format_destiny,$also_on_sale_date); 
$also_on_event=explode("-",$con_from_date);

$cat_explode=explode('@',$also_on_sale_rows['event_category']);
		$event_sellerid = base64_encode($also_on_sale_rows['seller_id']);
$event_category_nm = strtolower(str_replace(" ","_",$cat_explode[0]));
$e_nm = strtolower(str_replace(" ","_",$also_on_sale_rows['event_url']));


   $sql_tr1 = "select `trading_name` from tk_seller_users where id=".$also_on_sale_rows['seller_id']."";
$teadingnm=mysql_query($sql_tr1);
$teadingnm_result=mysql_fetch_array($teadingnm);
$also_trading_name=strtolower(str_replace(" ","_",$att_city['page_name']));


 $tic_dis = mysql_query("SELECT *
FROM `event_ticket_type`
WHERE `event_id` = '".$also_on_sale_rows['id']."'
AND IF( `ticket_quantity` != `ticket_sold` , 1, 0 ) =1
ORDER BY `event_ticket_type`.`ticket_price` ASC

LIMIT 0 , 1");
$tic_dis_pr=mysql_fetch_assoc($tic_dis);
$tic_dis_pr_name=$tic_dis_pr['ticket_price'];



$event_pricenumrow=mysql_num_rows($tic_dis);
if($event_pricenumrow == "0")
{
	
	$sql_pr1 = "SELECT *
FROM `event_ticket_type`
WHERE `event_id` = '".$also_on_sale_rows['id']."'
ORDER BY `event_ticket_type`.`ticket_price` ASC
LIMIT 0 , 1";
$event_ticket_type1=mysql_query($sql_pr1);
$event_price1=mysql_fetch_array($event_ticket_type1);
	
	$tic_dis_pr_name=$event_price1['ticket_price'];

}
else{

	$tic_dis_pr_name=$event_price['ticket_price'];

}


$tic_dis_pr_name1="&pound;".number_format($tic_dis_pr_name, 2, '.', '');

//also on sale price

$sql_price_also =mysql_query("SELECT *
FROM `event_ticket_type`
WHERE `event_id` ='".$also_on_sale_rows['id']."' 
ORDER BY `ticket_price` ASC
LIMIT 0 , 1");


$alsoonsale_min_price=mysql_fetch_array($sql_price_also);



$min_price_sale=$alsoonsale_min_price['ticket_price'];


$min_price_alsosale="&pound;".number_format($min_price_sale, 2, '.', '');


$li_seller_id_url = base64_encode($also_on_sale_rows['seller_id']);
$li_event_id_url = base64_encode($also_on_sale_rows['id']);
//$li_event_nm_url=strtolower(str_replace(" ","_",$also_on_sale_rows['event_name']));
$li_event_nm_url=strtolower(preg_replace('/[^a-zA-Z0-9]/s', '_', $also_on_sale_rows['event_name']));
$event_url=$SITE_URL."/".$li_seller_id_url."/".$li_event_id_url."/".$li_event_nm_url;

$resize_url = $SITE_URL."/resize.php";

 $findbim =  mysql_fetch_array(mysql_query("SELECT FIND_IN_SET( '".$also_on_sale_rows['select_bigimg']."', `bigimagecroppno`) as find
FROM `tk_events` WHERE id=".$also_on_sale_rows['id'].""));
if($sale_on_imge == '')
$sale_on_imge='image_notavailable.jpg';

//echo $sale_on_imge;
if($findbim['find'] == "0")
{
	
	$also_on_sale ="<a href=\"$event_url\"><img title='$title' alt='$title' src=\"$SITE_URL/kroppr/kropped/$sale_on_imge\" height=\"110\" width=\"146\" border=\"0\" alt=\"df\"/></a>";
}
else
{
	
	$also_on_sale ="<a href=\"$event_url\"><img title='$title' alt='$title' src=\"$SITE_URL/kroppr/kropped/$sale_on_imge\" height=\"110\" width=\"146\" border=\"0\" alt=\"dfc\"/></a>";
}	


if($c == 5){
$mar_rt = "margin-right:0";
}
$div_also_on_sale .="<li style=\"$mar_rt\"><div class=\"mosaic-block cover\">
            <div class=\"mosaic-overlay\">$also_on_sale</div>
            <a href=\"$event_url\"  class=\"mosaic-backdrop\" style=\"text-decoration:none;\">
                <div class=\"details\">
				  <div style=\"height:62px;overflow:hidden;\">
                	<div class=\"sales_header_1\" id=\"also_div_val_$counter_value\">
					<h1 id=\"also_header_text_$counter_value\">$title</h1>
					</div>
					<div class=\"sales_discription\" id=\"also_venu_div_$counter_value\">
					  <h1 id=\"also_venu_text_$counter_value\">At ".$also_ven_name." in ".$att_city."</h1></div>
					</br>
					</div>
					<div class=\"sales_price\">
					<span class='discrip-left'><u>$top_recom_on_event[0]</u></span><span class='price-right'>$min_price_alsosale</span>
</div>
                </div>
            </a>
        </div></li>
		<script>
  var lines_count=0;
   function also_nthLine_$counter_value() 
   {
	var words = $('#also_header_text_$counter_value').text().split(' ');
    var cache = words[0]; //because we miss the first word as we need to detect the height.
    var lines = [];
	var lin=0;
    $('#also_div_val_$counter_value').append('<h1 id=\"sample3\">' + words[0] + '</h1>');
	var size = $('#sample3').height();
    var newSize = size;
	for (var i = 1; i < words.length; i++)
	{
       var sampleText = $('#sample3').html();
	   cache = cache + ' ' + words[i];
	   marker = [i];
	   $('#sample3').html(sampleText + ' ' + words[i]);
       var newSize = $('#sample3').height();
		if (size !== newSize) 
		{
        	cache = cache.substring(0, cache.length - (words[i].length + 1));
            lines.push(cache);
            cache = words[i];
            size = $('#sample3').height();
	    }
    }
    lines.push(cache);
    cache = '';
	cache1='';
	lines_count=lines.length;
	if(lines_count>=2)
	{
		lin=2;
		l2=0;
	}
	else
	{
    	if(lines.length>2)
		{
			lin=2;
			l2=1;
		}
		else
		{
			lin=lines.length;
			l2=1;
		}
	}
	for (var i = 0; i < lin; i++) 
	{ 
		var words_count = lines[i].split('');
		//alert(words_count);
		if(i==1)
		{	
			if(lines.length>=lin)
			{
			  
				cache1 = cache1 + ' <span class=\"linesd-' + [i] + '\">';
		   		for(var j=0; j<=15;j++)
		   		{
					if( words_count[j]!=undefined)
			 			cache1 = cache1 + words_count[j];
		   		}
				if((words_count.length>15) || (lines.length>lin))
			    {
		   			cache1 = cache1 +  '...</span>';
			  	}
				else
				{
					cache1 = cache1 +  '</span>';				
				}
			}
			else
			{
				cache1 = cache1 + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
			}
		}
		else
		    cache = cache + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
    }
	cache=cache+cache1;
	
    $('#sample3').remove();
    cache = cache.substring(1);
    $('#also_header_text_$counter_value').html(cache);
	if(lines.length>=lin)
	{
	  if((words_count.length>15) || (lines.length>=lin))
	  {
		var  cont_width    = $('#also_header_text_$counter_value').width();
   		var  txt           = cache1;
   		var one_line      = $('<span class=\"stretch_it\">' + txt + '</span>');
    	var nb_char       = txt.length;
    	var spacing       = cont_width/nb_char,
    	txt_width;    
    	$('#also_header_text_$counter_value .line-1').html(one_line);	
    	txt_width = one_line.width();
    	if (txt_width < cont_width)
		{
        	var  char_width     = txt_width/nb_char,
        	ltr_spacing    = spacing - char_width + (spacing - char_width)/nb_char ; 
  			$('#also_header_text_$counter_value .line-1').css({'letter-spacing': ltr_spacing});
    	} 
		else if (txt_width == cont_width)
		{
        	$('#also_header_text_$counter_value .line-1').css({'letter-spacing': '0.8px'});
    	} 
		else
		{
			//one_line.contents().unwrap();
        	$('#also_header_text_$counter_value .line-1').css({'text-align': 'justify'});
    	}
	  }
	}
	}	
	function also_venu_nthLine_$counter_value() 
	{
	var words = $('#also_venu_text_$counter_value').text().split(' ');
    var venu_cache = words[0];
	var l1=0;
	var lin=0;
    var lines = [];
    $('#also_venu_text_$counter_value').append('<h1 id=\"sample4\">' + words[0] + '</h1>');
	var size = $('#sample4').height();
    var newSize = size;
	for (var i = 1; i < words.length; i++)
	{
       var sampleText = $('#sample4').html();
	   venu_cache = venu_cache + ' ' + words[i];
	   marker = [i];
	   $('#sample4').html(sampleText + ' ' + words[i]);
       var newSize = $('#sample4').height();
		if (size !== newSize) 
		{
        	venu_cache = venu_cache.substring(0, venu_cache.length - (words[i].length + 1));
            lines.push(venu_cache);
            venu_cache = words[i];
            size = $('#sample4').height();
	    }
    }
    lines.push(venu_cache);
    venu_cache = '';
	venu_cache1='';
	if(lines_count>=2)
	{
		lin=1;
		l1=0;
	}
	else
	{
    	if(lines.length>2)
		{
			lin=2;
			l1=1;
		}
		else
		{
			l1=1;
			lin=lines.length;
		}
	}
	for (var i = 0; i < lin; i++) 
	{ 
		var words_count = lines[i].split('');
		if(i==l1)
		{
			if(lines.length>=lin) 
			{
				venu_cache1 = venu_cache1 + ' <span class=\"line-' + [i] + '\">';
		   		for(var j=0; j<=15;j++)
		   		{
					if(words_count[j]!=undefined)
			 		     venu_cache1 = venu_cache1 + words_count[j];
		   		}				
				if((words_count.length>15) || (lines.length>=lin))
			    {
		   			venu_cache1 = venu_cache1 +  '...</span>';
			  	}
				else
				{
					venu_cache1 = venu_cache1 +  '</span>';			
				}
			}
			else
			{
				venu_cache1 = venu_cache1 + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
			}
		
		}
		else
		    venu_cache = venu_cache + ' <span class=\"line-' + [i] + '\">' + lines[i] + '</span>';
    }
	venu_cache=venu_cache+venu_cache1;
    $('#sample4').remove();
    venu_cache = venu_cache.substring(1);
    $('#also_venu_text_$counter_value').html(venu_cache);
	if(lines.length>=lin)
	{
	   if((words_count.length>15) || (lines.length>lin))
	   {
		var  cont_width    = $('#also_venu_text_$counter_value').width();
   		var  txt           = venu_cache1;
   		var one_line      = $('<span class=\"stretch_it\">' + txt + '</span>');
		
    	var nb_char       = txt.length;
    	var spacing       = cont_width/nb_char,
    	txt_width;    
    	$('#also_venu_text_$counter_value .line-'+l1).html(one_line);	
    	txt_width = one_line.width();
    	if (txt_width <cont_width)
		{
        	var  char_width     = txt_width/nb_char,
        	ltr_spacing    = spacing - char_width + (spacing - char_width)/nb_char ; 
  			$('#also_venu_text_$counter_value .line-'+l1).css({'letter-spacing': ltr_spacing});
    	} 
		else if (txt_width == cont_width)
		{
        	$('#also_venu_text_$counter_value .line-'+l1).css({'letter-spacing': '0.8px'});
    	} 
		else
		{
			//one_line.contents().unwrap();
        	$('#also_header_text_$counter_value .line-1').css({'text-align': 'justify'});
    	}
		}
	}
 }
  </script>";
  
  $res_div_also_on_sale .="<li><div style=\"float:left\">$also_on_sale
            						<a href=\"$event_url\" class=\"also_sale_det\">
                					<div class=\"also_sale_details\">
				  						<div style=\"height:62px;overflow:hidden;\">
                							<div class=\"sales_header_1\" id=\"also_div_val_$counter_value\">
												<h1 id=\"also_header_text_$counter_value\">$title</h1>
											</div>
											<div class=\"sales_discription\" id=\"also_venu_div_$counter_value\">
					  							<h1 id=\"also_venu_text_$counter_value\">At ".$also_ven_name." in ".$att_city."</h1>
											</div>
											</br>
										</div>
										<div class=\"sales_price\">
											<span class='discrip-left'><u>$top_recom_on_event[0]</u></span><span class='price-right'>$min_price_alsosale</span>
										</div>
                					</div>
            					    </a>
        						</div></li>";
		
	$c++;	
	$counter_value++;
}



}
else
{
$div_also_on_sale .='<li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
                                    <li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon2.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
                                    <li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon3.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
									<li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon5.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
									<li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon6.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
                                    <li style="margin:0px;"><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon4.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>';
									
									
$res_div_also_on_sale .='<li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
                                    <li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon2.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
                                    <li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon3.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
									<li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon5.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
									<li><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon6.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>
                                    <li style="margin:0px;"><img src="'.$SITE_URL.'/images/frontend/Sale-coming-soon4.png" alt="Also On Sale Events Coming Soon" title="Also On Sale Events Coming Soon"></li>';
}
/*also on sale end*/
/*categorie code start*/
/*music*/
$category_event_query=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%music%' and status='Active'");
if(mysql_num_rows($category_event_query) > 0)
{
	$div_header_music .="<ul><li>";
}
while($category_event_rows=mysql_fetch_array($category_event_query))
{
	$sub_category_event=$category_event_rows['sub_cat_name'];
	$sub_category_event1=str_replace("&","and",$sub_category_event);
	//$sub_category_event2=strtolower(str_replace("  ","_",$sub_category_event1));
	$sub_category_replace=strtolower(str_replace(" ","_",$sub_category_event1));
	$div_sub_category .="<ul><li><a href=\"$SITE_URL/category/music/$sub_category_replace\">$sub_category_event</a></li></ul>";
	if(mysql_num_rows($category_event_query) > 0) 
	{		   
 		$div_header_music .="<a href=\"$SITE_URL/category/music/$sub_category_replace\">$sub_category_event</a>";	
	}				   
}
if(mysql_num_rows($category_event_query) > 0)
{
	$div_header_music .="</li> </ul>";
}
/*music
*/
/*sports
*/
$categ_event_sports_query=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%sports%' and status='Active'");
if(mysql_num_rows($categ_event_sports_query) > 0)
{
	$div_header_sports .="<ul> <li>";
}
while($categ_event_sports_rows=mysql_fetch_array($categ_event_sports_query))
{
	$sub_cat_sport=$categ_event_sports_rows['sub_cat_name'];
	$sub_cat_sports=strtolower(str_replace(" ","_",$sub_cat_sport));
	$div_subcategory_sports .="<ul><li><a href=\"$SITE_URL/category/sports/$sub_cat_sports\">$sub_cat_sport</a></li></ul>";
	if(mysql_num_rows($categ_event_sports_query) > 0)
	{
		$div_header_sports .="<a href=\"$SITE_URL/category/sports/$sub_cat_sports\">$sub_cat_sport</a>";
	}							   
}
if(mysql_num_rows($categ_event_sports_query) > 0)
{
	$div_header_sports .="</li> </ul>";
}
/*sports
*/
/*arts
*/
$subcat_arts_event=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%arts and theater%' and status='Active'");
if(mysql_num_rows($subcat_arts_event) > 0)
{
	$div_header_arts .=" <ul><li>";
}
while($subcat_sports_rows=mysql_fetch_array($subcat_arts_event))
{
	$subcat_art=$subcat_sports_rows['sub_cat_name'];
	$subcat_arts=strtolower(str_replace(" ","_",$subcat_art));
  	$div_subcat_arts .="<ul><li><a href=\"$SITE_URL/category/arts_and_theater/$subcat_arts\">$subcat_art</a></li></ul>";
	if(mysql_num_rows($subcat_arts_event) > 0)
	{				
		$div_header_arts .="<a href=\"$SITE_URL/category/arts_and_theater/$subcat_arts\">$subcat_art</a>";	
	}	
}
if(mysql_num_rows($subcat_arts_event) > 0)
{
	$div_header_arts .="</li> </ul>";
}
/*arts
*/
/*family
*/
$subcat_family_query=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%family%' and status='Active'");
if(mysql_num_rows($subcat_family_query) > 0)
{
	$div_header_family .="<ul><li>";
}
while($subcat_family_query_rows=mysql_fetch_array($subcat_family_query))
{
  $subcat_event_family=$subcat_family_query_rows['sub_cat_name'];
  $subcat_event_fam=strtolower(str_replace(" ","_",$subcat_event_family));
  $div_event_family .="<ul><li><a href=\"$SITE_URL/category/family/$subcat_event_fam\"> $subcat_event_family</a></li></ul>";
  if(mysql_num_rows($subcat_family_query) > 0)
  {			 
 	$div_header_family .="<a href=\"$SITE_URL/category/family/$subcat_event_fam\">$subcat_event_family</a>";
  }
}
if(mysql_num_rows($subcat_family_query) > 0)
{
	$div_header_family .="</li></ul>";
}


//This is to load the sub categories drop down box in front end website :: pujitha :: 17-07-2014

$sub_category_event_query=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%music%' and status='Active'");
if(mysql_num_rows($sub_category_event_query) < 0)
{
	$sub_cat_div_header_music .="";
}
else
{
while($sub_category_event_rows=mysql_fetch_array($sub_category_event_query))
 {
	$sub_category_event=$sub_category_event_rows['sub_cat_name'];
	$sub_category_replace=strtolower(str_replace(" ","_",$sub_category_event));
	$sub_cat_div_header_music .="<option value=\"$sub_category_replace\">$sub_category_event</option>";				   
 }
}


/*music
*/
/*sports
*/
$sub_categ_event_sports_query=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%sports%' and status='Active'");
if(mysql_num_rows($sub_categ_event_sports_query) < 0)
{
	$sub_cat_div_header_sports .="";
}
else
{
	while($sub_categ_event_sports_rows=mysql_fetch_array($sub_categ_event_sports_query))
	{
		$sub_cat_sport=$sub_categ_event_sports_rows['sub_cat_name'];
		$sub_cat_sports=strtolower(str_replace(" ","_",$sub_cat_sport));
		$sub_cat_div_header_sports .="<option value=\"$sub_cat_sports\">$sub_cat_sport</a></li></ul>";						   
	}
}

/*sports
*/
/*arts
*/
$subcat_arts_event_query=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%arts and theater%' and status='Active'");
if(mysql_num_rows($subcat_arts_event_query) < 0)
{
	$sub_cat_div_header_arts .="";
}
else
{
	while($subcat_sports_rows=mysql_fetch_array($subcat_arts_event_query))
	{
		$subcat_art=$subcat_sports_rows['sub_cat_name'];
		$subcat_arts=strtolower(str_replace(" ","_",$subcat_art));
  		$sub_cat_div_header_arts .="<option value=\"$subcat_arts\">$subcat_art</option>";
	}
}



/*arts
*/
/*family
*/
$sub_cat_family_query=mysql_query("SELECT  DISTINCT (`sub_cat_name`)FROM tk_subcategory WHERE `category` LIKE '%family%' and status='Active'");
if(mysql_num_rows($sub_cat_family_query) < 0)
{
	$sub_cat_div_header_family .="";
}
while($subcat_family_query_rows=mysql_fetch_array($sub_cat_family_query))
{
  $subcat_event_family=$subcat_family_query_rows['sub_cat_name'];
  $subcat_event_fam=strtolower(str_replace(" ","_",$subcat_event_family));
  $sub_cat_div_header_family .="<option value=\"$subcat_event_fam\"> $subcat_event_family</option>";
}
//END


/*family
*/
/*categories code end
*/
$select_footer_category=mysql_query("select * from ".TK_ADMIN_SETTINGS." where id='1'");
$footer_ctegory_display=mysql_fetch_array($select_footer_category);
$footer_category_state=$footer_ctegory_display['footer_category_settings'];
$footer_promotion_seetings=$footer_ctegory_display['footer_promotions_settings'];
$PROMPT_CLASS_TIPS = "sucess_tips";

/* Promotion */
global $promotiondiv;
//$promotion_query=mysql_query("SELECT  * FROM promotions WHERE  status='Active' and display=1 order by id desc limit 0,4");
$promotion_query=mysql_query("SELECT  * FROM promotions WHERE display=1 order by RAND() desc limit 0,4");

$i = 1;
//$promotiondiv='<div id="sliderh4_container" style="position: relative; top: 0px; left: 0px; width:740px;height:220px;">
				//<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 100%; height: 220px;overflow: hidden;">';
while($promotions_rows=mysql_fetch_array($promotion_query))
{
  	$link=$promotions_rows['link'];
    $promo_image=$promotions_rows['image'];
	$promo_image=$promotions_rows['image'];
	$link_page_dis   =  $promotions_rows['link_page'];
	if($link_page_dis == "0")
	{
		$link_page = "_blank";
	}
	else
	{
		$link_page = "_parent";
	}
	$resize_url = $SITE_URL."/resize.php";
	if($i == "1")	
	{
		$exalpha = "alpha";
	}
	elseif($i == "4")	
	{
		$exomga = "omega";
	}
	else
	{
		$exalpha = "";
	}
	
	
if (substr($link, 0, 7) == "http://"){
    $link = $link;
	// echo "<br/>";
}else if (substr($link, 0, 8) == "https://"){
    $link = $link;
	// echo "<br/>";
}else{
    $link = "http://".$link;
	// echo "<br/>";
}

	$ss='<div class="devide_line">
            <hr class="left_line"/>
            <span class="main_headers">Promotions</span>
            <hr class="right_line"/>
         </div>
	
			<div class="heading_lines">
			<span class="promotions_main_headers">Promotions</span>
			<div class="tab_top_rec_devide_line"></div>
			</div>';
			
	//<a href=\"$link\" target=\"$link_page\"><img alt='promotions' title='promotions' src=\"$resize_url?src=management/promotion/uploads/$promo_image&h=220&w=218\"  /></a>
	// <a href=\"$link\" target=\"$link_page\">
						 // <img alt='promotions' title='promotions' src=\"$resize_url?src=management/promotion/uploads/$promo_image&h=220&w=218\"/></a>
						 
						 //<div class=\"promotions_box $exalpha $exomga\">
                        	//<div class=\"promotions_boxes\">
							 //<a href=\"$link\" target=\"$link_page\"><img alt='promotions' title='promotions' src=\"$resize_url?src=management/promotion/uploads/$promo_image&h=220&w=218\"  /></a>
							//</div>
                        //</div>
    $promotiondiv .="<li>
					   <a href=\"$link\" target=\"$link_page\"><img alt='promotions' title='promotions' src=\"$resize_url?src=management/promotion/uploads/$promo_image&h=220&w=218\"  /></a>
						</li>";
	$i++;
 }      

//$promotiondiv.='</div></div>';         
//$promotiondiv.="</div></div>";
/* Promotion */
//$PAGE_CONTENTS	= ReadTemplate("$TEMPLATE_DIR/index.html");

$cooling_update_select=mysql_query("select * from tk_admin_settings where id='1' ");
$cooling_select=mysql_fetch_array($cooling_update_select);

//print_r($cooling_select);
//var_dump($cooling_select);
//echo "alksdkljasfsad";
$TOPBAR			= ReadTemplate("$TEMPLATE_DIR/common/topbar.html");
$BANNER_CONTENT = ReadTemplate("$TEMPLATE_DIR/common/banner.html");
$RIGHT_TICKETS	= ReadTemplate("$TEMPLATE_DIR/common/right_tickets.html");
//$RIGHT_TICKETS	= ReadTemplate("$TEMPLATE_DIR/common/right.php");
//$RIGHT_TICKETS	= ReadTemplate("$TEMPLATE_DIR/common/itest.htm");

if($cooling_select['footer_category_settings'] == "1")
{
$CATEGORIES	= ReadTemplate("$TEMPLATE_DIR/common/categories.html");
}
if($cooling_select['footer_also_settings'] == "1")
{
$ALSO_ON_SALE	= ReadTemplate("$TEMPLATE_DIR/common/also_on_sale.html");
}

if($cooling_select['footer_promotions_settings'] == "1")
{
$PROMOTIONS	= ReadTemplate("$TEMPLATE_DIR/common/promotions.html");
}

$BOTTOMBAR		  = ReadTemplate("$TEMPLATE_DIR/common/bottom.html");
$TEMPLATE		    = ReadTemplate("$TEMPLATE_DIR/common/template-home.html");

ReplaceContent(Array("TOPBAR","BANNER_CONTENT", "RIGHT_TICKETS", "ALSO_ON_SALE","CATEGORIES","PROMOTIONS", "BOTTOMBAR", "PAGE_CONTENTS", "SUB_TEMPLATE", "TEMPLATE"));
//ReplaceContent(Array("TOPBAR","BANNER_CONTENT", "ALSO_ON_SALE","CATEGORIES","PROMOTIONS", "BOTTOMBAR", "PAGE_CONTENTS", "SUB_TEMPLATE", "TEMPLATE"));
//include("templates/common/right.php");
print $TEMPLATE;
flush();
$start=time();
//$total_time = round(($finish - $start), 4);
//echo 'Page generated in '.$total_time.' seconds.';
?>

<script>
    var frameElement = document.getElementById("frame-id");
    frameElement.contentWindow.location.href = frameElement.src;
</script>

<!--<script type="text/javascript">
var nthLine = function () {

    var content = $('h1').text();
	var words = content.split(" ");
    var cache = words[0]; //because we miss the first word as we need to detect the height.
    var lines = [];
    //make new object
    $(".sales_header_1").append('<h1 id="sample">' + words[0] + '</h1>');

    var size = $('#sample').height();
    var newSize = size;
	for (var i = 1; i < words.length; i++)
	{
       var sampleText = $('#sample').html();
	   cache = cache + ' ' + words[i];
	   marker = [i];
	   $('#sample').html(sampleText + ' ' + words[i]);
       var newSize = $('#sample').height();
		if (size !== newSize) 
		{
        	cache = cache.substring(0, cache.length - (words[i].length + 1));
            lines.push(cache);
            cache = words[i];
            size = $('#sample').height();
	    }
    }
    lines.push(cache);
    cache = ''
    if(lines.length>2)
	{
		lin=2;
	}
	else
	{
		lin=lines.length;
	}
	for (var i = 0; i < lin; i++) 
	{ 
		var words_count = lines[i].split("");
		if(i==1)
		{
			if(words_count.length>10) 
			{

				cache = cache + ' <span class="line-' + [i] + '">';
		   		for(var j=0; j<=10;j++)
		   		{
			 		cache = cache + words_count[j];
		   		}
		   		cache = cache +  '...</span>';
			}
			else
			{
				cache = cache + ' <span class="line-' + [i] + '">' + lines[i] + '</span>';
			}
		}
		else
		    cache = cache + ' <span class="line-' + [i] + '">' + lines[i] + '</span>';
    }

    //nukes the additional element to calc lines
    $('#sample').remove();
    
    //removes the space that causes problems on resize.
    cache = cache.substring(1);
    //prints the result.
    $('h1').html(cache);

};

 nthLine();



//
///$(window).resize(nthLine);
</script>-->
<script type="text/javascript">
$(document).ready(function() {
for(var sa=0;sa<document.getElementById("counter_value").value;sa++)
{
	fun_name="";
	fun_name3="";
	var fun_name="also_nthLine_";
	var fun_name3="also_venu_nthLine_";
	window[fun_name+sa]();
	window[fun_name3+sa]();
}

for(var sa1=0;sa1<document.getElementById("rec_counter_value").value;sa1++)
{
	fun_name4="";
	fun_name5="";
	var fun_name4="just_nthLine_";
	var fun_name5="just_venu_nthLine_";
	window[fun_name4+sa1]();
	window[fun_name5+sa1]();
}
});
//$('.top_banner').hover(function(){ 
//	$(".jssora12l").css("background-position","0px 140px");
//	$(".jssora12r").css("background-position","0px 140px");
//	});
//	
//$('.top_banner').mouseout(function(){
//	$(".jssora12l").css("background-position","-195px -37px");
//	$(".jssora12r").css("background-position","-195px -37px");
//	});
</script>
