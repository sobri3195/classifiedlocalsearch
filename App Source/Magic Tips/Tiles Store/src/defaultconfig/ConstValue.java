package defaultconfig;

import java.util.ArrayList;
import java.util.HashMap;

import android.database.sqlite.SQLiteDatabase;

import com.way.magictrik.R;

public class ConstValue {
	//	public static SQLiteDatabase dbCommon;
	public static final boolean DEBUG_MODE = true;
	public static final String LOG_TAG = "WINE_FIND";
	public static String DATABASE_URL="data/data/com.way.magictrik/database";
	
	//------------new json----------
	public static final String JSON_MAINCAT = "http://gujjurocks.com/magic/index.php?component=json&action=maincategory";
	//public static final String JSON_MAINCAT_COUNT = "http://gujjurocks.com/magic/index.php?component=json&action=count_maincategories";
	public static final String JSON_CAT = "http://gujjurocks.com/magic/index.php?component=json&action=categories&id=";
	//public static final String JSON_CAT_COUNT = "http://gujjurocks.com/magic/index.php?component=json&action=count_categories&id=";
	public static final String JSON_COMPANI = "http://gujjurocks.com/magic/index.php?component=json&action=companies&cat=";
	public static final String JSON_COMPANI_SEARCH = "http://gujjurocks.com/magic/index.php?component=json&action=companysearch&cat=";
	public static final String JSON_COMPANI_NEAR_BY = "http://gujjurocks.com/magic/index.php?component=json&action=getnearby";
	//public static final String JSON_COMPANI_COUNT = "http://gujjurocks.com/magic/index.php?component=json&action=count_companies&cat=";
	public static final String JSON_COMPANI_REVIEW = "http://gujjurocks.com/magic/index.php?component=json&action=reviews&id=";
	//public static final String JSON_COMPANI_REVIEW_COUNT = "http://gujjurocks.com/magic/index.php?component=json&action=count_reviews&id=";

	public static final String JSON_RELATION = "http://gujjurocks.com/magic/index.php?component=json&action=relation";
	public static final String JSON_RELATION_COUNT = "http://gujjurocks.com/magic/index.php?component=json&action=count_relation";
	
	public static final String JSON_REVIEW_ADD = "http://gujjurocks.com/magic/index.php?component=review&action=add";
	public static final String JSON_INQUIRY_ADD = "http://gujjurocks.com/magic/index.php?component=inquiry&action=add";
	public static final String JSON_REGISTRATION_ADD = "http://gujjurocks.com/magic/index.php?component=user&action=addpost";
	
	//----------JSON URLS------------//
	public static final String JSON_MAINCATEGORY = "http://gujjurocks.com/magic/admin/index.php?component=services&action=maincategory";
	public static final String JSON_COMPANIES = "http://gujjurocks.com/magic/admin/index.php?component=services&action=companies&cat=";
	public static final String JSON_COMPANY_PROFILE = "http://gujjurocks.com/magic/admin/index.php?component=services&action=profile&cat=";
	//----------JSON URLS------------//
	
	//----------IMAGES URL------------//
	public static final String TILESSTORE_IMAGE = "http://gujjurocks.com/magic/userfiles/tilesstore/";
	public static final String CONTENTS_IMAGE = "http://gujjurocks.com/magic/userfiles/contents/";
	//----------JSON URLS------------//
	
	
	//----------MAIN CATEGORY CONSTANTS------------//
	public static  ArrayList<HashMap<String, String>> maincatList;
	public static String SELECTED_MAINCATEGORY_TITLE;
	public static String SELECTED_MAINCATEGORY_ID;
	public static String SELECTED_MAINCATEGORY_DESC;
	public static String SELECTED_CATEGORY_ID;
	public static String SELECTED_CATEGORY_TITLE;
	
	public static String SEARCH_TEXT="";
	
	public static int[] mainCatIcons = new int[] { R.drawable.home_btn_1 ,  R.drawable.home_btn_2, R.drawable.home_btn_3,R.drawable.home_btn_4,R.drawable.home_btn_5,R.drawable.home_btn_6,R.drawable.home_btn_7,R.drawable.home_btn_8,R.drawable.home_btn_9};
	
	
	//-------COMPANY LIST CONSTANT VALUE--------//
	public static  ArrayList<HashMap<String, ArrayList<HashMap<String, String>>>> companyList = new ArrayList<HashMap<String,ArrayList<HashMap<String,String>>>>();
	public static  HashMap<String, HashMap<String, String>> companyProfile = new HashMap<String,HashMap<String,String>>();
	//-------COMPANY LIST CONSTANT VALUE--------//
	public static int SELECTED_COMPANY_ID;
	public static String SELECTED_COMPANY_KEY;
	
	//-------NEWS LINK--------//
	public static ArrayList<HashMap<String, String>> newsList = new ArrayList<HashMap<String, String>>();
	public static int SELECTED_NEWS_ID;
	public static String NEWS_URL="";
	
	public static ArrayList<HashMap<String, String>> compList1 = new ArrayList<HashMap<String,String>>();
	public static ArrayList<HashMap<String, String>> compList2 = new ArrayList<HashMap<String,String>>();
	public static ArrayList<HashMap<String, String>> compList3 = new ArrayList<HashMap<String,String>>();
	
	
	public static HashMap<String, String> sel_main_category = new HashMap<String, String>();
	public static HashMap<String, String> sel_category = new HashMap<String, String>();
	public static HashMap<String, String> sel_company = new HashMap<String, String>();
	
	public static String PREF_MAINMENU = "MAINMENUPREF";
	public static String PREF_CATEGORIES = "CATEGORIESPREF";
	public static String PREF_COMPANYIES = "COMPANYPREF";
	public static String PREF_REVIEW = "REVIEWPREF";
}
