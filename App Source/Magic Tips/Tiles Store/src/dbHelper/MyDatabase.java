package dbHelper;

import defaultconfig.ConstValue;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;


public class MyDatabase extends SqlDbHelper{

	public MyDatabase(Context context) {
		super(context, "", null, 1);
		// TODO Auto-generated constructor stub
	}
	public Cursor getQuery(String sql) {
		SQLiteDatabase db = getReadableDatabase();
		Cursor cr = db.rawQuery(sql,null);
		return cr;
	}
}
